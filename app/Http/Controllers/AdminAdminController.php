<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminDepartment;
use App\Models\Department;
use App\Models\Role;
use App\Notifications\AdminCreated;
use Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $departments = Department::all();

        return view('admin.admin.create',
                    ['roles' => $roles,
                     'departments' => $departments
                    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'role_id' => 'required',
            'department_id' => 'required',
        ];

        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'email.required' => 'Bạn phải nhập email.',
            'email.email' => 'Định dạng mail không đúng.',
            'email.unique' => 'Email đã tồn tại.',
            'role_id.required' => 'Bạn phải chọn vai trò.',
            'department_id.required' => 'Bạn phải chọn phòng/ban.',
        ];

        $request->validate($rules,$messages);


        $password = Str::random(8);

        //Create new Admin
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($password);
        $admin->role_id = $request->role_id;
        $admin->save();

        //Create admin_department pivot item
        $admin->departments()->attach($request->department_id);


        //Send password to user's email
        Notification::route('mail' , $admin->email)->notify(new AdminCreated($admin->id, $password));

        Alert::toast('Tạo tài khoản mới thành công và gửi mật khẩu tới email người quản trị!', 'success', 'top-right');
        return redirect()->route('admin.admins.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $roles = Role::all();
        $departments = Department::all();
        $admin = Admin::findOrFail($id);
        $selected_departments = AdminDepartment::where('admin_id', $id)->pluck('department_id')->toArray();

        // Check condition before editing
        if (!Auth::user()->can('create-admin')) {
            Alert::toast('Bạn không có quyền sửa tài khoản quản trị!', 'error', 'top-right');
            return redirect()->route('admin.admins.index');
        }
        return view('admin.admin.edit',
                    [
                        'roles' => $roles,
                        'departments' => $departments,
                        'admin' => $admin,
                        'selected_departments' => $selected_departments,
                    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
            'role_id' => 'required',
            'department_id' => 'required',
        ];

        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'email.required' => 'Bạn phải nhập email.',
            'email.email' => 'Định dạng mail không đúng.',
            'email.unique' => 'Email đã tồn tại.',
            'role_id.required' => 'Bạn phải chọn vai trò.',
            'department_id.required' => 'Bạn phải chọn phòng/ban.',
        ];

        $request->validate($rules,$messages);

        $old_mail = '';

        //Edit Admin
        $admin = Admin::findOrFail($id);
        if ($request->email != $admin->email) {
            // Create new passoword
            $password = Str::random(8);
            $admin->password = Hash::make($password);
            $old_mail = $admin->email;
        }
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->role_id = $request->role_id;
        $admin->save();

        // Delete all old pivot items
        $admin->find($id)->departments()->detach();

        //Create admin_department pivot item
        $admin->departments()->attach($request->department_id);

        if ($request->email != $old_mail) {
            //Send password to user's email
            Notification::route('mail' , $admin->email)->notify(new AdminCreated($admin->id, $password));
        }

        Alert::toast('Sửa tài khoản mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.admins.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function anyData()
    {
        $admins = Admin::with(['role', 'departments'])->select(['id', 'name', 'email', 'role_id'])->get();
        return Datatables::of($admins)
            ->addIndexColumn()
            ->editColumn('name', function ($admins) {
                return $admins->name;
            })
            ->editColumn('email', function ($admins) {
                return $admins->email;
            })
            ->editColumn('role', function ($admins) {
                return $admins->role->name;
            })
            ->editColumn('departments', function ($admins) {
                $departments = '';
                foreach ($admins->departments as $department) {
                    $departments .= $department->name . '<br>';
                }
                return $departments;
            })
            ->addColumn('actions', function ($admins) {
                $action = '<a href="' . route("admin.admins.edit", $admins->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.admins.destroy", $admins->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions', 'departments'])
            ->make(true);
    }


    public function import(Request $request)
    {

    }
}
