<?php

namespace App\Http\Controllers;

use App\Models\RecruitmentMethod;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminRecruitmentMethodController extends Controller
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
        ];

        $messages = [
            'name.required' => 'Bạn phải nhập tên',
        ];

        $request->validate($rules, $messages);

        $recruitment_method = new RecruitmentMethod();
        $recruitment_method->name = $request->name;
        $recruitment_method->save();

        Alert::toast('Thêm cách thử tuyển mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(RecruitmentMethod $recruitmentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecruitmentMethod $recruitmentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecruitmentMethod $recruitmentMethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecruitmentMethod $recruitmentMethod)
    {
        //
    }
}
