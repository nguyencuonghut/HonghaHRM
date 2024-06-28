<?php

namespace App\Http\Controllers;

use App\Models\DivisionManager;
use Illuminate\Http\Request;
use Datatables;

class AdminDivisionManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.division_manager.index');
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
    public function show(DivisionManager $divisionManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DivisionManager $divisionManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DivisionManager $divisionManager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DivisionManager $divisionManager)
    {
        //
    }

    public function anyData()
    {
        $division_managers = DivisionManager::with('division', 'manager')->get();
        return Datatables::of($division_managers)
            ->addIndexColumn()
            ->editColumn('division', function ($division_managers) {
                return $division_managers->division->name;

            })
            ->editColumn('manager', function ($division_managers) {
                return '<a href="' . route("admin.hr.employees.show", $division_managers->manager_id) . '">' . $division_managers->manager->name . '</a>';
            })
            ->addColumn('actions', function ($division_managers) {
                $action = '<a href="' . route("admin.division_managers.edit", $division_managers->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.division_managers.destroy", $division_managers->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['manager','actions'])
            ->make(true);
    }
}
