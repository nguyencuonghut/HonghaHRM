<?php

namespace App\Http\Controllers;

use App\Models\ProposalCandidateDocument;
use App\Models\Document;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminProposalCandidateDocumentController extends Controller
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
            'document_id' => 'required',
            'status' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'document_id.required' => 'Bạn phải chọn tên giấy tờ',
            'status.required' => 'Bạn phải chọn trạng thái.',
        ];

        $request->validate($rules,$messages);

        // Check if proposal candidate document existed or not
        $my_proposal_candidate_document = ProposalCandidateDocument::where('proposal_candidate_id', $request->proposal_candidate_id)
                                                                            ->where('document_id', $request->document_id)
                                                                            ->get();
        if ($my_proposal_candidate_document) {
            Alert::toast('Giấy tờ đã được khai báo!', 'error', 'top-right');
            return redirect()->back();
        }

        // Create new
        $proposal_candidate_document = new ProposalCandidateDocument();
        $proposal_candidate_document->proposal_candidate_id = $request->proposal_candidate_id;
        $proposal_candidate_document->document_id = $request->document_id;
        $proposal_candidate_document->status = $request->status;
        $proposal_candidate_document->save();

        Alert::toast('Tạo trạng thái giấy tờ thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProposalCandidateDocument $proposalCandidateDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'proposal_candidate_id' => 'required',
            'document_id' => 'required',
            'status' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'document_id.required' => 'Bạn phải chọn tên giấy tờ',
            'status.required' => 'Bạn phải chọn trạng thái.',
        ];

        $request->validate($rules,$messages);

        $proposal_candidate_document = ProposalCandidateDocument::findOrFail($id);
        $proposal_candidate_document->proposal_candidate_id = $request->proposal_candidate_id;
        $proposal_candidate_document->document_id = $request->document_id;
        $proposal_candidate_document->status = $request->status;
        $proposal_candidate_document->save();

        Alert::toast('Sửa trạng thái giấy tờ thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $proposal_candidate_document = ProposalCandidateDocument::findOrFail($id);
        $proposal_candidate_document->destroy($proposal_candidate_document->id);

        Alert::toast('Xóa thái giấy tờ thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
