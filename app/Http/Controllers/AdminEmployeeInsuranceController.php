<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\EmployeeInsurance;
use App\Models\EmployeeWork;
use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeInsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.insurance.index');
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
            'employee_id' => 'required',
            'insurance_id' => 'required',
            'insurance_s_date' => 'required',
            'pay_rate' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id nhân sự không hợp lệ.',
            'insurance_id.required' => 'Bạn phải chọn loại bảo hiểm.',
            'insurance_s_date.required' => 'Bạn phải nhập ngày bắt đầu.',
            'pay_rate.required' => 'Bạn phải nhập tỷ lệ đóng.',
        ];

        $request->validate($rules, $messages);

        $employee_insurance = new EmployeeInsurance();
        $employee_insurance->employee_id = $request->employee_id;
        $employee_insurance->insurance_id = $request->insurance_id;
        $employee_insurance->start_date = Carbon::createFromFormat('d/m/Y', $request->insurance_s_date);
        if ($request->insurance_e_date) {
            $employee_insurance->end_date = Carbon::createFromFormat('d/m/Y', $request->insurance_e_date);
        }
        $employee_insurance->pay_rate = $request->pay_rate;
        $employee_insurance->save();

        Alert::toast('Tạo mới bảo hiểm thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeInsurance $employeeInsurance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee_insurance = EmployeeInsurance::findOrFail($id);
        $insurances = Insurance::all();
        return view('admin.insurance.edit', [
            'employee_insurance' => $employee_insurance,
            'insurances' => $insurances,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'insurance_id' => 'required',
            'insurance_s_date' => 'required',
            'pay_rate' => 'required',
        ];

        $messages = [
            'insurance_id.required' => 'Bạn phải chọn loại bảo hiểm.',
            'insurance_s_date.required' => 'Bạn phải nhập ngày bắt đầu.',
            'pay_rate.required' => 'Bạn phải nhập tỷ lệ đóng.',
        ];

        $request->validate($rules, $messages);

        $employee_insurance = EmployeeInsurance::findOrFail($id);
        $employee_insurance->start_date = Carbon::createFromFormat('d/m/Y', $request->insurance_s_date);
        if ($request->insurance_e_date) {
            $employee_insurance->end_date = Carbon::createFromFormat('d/m/Y', $request->insurance_e_date);
        } else {
            $employee_insurance->end_date = null;
        }
        $employee_insurance->pay_rate = $request->pay_rate;
        $employee_insurance->save();

        Alert::toast('Sửa bảo hiểm thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_insurance->employee_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_insurance = EmployeeInsurance::findOrFail($id);
        $employee_insurance->destroy($id);

        Alert::toast('Xóa bảo hiểm thành công!', 'success', 'top-right');
        return redirect()->back();
    }


    public function anyData()
    {
        $employee_insurances = EmployeeInsurance::orderBy('employee_id', 'asc')->get();
        return Datatables::of($employee_insurances)
            ->addIndexColumn()
            ->editColumn('insurance', function ($employee_insurances) {
                return $employee_insurances->insurance->name;
            })
            ->editColumn('employee_code', function ($employee_insurances) {
                return $employee_insurances->employee->code;
            })
            ->editColumn('employee_name', function ($employee_insurances) {
                return '<a href=' . route("admin.hr.employees.show", $employee_insurances->employee_id) . '>' . $employee_insurances->employee->name . '</a>' ;
            })
            ->editColumn('employee_department', function ($employee_insurances) {
                $employee_works = EmployeeWork::where('employee_id', $employee_insurances->employee_id)->where('status', 'On')->get();
                $employee_department_str = '';
                $i = 0;
                $length = count($employee_works);
                if ($length) {
                    foreach ($employee_works as $employee_work) {
                        if(++$i === $length) {
                            $employee_department_str .= $employee_work->company_job->department->name;
                        } else {
                            $employee_department_str .= $employee_work->company_job->department->name;
                            $employee_department_str .= ' | ';
                        }
                    }
                } else {
                    $employee_department_str .= '!! Chưa gán vị trí công việc !!';
                }
                return $employee_department_str;
            })
            ->editColumn('employee_bhxh', function ($employee_insurances) {
                return $employee_insurances->employee->bhxh;
            })
            ->editColumn('start_date', function ($employee_insurances) {
                return date('d/m/Y', strtotime($employee_insurances->start_date));
            })
            ->editColumn('end_date', function ($employee_insurances) {
                if ($employee_insurances->end_date) {
                    return date('d/m/Y', strtotime($employee_insurances->end_date));
                } else {
                    return '';
                }
            })
            ->editColumn('pay_rate', function ($employee_insurances) {
                return $employee_insurances->pay_rate;
            })
            ->rawColumns(['employee_name', 'employee_department'])
            ->make(true);
    }
}
