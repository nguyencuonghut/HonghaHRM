<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeEducation;
use App\Models\Education;
use App\Models\Commune;
use App\Models\CompanyJob;
use App\Models\District;
use App\Models\Province;
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
        $educations = Education::orderBy('name', 'asc')->get();
        $company_jobs = CompanyJob::orderBy('name', 'asc')->get();
        return view('admin.employee.index',
                    [
                        'communes' => $communes,
                        'districts' => $districts,
                        'provinces' => $provinces,
                        'educations' => $educations,
                        'company_jobs' => $company_jobs,
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
            'private_email' => 'unique:employees',
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
            'addmore.*.education_id' => 'required',
        ];
        $messages = [
            'code.required' => 'Bạn phải nhập mã.',
            'code.unique' => 'Mã đã tồn tại.',
            'name.required' => 'Bạn phải nhập tên.',
            'img_path.required' => 'Bạn phải chọn ảnh.',
            'private_email.unique' => 'Email cá nhân đã tồn tại.',
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
            'addmore.*.education_id.required' => 'Bạn phải nhập tên trường.',
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
        $employee->company_job_id = $request->company_job_id;
        $employee->save();

        // Create EmployeeEducation
        foreach ($request->addmore as $item) {
            $employee_education = new EmployeeEducation();
            $employee_education->employee_id = $employee->id;
            $employee_education->education_id = $item['education_id'];
            if ($item['major']) {
                $employee_education->major = $item['major'];
            }
            $employee_education->save();
        }

        Alert::toast('Thêm nhân sự mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $communes = Commune::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        $provinces = Province::orderBy('name', 'asc')->get();
        $educations = Education::orderBy('name', 'asc')->get();
        $company_jobs = CompanyJob::orderBy('name', 'asc')->get();
        $employee = Employee::findOrFail($id);
        return view('admin.employee.edit',
                    [
                        'employee' => $employee,
                        'communes' => $communes,
                        'districts' => $districts,
                        'provinces' => $provinces,
                        'educations' => $educations,
                        'company_jobs' => $company_jobs,
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
            'private_email' => 'unique:employees,private_email,'.$id,
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
            'company_job_id' => 'required',
            'addmore.*.education_id' => 'required',
        ];
        $messages = [
            'code.required' => 'Bạn phải nhập mã.',
            'code.unique' => 'Mã đã tồn tại.',
            'name.required' => 'Bạn phải nhập tên.',
            'private_email.unique' => 'Email cá nhân đã tồn tại.',
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
            'addmore.*.education_id.required' => 'Bạn phải nhập tên trường.',
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
        $employee->company_job_id = $request->company_job_id;
        $employee->save();

        //Delete all old EmployeeEducation
        $old_employee_educations = EmployeeEducation::where('employee_id', $employee->id)->get();
        foreach($old_employee_educations as $item) {
            $item->destroy($item->id);
        }

        // Create EmployeeEducation
        foreach ($request->addmore as $item) {
            $employee_education = new EmployeeEducation();
            $employee_education->employee_id = $employee->id;
            $employee_education->education_id = $item['education_id'];
            if ($item['major']) {
                $employee_education->major = $item['major'];
            }
            $employee_education->save();
        }

        Alert::toast('Sửa nhân sự mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.employees.index');
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
        $employees = Employee::with(['commune', 'company_job'])->orderBy('name', 'desc')->get();
        return Datatables::of($employees)
            ->addIndexColumn()
            ->editColumn('code', function ($employees) {
                return $employees->company_job->department->code . $employees->code;
            })
            ->editColumn('name', function ($employees) {
                return '<a href="'.route('admin.employees.show', $employees->id).'">'.$employees->name.'</a>';
            })
            ->editColumn('email', function ($employees) {
                $email = '';
                if ($employees->private_email) {
                    $email .= $employees->private_email;
                }
                if ($employees->company_email) {
                    $email .= ',<br>' . ' ' . $employees->company_email;
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
                return $employees->temporary_address . ', ' .  $employees->temporary_commune->name .', ' .  $employees->temporary_commune->district->name .', ' . $employees->temporary_commune->district->province->name;
            })
            ->addColumn('actions', function ($employees) {
                $action = '<a href="' . route("admin.employees.edit", $employees->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.employees.destroy", $employees->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions', 'name', 'email'])
            ->make(true);
    }
}
