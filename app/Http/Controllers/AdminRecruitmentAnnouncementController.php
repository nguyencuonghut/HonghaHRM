<?php

namespace App\Http\Controllers;

use App\Models\RecruitmentAnnouncement;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminRecruitmentAnnouncementController extends Controller
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
            'social_media_id' => 'required',
        ];
        $messages = [
            'social_media_id.required' => 'Bạn phải chọn kênh.',
        ];
        $request->validate($rules,$messages);

        //Create new RecruitmentAnnouncement
        $announcement = new RecruitmentAnnouncement();
        $announcement->proposal_id = $request->proposal_id;
        $announcement->status = 'Đã đăng';
        $announcement->save();

        //Create announcement_social_media pivot item
        $announcement->social_media()->attach($request->social_media_id);

        Alert::toast('Thêm kế hoạch tuyển dụng mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.recruitment.proposals.show', $announcement->proposal_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(RecruitmentAnnouncement $recruitmentAnnouncement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecruitmentAnnouncement $recruitmentAnnouncement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecruitmentAnnouncement $recruitmentAnnouncement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecruitmentAnnouncement $recruitmentAnnouncement)
    {
        //
    }
}
