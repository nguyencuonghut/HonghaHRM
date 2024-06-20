<?php

namespace App\Http\Controllers;

use App\Models\RecruitmentSocialMedia;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminRecruitmentSocialMediaController extends Controller
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

        $recruitment_social_media = new RecruitmentSocialMedia();
        $recruitment_social_media->name = $request->name;
        $recruitment_social_media->save();

        Alert::toast('Thêm kênh đăng tin mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(RecruitmentSocialMedia $recruitmentSocialMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecruitmentSocialMedia $recruitmentSocialMedia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecruitmentSocialMedia $recruitmentSocialMedia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecruitmentSocialMedia $recruitmentSocialMedia)
    {
        //
    }
}
