<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AdminOfferController extends Controller
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
            'proposal_candidate_id' => 'required',
            'current_salary' => 'required',
            'desired_salary' => 'required',
            'feedback' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'current_salary.required' => 'Bạn phải nhập lương hiện tại',
            'desired_salary.required' => 'Bạn phải nhập lương yêu cầu.',
            'feedback.required' => 'Bạn phải nhập phản hồi.',
        ];

        $request->validate($rules,$messages);

        $offer = new Offer();
        $offer->proposal_candidate_id = $request->proposal_candidate_id;
        $offer->current_salary = $request->current_salary;
        $offer->desired_salary = $request->desired_salary;
        $offer->feedback = $request->feedback;
        if ($request->detail) {
            $offer->detail = $request->detail;
        }
        if ($request->offer_note) {
            $offer->note = $request->offer_note;
        }
        $offer->creator_id = Auth::user()->id;
        $offer->save();

        Alert::toast('Nhập dữ liệu thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $proposal_candidate_id)
    {
        $rules = [
            'proposal_candidate_id' => 'required',
            'current_salary' => 'required',
            'desired_salary' => 'required',
            'feedback' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'current_salary.required' => 'Bạn phải nhập lương hiện tại',
            'desired_salary.required' => 'Bạn phải nhập lương yêu cầu.',
            'feedback.required' => 'Bạn phải nhập phản hồi.',
        ];

        $request->validate($rules,$messages);

        $offer = Offer::where('proposal_candidate_id', $proposal_candidate_id)->first();
        $offer->proposal_candidate_id = $request->proposal_candidate_id;
        $offer->current_salary = $request->current_salary;
        $offer->desired_salary = $request->desired_salary;
        $offer->feedback = $request->feedback;
        if ($request->detail) {
            $offer->detail = $request->detail;
        }
        if ($request->offer_note) {
            $offer->note = $request->offer_note;
        }
        $offer->creator_id = Auth::user()->id;
        $offer->save();

        Alert::toast('Sửa đề xuất thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($proposal_candidate_id)
    {
        $offer = Offer::where('proposal_candidate_id', $proposal_candidate_id)->first();
        $offer->destroy($offer->id);
        Alert::toast('Xóa đề xuất thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
