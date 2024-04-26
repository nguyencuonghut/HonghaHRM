<?php

namespace App\Http\Controllers;

use App\Models\RecruitmentCandidate;
use App\Models\RecruitmentProposal;
use App\Models\ProposalCandidate;
use App\Models\CandidateEducation;
use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdminRecruitmentCandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.candidate.index');
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
            'proposal_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'date_of_birth' => 'required',
            'cccd' => 'required',
            'issued_date' => 'required',
            'issued_by' => 'required',
            'gender' => 'required',
            'commune_id' => 'required',
            'addmore.*.education_id' => 'required',
        ];
        $messages = [
            'proposal_id.required' => 'Số phiếu đề nghị tuyển dụng không hợp lệ.',
            'name.required' => 'Bạn phải nhập tên.',
            'email.required' => 'Bạn phải nhập địa chỉ email.',
            'email.email' => 'Email sai định dạng.',
            'email.max' => 'Email dài quá 255 ký tự.',
            'phone.required' => 'Bạn phải số điện thoại.',
            'date_of_birth.required' => 'Bạn phải nhập ngày sinh.',
            'cccd.required' => 'Bạn phải nhập số CCCD.',
            'issued_date.required' => 'Bạn phải nhập ngày cấp.',
            'issued_by.required' => 'Bạn phải nhập nơi cấp.',
            'gender.required' => 'Bạn phải chọn giới tính.',
            'commune_id.required' => 'Bạn phải chọn Xã Phường.',
            'addmore.*.education_id.required' => 'Bạn phải nhập tên trường.',
        ];
        $request->validate($rules,$messages);

        $candidate = new RecruitmentCandidate();
        $candidate->name = $request->name;
        $candidate->email = $request->email;
        $candidate->phone = $request->phone;
        $candidate->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
        $candidate->cccd = $request->cccd;
        $candidate->issued_date = Carbon::createFromFormat('d/m/Y', $request->issued_date);
        $candidate->issued_by = $request->issued_by;
        $candidate->gender = $request->gender;
        $candidate->commune_id = $request->commune_id;
        $candidate->creator_id = Auth::user()->id;
        $candidate->save();

        // Create CandidateEducation
        foreach ($request->addmore as $item) {
            //dd($item['major']);
            $candidate_education = new CandidateEducation();
            $candidate_education->candidate_id = $candidate->id;
            $candidate_education->education_id = $item['education_id'];
            if ($item['major']) {
                $candidate_education->major = $item['major'];
            }
            $candidate_education->save();
        }

        Alert::toast('Thêm ứng viên mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $candidate = RecruitmentCandidate::findOrFail($id);

        return view('admin.candidate.show', ['candidate' => $candidate]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        //
    }


    public function anyData()
    {
        $candidates = RecruitmentCandidate::with(['commune', 'proposals'])->orderBy('name', 'desc')->get();
        return Datatables::of($candidates)
            ->addIndexColumn()
            ->editColumn('name', function ($candidates) {
                return '<a href="'.route('admin.recruitment.candidates.show', $candidates->id).'">'.$candidates->name.'</a>';
            })
            ->editColumn('email', function ($candidates) {
                return $candidates->email;
            })
            ->editColumn('phone', function ($candidates) {
                return $candidates->phone;
            })
            ->editColumn('addr', function ($candidates) {
                return $candidates->commune->name .' - ' .  $candidates->commune->district->name .' - ' . $candidates->commune->district->province->name;
            })
            ->editColumn('cccd', function ($candidates) {
                return $candidates->cccd;
            })
            ->addColumn('recruitments', function ($candidates) {
                $recruitments = '';
                foreach ($candidates->proposals as $proposal) {
                    $recruitments = $recruitments . ' - ' . $proposal->company_job->name . '<br>';
                }
                return $recruitments;
            })
            ->addColumn('actions', function ($candidates) {
                $action = '<a href="' . route("admin.recruitment.candidates.edit", $candidates->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.recruitment.candidates.destroy", $candidates->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions', 'name', 'recruitments'])
            ->make(true);
    }
}
