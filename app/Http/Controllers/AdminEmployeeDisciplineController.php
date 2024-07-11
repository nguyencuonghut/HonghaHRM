<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDiscipline;
use App\Models\EmployeeWork;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeDisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.discipline.index');
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
            'code' => 'required|unique:employee_disciplines',
            'dis_sign_date' => 'required',
            'dis_content' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id nhân viên không hợp lệ.',
            'code.required' => 'Bạn phải nhập số kỷ luật.',
            'code.unique' => 'Số kỷ luật đã tồn tại.',
            'sigdis_sign_daten_date.required' => 'Bạn phải nhập ngày ký.',
            'dis_content.required' => 'Bạn phải nhập nội dung.',
        ];

        $request->validate($rules, $messages);

        $employee_discipline = new EmployeeDiscipline();
        $employee_discipline->employee_id = $request->employee_id;
        $employee_discipline->code = $request->code;
        $employee_discipline->sign_date = Carbon::createFromFormat('d/m/Y', $request->dis_sign_date);
        $employee_discipline->content = $request->dis_content;
        if ($request->dis_note) {
            $employee_discipline->note = $request->dis_note;
        }
        $employee_discipline->save();

        Alert::toast('Nhập kỷ luật mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeDiscipline $employeeDiscipline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee_discipline = EmployeeDiscipline::findOrFail($id);
        return view('admin.discipline.edit', ['employee_discipline' => $employee_discipline]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'code' => 'required|unique:employee_disciplines,code,'.$id,
            'sign_date' => 'required',
            'content' => 'required',
        ];

        $messages = [
            'code.required' => 'Bạn phải nhập số kỷ luật.',
            'code.unique' => 'Số kỷ luật đã tồn tại.',
            'sign_date.required' => 'Bạn phải nhập ngày ký.',
            'content.required' => 'Bạn phải nhập nội dung.',
        ];

        $request->validate($rules, $messages);

        $employee_discipline = EmployeeDiscipline::findOrFail($id);
        $employee_discipline->code = $request->code;
        $employee_discipline->sign_date = Carbon::createFromFormat('d/m/Y', $request->sign_date);
        $employee_discipline->content = $request->content;
        if ($request->note) {
            $employee_discipline->note = $request->note;
        }
        $employee_discipline->save();

        Alert::toast('Sửa kỷ luật thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_discipline->employee_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_discipline = EmployeeDiscipline::findOrFail($id);
        $employee_discipline->destroy($id);

        Alert::toast('Xóa kỷ luật thành công!', 'success', 'top-right');
        return redirect()->back();
    }


    public function employeeData($employee_id)
    {
        $employee_disciplines = EmployeeDiscipline::where('employee_id', $employee_id)->orderBy('id', 'desc')->get();
        return Datatables::of($employee_disciplines)
            ->addIndexColumn()
            ->editColumn('code', function ($employee_disciplines) {
                return $employee_disciplines->code;
            })
            ->editColumn('sign_date', function ($employee_disciplines) {
                return date('d/m/Y', strtotime($employee_disciplines->sign_date));
            })
            ->editColumn('content', function ($employee_disciplines) {
                return $employee_disciplines->content;
            })
            ->editColumn('note', function ($employee_disciplines) {
                return $employee_disciplines->note;
            })
            ->addColumn('actions', function ($employee_disciplines) {
                $action = '<a href="' . route("admin.hr.disciplines.edit", $employee_disciplines->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.hr.disciplines.destroy", $employee_disciplines->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions', 'content', 'note'])
            ->make(true);
    }

    public function anyData()
    {
        $employee_disciplines = EmployeeDiscipline::orderBy('id', 'desc')->get();
        return Datatables::of($employee_disciplines)
            ->addIndexColumn()
            ->editColumn('department', function ($employee_disciplines) {
                $employee_works = EmployeeWork::where('employee_id', $employee_disciplines->employee_id)->where('status', 'On')->get();
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
            ->editColumn('employee', function ($employee_disciplines) {
                return '<a href="' . route("admin.hr.employees.show", $employee_disciplines->employee_id) . '">' . $employee_disciplines->employee->name . '</a>';
            })
            ->editColumn('code', function ($employee_disciplines) {
                return $employee_disciplines->code;
            })
            ->editColumn('sign_date', function ($employee_disciplines) {
                return date('d/m/Y', strtotime($employee_disciplines->sign_date));
            })
            ->editColumn('content', function ($employee_disciplines) {
                return $employee_disciplines->content;
            })
            ->editColumn('note', function ($employee_disciplines) {
                return $employee_disciplines->note;
            })
            ->addColumn('actions', function ($employee_disciplines) {
                $action = '<a href="' . route("admin.hr.disciplines.edit", $employee_disciplines->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.hr.disciplines.destroy", $employee_disciplines->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['department', 'employee', 'actions', 'content', 'note'])
            ->make(true);
    }
}
