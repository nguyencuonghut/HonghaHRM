<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminDistrictController extends Controller
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
            'province_id' => 'required',
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'province_id.required' => 'Bạn phải chọn tỉnh.',
        ];
        $request->validate($rules,$messages);

        $district = new District();
        $district->name = $request->name;
        $district->province_id = $request->province_id;
        $district->save();

        Alert::toast('Thêm quận/huyện mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, District $district)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(District $district)
    {
        //
    }
}
