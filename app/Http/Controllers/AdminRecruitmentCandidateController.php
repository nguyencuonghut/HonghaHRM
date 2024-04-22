<?php

namespace App\Http\Controllers;

use App\Models\RecruitmentCandidate;
use Illuminate\Http\Request;
use App\Notifications\CandidateCvReceived;
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
            'cv_file' => 'required',
            'receive_method' => 'required',
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
            'cv_file.required' => 'Bạn phải chọn file CV.',
            'receive_method.required' => 'Bạn phải chọn cách nhận CV.',
        ];
        $request->validate($rules,$messages);

        $candidate = new RecruitmentCandidate();
        $candidate->proposal_id = $request->proposal_id;
        $candidate->name = $request->name;
        $candidate->email = $request->email;
        $candidate->phone = $request->phone;
        $candidate->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
        $candidate->cccd = $request->cccd;
        $candidate->issued_date = Carbon::createFromFormat('d/m/Y', $request->issued_date);
        $candidate->issued_by = $request->issued_by;
        $candidate->gender = $request->gender;
        $candidate->commune_id = $request->commune_id;
        $candidate->batch = $request->batch;
        $candidate->receive_method = $request->receive_method;
        $candidate->creator_id = Auth::user()->id;
        // Store CV file
        if ($request->hasFile('cv_file')) {
            $path = 'dist/cv';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('cv_file');
            $name = str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $candidate->cv_file = $path . '/' . $name;
        }
        $candidate->save();

        //Send password to candidate's email
        Notification::route('mail' , $candidate->email)->notify(new CandidateCvReceived($candidate->id));

        Alert::toast('Thêm người dùng mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        //
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
        $candidates = RecruitmentCandidate::select(['id', 'name', 'email', 'phone', 'date_of_birth', 'commune_id'])->get();
        return Datatables::of($candidates)
            ->addIndexColumn()
            ->editColumn('name', function ($candidates) {
                return $candidates->name;
            })
            ->editColumn('email', function ($candidates) {
                return $candidates->email;
            })
            ->editColumn('phone', function ($candidates) {
                return $candidates->phone;
            })
            ->editColumn('date_of_birth', function ($candidates) {
                return date('d/m/Y', strtotime($candidates->date_of_birth));
            })
            ->editColumn('addr', function ($candidates) {
                return $candidates->commune->name . ' - ' . $candidates->commune->district->name . ' - ' . $candidates->commune->district->province->name;
            })
            ->addColumn('actions', function ($users) {
                $action = '<a href="' . route("admin.recruitment.candidates.edit", $users->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.recruitment.candidates.destroy", $users->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
