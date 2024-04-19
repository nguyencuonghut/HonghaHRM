<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\RecruitmentPlan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class AdminRecruitmentPlanController extends Controller
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
            'method_id' => 'required',
        ];
        $messages = [
            'method_id.required' => 'Bạn phải chọn cách thức.',
        ];
        $request->validate($rules,$messages);

        //Create new RecruitmentPlan
        $plan = new RecruitmentPlan();
        $plan->proposal_id          = $request->proposal_id;
        if ($request->budget) {
            $plan->budget       = $request->budget;
        }
        $plan->creator_id = Auth::user()->id;
        $plan->status = 'Mở';
        $plan->save();

        //Create plan_method pivot item
        $plan->methods()->attach($request->method_id);

        //Send notification to approver
        $approvers = Admin::where('role_id', 2)->get(); //2: Ban lãnh đạo
        foreach ($approvers as $approver) {
            //Notification::route('mail' , $approver->email)->notify(new RecruitmentPlanCreated($plan->id));
        }

        Alert::toast('Thêm kế hoạch tuyển dụng mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.recruitment.proposals.show', $plan->proposal_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(RecruitmentPlan $recruitmentPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecruitmentPlan $recruitmentPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecruitmentPlan $recruitmentPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecruitmentPlan $recruitmentPlan)
    {
        //
    }
}
