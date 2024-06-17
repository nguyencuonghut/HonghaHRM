<?php

namespace App\Http\Controllers;

use App\Models\Probation;
use Illuminate\Http\Request;
use App\Models\ProposalCandidateEmployee;
use App\Models\ProposalCandidate;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AdminProbationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Probation $probation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Probation $probation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Probation $probation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Probation $probation)
    {
        //
    }
}
