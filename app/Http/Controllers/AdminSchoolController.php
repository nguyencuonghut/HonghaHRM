<?php

namespace App\Http\Controllers;

use App\Models\CandidateSchool;
use App\Models\EmployeeSchool;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;
use Datatables;

class AdminSchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.school.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.school.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:schools',
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'name.unique' => 'Tên đã tồn tại.',
        ];
        $request->validate($rules,$messages);

        $school = new School();
        $school->name = $request->name;
        $school->save();

        Alert::toast('Thêm trường mới thành công!', 'success', 'top-right');
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
        $school = School::findOrFail($id);
        return view('admin.school.edit', ['school' => $school]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:schools,name,'.$id,
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'name.unique' => 'Tên đã tồn tại.',
        ];
        $request->validate($rules,$messages);

        $school = School::findOrFail($id);
        $school->name = $request->name;
        $school->save();

        Alert::toast('Sửa trường mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.schools.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $school = School::findOrFail($id);
        // Check condition before delete
        $candidate_school = CandidateSchool::where('school_id', $school->id)->get();
        $employee_school = EmployeeSchool::where('school_id', $school->id)->get();
        if (0 != $candidate_school->count()
            || 0 != $employee_school->count()) {
            Alert::toast('Trường này đang được sử dụng. Không thể xóa!', 'error', 'top-right');
            return redirect()->back();
        }
        $school->destroy($id);

        Alert::toast('Xóa trường thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    public function anyData()
    {
        $schools = School::orderBy('id', 'desc');
        return Datatables::of($schools)
            ->addIndexColumn()
            ->editColumn('name', function ($schools) {
                return $schools->name;
            })
            ->addColumn('actions', function ($schools) {
                $action = '<a href="' . route("admin.schools.edit", $schools->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.schools.destroy", $schools->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
