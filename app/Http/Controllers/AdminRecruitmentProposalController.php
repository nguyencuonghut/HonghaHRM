<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminDepartment;
use App\Models\Commune;
use App\Models\Department;
use App\Models\District;
use App\Models\Division;
use App\Models\Document;
use App\Models\CompanyJob;
use App\Models\School;
use App\Models\Degree;
use App\Models\Province;
use App\Models\RecruitmentProposal;
use App\Models\RecruitmentMethod;
use App\Models\RecruitmentSocialMedia;
use App\Models\RecruitmentCandidate;
use App\Models\CvReceiveMethod;
use App\Notifications\RecruitmentProposalCreated;
use App\Notifications\RecruitmentProposalRequestApprove;
use App\Notifications\RecruitmentProposalRejected;
use App\Notifications\RecruitmentProposalApproved;
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
        $departments = Department::all()->pluck('name', 'id');
        if ('Admin' == Auth::user()->role->name) {
            // Fetch all company_jobs for Admin
            $company_jobs = CompanyJob::orderBy('name', 'asc')->get();
        } else {
            // Only fetch the Admin's department
            $department_ids = [];
            $department_ids = AdminDepartment::where('admin_id', Auth::user()->id)->pluck('department_id')->toArray();
            $company_jobs = CompanyJob::whereIn('department_id', $department_ids)->orderBy('name', 'asc')->get();
        }
        return view('admin.recruitment.proposal.create',
                    ['company_jobs' => $company_jobs,
                    'departments' => $departments,
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
            'work_time' => 'required',
        ];
        $messages = [
            'company_job_id.required' => 'Bạn phải chọn vị trí.',
            'quantity.required' => 'Bạn phải nhập số lượng.',
            'reason.required' => 'Bạn phải nhập lý do.',
            'requirement.required' => 'Bạn phải nhập yêu cầu.',
            'work_time.required' => 'Bạn phải nhập thời gian.',
        ];
        $request->validate($rules,$messages);

        //Create new RecruitmentProposal
        $proposal = new RecruitmentProposal();
        $proposal->company_job_id   = $request->company_job_id;
        $proposal->quantity         = $request->quantity;
        $proposal->reason           = $request->reason;
        $proposal->requirement      = $request->requirement;
        if ($request->salary) {
            $proposal->salary       = $request->salary;
        }
        $proposal->work_time        = Carbon::createFromFormat('d/m/Y', $request->work_time);
        if ($request->note) {
            $proposal->note = $request->note;
        }
        $proposal->creator_id     = Auth::user()->id;
        $proposal->status = 'Mở';
        $proposal->save();

        //Send notification to reviewer
        $reviewers = Admin::where('role_id', 4)->get(); //4: Nhân sự
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
        $methods = RecruitmentMethod::orderBy('name' ,'asc')->get();
        $receive_methods = CvReceiveMethod::orderBy('name' ,'asc')->get();
        $social_media = RecruitmentSocialMedia::all()->pluck('name', 'id');
        $provinces = Province::orderBy('name' ,'asc')->get();
        $districts = District::orderBy('name' ,'asc')->get();
        $communes = Commune::orderBy('name' ,'asc')->get();
        $candidates = RecruitmentCandidate::orderBy('id', 'asc')->get();
        $schools = School::orderBy('name', 'asc')->get();
        $degrees = Degree::orderBy('name', 'asc')->get();
        $company_jobs = CompanyJob::orderBy('name', 'asc')->get();
        $documents = Document::orderBy('name', 'asc')->get();
        return view('admin.recruitment.proposal.show',
                    ['proposal' => $proposal,
                     'methods' => $methods,
                     'social_media' => $social_media,
                     'provinces' => $provinces,
                     'districts' => $districts,
                     'communes' => $communes,
                     'receive_methods' => $receive_methods,
                     'candidates' => $candidates,
                     'schools' => $schools,
                     'degrees' => $degrees,
                     'company_jobs' => $company_jobs,
                     'documents' => $documents,
                    ]);
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
        if ('Admin' == Auth::user()->role->name
            || 'Ban lãnh đạo' == Auth::user()->role->name
            || 'Nhân sự' == Auth::user()->role->name) {
            $proposals = RecruitmentProposal::with(['company_job', 'creator', 'reviewer', 'approver'])->orderBy('id', 'desc')->get();

        } else {
            // Only fetch the Proposal according to Admin's department
            $department_ids = [];
            $department_ids = AdminDepartment::where('admin_id', Auth::user()->id)->pluck('department_id')->toArray();
            $company_job_ids = [];
            $company_job_ids = CompanyJob::whereIn('department_id', $department_ids)->pluck('id')->toArray();
            $proposals = RecruitmentProposal::with(['company_job', 'creator', 'reviewer', 'approver'])
                                                ->whereIn('company_job_id', $company_job_ids)
                                                ->orderBy('id', 'desc')
                                                ->get();
        }
        //$proposals = RecruitmentProposal::with(['company_job', 'creator', 'reviewer', 'approver'])->orderBy('id', 'desc')->get();
        return Datatables::of($proposals)
            ->addIndexColumn()
            ->editColumn('company_job', function ($proposals) {
                return '<a href="'.route('admin.recruitment.proposals.show', $proposals->id).'">'.$proposals->company_job->name.'</a>';
            })
            ->editColumn('department', function ($proposals) {
                $department = '';
                if ($proposals->company_job->division_id) {
                    $department = $department . $proposals->company_job->division->name . ' - ';
                }
                $department .= $proposals->company_job->department->name;
                return $department;
            })
            ->editColumn('quantity', function ($proposals) {
                return $proposals->quantity;
            })
            ->editColumn('reason', function ($proposals) {
                return $proposals->reason;
            })
            ->editColumn('work_time', function ($proposals) {
                return date('d/m/Y', strtotime($proposals->work_time));
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


    public function approve(Request $request, $id)
    {
        $rules = [
            'approver_result' => 'required',
        ];
        $messages = [
            'approver_result.required' => 'Bạn phải chọn kết quả.',
        ];
        $request->validate($rules,$messages);

        $proposal = RecruitmentProposal::findOrFail($id);
        $proposal->approver_result = $request->approver_result;
        $proposal->approver_comment = $request->approver_comment;
        $proposal->approver_id = Auth::user()->id;
        $proposal->status = 'Đã duyệt';
        $proposal->save();

        //Send notification to creator and reviewer
        Notification::route('mail' , $proposal->creator->email)->notify(new RecruitmentProposalApproved($proposal->id));
        Notification::route('mail' , $proposal->reviewer->email)->notify(new RecruitmentProposalApproved($proposal->id));

        Alert::toast('Phê duyệt thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
