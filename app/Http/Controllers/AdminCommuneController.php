<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminCommuneController extends Controller
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
            'district_id' => 'required',
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'district_id.required' => 'Bạn phải chọn quận/huyện.',
        ];
        $request->validate($rules,$messages);

        $commune = new Commune();
        $commune->name = $request->name;
        $commune->district_id = $request->district_id;
        $commune->save();

        Alert::toast('Thêm xã/phường mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Commune $commune)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commune $commune)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commune $commune)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commune $commune)
    {
        //
    }
}
