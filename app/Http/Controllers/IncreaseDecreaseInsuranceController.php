<?php

namespace App\Http\Controllers;

use App\Models\IncreaseDecreaseInsurance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class IncreaseDecreaseInsuranceController extends Controller
{
    public function getConfirmIncrease($id)
    {
        $increase_decrease_insurance = IncreaseDecreaseInsurance::findOrFail($id);

        return view('admin.inc_dec_insurance.confirm_increase', ['increase_decrease_insurance' => $increase_decrease_insurance]);
    }

    public function confirmIncrease(Request $request, $id)
    {
        $rules = ['increase_confirmed_month' => 'required'];
        $messages = ['increase_confirmed_month.required' => 'Bạn phải chọn tháng tăng'];

        $request->validate($rules, $messages);

        $increase_decrease_insurance = IncreaseDecreaseInsurance::findOrFail($id);
        $increase_decrease_insurance->increase_confirmed_month =  Carbon::createFromFormat('m/Y', $request->increase_confirmed_month);
        $increase_decrease_insurance->save();

        Alert::toast('Xác nhận tăng BHXH thành công!', 'success', 'top-right');
        return redirect()->route('admin.reports.candidateIncDecBhxh');
    }

    public function getConfirm($id)
    {
        $increase_decrease_insurance = IncreaseDecreaseInsurance::findOrFail($id);

        return view('admin.inc_dec_insurance.confirm_decrease', ['increase_decrease_insurance' => $increase_decrease_insurance]);
    }

    public function confirm(Request $request, $id)
    {
        $rules = ['decrease_confirmed_month' => 'required'];
        $messages = ['decrease_confirmed_month.required' => 'Bạn phải chọn tháng tăng'];

        $request->validate($rules, $messages);

        $increase_decrease_insurance = IncreaseDecreaseInsurance::findOrFail($id);
        $increase_decrease_insurance->decrease_confirmed_month =  Carbon::createFromFormat('m/Y', $request->decrease_confirmed_month);
        $increase_decrease_insurance->save();

        Alert::toast('Xác nhận giảm BHXH thành công!', 'success', 'top-right');
        return redirect()->route('admin.reports.candidateIncDecBhxh');
    }
}
