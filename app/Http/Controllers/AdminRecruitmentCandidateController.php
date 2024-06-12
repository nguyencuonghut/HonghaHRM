<?php

namespace App\Http\Controllers;

use App\Models\RecruitmentCandidate;
use App\Models\RecruitmentProposal;
use App\Models\ProposalCandidate;
use App\Models\School;
use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use App\Models\CandidateSchool;
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
        $communes = Commune::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        $provinces = Province::orderBy('name', 'asc')->get();
        $schools = School::orderBy('name', 'asc')->get();
        return view('admin.candidate.index',
                    [
                        'communes' => $communes,
                        'districts' => $districts,
                        'provinces' => $provinces,
                        'schools' => $schools,
                    ]);
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
            'phone' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'commune_id' => 'required',
            'addmore.*.school_id' => 'required',
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'phone.required' => 'Bạn phải nhập số điện thoại.',
            'date_of_birth.required' => 'Bạn phải nhập ngày sinh.',
            'gender.required' => 'Bạn phải chọn giới tính.',
            'address.required' => 'Bạn phải nhập số nhà, thôn, xóm.',
            'commune_id.required' => 'Bạn phải chọn Xã Phường.',
            'addmore.*.school_id.required' => 'Bạn phải nhập tên trường.',
        ];
        $request->validate($rules,$messages);

        $candidate = new RecruitmentCandidate();
        $candidate->name = $request->name;
        if ($request->email) {
            $candidate->email = $request->email;
        }
        $candidate->phone = $request->phone;
        if ($request->relative_phone) {
            $candidate->relative_phone = $request->relative_phone;
        }
        $candidate->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
        if ($request->cccd) {
            $candidate->cccd = $request->cccd;
        }
        if ($request->issued_date) {
            $candidate->issued_date = Carbon::createFromFormat('d/m/Y', $request->issued_date);
        }
        if ($request->issued_by) {
            $candidate->issued_by = $request->issued_by;
        }
        $candidate->gender = $request->gender;
        $candidate->address = $request->address;
        $candidate->commune_id = $request->commune_id;
        $candidate->experience = $request->experience;
        if ($request->note) {
            $candidate->issued_by = $request->note;
        }
        $candidate->creator_id = Auth::user()->id;
        $candidate->save();

        // Create CandidateSchool
        foreach ($request->addmore as $item) {
            $candidate_school = new CandidateSchool();
            $candidate_school->candidate_id = $candidate->id;
            $candidate_school->school_id = $item['school_id'];
            if ($item['major']) {
                $candidate_school->major = $item['major'];
            }
            $candidate_school->save();
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
    public function edit($id)
    {
        $candidate = RecruitmentCandidate::findOrFail($id);
        $communes = Commune::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        $provinces = Province::orderBy('name', 'asc')->get();
        $schools = School::orderBy('name', 'asc')->get();
        return view('admin.candidate.edit',
                    ['candidate' => $candidate,
                    'communes' => $communes,
                    'districts' => $districts,
                    'provinces' => $provinces,
                    'schools' => $schools,
                    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'commune_id' => 'required',
            'addmore.*.school_id' => 'required',
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'phone.required' => 'Bạn phải nhập số điện thoại.',
            'date_of_birth.required' => 'Bạn phải nhập ngày sinh.',
            'gender.required' => 'Bạn phải chọn giới tính.',
            'address.required' => 'Bạn phải nhập số nhà, thôn, xóm.',
            'commune_id.required' => 'Bạn phải chọn Xã Phường.',
            'addmore.*.school_id.required' => 'Bạn phải nhập tên trường.',
        ];
        $request->validate($rules,$messages);

        $candidate = RecruitmentCandidate::findOrFail($id);
        $candidate->name = $request->name;
        if ($request->email) {
            $candidate->email = $request->email;
        }
        $candidate->phone = $request->phone;
        if ($request->relative_phone) {
            $candidate->relative_phone = $request->relative_phone;
        }
        $candidate->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
        if ($request->cccd) {
            $candidate->cccd = $request->cccd;
        }
        if ($request->issued_date) {
            $candidate->issued_date = Carbon::createFromFormat('d/m/Y', $request->issued_date);
        }
        if ($request->issued_by) {
            $candidate->issued_by = $request->issued_by;
        }
        $candidate->gender = $request->gender;
        $candidate->address = $request->address;
        $candidate->commune_id = $request->commune_id;
        $candidate->experience = $request->experience;
        if ($request->note) {
            $candidate->issued_by = $request->note;
        }
        $candidate->creator_id = Auth::user()->id;
        $candidate->save();

        //Delete all old CandidateSchool
        $old_candidate_schools = CandidateSchool::where('candidate_id', $candidate->id)->get();
        foreach($old_candidate_schools as $item) {
            $item->destroy($item->id);
        }

        // Create CandidateSchool
        foreach ($request->addmore as $item) {
            //dd($item['major']);
            $candidate_school = new CandidateSchool();
            $candidate_school->candidate_id = $candidate->id;
            $candidate_school->school_id = $item['school_id'];
            if ($item['major']) {
                $candidate_school->major = $item['major'];
            }
            $candidate_school->save();
        }

        Alert::toast('Sửa ứng viên thành công!', 'success', 'top-right');
        return redirect()->route('admin.recruitment.candidates.show', $candidate->id);
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
                return $candidates->address . ', ' .  $candidates->commune->name .', ' .  $candidates->commune->district->name .', ' . $candidates->commune->district->province->name;
            })
            ->editColumn('cccd', function ($candidates) {
                return $candidates->cccd;
            })
            ->addColumn('recruitments', function ($candidates) {
                $recruitments = '';
                foreach ($candidates->proposals as $proposal) {
                    $url = '<a href="' . route('admin.recruitment.proposals.show', $proposal->id) . '">' . $proposal->company_job->name . '</a>';
                    $recruitments = $recruitments . ' - ' . $url . '<br>';
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
