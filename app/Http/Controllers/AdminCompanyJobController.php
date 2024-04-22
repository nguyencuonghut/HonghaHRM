<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminCompanyJobController extends Controller
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
            'name' => 'required',
            'sel_department' => 'required',
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'sel_department.required' => 'Bạn phải chọn phòng ban.',
        ];
        $request->validate($rules,$messages);

        $job = new Job();
        $job->name = $request->name;
        $job->department_id = $request->sel_department;
        if ($request->division_id) {
            $job->division_id = $request->sel_division;
        }
        $job->save();

        Alert::toast('Thêm vị trí mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //
    }
}
