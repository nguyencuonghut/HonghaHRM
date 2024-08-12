<?php

namespace App\Http\Controllers;

use App\Models\EmployeeWelfare;
use App\Models\EmployeeWork;
use App\Models\Welfare;
use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeWelfareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.welfare.index');
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
            'welfare_id' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id nhân sự không hợp lệ.',
            'welfare_id.required' => 'Bạn phải chọn tên phúc lợi.'
        ];

        $request->validate($rules, $messages);

        $employee_welfare = new EmployeeWelfare();
        $employee_welfare->employee_id = $request->employee_id;
        $employee_welfare->welfare_id = $request->welfare_id;
        if($request->payment_date) {
            $employee_welfare->payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date);
        }
        if($request->payment_amount) {
            $employee_welfare->payment_amount = $request->payment_amount;
            $employee_welfare->status = 'Đóng';
        } else {
            $employee_welfare->status = 'Mở';
        }
        $employee_welfare->save();

        Alert::toast('Tạo mới phúc lợi thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeWelfare $employeeWelfare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee_welfare = EmployeeWelfare::findOrFail($id);
        $welfares = Welfare::all();
        return view('admin.welfare.edit', [
            'employee_welfare' => $employee_welfare,
            'welfares' => $welfares,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'welfare_id' => 'required',
        ];

        $messages = [
            'welfare_id.required' => 'Bạn phải chọn tên phúc lợi.'
        ];

        $request->validate($rules, $messages);

        $employee_welfare = EmployeeWelfare::findOrFail($id);
        $employee_welfare->welfare_id = $request->welfare_id;
        if($request->payment_date) {
            $employee_welfare->payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date);
        }
        if($request->payment_amount) {
            $employee_welfare->payment_amount = $request->payment_amount;
            $employee_welfare->status = 'Đóng';
        } else {
            $employee_welfare->status = 'Mở';
            $employee_welfare->payment_amount = 0;
        }
        $employee_welfare->save();

        Alert::toast('Sửa phúc lợi thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_welfare->employee_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_welfare = EmployeeWelfare::findOrFail($id);
        $employee_welfare->destroy($id);

        Alert::toast('Xóa phúc lợi thành công!', 'success', 'top-right');
        return redirect()->back();
    }


    public function anyData()
    {
        $employee_welfares = EmployeeWelfare::join('employees', 'employees.id', 'employee_welfares.employee_id')
                                            ->orderBy('employees.code', 'desc')
                                            ->get();
        return Datatables::of($employee_welfares)
            ->addIndexColumn()
            ->editColumn('employee_code', function ($employee_welfares) {
                return $employee_welfares->employee->code;
            })
            ->editColumn('employee_name', function ($employee_welfares) {
                return '<a href=' . route("admin.hr.employees.show", $employee_welfares->employee_id) . '>' . $employee_welfares->employee->name . '</a>' ;
            })
            ->editColumn('employee_department', function ($employee_welfares) {
                $employee_works = EmployeeWork::where('employee_id', $employee_welfares->employee_id)->where('status', 'On')->get();
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
            ->editColumn('welfare', function ($employee_welfares) {
                return $employee_welfares->welfare->name;
            })
            ->editColumn('payment_date', function ($employee_welfares) {
                if ($employee_welfares->payment_date) {
                    return date('d/m/Y', strtotime($employee_welfares->payment_date));
                } else {
                    return '';
                }
            })
            ->editColumn('payment_amount', function ($employee_welfares) {
                if ($employee_welfares->payment_amount) {
                    return number_format($employee_welfares->payment_amount, 0, '.', ',');
                } else {
                    return '';
                }
            })
            ->editColumn('status', function ($employee_welfares) {
                if ('Mở' == $employee_welfares->status) {
                    return '<span class="badge badge-success">' . $employee_welfares->status . '</span>';
                } else {
                    return '<span class="badge badge-secondary">' . $employee_welfares->status . '</span>';
                }
            })
            ->rawColumns(['employee_name', 'employee_department', 'payment_amount', 'status'])
            ->make(true);
    }
}
