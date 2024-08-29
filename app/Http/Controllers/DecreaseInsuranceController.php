<?php

namespace App\Http\Controllers;

use App\Models\DecreaseInsurance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DecreaseInsuranceController extends Controller
{

    public function getConfirm($id)
    {
        $decrease_insurance = DecreaseInsurance::findOrFail($id);

        return view('admin.decrease_insurance.confirm', ['decrease_insurance' => $decrease_insurance]);
    }

    public function confirm(Request $request, $id)
    {
        $rules = ['confirmed_month' => 'required'];
        $messages = ['confirmed_month.required' => 'Bạn phải chọn tháng tăng'];

        $request->validate($rules, $messages);

        $decrease_insurance = DecreaseInsurance::findOrFail($id);
        $decrease_insurance->confirmed_month =  Carbon::createFromFormat('m/Y', $request->confirmed_month);
        $decrease_insurance->save();

        Alert::toast('Xác nhận giảm BHXH thành công!', 'success', 'top-right');
        return redirect()->route('admin.reports.candidateIncDecBhxh');
    }
}
