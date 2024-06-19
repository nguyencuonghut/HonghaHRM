<?php

namespace App\Http\Controllers;

use App\Models\Probation;
use Illuminate\Http\Request;
use App\Models\ProposalCandidateEmployee;
use App\Models\ProposalCandidate;
use App\Models\RecruitmentProposal;
use Carbon\Carbon;
use Datatables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AdminProbationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.probation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id hồ sơ nhân sự không hợp lệ.',
            'start_date.required' => 'Bạn phải nhập ngày bắt đầu.',
            'end_date.required' => 'Bạn phải nhập ngày kết thúc.',
        ];

        $request->validate($rules, $messages);

        // Get the last proposal_id
        $last_proposal_candidate_employee = ProposalCandidateEmployee::where('employee_id', $request->employee_id)
                                                                        ->orderBy('id', 'desc')->latest()->first();
        if ($last_proposal_candidate_employee->count()) {
            $last_proposal_candidate = ProposalCandidate::findOrFail($last_proposal_candidate_employee->proposal_candidate_id);
        } else {
            Alert::toast('Không tìm thấy đề xuất tuyển dụng cho kế hoạch thử việc!', 'error', 'top-right');
            return redirect()->back();
        }

        $probation = new Probation();
        $probation->employee_id = $request->employee_id;
        $probation->proposal_id = $last_proposal_candidate->proposal_id;
        $probation->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $probation->end_date = Carbon::createFromFormat('d/m/Y', $request->end_date);
        $probation->creator_id = Auth::user()->id;
        $probation->save();

        Alert::toast('Thêm kế hoạch thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $probation = Probation::findOrFail($id);
        return view('admin.probation.show', ['probation' => $probation]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $probation = Probation::findOrFail($id);

        // Check condition before editing
        if ($probation->approver_result) {
            Alert::toast('Thử việc đã được duyệt. Không thể sửa!', 'error', 'top-right');
            return redirect()->back();
        }
        return view('admin.probation.edit', ['probation' => $probation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $messages = [
            'start_date.required' => 'Bạn phải nhập ngày bắt đầu.',
            'end_date.required' => 'Bạn phải nhập ngày kết thúc.',
        ];

        $request->validate($rules, $messages);

        $probation = Probation::findOrFail($id);

        // Check condition before updating
        if ($probation->approver_result) {
            Alert::toast('Thử việc đã được duyệt. Không thể sửa!', 'error', 'top-right');
            return redirect()->back();
        }
        $probation->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $probation->end_date = Carbon::createFromFormat('d/m/Y', $request->end_date);
        $probation->creator_id = Auth::user()->id;
        $probation->save();

        Alert::toast('Sửa kế hoạch thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $probation = Probation::findOrFail($id);

        // Check condition before destroying
        if ($probation->approver_result) {
            Alert::toast('Thử việc đã được duyệt. Không thể xóa!', 'error', 'top-right');
            return redirect()->back();
        }

        // Delete all Plans
        foreach ($probation->plans as $plan) {
            $plan->destroy($plan->id);
        }

        // Delete probation
        $probation->destroy($id);

        Alert::toast('Xóa kế hoạch thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    public function evaluate(Request $request, $id)
    {
        $rules = [
            'result_of_work' => 'required',
            'result_of_attitude' => 'required',
            'result_manager_status' => 'required'
        ];

        $messages = [
            'result_of_work.required' => 'Bạn phải nhập kết quả công việc.',
            'result_of_attitude.required' => 'Bạn phải nhập ý thức, thái độ.',
            'result_manager_status.required' => 'Bạn phải nhập đánh giá.',
        ];

        $request->validate($rules, $messages);

        $probation = Probation::findOrFail($id);
        $probation->result_of_work = $request->result_of_work;
        $probation->result_of_attitude = $request->result_of_attitude;
        $probation->result_manager_status = $request->result_manager_status;
        $probation->save();

        Alert::toast('Đánh giá kết quả thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    public function review(Request $request, $id)
    {
        $rules = [
            'result_reviewer_status' => 'required'
        ];

        $messages = [
            'result_reviewer_status.required' => 'Bạn phải nhập đánh giá.',
        ];

        $request->validate($rules, $messages);

        $probation = Probation::findOrFail($id);
        $probation->result_reviewer_status = $request->result_reviewer_status;
        $probation->result_review_time = Carbon::now();
        $probation->result_reviewer_id = Auth::user()->id;
        $probation->save();

        Alert::toast('Kiểm tra kết quả thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    public function approve(Request $request, $id)
    {
        $rules = [
            'approver_result' => 'required',
        ];

        $messages = [
            'approver_result.required' => 'Bạn phải nhập kết quả.',
        ];

        $request->validate($rules, $messages);

        $probation = Probation::findOrFail($id);
        $probation->approver_result = $request->approver_result;
        if ($request->approver_comment) {
            $probation->approver_comment = $request->approver_comment;
        }
        $probation->approve_time = Carbon::now();
        $probation->approver_id = Auth::user()->id;
        $probation->save();

        Alert::toast('Duyệt kết quả thử việc thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    public function anyData()
    {
        $probations = Probation::with(['employee', 'creator', 'approver'])->orderBy('id', 'asc')->get();
        return Datatables::of($probations)
            ->addIndexColumn()
            ->editColumn('employee_name', function ($probations) {
                return $probations->employee->name;
            })
            ->editColumn('company_job', function ($probations) {
                $proposal = RecruitmentProposal::findOrFail($probations->proposal_id);
                return $proposal->company_job->name;
            })
            ->editColumn('time', function ($probations) {
                $time = '';
                $time = $time . date('d/m/Y', strtotime($probations->start_date)) . ' - ' . date('d/m/Y', strtotime($probations->end_date));

                return '<a href="'.route('admin.probations.show', $probations->id).'">'.$time.'</a>';
            })
            ->editColumn('creator', function ($probations) {
                if ($probations->result_manager_status) {
                    if ('Đạt' == $probations->result_manager_status) {
                        return $probations->creator->name . ' - ' . '<span class="badge badge-success">' . $probations->result_manager_status . '</span>';
                    } else {
                        return $probations->creator->name . ' - ' . '<span class="badge badge-danger">' . $probations->result_manager_status . '</span>';
                    }
                } else {
                    return $probations->creator->name;
                }
            })
            ->editColumn('approver', function ($probations) {
                if ($probations->approver_id) {
                    if ('Đồng ý' == $probations->approver_result) {
                        return $probations->approver->name . ' - ' . '<span class="badge badge-success">' . $probations->approver_result . '</span>';
                    } else {
                        return $probations->approver->name . ' - ' . '<span class="badge badge-danger">' . $probations->approver_result . '</span>';
                    }
                } else {
                    return '-';
                }
            })
            ->addColumn('actions', function ($probations) {
                $action = '<a href="' . route("admin.probations.edit", $probations->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.probations.destroy", $probations->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions', 'creator', 'approver', 'time'])
            ->make(true);
    }
}
