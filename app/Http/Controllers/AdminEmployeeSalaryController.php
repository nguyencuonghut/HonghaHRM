<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSalary;
use App\Models\EmployeeWork;
use Illuminate\Http\Request;
use Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.salary.index');
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
            'position_salary' => 'required',
            'capacity_salary' => 'required',
            'position_allowance' => 'required',
            'insurance_salary' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id nhân viên không hợp lệ.',
            'position_salary.required' => 'Bạn phải nhập lương vị trí.',
            'capacity_salary.required' => 'Bạn phải nhập lương năng lực.',
            'position_allowance.required' => 'Bạn phải nhập phụ cấp vị trí.',
            'insurance_salary.required' => 'Bạn phải nhập lương bảo hiểm.',
        ];

        $request->validate($rules, $messages);

        $employee_salary = new EmployeeSalary();
        $employee_salary->employee_id = $request->employee_id;
        $employee_salary->position_salary = $request->position_salary;
        $employee_salary->capacity_salary = $request->capacity_salary;
        $employee_salary->position_allowance = $request->position_allowance;
        $employee_salary->insurance_salary = $request->insurance_salary;
        $employee_salary->status = 'On';
        $employee_salary->save();

        Alert::toast('Tạo lương mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee_salary = EmployeeSalary::findOrFail($id);
        return view('admin.salary.edit', ['employee_salary' => $employee_salary]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'position_salary' => 'required',
            'capacity_salary' => 'required',
            'position_allowance' => 'required',
            'insurance_salary' => 'required',
        ];

        $messages = [
            'position_salary.required' => 'Bạn phải nhập lương vị trí.',
            'capacity_salary.required' => 'Bạn phải nhập lương năng lực.',
            'position_allowance.required' => 'Bạn phải nhập phụ cấp vị trí.',
            'insurance_salary.required' => 'Bạn phải nhập lương bảo hiểm.',
        ];

        $request->validate($rules, $messages);

        $employee_salary = EmployeeSalary::findOrFail($id);
        $employee_salary->position_salary = $request->position_salary;
        $employee_salary->capacity_salary = $request->capacity_salary;
        $employee_salary->position_allowance = $request->position_allowance;
        $employee_salary->insurance_salary = $request->insurance_salary;
        $employee_salary->save();

        Alert::toast('Sửa lương thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_salary->employee_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_salary = EmployeeSalary::findOrFail($id);
        $employee_salary->destroy($id);

        Alert::toast('Xóa lương thành công!', 'success', 'top-right');
        return redirect()->back();
    }


    public function employeeData($employee_id)
    {
        $employee_salaries = EmployeeSalary::where('employee_id', $employee_id)->orderBy('id', 'desc')->get();
        return Datatables::of($employee_salaries)
            ->addIndexColumn()
            ->editColumn('position_salary', function ($employee_salaries) {
                return number_format($employee_salaries->position_salary, 0, '.', ',');
            })
            ->editColumn('capacity_salary', function ($employee_salaries) {
                return number_format($employee_salaries->capacity_salary, 0, '.', ',');
            })
            ->editColumn('position_allowance', function ($employee_salaries) {
                return number_format($employee_salaries->position_allowance, 0, '.', ',');
            })
            ->editColumn('insurance_salary', function ($employee_salaries) {
                return number_format($employee_salaries->insurance_salary, 0, '.', ',');
            })
            ->editColumn('status', function ($employee_salaries) {
                if($employee_salaries->status == 'On') {
                    return '<span class="badge badge-success">On</span>';
                } else {
                    return '<span class="badge badge-secondary">Off</span>';
                }
            })
            ->addColumn('actions', function ($employee_salaries) {
                $action = '<a href="' . route("admin.hr.salaries.edit", $employee_salaries->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.hr.salaries.destroy", $employee_salaries->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    public function anyData()
    {
        $employee_salaries = EmployeeSalary::where('status', 'On')->orderBy('id', 'desc')->get();
        return Datatables::of($employee_salaries)
            ->addIndexColumn()
            ->editColumn('department', function ($employee_salaries) {
                $employee_works = EmployeeWork::where('employee_id', $employee_salaries->employee_id)->where('status', 'On')->get();
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
            ->editColumn('code', function ($employee_salaries) {
                return $employee_salaries->employee->code;
            })
            ->editColumn('employee', function ($employee_salaries) {
                return '<a href="' . route("admin.hr.employees.show", $employee_salaries->employee_id) . '">' . $employee_salaries->employee->name . '</a>';
            })
            ->editColumn('position_salary', function ($employee_salaries) {
                return number_format($employee_salaries->position_salary, 0, '.', ',');
            })
            ->editColumn('capacity_salary', function ($employee_salaries) {
                return number_format($employee_salaries->capacity_salary, 0, '.', ',');
            })
            ->editColumn('position_allowance', function ($employee_salaries) {
                return number_format($employee_salaries->position_allowance, 0, '.', ',');
            })
            ->editColumn('insurance_salary', function ($employee_salaries) {
                return number_format($employee_salaries->insurance_salary, 0, '.', ',');
            })
            ->editColumn('status', function ($employee_salaries) {
                if($employee_salaries->status == 'On') {
                    return '<span class="badge badge-success">On</span>';
                } else {
                    return '<span class="badge badge-secondary">Off</span>';
                }
            })
            ->rawColumns(['department', 'employee', 'status'])
            ->make(true);
    }
}
