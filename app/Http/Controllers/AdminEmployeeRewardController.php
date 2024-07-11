<?php

namespace App\Http\Controllers;

use App\Models\EmployeeReward;
use App\Models\EmployeeWork;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeRewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.reward.index');
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
            'code' => 'required|unique:employee_rewards',
            'sign_date' => 'required',
            'content' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id nhân viên không hợp lệ.',
            'code.required' => 'Bạn phải nhập số khen thưởng.',
            'code.unique' => 'Số khen thưởng đã tồn tại.',
            'sign_date.required' => 'Bạn phải nhập ngày ký.',
            'content.required' => 'Bạn phải nhập nội dung.',
        ];

        $request->validate($rules, $messages);

        $employee_reward = new EmployeeReward();
        $employee_reward->employee_id = $request->employee_id;
        $employee_reward->code = $request->code;
        $employee_reward->sign_date = Carbon::createFromFormat('d/m/Y', $request->sign_date);
        $employee_reward->content = $request->content;
        if ($request->note) {
            $employee_reward->note = $request->note;
        }
        $employee_reward->save();

        Alert::toast('Nhập khen thưởng mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeReward $employeeReward)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee_reward = EmployeeReward::findOrFail($id);
        return view('admin.reward.edit', ['employee_reward' => $employee_reward]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'code' => 'required|unique:employee_rewards,code,'.$id,
            'sign_date' => 'required',
            'content' => 'required',
        ];

        $messages = [
            'code.required' => 'Bạn phải nhập số khen thưởng.',
            'code.unique' => 'Số khen thưởng đã tồn tại.',
            'sign_date.required' => 'Bạn phải nhập ngày ký.',
            'content.required' => 'Bạn phải nhập nội dung.',
        ];

        $request->validate($rules, $messages);

        $employee_reward = EmployeeReward::findOrFail($id);
        $employee_reward->code = $request->code;
        $employee_reward->sign_date = Carbon::createFromFormat('d/m/Y', $request->sign_date);
        $employee_reward->content = $request->content;
        if ($request->note) {
            $employee_reward->note = $request->note;
        }
        $employee_reward->save();

        Alert::toast('Sửa khen thưởng thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_reward->employee_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_reward = EmployeeReward::findOrFail($id);
        $employee_reward->destroy($id);

        Alert::toast('Xóa khen thưởng thành công!', 'success', 'top-right');
        return redirect()->back();
    }


    public function employeeData($employee_id)
    {
        $employee_rewards = EmployeeReward::where('employee_id', $employee_id)->orderBy('id', 'desc')->get();
        return Datatables::of($employee_rewards)
            ->addIndexColumn()
            ->editColumn('code', function ($employee_rewards) {
                return $employee_rewards->code;
            })
            ->editColumn('sign_date', function ($employee_rewards) {
                return date('d/m/Y', strtotime($employee_rewards->sign_date));
            })
            ->editColumn('content', function ($employee_rewards) {
                return $employee_rewards->content;
            })
            ->editColumn('note', function ($employee_rewards) {
                return $employee_rewards->note;
            })
            ->addColumn('actions', function ($employee_rewards) {
                $action = '<a href="' . route("admin.hr.rewards.edit", $employee_rewards->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.hr.rewards.destroy", $employee_rewards->id) . '" method="POST">
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
        $employee_rewards = EmployeeReward::orderBy('id', 'desc')->get();
        return Datatables::of($employee_rewards)
            ->addIndexColumn()
            ->editColumn('department', function ($employee_rewards) {
                $employee_works = EmployeeWork::where('employee_id', $employee_rewards->employee_id)->where('status', 'On')->get();
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
            ->editColumn('employee', function ($employee_rewards) {
                return '<a href="' . route("admin.hr.employees.show", $employee_rewards->employee_id) . '">' . $employee_rewards->employee->name . '</a>';
            })
            ->editColumn('code', function ($employee_rewards) {
                return $employee_rewards->code;
            })
            ->editColumn('sign_date', function ($employee_rewards) {
                return date('d/m/Y', strtotime($employee_rewards->sign_date));
            })
            ->editColumn('content', function ($employee_rewards) {
                return $employee_rewards->content;
            })
            ->editColumn('note', function ($employee_rewards) {
                return $employee_rewards->note;
            })
            ->addColumn('actions', function ($employee_rewards) {
                $action = '<a href="' . route("admin.hr.rewards.edit", $employee_rewards->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.hr.rewards.destroy", $employee_rewards->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['department', 'employee', 'actions', 'content', 'note'])
            ->make(true);
    }
}
