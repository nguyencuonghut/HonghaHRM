<?php

namespace App\Http\Controllers;

use App\Models\DepartmentManager;
use Illuminate\Http\Request;
use Datatables;

class AdminDepartmentManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.department_manager.index');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DepartmentManager $departmentManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepartmentManager $departmentManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DepartmentManager $departmentManager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentManager $departmentManager)
    {
        //
    }

    public function anyData()
    {
        $department_managers = DepartmentManager::with('department', 'manager')->get();
        return Datatables::of($department_managers)
            ->addIndexColumn()
            ->editColumn('department', function ($department_managers) {
                return '<a href="' . route("admin.departments.show", $department_managers->department_id) . '">' . $department_managers->department->name . '</a>';

            })
            ->editColumn('manager', function ($department_managers) {
                return '<a href="' . route("admin.hr.employees.show", $department_managers->manager_id) . '">' . $department_managers->manager->name . '</a>';
            })
            ->addColumn('actions', function ($department_managers) {
                $action = '<a href="' . route("admin.department_managers.edit", $department_managers->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.department_managers.destroy", $department_managers->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['department', 'manager','actions'])
            ->make(true);
    }
}
