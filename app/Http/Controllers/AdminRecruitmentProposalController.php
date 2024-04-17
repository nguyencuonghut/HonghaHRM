<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Department;
use App\Models\Division;
use App\Models\CompanyJob;
use App\Models\RecruitmentProposal;
use App\Notifications\RecruitmentProposalCreated;
use App\Notifications\RecruitmentProposalRequestApprove;
use App\Notifications\RecruitmentProposalRejected;
use Carbon\Carbon;
use Datatables;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class AdminRecruitmentProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.recruitment.proposal.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Check authorize
        if(!Auth::user()->can('create-propose')) {
            Alert::toast('Bạn không có quyền thêm đề xuất!', 'error', 'top-right');
            return redirect()->route('admin.recruitment.proposals.index');
        }
        $company_jobs = CompanyJob::orderBy('name', 'asc')->get();
        $departments = Department::all()->pluck('name', 'id');
        $divisions = Division::all()->pluck('name', 'id');
        return view('admin.recruitment.proposal.create',
                    ['company_jobs' => $company_jobs,
                    'departments' => $departments,
                    'divisions' => $divisions,
                    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'company_job_id' => 'required',
            'quantity' => 'required',
            'reason' => 'required',
            'requirement' => 'required',
            'salary' => 'required',
            'work_time' => 'required',
        ];
        $messages = [
            'company_job_id.required' => 'Bạn phải chọn vị trí.',
            'quantity.required' => 'Bạn phải nhập số lượng.',
            'reason.required' => 'Bạn phải nhập lý do.',
            'requirement.required' => 'Bạn phải nhập yêu cầu.',
            'salary.required' => 'Bạn phải nhập mức lương',
            'work_time.required' => 'Bạn phải nhập thời gian.',
        ];
        $request->validate($rules,$messages);

        //Create new RecruitmentProposal
        $proposal = new RecruitmentProposal();
        $proposal->company_job_id   = $request->company_job_id;
        $proposal->quantity         = $request->quantity;
        $proposal->reason           = $request->reason;
        $proposal->requirement      = $request->requirement;
        $proposal->salary           = $request->salary;
        $proposal->work_time        = Carbon::createFromFormat('d/m/Y', $request->work_time);
        if ($request->note) {
            $proposal->note = $request->note;
        }
        $proposal->creator_id     = Auth::user()->id;
        $proposal->status = 'Mở';
        $proposal->save();

        //Send notification to reviewer
        $reviewers = Admin::where('role_id', 4)->get(); //2: Nhân sự
        foreach ($reviewers as $reviewer) {
            Notification::route('mail' , $reviewer->email)->notify(new RecruitmentProposalCreated($proposal->id));
        }

        Alert::toast('Thêm yêu cầu tuyển dụng mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.recruitment.proposals.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $proposal = RecruitmentProposal::findOrFail($id);
        return view('admin.recruitment.proposal.show',compact('proposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecruitmentProposal $recruitmentProposal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecruitmentProposal $recruitmentProposal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecruitmentProposal $recruitmentProposal)
    {
        //
    }


    public function anyData()
    {
        $proposals = RecruitmentProposal::with(['company_job', 'creator', 'reviewer', 'approver'])->get();
        return Datatables::of($proposals)
            ->addIndexColumn()
            ->editColumn('company_job', function ($proposals) {
                return '<a href="'.route('admin.recruitment.proposals.show', $proposals->id).'">'.$proposals->company_job->name.'</a>';
            })
            ->editColumn('department', function ($proposals) {
                $department = '';
                $department = $proposals->company_job->department->name;
                if ($proposals->division_id) {
                    $department = $department . $proposals->company_job->division->name;
                }
                return $department;
            })
            ->editColumn('quantity', function ($proposals) {
                return $proposals->quantity;
            })
            ->editColumn('reason', function ($proposals) {
                return $proposals->reason;
            })
            ->editColumn('requirement', function ($proposals) {
                return $proposals->requirement;
            })
            ->editColumn('salary', function ($proposals) {
                return number_format($proposals->salary, 0, '.', ',');
            })
            ->editColumn('work_time', function ($proposals) {
                return date('d/m/Y', strtotime($proposals->work_time));
            })
            ->editColumn('note', function ($proposals) {
                return $proposals->note;
            })
            ->editColumn('creator', function ($proposals) {
                return $proposals->creator->name;
            })
            ->editColumn('reviewer', function ($proposals) {
                return $proposals->reviewer_id ? $proposals->reviewer->name : '';
            })
            ->editColumn('approver', function ($proposals) {
                return $proposals->approver_id ? $proposals->approver->name : '';
            })
            ->editColumn('status', function ($proposals) {
                if($proposals->status == 'Mở') {
                    return '<span class="badge badge-primary">Mở</span>';
                } else if($proposals->status == 'Đã kiểm tra'){
                    return '<span class="badge badge-warning">Đã kiểm tra</span>';
                } else {
                    return '<span class="badge badge-success">Đã duyệt</span>';
                }
            })
            ->addColumn('actions', function ($proposals) {
                $action = '<a href="' . route("admin.recruitment.proposals.edit", $proposals->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.recruitment.proposals.destroy", $proposals->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['company_job', 'actions', 'status', 'requirement', 'reason', 'note'])
            ->make(true);
    }

    public function review(Request $request, $id)
    {
        $rules = [
            'reviewer_result' => 'required',
        ];
        $messages = [
            'reviewer_result.required' => 'Bạn phải chọn kết quả.',
        ];
        $request->validate($rules,$messages);

        $proposal = RecruitmentProposal::findOrFail($id);
        $proposal->reviewer_result = $request->reviewer_result;
        $proposal->reviewer_comment = $request->reviewer_comment;
        $proposal->reviewer_id = Auth::user()->id;
        $proposal->status = 'Đã kiểm tra';
        $proposal->save();

        //Send notification
        if ('Đồng ý' == $proposal->reviewer_result) {
            // Send notification to request approve
            $leaders = Admin::where('role_id', 2)->get(); //2: Ban lãnh đạo
            foreach ($leaders as $leader) {
                Notification::route('mail' , $leader->email)->notify(new RecruitmentProposalRequestApprove($proposal->id));
            }
        } else {
            // Send notification for reject status to the creator
            Notification::route('mail' , $proposal->creator->email)->notify(new RecruitmentProposalRejected($proposal->id));
        }

        Alert::toast('Kiểm tra thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
