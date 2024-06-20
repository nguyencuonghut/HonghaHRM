<?php

namespace App\Http\Controllers;

use App\Models\CvReceiveMethod;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminCvReceiveMethodController extends Controller
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
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'Bạn phải nhập tên',
        ];

        $request->validate($rules, $messages);

        $cv_receive_method = new CvReceiveMethod();
        $cv_receive_method->name = $request->name;
        $cv_receive_method->save();

        Alert::toast('Thêm nguồn tin mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ReceiveMethod $receiveMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReceiveMethod $receiveMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReceiveMethod $receiveMethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReceiveMethod $receiveMethod)
    {
        //
    }
}
