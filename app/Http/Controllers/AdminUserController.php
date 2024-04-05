<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Notifications\UserCreated;
use Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all()->pluck('name', 'id');
        return view('admin.user.create', ['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'department_id' => 'required',
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'name.max' => 'Tên dài quá 255 ký tự.',
            'type.required' => 'Bạn phải nhập kiểu người dùng.',
            'email.required' => 'Bạn phải nhập địa chỉ email.',
            'email.email' => 'Email sai định dạng.',
            'email.max' => 'Email dài quá 255 ký tự.',
            'department_id.required' => 'Bạn phải chọn phòng ban.',
        ];
        $request->validate($rules,$messages);

        $password = Str::random(8);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($password);
        $user->save();

        //Create user_department pivot item
        $user->departments()->attach($request->department_id);

        //Send password to user's email
        Notification::route('mail' , $user->email)->notify(new UserCreated($user->id, $password));

        Alert::toast('Tạo người dùng mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.users.index');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
        $users = User::select(['id', 'name', 'email'])->get();
        return Datatables::of($users)
            ->addIndexColumn()
            ->editColumn('name', function ($users) {
                return $users->name;
            })
            ->editColumn('email', function ($users) {
                return $users->email;
            })
            ->editColumn('departments', function ($users) {
                $i = 0;
                $length = count($users->departments);
                $departments_list = '';
                foreach ($users->departments as $item) {
                    if(++$i === $length) {
                        $departments_list =  $departments_list . $item->name;
                    } else {
                        $departments_list = $departments_list . $item->name . ', ';
                    }
                }
                return $departments_list;
            })
            ->addColumn('actions', function ($users) {
                $action = '<a href="' . route("admin.users.edit", $users->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.users.destroy", $users->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function import(Request $request)
    {

    }

    public function gallery()
    {
        return view('admin.user.gallery');
    }
}
