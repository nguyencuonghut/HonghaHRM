<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRegime;
use App\Models\EmployeeWork;
use App\Models\Regime;
use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeRegimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.regime.index');
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
            'regime_id' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id nhân sự không hợp lệ.',
            'regime_id.required' => 'Bạn phải chọn tên chính sách.'
        ];

        $request->validate($rules, $messages);

        $employee_regime = new EmployeeRegime();
        $employee_regime->employee_id = $request->employee_id;
        $employee_regime->regime_id = $request->regime_id;
        if($request->off_start_date) {
            $employee_regime->off_start_date = Carbon::createFromFormat('d/m/Y', $request->off_start_date);
        }
        if($request->off_end_date) {
            $employee_regime->off_end_date = Carbon::createFromFormat('d/m/Y', $request->off_end_date);
        }
        if($request->payment_period) {
            $employee_regime->payment_period = $request->payment_period;
        }
        if($request->payment_amount) {
            $employee_regime->payment_amount = $request->payment_amount;
            $employee_regime->status = 'Đóng';
        } else {
            $employee_regime->status = 'Mở';
        }
        $employee_regime->save();

        Alert::toast('Tạo mới chế độ thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeRegime $employeeRegime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee_regime = EmployeeRegime::findOrFail($id);
        $regimes = Regime::all();
        return view('admin.regime.edit', [
            'employee_regime' => $employee_regime,
            'regimes' => $regimes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'regime_id' => 'required',
        ];

        $messages = [
            'regime_id.required' => 'Bạn phải chọn tên chính sách.'
        ];

        $request->validate($rules, $messages);

        $employee_regime = EmployeeRegime::findOrFail($id);
        $employee_regime->regime_id = $request->regime_id;
        if($request->off_start_date) {
            $employee_regime->off_start_date = Carbon::createFromFormat('d/m/Y', $request->off_start_date);
        }
        if($request->off_end_date) {
            $employee_regime->off_end_date = Carbon::createFromFormat('d/m/Y', $request->off_end_date);
        }
        if($request->payment_period) {
            $employee_regime->payment_period = $request->payment_period;
        } else {
            $employee_regime->payment_period = null;
        }
        if($request->payment_amount) {
            $employee_regime->payment_amount = $request->payment_amount;
            $employee_regime->status = 'Đóng';
        } else {
            $employee_regime->status = 'Mở';
            $employee_regime->payment_amount = 0;
        }
        $employee_regime->save();

        Alert::toast('Sửa chế độ thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_regime->employee_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_regime = EmployeeRegime::findOrFail($id);
        $employee_regime->destroy($id);

        Alert::toast('Xóa chế độ thành công!', 'success', 'top-right');
        return redirect()->back();
    }


    public function anyData()
    {
        $employee_regimes = EmployeeRegime::orderBy('employee_id', 'asc')->get();
        return Datatables::of($employee_regimes)
            ->addIndexColumn()
            ->editColumn('employee_code', function ($employee_regimes) {
                return $employee_regimes->employee->code;
            })
            ->editColumn('employee_name', function ($employee_regimes) {
                return '<a href=' . route("admin.hr.employees.show", $employee_regimes->employee_id) . '>' . $employee_regimes->employee->name . '</a>' ;
            })
            ->editColumn('employee_department', function ($employee_regimes) {
                $employee_works = EmployeeWork::where('employee_id', $employee_regimes->employee_id)->where('status', 'On')->get();
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
            ->editColumn('employee_bhxh', function ($employee_regimes) {
                return $employee_regimes->employee->bhxh;
            })
            ->editColumn('off_start_date', function ($employee_regimes) {
                if ($employee_regimes->off_start_date) {
                    return date('d/m/Y', strtotime($employee_regimes->off_start_date));
                } else {
                    return '';
                }
            })
            ->editColumn('off_end_date', function ($employee_regimes) {
                if ($employee_regimes->off_end_date) {
                    return date('d/m/Y', strtotime($employee_regimes->off_end_date));
                } else {
                    return '';
                }
            })
            ->editColumn('payment_period', function ($employee_regimes) {
                return $employee_regimes->payment_period;
            })
            ->editColumn('payment_amount', function ($employee_regimes) {
                if ($employee_regimes->payment_amount) {
                    return number_format($employee_regimes->payment_amount, 0, '.', ',');
                } else {
                    return '';
                }
            })
            ->editColumn('status', function ($employee_regimes) {
                if ('Mở' == $employee_regimes->status) {
                    return '<span class="badge badge-success">' . $employee_regimes->status . '</span>';
                } else {
                    return '<span class="badge badge-secondary">' . $employee_regimes->status . '</span>';
                }
            })
            ->rawColumns(['employee_name', 'employee_department', 'payment_amount', 'status'])
            ->make(true);
    }
}
