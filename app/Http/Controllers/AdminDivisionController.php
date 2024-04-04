<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Datatables;
use Illuminate\Http\Request;

class AdminDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.division.index');
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
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        //
    }

    public function anyData()
    {
        $divisions = Division::with('department')->select(['id', 'code', 'name', 'department_id'])->get();
        return Datatables::of($divisions)
            ->addIndexColumn()
            ->editColumn('code', function ($divisions) {
                return $divisions->code;
            })
            ->editColumn('name', function ($divisions) {
                return $divisions->name;
            })
            ->editColumn('department_id', function ($divisions) {
                return $divisions->department->name;
            })
            ->addColumn('actions', function ($divisions) {
                $action = '<a href="' . route("admin.divisions.edit", $divisions->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.divisions.destroy", $divisions->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
