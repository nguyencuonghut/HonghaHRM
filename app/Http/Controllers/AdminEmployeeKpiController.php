<?php

namespace App\Http\Controllers;

use App\Models\EmployeeKpi;
use App\Models\EmployeeWork;
use Illuminate\Http\Request;
use Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeKpiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.kpi.index');
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
            'year' => 'required',
            'month' => 'required',
            'score' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id nhân sự không đúng.',
            'year.required' => 'Bạn cần nhập năm.',
            'month.required' => 'Bạn cần nhập tháng.',
            'score.required' => 'Bạn cần nhập điểm.',
        ];

        $request->validate($rules, $messages);

        $employee_kpi = new EmployeeKpi();
        $employee_kpi->employee_id = $request->employee_id;
        $employee_kpi->year = $request->year;
        $employee_kpi->month = $request->month;
        $employee_kpi->score = $request->score;
        $employee_kpi->save();

        Alert::toast('Nhập KPI mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeKpi $employeeKpi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee_kpi = EmployeeKpi::findOrFail($id);
        return view('admin.kpi.edit', ['employee_kpi' => $employee_kpi]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'year' => 'required',
            'month' => 'required',
            'score' => 'required',
        ];

        $messages = [
            'year.required' => 'Bạn cần nhập năm.',
            'month.required' => 'Bạn cần nhập tháng.',
            'score.required' => 'Bạn cần nhập điểm.',
        ];

        $request->validate($rules, $messages);

        $employee_kpi = EmployeeKpi::findOrFail($id);
        $employee_kpi->year = $request->year;
        $employee_kpi->month = $request->month;
        $employee_kpi->score = $request->score;
        $employee_kpi->save();

        Alert::toast('Lưu KPI mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_kpi->employee_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_kpi = EmployeeKpi::findOrFail($id);
        $employee_kpi->destroy($id);

        Alert::toast('Xóa KPI mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    public function employeeData($employee_id)
    {
        $employee_kpis = EmployeeKpi::where('employee_id', $employee_id)->get();
        return Datatables::of($employee_kpis)
            ->addIndexColumn()
            ->editColumn('year', function ($employee_kpis) {
                return $employee_kpis->year;
            })
            ->editColumn('month', function ($employee_kpis) {
                return $employee_kpis->month;
            })
            ->editColumn('score', function ($employee_kpis) {
                return $employee_kpis->score;
            })
            ->addColumn('actions', function ($employee_kpis) {
                $action = '<a href="' . route("admin.hr.kpis.edit", $employee_kpis->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.hr.kpis.destroy", $employee_kpis->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function anyData()
    {
        $employee_kpis = EmployeeKpi::orderBy('id', 'desc')->get();
        return Datatables::of($employee_kpis)
            ->addIndexColumn()
            ->editColumn('department', function ($employee_kpis) {
                $employee_works = EmployeeWork::where('employee_id', $employee_kpis->employee_id)->where('status', 'On')->get();
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
            ->editColumn('employee', function ($employee_kpis) {
                return '<a href="' . route("admin.hr.employees.show", $employee_kpis->employee_id) . '">' . $employee_kpis->employee->name . '</a>';
            })
            ->editColumn('year', function ($employee_kpis) {
                return $employee_kpis->year;
            })
            ->editColumn('month', function ($employee_kpis) {
                return $employee_kpis->month;
            })
            ->editColumn('score', function ($employee_kpis) {
                return $employee_kpis->score;
            })
            ->addColumn('actions', function ($employee_kpis) {
                $action = '<a href="' . route("admin.hr.kpis.edit", $employee_kpis->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.hr.kpis.destroy", $employee_kpis->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['department', 'employee', 'actions'])
            ->make(true);
    }
}
