<?php

namespace App\Http\Controllers;

use App\Models\IncreaseInsurance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class IncreaseInsuranceController extends Controller
{
    public function getConfirm($id)
    {
        $increase_insurance = IncreaseInsurance::findOrFail($id);

        return view('admin.increase_insurance.confirm', ['increase_insurance' => $increase_insurance]);
    }

    public function confirm(Request $request, $id)
    {
        $rules = ['confirmed_month' => 'required'];
        $messages = ['confirmed_month.required' => 'Bạn phải chọn tháng tăng'];

        $request->validate($rules, $messages);

        $increase_insurance = IncreaseInsurance::findOrFail($id);
        $increase_insurance->confirmed_month =  Carbon::createFromFormat('m/Y', $request->confirmed_month);
        $increase_insurance->save();

        Alert::toast('Xác nhận tăng BHXH thành công!', 'success', 'top-right');
        return redirect()->route('admin.reports.candidateIncDecBhxh');
    }
}
