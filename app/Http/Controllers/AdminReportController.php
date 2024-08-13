<?php

namespace App\Http\Controllers;

use App\Models\CompanyJob;
use App\Models\Employee;
use App\Models\EmployeeInsurance;
use App\Models\EmployeeWork;
use App\Models\EmployeeRelative;
use App\Models\EmployeeSalary;
use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    public function birthday(Request $request)
    {
        if ($request->ajax()) {
            $employees = Employee::select('*');

            return Datatables::of($employees)
                ->addIndexColumn()
                ->editColumn('name', function ($employees) {
                    return '<a href="' . route("admin.hr.employees.show", $employees->id) . '">' . $employees->name . '</a>';

                })
                ->editColumn('company_email', function ($employees) {
                    return $employees->company_email;

                })
                ->addColumn('gender', function($employees){
                    return $employees->gender;
                })
                ->editColumn('date_of_birth', function ($employees) {
                    return date('d/m/Y', strtotime($employees->date_of_birth));

                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('month')) {
                        $instance->whereMonth('date_of_birth', $request->get('month'));
                    }
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('gender', 'LIKE', "%$search%")
                            ->orWhere('date_of_birth', 'LIKE', "%$search%")
                            ->orWhere('company_email', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name'])
                ->make(true);
        }

        return view('admin.report.birthday');
    }

    public function situation()
    {
        return view('admin.report.situation');
    }

    public function situationData()
    {
        $employee_relatives = EmployeeRelative::where('situation', '!=', null)->orderBy('employee_id', 'asc')->get();
        return Datatables::of($employee_relatives)
            ->addIndexColumn()
            ->editColumn('name', function ($employee_relatives) {
                return $employee_relatives->name;
            })
            ->editColumn('type', function ($employee_relatives) {
                return $employee_relatives->type;
            })
            ->editColumn('year_of_birth', function ($employee_relatives) {
                return $employee_relatives->year_of_birth;
            })
            ->editColumn('employee', function ($employee_relatives) {
                return '<a href="'.route("admin.hr.employees.show", $employee_relatives->employee_id).'">'.$employee_relatives->employee->name.'</a>';
            })
            ->rawColumns(['employee'])
            ->make(true);
    }

    public function kid_policy()
    {
        return view('admin.report.kid_policy');
    }

    public function kidData()
    {

        $employee_relatives = EmployeeRelative::whereIn('type', ['Con trai', 'Con gái'])
                                        ->where('year_of_birth', '>=', Carbon::now()->year - 15)
                                        ->orderBy('employee_id', 'asc')
                                        ->get();
        return Datatables::of($employee_relatives)
            ->addIndexColumn()
            ->editColumn('name', function ($employee_relatives) {
                return $employee_relatives->name;
            })
            ->editColumn('type', function ($employee_relatives) {
                return $employee_relatives->type;
            })
            ->editColumn('year_of_birth', function ($employee_relatives) {
                return $employee_relatives->year_of_birth;
            })
            ->editColumn('employee', function ($employee_relatives) {
                return '<a href="'.route("admin.hr.employees.show", $employee_relatives->employee_id).'">'.$employee_relatives->employee->name.'</a>';
            })
            ->rawColumns(['employee'])
            ->make(true);
    }

    public function seniority(Request $request)
    {
        if ($request->ajax()) {
            $employees = Employee::select('*');

            return Datatables::of($employees)
                ->addIndexColumn()
                ->editColumn('name', function ($employees) {
                    return '<a href="' . route("admin.hr.employees.show", $employees->id) . '">' . $employees->name . '</a>';

                })
                ->editColumn('department', function ($employees) {
                    $employee_works = EmployeeWork::where('employee_id', $employees->id)->where('status', 'On')->get();
                    $employee_department_str = '';
                    $i = 0;
                    $length = count($employee_works);
                    if ($length) {
                        foreach ($employee_works as $employee_work) {
                            if(++$i === $length) {
                                $employee_department_str .= $employee_work->company_job->department->name;
                                if ($employee_work->company_job->division_id) {
                                    $employee_department_str .= ' - ' . $employee_work->company_job->division->name;
                                }
                            } else {
                                $employee_department_str .= $employee_work->company_job->department->name;

                                if ($employee_work->company_job->division_id) {
                                    $employee_department_str .= ' - ' . $employee_work->company_job->division->name;
                                }
                                $employee_department_str .= ' | ';
                            }
                        }
                    } else {
                        $employee_department_str .= '!! Chưa gán vị trí công việc !!';
                    }

                    return $employee_department_str;
                })
                ->editColumn('join_date', function ($employees) {
                    return date('d/m/Y', strtotime($employees->join_date));
                })
                ->editColumn('seniority', function ($employees) {
                    return Carbon::parse($employees->join_date)->diffInYears(Carbon::now());
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('year')
                        && 'Tất cả' != $request->get('year')) {
                        $instance->whereYear('join_date', Carbon::now()->year - $request->get('year'));
                    }
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('join_date', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name'])
                ->make(true);
        }

        return view('admin.report.seniority');
    }

    public function offWork()
    {
        return view('admin.report.off_work');
    }

    public function offworkData()
    {
        // off_type_id = 1 -> Nghỉ việc
        $employee_works = EmployeeWork::where('status', 'Off')->where('off_type_id', 1)->orderBy('employee_id', 'asc')->get();
        return Datatables::of($employee_works)
            ->addIndexColumn()
            ->editColumn('employee', function ($employee_works) {
                return '<a href=' . route("admin.hr.employees.show", $employee_works->employee_id) . '>' . $employee_works->employee->name . '</a>' ;
            })
            ->editColumn('company_job', function ($employee_works) {
                return $employee_works->company_job->name;
            })
            ->editColumn('department', function ($employee_works) {
                if ($employee_works->company_job->division_id) {
                    return $employee_works->company_job->division->name .  ' - ' . $employee_works->company_job->department->name;

                } else {
                    return $employee_works->company_job->department->name;
                }
            })
            ->editColumn('end_date', function ($employee_works) {
                if ($employee_works->end_date) {
                    return date('d/m/Y', strtotime($employee_works->end_date));
                } else {
                    return '-';
                }
            })
            ->editColumn('off_reason', function ($employee_works) {
                return $employee_works->off_reason;
            })
            ->rawColumns(['employee', 'off_reason'])
            ->make(true);
    }

    public function incDecBhxh()
    {
        return view('admin.report.inc_dec_bhxh');
    }

    public function incBhxhData()
    {
        $this_month = Carbon::now()->month;
        $this_year = Carbon::now()->year;
        $employee_works = EmployeeWork::where('on_type_id', 2)->whereMonth('start_date', $this_month)->whereYear('start_date', $this_year)->select('*');
        return Datatables::of($employee_works)
            ->addIndexColumn()
            ->editColumn('code', function ($employee_works) {
                return $employee_works->employee->code;
            })
            ->editColumn('name', function ($employee_works) {
                return '<a href="' . route("admin.hr.employees.show", $employee_works->employee->id) . '">' . $employee_works->employee->name . '</a>';

            })
            ->editColumn('company_job', function ($employee_works) {
                return $employee_works->company_job->name;

            })
            ->editColumn('start_date', function ($employee_works) {
                return date('d/m/Y', strtotime($employee_works->start_date));
            })
            ->editColumn('insurance_salary', function ($employee_works) use ($this_month, $this_year){
                // Tính lương bhxh tại tháng này
                $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $this_month, $this_year);
                if ($employee_salary) {
                    return number_format($employee_salary->insurance_salary, 0, '.', ',');
                } else {
                    return '';
                }
            })
            ->editColumn('bhxh_increase', function ($employee_works) use ($this_month, $this_year){
                // Tính toán số tiền tăng cho 1- bhxh
                $employee_insurance = EmployeeInsurance::where('employee_id', $employee_works->employee_id)
                                                        ->where('insurance_id', 1)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $this_month, $this_year);
                    if ($employee_salary) {
                        $bhxh_increase = $employee_salary->insurance_salary * $employee_insurance->pay_rate / 100;
                        return number_format($bhxh_increase, 0, '.', ',');
                    } else {
                        return '';
                    }
                } else {
                    return 'Chưa khai báo BHXH';
                }
            })
            ->editColumn('bhtn_increase', function ($employee_works) use ($this_month, $this_year){
                // Tính toán số tiền tăng cho bhtn
                // Tính toán số tiền tăng cho 2- bhtn
                $employee_insurance = EmployeeInsurance::where('employee_id', $employee_works->employee_id)
                                                        ->where('insurance_id', 2)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $this_month, $this_year);
                    if ($employee_salary) {
                        $bhxh_increase = $employee_salary->insurance_salary * $employee_insurance->pay_rate / 100;
                        return number_format($bhxh_increase, 0, '.', ',');
                    } else {
                        return '';
                    }
                    } else {
                    return 'Chưa khai báo BHTN';
                }
            })
            ->rawColumns(['name'])
            ->make(true);
    }

    public function decBhxhData()
    {
        $this_month = Carbon::now()->month;
        $this_year = Carbon::now()->year;
        $employee_works = EmployeeWork::where('off_type_id', '!=', null)->whereMonth('end_date', $this_month)->whereYear('end_date', $this_year)->select('*');
        return Datatables::of($employee_works)
            ->addIndexColumn()
            ->editColumn('code', function ($employee_works) {
                return $employee_works->employee->code;
            })
            ->editColumn('name', function ($employee_works) {
                return '<a href="' . route("admin.hr.employees.show", $employee_works->employee->id) . '">' . $employee_works->employee->name . '</a>';

            })
            ->editColumn('end_date', function ($employee_works) {
                return date('d/m/Y', strtotime($employee_works->end_date));
            })
            ->editColumn('insurance_salary', function ($employee_works) use ($this_month, $this_year){
                // Tính lương bhxh tại tháng này
                $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $this_month, $this_year);
                if ($employee_salary) {
                    return number_format($employee_salary->insurance_salary, 0, '.', ',');
                } else {
                    return '';
                }
            })
            ->editColumn('bhxh_decrease', function ($employee_works) use ($this_month, $this_year){
                // Tính toán số tiền giảm cho 1- bhxh
                $employee_insurance = EmployeeInsurance::where('employee_id', $employee_works->employee_id)
                                                        ->where('insurance_id', 1)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $this_month, $this_year);
                    if ($employee_salary) {
                        $bhxh_decrease = $employee_salary->insurance_salary * $employee_insurance->pay_rate / 100;
                        return number_format($bhxh_decrease, 0, '.', ',');
                    } else {
                        return '';
                    }
                } else {
                    return 'Chưa khai báo BHXH';
                }
            })
            ->editColumn('bhtn_decrease', function ($employee_works) use ($this_month, $this_year){
                // Tính toán số tiền giảm cho 2- bhtn
                $employee_insurance = EmployeeInsurance::where('employee_id', $employee_works->employee_id)
                                                        ->where('insurance_id', 2)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $this_month, $this_year);
                    if ($employee_salary) {
                        $bhtn_decrease = $employee_salary->insurance_salary * $employee_insurance->pay_rate / 100;
                        return number_format($bhtn_decrease, 0, '.', ',');
                    } else {
                        return '';
                    }
                    } else {
                    return 'Chưa khai báo BHTN';
                }
            })
            ->rawColumns(['name'])
            ->make(true);
    }

    public function incDecBhxhByMonth(Request $request)
    {
        $filter_month_year = explode('/', $request->month_of_year);
        $month = $filter_month_year[0];
        $year   = $filter_month_year[1];
        return view('admin.report.inc_dec_bhxh_by_month',
                    [
                        'month' => $month,
                        'year' => $year,
                    ]);
    }

    public function incBhxhByMonthData($month, $year)
    {
        // 2 - Phát sinh tăng khi ký HĐLĐ
        $employee_works = EmployeeWork::where('off_type_id', null)->where('on_type_id', 2)->whereMonth('start_date', $month)->whereYear('start_date', $year)->select('*');
        return Datatables::of($employee_works)
            ->addIndexColumn()
            ->editColumn('code', function ($employee_works) {
                return $employee_works->employee->code;
            })
            ->editColumn('name', function ($employee_works) {
                return '<a href="' . route("admin.hr.employees.show", $employee_works->employee->id) . '">' . $employee_works->employee->name . '</a>';
            })
            ->editColumn('start_date', function ($employee_works) {
                return date('d/m/Y', strtotime($employee_works->start_date));
            })
            ->editColumn('insurance_salary', function ($employee_works) use ($month, $year){
                // Tính lương bhxh tại thời điểm chạy báo cáo
                $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $month, $year);
                if ($employee_salary) {
                    return number_format($employee_salary->insurance_salary, 0, '.', ',');
                } else {
                    return '';
                }
            })
            ->editColumn('bhxh_increase', function ($employee_works) use ($month, $year){
                // Tính toán số tiền tăng cho 1- bhxh
                $employee_insurance = EmployeeInsurance::where('employee_id', $employee_works->employee_id)
                                                        ->where('insurance_id', 1)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $month, $year);
                    if ($employee_salary) {
                        $bhxh_increase = $employee_salary->insurance_salary * $employee_insurance->pay_rate / 100;
                        return number_format($bhxh_increase, 0, '.', ',');
                    } else {
                        return '';
                    }
                } else {
                    return 'Chưa khai báo BHXH';
                }
            })
            ->editColumn('bhtn_increase', function ($employee_works) use ($month, $year){
                // Tính toán số tiền tăng cho bhtn
                // Tính toán số tiền tăng cho 2- bhtn
                $employee_insurance = EmployeeInsurance::where('employee_id', $employee_works->employee_id)
                                                        ->where('insurance_id', 2)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $month, $year);
                    if ($employee_salary) {
                        $bhxh_increase = $employee_salary->insurance_salary * $employee_insurance->pay_rate / 100;
                        return number_format($bhxh_increase, 0, '.', ',');
                    } else {
                        return '';
                    }
                    } else {
                    return 'Chưa khai báo BHTN';
                }
            })
            ->rawColumns(['name', 'start_date'])
            ->make(true);
    }

    public function decBhxhByMonthData($month, $year)
    {
        //Phát sinh giảm khi nghỉ việc
        $employee_works = EmployeeWork::where('off_type_id', '!=', null)->whereMonth('end_date', $month)->whereYear('end_date', $year)->select('*');
        return Datatables::of($employee_works)
            ->addIndexColumn()
            ->editColumn('code', function ($employee_works) {
                return $employee_works->employee->code;
            })
            ->editColumn('name', function ($employee_works) {
                return '<a href="' . route("admin.hr.employees.show", $employee_works->employee->id) . '">' . $employee_works->employee->name . '</a>';

            })
            ->editColumn('end_date', function ($employee_works) {
                return date('d/m/Y', strtotime($employee_works->end_date));
            })
            ->editColumn('insurance_salary', function ($employee_works) use ($month, $year){
                // Tính lương bhxh tại thời điểm chạy báo cáo
                $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $month, $year);
                if ($employee_salary) {
                    return number_format($employee_salary->insurance_salary, 0, '.', ',');
                } else {
                    return '';
                }
            })
            ->editColumn('bhxh_decrease', function ($employee_works) use ($month, $year){
                // Tính toán số tiền giảm cho 1- bhxh
                $employee_insurance = EmployeeInsurance::where('employee_id', $employee_works->employee_id)
                                                        ->where('insurance_id', 1)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $month, $year);
                    if ($employee_salary) {
                        $bhxh_decrease = $employee_salary->insurance_salary * $employee_insurance->pay_rate / 100;
                        return number_format($bhxh_decrease, 0, '.', ',');
                    } else {
                        return '';
                    }
                } else {
                    return 'Chưa khai báo BHXH';
                }
            })
            ->editColumn('bhtn_decrease', function ($employee_works) use ($month, $year){
                // Tính toán số tiền giảm cho 2- bhtn
                $employee_insurance = EmployeeInsurance::where('employee_id', $employee_works->employee_id)
                                                        ->where('insurance_id', 2)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $month, $year);
                    if ($employee_salary) {
                        $bhtn_decrease = $employee_salary->insurance_salary * $employee_insurance->pay_rate / 100;
                        return number_format($bhtn_decrease, 0, '.', ',');
                    } else {
                        return '';
                    }
                    } else {
                    return 'Chưa khai báo BHTN';
                }
            })
            ->rawColumns(['name'])
            ->make(true);
    }

    public function insurancePayment()
    {
        return view('admin.report.insurance_payment');

    }

    public function insurancePaymentData()
    {
        $this_month = Carbon::now()->month;
        $this_year = Carbon::now()->year;
        $greater_year_employee_works = EmployeeWork::where('status', 'On')
                                        ->where('off_type_id', null)
                                        ->whereYear('start_date', '<', $this_year)
                                        ->select('*')->get();
        $equal_year_employee_works = EmployeeWork::where('status', 'On')
                                        ->where('off_type_id', null)
                                        ->whereYear('start_date', $this_year)
                                        ->whereMonth('start_date', '<=',$this_month)
                                        ->select('*')->get();
        $tempCollection = collect([$greater_year_employee_works, $equal_year_employee_works]);
        $employee_works = $tempCollection->flatten(1)->unique('employee_id');

        return Datatables::of($employee_works)
            ->addIndexColumn()
            ->editColumn('code', function ($employee_works) {
                return $employee_works->employee->code;
            })
            ->editColumn('name', function ($employee_works) {
                return '<a href="' . route("admin.hr.employees.show", $employee_works->employee->id) . '">' . $employee_works->employee->name . '</a>';

            })
            ->editColumn('end_date', function ($employee_works) {
                return date('d/m/Y', strtotime($employee_works->end_date));
            })
            ->editColumn('insurance_salary', function ($employee_works) use ($this_month, $this_year){
                // Tính lương bhxh tại tháng này
                $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $this_month, $this_year);
                if ($employee_salary) {
                    // Kiểm tra có phải là Nhân Sự tăng trong tháng
                    if (date('m', strtotime($employee_works->start_date)) == $this_month) {
                        return '+' . number_format($employee_salary->insurance_salary, 0, '.', ',');
                    } else {
                        return number_format($employee_salary->insurance_salary, 0, '.', ',');
                    }
                } else {
                    return '';
                }
            })
            ->editColumn('bhxh_payment', function ($employee_works) use ($this_month, $this_year){
                // Tính toán số tiền nộp cho 1- bhxh
                $employee_insurance = EmployeeInsurance::where('employee_id', $employee_works->employee_id)
                                                        ->where('insurance_id', 1)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $this_month, $this_year);
                    if ($employee_salary) {
                        $bhxh_payment = $employee_salary->insurance_salary * $employee_insurance->pay_rate / 100;
                        if (date('m', strtotime($employee_works->start_date)) == $this_month) {
                            return '+' . number_format($bhxh_payment, 0, '.', ',');
                        } else {
                            return number_format($bhxh_payment, 0, '.', ',');
                        }
                    } else {
                        return '';
                    }
                } else {
                    return 'Chưa khai báo BHXH';
                }
            })
            ->editColumn('bhtn_payment', function ($employee_works) use ($this_month, $this_year){
                // Tính toán số tiền nộp cho 2- bhtn
                $employee_insurance = EmployeeInsurance::where('employee_id', $employee_works->employee_id)
                                                        ->where('insurance_id', 2)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($employee_works->employee_id, $this_month, $this_year);
                    if ($employee_salary) {
                        $bhtn_payment = $employee_salary->insurance_salary * $employee_insurance->pay_rate / 100;
                        if (date('m', strtotime($employee_works->start_date)) == $this_month) {
                            return '+' . number_format($bhtn_payment, 0, '.', ',');
                        } else {
                            return number_format($bhtn_payment, 0, '.', ',');
                        }
                    } else {
                        return '';
                    }
                    } else {
                    return 'Chưa khai báo BHTN';
                }
            })
            ->rawColumns(['name', 'insurance_salary', 'bhxh_payment', 'bhtn_payment'])
            ->make(true);
    }


    private function getEmployeeSalaryByMonthYear($employee_id, $month, $year)
    {
        // Tìm các EmployeeSalary với trạng thái On
        $on_employee_salary = EmployeeSalary::where('employee_id', $employee_id)
                                                ->where('status', 'On')
                                                ->whereYear('start_date', '<=', $year)
                                                ->whereMonth('start_date', '<=', $month)
                                                ->first();
        if ($on_employee_salary) {
            return $on_employee_salary;
        } else {
            // Tìm các EmployeeSalary với trạng thái Off
            $off_employee_salaries = EmployeeSalary::where('employee_id', $employee_id)
                                                    ->where('status', 'Off')
                                                    ->whereYear('start_date', '<=', $year)
                                                    ->whereYear('end_date', '>=', $year)
                                                    ->get();
            if ($off_employee_salaries->count() > 1) {
                // Tiếp tục lọc theo tháng
            return EmployeeSalary::where('employee_id', $employee_id)
                                ->where('status', 'Off')
                                ->whereYear('start_date', '<=', $year)
                                ->whereYear('end_date', '>=', $year)
                                ->whereMonth('start_date', '<=', $month)
                                ->whereMonth('end_date', '>=', $month)
                                ->first();
            } else {
                // Trả về luôn
                return EmployeeSalary::where('employee_id', $employee_id)
                                    ->where('status', 'Off')
                                    ->whereYear('start_date', '<=', $year)
                                    ->whereYear('end_date', '>=', $year)
                                    ->first();
            }
        }
    }
}
