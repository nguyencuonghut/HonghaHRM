<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Division;
use App\Models\Job;
use App\Models\RecruitmentProposal;
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
        $jobs = Job::orderBy('name', 'asc')->get();
        $departments = Department::all()->pluck('name', 'id');
        $divisions = Division::all()->pluck('name', 'id');
        return view('admin.recruitment.proposal.create',
                    ['jobs' => $jobs,
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
            'job_id' => 'required',
            'quantity' => 'required',
            'reason' => 'required',
            'requirement' => 'required',
            'salary' => 'required',
            'work_time' => 'required',
        ];
        $messages = [
            'job_id.required' => 'Bạn phải chọn vị trí.',
            'quantity.required' => 'Bạn phải nhập số lượng.',
            'reason.required' => 'Bạn phải nhập lý do.',
            'requirement.required' => 'Bạn phải nhập yêu cầu.',
            'salary.required' => 'Bạn phải nhập mức lương',
            'work_time.required' => 'Bạn phải nhập thời gian.',
        ];
        $request->validate($rules,$messages);

        //Create new RecruitmentProposal
        $proposal = new RecruitmentProposal();
        $proposal->job_id        = $request->job_id;
        $proposal->quantity      = $request->quantity;
        $proposal->reason        = $request->reason;
        $proposal->requirement   = $request->requirement;
        $proposal->salary        = $request->salary;
        $proposal->work_time     = Carbon::createFromFormat('d/m/Y', $request->work_time);//Carbon::createFromFormat('d-m-Y', c)->format('Y-m-d');
        if ($request->note) {
            $proposal->note = $request->note;
        }
        $proposal->creator_id     = Auth::user()->id;
        $proposal->status = 'Mở';
        $proposal->save();

        Alert::toast('Thêm yêu cầu tuyển dụng mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.recruitment.proposals.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RecruitmentProposal $recruitmentProposal)
    {
        //
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
        $proposals = RecruitmentProposal::with(['job', 'creator', 'reviewer', 'approver'])->get();
        return Datatables::of($proposals)
            ->addIndexColumn()
            ->editColumn('job', function ($proposals) {
                return $proposals->job->name;
            })
            ->editColumn('department', function ($proposals) {
                $department = '';
                $department = $proposals->job->department->name;
                if ($proposals->division_id) {
                    $department = $department . $proposals->job->division->name;
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
            ->rawColumns(['actions', 'status', 'requirement', 'reason', 'note'])
            ->make(true);
    }
}
