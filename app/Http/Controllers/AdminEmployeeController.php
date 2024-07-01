<?php

namespace App\Http\Controllers;

use App\Models\AdminDepartment;
use App\Models\Employee;
use App\Models\EmployeeWork;
use App\Models\EmployeeSchool;
use App\Models\EmployeeDocument;
use App\Models\School;
use App\Models\Degree;
use App\Models\Commune;
use App\Models\CompanyJob;
use App\Models\District;
use App\Models\Document;
use App\Models\Probation;
use App\Models\ProposalCandidate;
use App\Models\ProposalCandidateEmployee;
use App\Models\Province;
use App\Models\RecruitmentCandidate;
use App\Models\RecruitmentProposal;
use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeController extends Controller
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
        $degrees = Degree::orderBy('name', 'asc')->get();
        return view('admin.employee.index',
                    [
                        'communes' => $communes,
                        'districts' => $districts,
                        'provinces' => $provinces,
                        'schools' => $schools,
                        'degrees' => $degrees,
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
            'code' => 'required|unique:employees',
            'name' => 'required',
            'img_path' => 'required',
            'phone' => 'required',
            'relative_phone' => 'required',
            'date_of_birth' => 'required',
            'cccd' => 'required|unique:employees',
            'issued_date' => 'required',
            'issued_by' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'commune_id' => 'required',
            'addmore.*.school_id' => 'required',
            'experience' => 'required',
            'join_date' => 'required',
            'marriage_status' => 'required',
        ];
        $messages = [
            'code.required' => 'Bạn phải nhập mã.',
            'code.unique' => 'Mã đã tồn tại.',
            'name.required' => 'Bạn phải nhập tên.',
            'img_path.required' => 'Bạn phải chọn ảnh.',
            'phone.required' => 'Bạn phải nhập số điện thoại.',
            'relative_phone.required' => 'Bạn phải nhập số điện thoại người thân.',
            'date_of_birth.required' => 'Bạn phải nhập ngày sinh.',
            'cccd.required' => 'Bạn phải nhập số CCCD.',
            'cccd.unique' => 'Số CCCD đã tồn tại.',
            'issued_date.required' => 'Bạn phải nhập ngày cấp.',
            'issued_by.required' => 'Bạn phải nhập nơi cấp.',
            'gender.required' => 'Bạn phải chọn giới tính.',
            'address.required' => 'Bạn phải nhập số nhà, thôn, xóm.',
            'commune_id.required' => 'Bạn phải chọn Xã Phường.',
            'addmore.*.school_id.required' => 'Bạn phải nhập tên trường.',
            'experience.required' => 'Bạn phải nhập kinh nghiệm.',
            'join_date.required' => 'Bạn phải nhập ngày vào.',
            'marriage_status.required' => 'Bạn phải nhập tình trạng hôn nhân.',
        ];
        $request->validate($rules,$messages);

        $employee = new Employee();
        $employee->code = $request->code;
        $employee->name = $request->name;
        if ($request->hasFile('img_path')) {
            $path = 'dist/employee_img';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('img_path');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $employee->img_path = $path . '/' . $name;
        }
        if ($request->private_email) {
            $employee->private_email = $request->private_email;
        }
        if ($request->company_email) {
            $employee->company_email = $request->company_email;
        }
        $employee->phone = $request->phone;
        if ($request->relative_phone) {
            $employee->relative_phone = $request->relative_phone;
        }
        $employee->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
        if ($request->cccd) {
            $employee->cccd = $request->cccd;
        }
        if ($request->issued_date) {
            $employee->issued_date = Carbon::createFromFormat('d/m/Y', $request->issued_date);
        }
        if ($request->issued_by) {
            $employee->issued_by = $request->issued_by;
        }
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->commune_id = $request->commune_id;
        if ($request->temp_address) {
            $employee->temporary_address = $request->temp_address;
        }
        if ($request->temp_commune_id) {
            $employee->temporary_commune_id = $request->temp_commune_id;
        }
        $employee->experience = $request->experience;
        $employee->join_date = Carbon::createFromFormat('d/m/Y', $request->join_date);
        $employee->marriage_status = $request->marriage_status;
        $employee->save();

        // Create EmployeeSchool
        foreach ($request->addmore as $item) {
            $employee_school = new EmployeeSchool();
            $employee_school->employee_id = $employee->id;
            $employee_school->degree_id = $item['degree_id'];
            $employee_school->school_id = $item['school_id'];
            if ($item['major']) {
                $employee_school->major = $item['major'];
            }
            $employee_school->save();
        }

        Alert::toast('Thêm nhân sự mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        $documents = Document::all();
        $employee_documents = EmployeeDocument::where('employee_id', $employee->id)->get();
        $employee_works = EmployeeWork::where('employee_id', $employee->id)->get();
        $company_jobs = CompanyJob::all();
        $probations = Probation::all();

        return view('admin.employee.show',
                    ['employee' => $employee,
                    'documents' => $documents,
                    'employee_documents' => $employee_documents,
                    'probations' => $probations,
                    'employee_works' => $employee_works,
                    'company_jobs' => $company_jobs,
                    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $communes = Commune::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        $provinces = Province::orderBy('name', 'asc')->get();
        $schools = School::orderBy('name', 'asc')->get();
        $degrees = Degree::orderBy('name', 'asc')->get();
        $employee = Employee::findOrFail($id);

        return view('admin.employee.edit',
                    [
                        'employee' => $employee,
                        'communes' => $communes,
                        'districts' => $districts,
                        'provinces' => $provinces,
                        'schools' => $schools,
                        'degrees' => $degrees,
                    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'code' => 'required|unique:employees,code,'.$id,
            'name' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'relative_phone' => 'required',
            'date_of_birth' => 'required',
            'cccd' => 'required|unique:employees,cccd,'.$id,
            'name' => 'required',
            'issued_date' => 'required',
            'issued_by' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'commune_id' => 'required',
            'addmore.*.school_id' => 'required',
            'experience' => 'required',
            'join_date' => 'required',
            'marriage_status' => 'required',
        ];
        $messages = [
            'code.required' => 'Bạn phải nhập mã.',
            'code.unique' => 'Mã đã tồn tại.',
            'name.required' => 'Bạn phải nhập tên.',
            'phone.required' => 'Bạn phải nhập số điện thoại.',
            'relative_phone.required' => 'Bạn phải nhập số điện thoại người thân.',
            'date_of_birth.required' => 'Bạn phải nhập ngày sinh.',
            'cccd.required' => 'Bạn phải nhập số CCCD.',
            'cccd.unique' => 'Số CCCD đã tồn tại.',
            'issued_date.required' => 'Bạn phải nhập ngày cấp.',
            'issued_by.required' => 'Bạn phải nhập nơi cấp.',
            'gender.required' => 'Bạn phải chọn giới tính.',
            'address.required' => 'Bạn phải nhập số nhà, thôn, xóm.',
            'commune_id.required' => 'Bạn phải chọn Xã Phường.',
            'addmore.*.school_id.required' => 'Bạn phải nhập tên trường.',
            'experience.required' => 'Bạn phải nhập kinh nghiệm.',
            'join_date.required' => 'Bạn phải nhập ngày vào.',
            'marriage_status.required' => 'Bạn phải nhập tình trạng hôn nhân.',
        ];
        $request->validate($rules,$messages);

        $employee = Employee::findOrFail($id);
        $employee->code = $request->code;
        $employee->name = $request->name;
        if ($request->hasFile('img_path')) {
            $path = 'dist/employee_img';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('img_path');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $employee->img_path = $path . '/' . $name;
        }
        if ($request->private_email) {
            $employee->private_email = $request->private_email;
        }
        if ($request->company_email) {
            $employee->company_email = $request->company_email;
        }
        $employee->phone = $request->phone;
        if ($request->relative_phone) {
            $employee->relative_phone = $request->relative_phone;
        }
        $employee->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
        if ($request->cccd) {
            $employee->cccd = $request->cccd;
        }
        if ($request->issued_date) {
            $employee->issued_date = Carbon::createFromFormat('d/m/Y', $request->issued_date);
        }
        if ($request->issued_by) {
            $employee->issued_by = $request->issued_by;
        }
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->commune_id = $request->commune_id;
        if ($request->temp_address) {
            $employee->temporary_address = $request->temp_address;
        }
        if ($request->temp_commune_id) {
            $employee->temporary_commune_id = $request->temp_commune_id;
        }
        $employee->experience = $request->experience;
        $employee->join_date = Carbon::createFromFormat('d/m/Y', $request->join_date);
        $employee->marriage_status = $request->marriage_status;
        $employee->save();

        //Delete all old EmployeeSchool
        $old_employee_schools = EmployeeSchool::where('employee_id', $employee->id)->get();
        foreach($old_employee_schools as $item) {
            $item->destroy($item->id);
        }

        // Create EmployeeSchool
        foreach ($request->addmore as $item) {
            $employee_school = new EmployeeSchool();
            $employee_school->employee_id = $employee->id;
            $employee_school->degree_id = $item['degree_id'];
            $employee_school->school_id = $item['school_id'];
            if ($item['major']) {
                $employee_school->major = $item['major'];
            }
            $employee_school->save();
        }

        Alert::toast('Sửa nhân sự mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->destroy($employee->id);
        Alert::toast('Xóa nhân sự thành công!', 'success', 'top-right');
        return redirect()->back();
    }



    public function anyData()
    {
        if ('Trưởng đơn vị' == Auth::user()->role->name) {
            // Only fetch the Employee according to Admin's Department
            $department_ids = AdminDepartment::where('admin_id', Auth::user()->id)->pluck('department_id')->toArray();
            $company_job_ids = CompanyJob::whereIn('department_id', $department_ids)->pluck('id')->toArray();
            $employee_ids = EmployeeWork::whereIn('company_job_id', $company_job_ids)->pluck('employee_id')->toArray();
            $employees = Employee::with(['commune'])->whereIn('id', $employee_ids)->orderBy('name', 'desc')->get();
        } else {
            $employees = Employee::with(['commune'])->orderBy('name', 'desc')->get();
        }
        return Datatables::of($employees)
            ->addIndexColumn()
            ->editColumn('code', function ($employees) {
                return $employees->code;
            })
            ->editColumn('name', function ($employees) {
                return '<a href="'.route('admin.hr.employees.show', $employees->id).'">'.$employees->name.'</a>';
            })
            ->editColumn('email', function ($employees) {
                $email = '';
                if ($employees->private_email) {
                    $email .= $employees->private_email;
                }
                if ($employees->company_email) {
                    $email .= '<br>' . ' ' . $employees->company_email;
                }
                return $email;
            })
            ->editColumn('phone', function ($employees) {
                return $employees->phone;
            })
            ->editColumn('addr', function ($employees) {
                return $employees->address . ', ' .  $employees->commune->name .', ' .  $employees->commune->district->name .', ' . $employees->commune->district->province->name;
            })
            ->editColumn('cccd', function ($employees) {
                return $employees->cccd;
            })
            ->editColumn('temp_addr', function ($employees) {
                if ($employees->temporary_address) {
                    return $employees->temporary_address . ', ' .  $employees->temporary_commune->name .', ' .  $employees->temporary_commune->district->name .', ' . $employees->temporary_commune->district->province->name;
                } else {
                    return '-';
                }
            })
            ->addColumn('actions', function ($employees) {
                $action = '<a href="' . route("admin.hr.employees.edit", $employees->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.hr.employees.destroy", $employees->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions', 'name', 'email'])
            ->make(true);
    }

    public function createFromCandidate($proposal_candidate_id)
    {
        $proposal_candidate = ProposalCandidate::findOrFail($proposal_candidate_id);
        $candidate = RecruitmentCandidate::findOrFail($proposal_candidate->candidate_id);
        $proposal = RecruitmentProposal::findOrFail($proposal_candidate->proposal_id);
        $communes = Commune::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        $provinces = Province::orderBy('name', 'asc')->get();
        $schools = School::orderBy('name', 'asc')->get();
        $degrees = Degree::orderBy('name', 'asc')->get();
        $company_jobs = CompanyJob::orderBy('name', 'asc')->get();

        return view('admin.employee.create_from_candidate',
                    [
                        'communes' => $communes,
                        'districts' => $districts,
                        'provinces' => $provinces,
                        'schools' => $schools,
                        'degrees' => $degrees,
                        'company_jobs' => $company_jobs,
                        'proposal_candidate' => $proposal_candidate,
                        'candidate' => $candidate,
                        'proposal' => $proposal
                    ]);
    }

    public function storeFromCandidate(Request $request)
    {
        $rules = [
            'proposal_candidate_id' => 'required',
            'code' => 'required|unique:employees',
            'name' => 'required',
            'img_path' => 'required',
            'phone' => 'required',
            'relative_phone' => 'required',
            'date_of_birth' => 'required',
            'cccd' => 'required|unique:employees',
            'issued_date' => 'required',
            'issued_by' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'commune_id' => 'required',
            'company_job_id' => 'required',
            'addmore.*.school_name' => 'required',
            'addmore.*.degree_name' => 'required',
            'experience' => 'required',
            'join_date' => 'required',
            'marriage_status' => 'required',
        ];
        $messages = [
            'proposal_candidate_id.required' => 'proposal_candidate_id không hợp lệ.',
            'code.required' => 'Bạn phải nhập mã.',
            'code.unique' => 'Mã đã tồn tại.',
            'name.required' => 'Bạn phải nhập tên.',
            'img_path.required' => 'Bạn phải chọn ảnh.',
            'phone.required' => 'Bạn phải nhập số điện thoại.',
            'relative_phone.required' => 'Bạn phải nhập số điện thoại người thân.',
            'date_of_birth.required' => 'Bạn phải nhập ngày sinh.',
            'cccd.required' => 'Bạn phải nhập số CCCD.',
            'cccd.unique' => 'Số CCCD đã tồn tại.',
            'issued_date.required' => 'Bạn phải nhập ngày cấp.',
            'issued_by.required' => 'Bạn phải nhập nơi cấp.',
            'gender.required' => 'Bạn phải chọn giới tính.',
            'address.required' => 'Bạn phải nhập số nhà, thôn, xóm.',
            'commune_id.required' => 'Bạn phải chọn Xã Phường.',
            'company_job_id.required' => 'Bạn phải chọn vị trí.',
            'addmore.*.school_name.required' => 'Bạn phải nhập tên trường.',
            'addmore.*.degree_name.required' => 'Bạn phải nhập trình độ.',
            'experience.required' => 'Bạn phải nhập kinh nghiệm.',
            'join_date.required' => 'Bạn phải nhập ngày vào.',
            'marriage_status.required' => 'Bạn phải nhập tình trạng hôn nhân.',
        ];

        // Check if Employee is existed
        $existed_employee = Employee::where('name', $request->name)
                                    ->whereDate('date_of_birth', Carbon::createFromFormat('d/m/Y', $request->date_of_birth))
                                    ->where('commune_id', $request->commune_id)
                                    ->first();
        if ($existed_employee) {
            // Create ProposalCandidateEmployee
            $proposal_candidate_employee = new ProposalCandidateEmployee();
            $proposal_candidate_employee->proposal_candidate_id = $request->proposal_candidate_id;
            $proposal_candidate_employee->employee_id = $existed_employee->id;
            $proposal_candidate_employee->save();

            Alert::toast('Nhân sự đã có hồ sơ!', 'error', 'top-right');
            return redirect()->back();
        }

        $request->validate($rules,$messages);

        $employee = new Employee();
        $employee->code = $request->code;
        $employee->name = $request->name;
        if ($request->hasFile('img_path')) {
            $path = 'dist/employee_img';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('img_path');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $employee->img_path = $path . '/' . $name;
        }
        if ($request->private_email) {
            $employee->private_email = $request->private_email;
        }
        if ($request->company_email) {
            $employee->company_email = $request->company_email;
        }
        $employee->phone = $request->phone;
        if ($request->relative_phone) {
            $employee->relative_phone = $request->relative_phone;
        }
        $employee->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
        if ($request->cccd) {
            $employee->cccd = $request->cccd;
        }
        if ($request->issued_date) {
            $employee->issued_date = Carbon::createFromFormat('d/m/Y', $request->issued_date);
        }
        if ($request->issued_by) {
            $employee->issued_by = $request->issued_by;
        }
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->commune_id = $request->commune_id;
        if ($request->temp_address) {
            $employee->temporary_address = $request->temp_address;
        }
        if ($request->temp_commune_id) {
            $employee->temporary_commune_id = $request->temp_commune_id;
        }
        $employee->experience = $request->experience;
        $employee->join_date = Carbon::createFromFormat('d/m/Y', $request->join_date);
        $employee->marriage_status = $request->marriage_status;
        $employee->save();

        // Create EmployeeWork
        $employee_work = new EmployeeWork();
        $employee_work->employee_id = $employee->id;
        $employee_work->company_job_id = $request->company_job_id;
        $employee_work->status = 'On';
        $employee_work->start_date = Carbon::today()->toDateString();
        $employee_work->save();

        // Create EmployeeSchool
        foreach ($request->addmore as $item) {
            $employee_school = new EmployeeSchool();
            $employee_school->employee_id = $employee->id;
            $school = School::where('name', $item['school_name'])->first();
            $degree = Degree::where('name', $item['degree_name'])->first();
            $employee_school->degree_id = $degree->id;
            $employee_school->school_id = $school->id;
            if ($item['major']) {
                $employee_school->major = $item['major'];
            }
            $employee_school->save();
        }

        // Create ProposalCandidateEmployee
        $proposal_candidate_employee = new ProposalCandidateEmployee();
        $proposal_candidate_employee->proposal_candidate_id = $request->proposal_candidate_id;
        $proposal_candidate_employee->employee_id = $employee->id;
        $proposal_candidate_employee->save();

        Alert::toast('Thêm nhân sự mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee->id);
    }

    public function gallery(Request $request)
    {
        $search =  $request->input('search');
        if ($search != ""){
            $employees = Employee::with('commune')->where(function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('company_email', 'like', '%'.$search.'%')
                    ->orWhere('date_of_birth', 'like', '%'.$search.'%')
                    ->orWhere('cccd', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('code', 'like', '%'.$search.'%')
                    ->orWhereHas('commune' ,function($q) use ($search) {
                        $q->where('name', 'like', '%'.$search.'%');
                    });
            })
            ->paginate(9);
        } else {
            $employees = Employee::orderBy('name', 'asc')->paginate(9);
        }

        $communes = Commune::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        $provinces = Province::orderBy('name', 'asc')->get();
        $schools = School::orderBy('name', 'asc')->get();
        $degrees = Degree::orderBy('name', 'asc')->get();

        return view('admin.employee.gallery',
                    [
                        'employees' => $employees,
                        'communes' => $communes,
                        'districts' => $districts,
                        'provinces' => $provinces,
                        'schools' => $schools,
                        'degrees' => $degrees,
                    ]);
    }
}
