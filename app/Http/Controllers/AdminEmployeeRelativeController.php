<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRelative;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeRelativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'name' => 'required',
            'year_of_birth' => 'required',
            'job' => 'required',
            'type' => 'required',
            'health' => 'required',
            'is_living_together' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id nhân viên không đúng.',
            'name.required' => 'Bạn cần nhập tên.',
            'year_of_birth.required' => 'Bạn cần nhập năm sinh.',
            'job.required' => 'Bạn cần nhập nghề nghiệp.',
            'type.required' => 'Bạn cần nhập quan hệ.',
            'health.required' => 'Bạn cần nhập sức khỏe.',
            'is_living_together.required' => 'Bạn cần nhập sống cùng.',
        ];

        $request->validate($rules, $messages);

        $employee_relative = new EmployeeRelative();
        $employee_relative->employee_id = $request->employee_id;
        $employee_relative->name = $request->name;
        $employee_relative->year_of_birth = $request->year_of_birth;
        $employee_relative->job = $request->job;
        $employee_relative->type = $request->type;
        $employee_relative->health = $request->health;
        $employee_relative->is_living_together = $request->is_living_together;
        if ($request->situation) {
            $employee_relative->situation = $request->situation;
        }
        $employee_relative->save();

        Alert::toast('Thêm người thân mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeRelative $employeeRelative)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeRelative $employeeRelative)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'year_of_birth' => 'required',
            'job' => 'required',
            'type' => 'required',
            'health' => 'required',
            'is_living_together' => 'required',
        ];

        $messages = [
            'name.required' => 'Bạn cần nhập tên.',
            'year_of_birth.required' => 'Bạn cần nhập năm sinh.',
            'job.required' => 'Bạn cần nhập nghề nghiệp.',
            'type.required' => 'Bạn cần nhập quan hệ.',
            'health.required' => 'Bạn cần nhập sức khỏe.',
            'is_living_together.required' => 'Bạn cần nhập sống cùng.',
        ];

        $request->validate($rules, $messages);

        $employee_relative = EmployeeRelative::findOrFail($id);
        $employee_relative->name = $request->name;
        $employee_relative->year_of_birth = $request->year_of_birth;
        $employee_relative->job = $request->job;
        $employee_relative->type = $request->type;
        $employee_relative->health = $request->health;
        $employee_relative->is_living_together = $request->is_living_together;
        if ($request->situation) {
            $employee_relative->situation = $request->situation;
        }
        $employee_relative->save();

        Alert::toast('Sửa người thân mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_relative = EmployeeRelative::findOrFail($id);
        $employee_relative->destroy($id);

        Alert::toast('Xóa người thân thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
