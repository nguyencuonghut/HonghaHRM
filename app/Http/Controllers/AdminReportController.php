<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeContract;
use App\Models\EmployeeDocumentReport;
use App\Models\EmployeeInsurance;
use App\Models\EmployeeWork;
use App\Models\EmployeeRelative;
use App\Models\EmployeeSalary;
use App\Models\IncreaseDecreaseInsurance;
use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

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

    public function candidateIncDecBhxh()
    {
        return view('admin.report.candidate_inc_dec_bhxh');
    }

    public function candidateIncBhxhData()
    {
        $increase_insurances = IncreaseDecreaseInsurance::where('increase_confirmed_month', null)
                                                        ->where('is_increase', true)
                                                        ->select('employee_works.id AS employee_work_id', 'increase_decrease_insurances.id AS increase_insurance_id')
                                                        ->join('employee_works', 'employee_works.id', 'increase_decrease_insurances.employee_work_id')
                                                        ->get();
        return Datatables::of($increase_insurances)
            ->addIndexColumn()
            ->editColumn('code', function ($increase_insurances) {
                return $increase_insurances->employee_work->employee->code;
            })
            ->editColumn('name', function ($increase_insurances) {
                return '<a href="' . route("admin.hr.employees.show", $increase_insurances->employee_work->employee->id) . '">' . $increase_insurances->employee_work->employee->name . '</a>';

            })
            ->editColumn('company_job', function ($increase_insurances) {
                return $increase_insurances->employee_work->company_job->name;

            })
            ->editColumn('start_date', function ($increase_insurances) {
                return date('d/m/Y', strtotime($increase_insurances->employee_work->start_date));
            })
            ->addColumn('actions', function ($increase_insurances) {
                $action = '<a href="' . route("admin.inc_dec_insurances.getConfirmIncrease", $increase_insurances->increase_insurance_id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
                return $action;
            })
            ->rawColumns(['name', 'actions'])
            ->make(true);
    }

    public function candidateDecBhxhData()
    {
        $decrease_insurances = IncreaseDecreaseInsurance::where('decrease_confirmed_month', null)
                                                        ->where('is_decrease', true)
                                                        ->select('employee_works.id AS employee_work_id', 'increase_decrease_insurances.id AS decrease_insurance_id')
                                                        ->join('employee_works', 'employee_works.id', 'increase_decrease_insurances.employee_work_id')
                                                        ->get();
        return Datatables::of($decrease_insurances)
            ->addIndexColumn()
            ->editColumn('code', function ($decrease_insurances) {
                return $decrease_insurances->employee_work->employee->code;
            })
            ->editColumn('name', function ($decrease_insurances) {
                return '<a href="' . route("admin.hr.employees.show", $decrease_insurances->employee_work->employee->id) . '">' . $decrease_insurances->employee_work->employee->name . '</a>';

            })
            ->editColumn('end_date', function ($decrease_insurances) {
                return date('d/m/Y', strtotime($decrease_insurances->employee_work->end_date));
            })
            ->addColumn('actions', function ($decrease_insurances) {
                $action = '<a href="' . route("admin.inc_dec_insurances.getConfirmDecrease", $decrease_insurances->decrease_insurance_id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
                return $action;
            })
            ->rawColumns(['name', 'actions'])
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
        $increase_insurances = IncreaseDecreaseInsurance::where('increase_confirmed_month', '!=', null)
                                                        ->where('is_increase', true)
                                                        ->whereMonth('increase_confirmed_month', $this_month)
                                                        ->whereYear('increase_confirmed_month', $this_year)
                                                        ->select('*');
        return Datatables::of($increase_insurances)
            ->addIndexColumn()
            ->editColumn('code', function ($increase_insurances) {
                return $increase_insurances->employee_work->employee->code;
            })
            ->editColumn('name', function ($increase_insurances) {
                return '<a href="' . route("admin.hr.employees.show", $increase_insurances->employee_work->employee->id) . '">' . $increase_insurances->employee_work->employee->name . '</a>';

            })
            ->editColumn('company_job', function ($increase_insurances) {
                return $increase_insurances->employee_work->company_job->name;

            })
            ->editColumn('start_date', function ($increase_insurances) {
                return date('d/m/Y', strtotime($increase_insurances->employee_work->start_date));
            })
            ->editColumn('increase_confirmed_month', function ($increase_insurances) {
                return date('m/Y', strtotime($increase_insurances->increase_confirmed_month));
            })
            ->editColumn('insurance_salary', function ($increase_insurances) use ($this_month, $this_year){
                // Tính lương bhxh tại tháng này
                $employee_salary = $this->getEmployeeSalaryByMonthYear($increase_insurances->employee_work->employee_id, $this_month, $this_year);
                if ($employee_salary) {
                    return number_format($employee_salary->insurance_salary, 0, '.', ',');
                } else {
                    return '';
                }
            })
            ->editColumn('bhxh_increase', function ($increase_insurances) use ($this_month, $this_year){
                // Tính toán số tiền tăng cho 1- bhxh
                $employee_insurance = EmployeeInsurance::where('employee_id', $increase_insurances->employee_work->employee_id)
                                                        ->where('insurance_id', 1)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($increase_insurances->employee_work->employee_id, $this_month, $this_year);
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
            ->editColumn('bhtn_increase', function ($increase_insurances) use ($this_month, $this_year){
                // Tính toán số tiền tăng cho 2- bhtn
                $employee_insurance = EmployeeInsurance::where('employee_id', $increase_insurances->employee_work->employee_id)
                                                        ->where('insurance_id', 2)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($increase_insurances->employee_work->employee_id, $this_month, $this_year);
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
        $decrease_insurances = IncreaseDecreaseInsurance::where('decrease_confirmed_month', '!=', null)
                                                        ->where('is_decrease', true)
                                                        ->whereMonth('decrease_confirmed_month', $this_month)
                                                        ->whereYear('decrease_confirmed_month', $this_year)
                                                        ->select('*');
        return Datatables::of($decrease_insurances)
            ->addIndexColumn()
            ->editColumn('code', function ($decrease_insurances) {
                return $decrease_insurances->employee_work->employee->code;
            })
            ->editColumn('name', function ($decrease_insurances) {
                return '<a href="' . route("admin.hr.employees.show", $decrease_insurances->employee_work->employee->id) . '">' . $decrease_insurances->employee_work->employee->name . '</a>';

            })
            ->editColumn('end_date', function ($decrease_insurances) {
                return date('d/m/Y', strtotime($decrease_insurances->employee_work->end_date));
            })
            ->editColumn('decrease_confirmed_month', function ($decrease_insurances) {
                return date('m/Y', strtotime($decrease_insurances->decrease_confirmed_month));
            })
            ->editColumn('insurance_salary', function ($decrease_insurances) use ($this_month, $this_year){
                // Tính lương bhxh tại tháng này
                $employee_salary = $this->getEmployeeSalaryByMonthYear($decrease_insurances->employee_work->employee_id, $this_month, $this_year);
                if ($employee_salary) {
                    return number_format($employee_salary->insurance_salary, 0, '.', ',');
                } else {
                    return '';
                }
            })
            ->editColumn('bhxh_decrease', function ($decrease_insurances) use ($this_month, $this_year){
                // Tính toán số tiền giảm cho 1- bhxh
                $employee_insurance = EmployeeInsurance::where('employee_id', $decrease_insurances->employee_work->employee_id)
                                                        ->where('insurance_id', 1)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($decrease_insurances->employee_work->employee_id, $this_month, $this_year);
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
            ->editColumn('bhtn_decrease', function ($decrease_insurances) use ($this_month, $this_year){
                // Tính toán số tiền giảm cho 2- bhtn
                $employee_insurance = EmployeeInsurance::where('employee_id', $decrease_insurances->employee_work->employee_id)
                                                        ->where('insurance_id', 2)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($decrease_insurances->employee_work->employee_id, $this_month, $this_year);
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
        $increase_insurances = IncreaseDecreaseInsurance::where('increase_confirmed_month', '!=', null)
                                                        ->where('is_increase', true)
                                                        ->whereMonth('increase_confirmed_month', $month)
                                                        ->whereYear('increase_confirmed_month', $year)
                                                        ->select('*');
        return Datatables::of($increase_insurances)
            ->addIndexColumn()
            ->editColumn('code', function ($increase_insurances) {
                return $increase_insurances->employee_work->employee->code;
            })
            ->editColumn('name', function ($increase_insurances) {
                return '<a href="' . route("admin.hr.employees.show", $increase_insurances->employee_work->employee->id) . '">' . $increase_insurances->employee_work->employee->name . '</a>';
            })
            ->editColumn('start_date', function ($increase_insurances) {
                return date('d/m/Y', strtotime($increase_insurances->employee_work->start_date));
            })
            ->editColumn('increase_confirmed_month', function ($increase_insurances) {
                return date('m/Y', strtotime($increase_insurances->increase_confirmed_month));
            })
            ->editColumn('insurance_salary', function ($increase_insurances) use ($month, $year){
                // Tính lương bhxh tại thời điểm chạy báo cáo
                $employee_salary = $this->getEmployeeSalaryByMonthYear($increase_insurances->employee_work->employee_id, $month, $year);
                if ($employee_salary) {
                    return number_format($employee_salary->insurance_salary, 0, '.', ',');
                } else {
                    return '';
                }
            })
            ->editColumn('bhxh_increase', function ($increase_insurances) use ($month, $year){
                // Tính toán số tiền tăng cho 1- bhxh
                $employee_insurance = EmployeeInsurance::where('employee_id', $increase_insurances->employee_work->employee_id)
                                                        ->where('insurance_id', 1)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($increase_insurances->employee_work->employee_id, $month, $year);
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
            ->editColumn('bhtn_increase', function ($increase_insurances) use ($month, $year){
                // Tính toán số tiền tăng cho bhtn
                // Tính toán số tiền tăng cho 2- bhtn
                $employee_insurance = EmployeeInsurance::where('employee_id', $increase_insurances->employee_work->employee_id)
                                                        ->where('insurance_id', 2)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($increase_insurances->employee_work->employee_id, $month, $year);
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
        $decrease_insurances = IncreaseDecreaseInsurance::where('decrease_confirmed_month', '!=', null)
                                                        ->where('is_decrease', true)
                                                        ->whereMonth('decrease_confirmed_month', $month)
                                                        ->whereYear('decrease_confirmed_month', $year)
                                                        ->select('*');
        return Datatables::of($decrease_insurances)
            ->addIndexColumn()
            ->editColumn('code', function ($decrease_insurances) {
                return $decrease_insurances->employee_work->employee->code;
            })
            ->editColumn('name', function ($decrease_insurances) {
                return '<a href="' . route("admin.hr.employees.show", $decrease_insurances->employee_work->employee->id) . '">' . $decrease_insurances->employee_work->employee->name . '</a>';

            })
            ->editColumn('end_date', function ($decrease_insurances) {
                return date('d/m/Y', strtotime($decrease_insurances->employee_work->end_date));
            })
            ->editColumn('decrease_confirmed_month', function ($decrease_insurances) {
                return date('m/Y', strtotime($decrease_insurances->decrease_confirmed_month));
            })
            ->editColumn('insurance_salary', function ($decrease_insurances) use ($month, $year){
                // Tính lương bhxh tại thời điểm chạy báo cáo
                $employee_salary = $this->getEmployeeSalaryByMonthYear($decrease_insurances->employee_work->employee_id, $month, $year);
                if ($employee_salary) {
                    return number_format($employee_salary->insurance_salary, 0, '.', ',');
                } else {
                    return '';
                }
            })
            ->editColumn('bhxh_decrease', function ($decrease_insurances) use ($month, $year){
                // Tính toán số tiền giảm cho 1- bhxh
                $employee_insurance = EmployeeInsurance::where('employee_id', $decrease_insurances->employee_work->employee_id)
                                                        ->where('insurance_id', 1)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($decrease_insurances->employee_work->employee_id, $month, $year);
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
            ->editColumn('bhtn_decrease', function ($decrease_insurances) use ($month, $year){
                // Tính toán số tiền giảm cho 2- bhtn
                $employee_insurance = EmployeeInsurance::where('employee_id', $decrease_insurances->employee_work->employee_id)
                                                        ->where('insurance_id', 2)
                                                        ->first();
                if ($employee_insurance) {
                    $employee_salary = $this->getEmployeeSalaryByMonthYear($decrease_insurances->employee_work->employee_id, $month, $year);
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

    public function document()
    {
        return view('admin.report.document');
    }

    public function documentData()
    {
        $employee_document_reports = EmployeeDocumentReport::join('employees', 'employees.id', 'employee_document_reports.employee_id')
                                                            ->orderBy('employees.code', 'desc')
                                                            ->get();
        return Datatables::of($employee_document_reports)
        ->addIndexColumn()
        ->editColumn('code', function ($employee_document_reports) {
            return $employee_document_reports->employee->code;
        })
        ->editColumn('name', function ($employee_document_reports) {
            return '<a href="' . route("admin.hr.employees.show", $employee_document_reports->employee->id) . '">' . $employee_document_reports->employee->name . '</a>';
        })
        ->editColumn('syll', function ($employee_document_reports) {
            return $employee_document_reports->syll ? 'X' : '';
        })
        ->editColumn('cmt', function ($employee_document_reports) {
            return $employee_document_reports->cmt ? 'X' : '';
        })
        ->editColumn('sk', function ($employee_document_reports) {
            return $employee_document_reports->sk ? 'X' : '';
        })
        ->editColumn('gks', function ($employee_document_reports) {
            return $employee_document_reports->gks ? 'X' : '';
        })
        ->editColumn('shk', function ($employee_document_reports) {
            return $employee_document_reports->shk ? 'X' : '';
        })
        ->editColumn('dxv', function ($employee_document_reports) {
            return $employee_document_reports->dxv ? 'X' : '';
        })
        ->editColumn('bc', function ($employee_document_reports) {
            return $employee_document_reports->bc ? 'X' : '';
        })
        ->editColumn('gxnds', function ($employee_document_reports) {
            return $employee_document_reports->gxnds ? 'X' : '';
        })
        ->rawColumns(['name'])
        ->make(true);
    }

    public function insurancePaymentData()
    {
        $this_month = Carbon::now()->month;
        $this_year = Carbon::now()->year;
        $greater_year_employee_works = EmployeeWork::where('status', 'On')
                                        ->where('off_type_id', null)
                                        ->whereYear('start_date', '<', $this_year)
                                        ->select('*')
                                        ->get();
        $equal_year_employee_works = EmployeeWork::where('status', 'On')
                                        ->where('off_type_id', null)
                                        ->whereYear('start_date', $this_year)
                                        ->whereMonth('start_date', '<=',$this_month)
                                        ->select('*')
                                        ->get();
        $tempCollection = collect([$greater_year_employee_works, $equal_year_employee_works]);
        $employee_works = $tempCollection->flatten(1)->unique('employee_id')->sortByDesc('employee.code');

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
                        return '<p style="color:#198754;"> ' . '+' . number_format($employee_salary->insurance_salary, 0, '.', ',') . '</p>';
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
                            return '<p style="color:#198754;"> ' . '+' . number_format($bhxh_payment, 0, '.', ',') . '</p>';
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
                            return '<p style="color:#198754;"> ' . '+' . number_format($bhtn_payment, 0, '.', ',') . '</p>';
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

    public function exportIncBhxh()
    {
        $this_month = Carbon::now()->month;
        $this_year = Carbon::now()->year;
        $file_name = $this->createIncDecBhxhFile($this_month, $this_year, true);

        Alert::toast('Tải file thành công!!', 'success', 'top-right');
        return response()->download($file_name)->deleteFileAfterSend(true);
    }


    public function exportIncBhxhByMonth($month, $year)
    {
        $file_name = $this->createIncDecBhxhFile($month, $year, true);
        Alert::toast('Tải file thành công!!', 'success', 'top-right');
        return response()->download($file_name)->deleteFileAfterSend(true);
    }

    public function exportDecBhxh()
    {
        $this_month = Carbon::now()->month;
        $this_year = Carbon::now()->year;
        $file_name = $this->createIncDecBhxhFile($this_month, $this_year, false);

        Alert::toast('Tải file thành công!!', 'success', 'top-right');
        return response()->download($file_name)->deleteFileAfterSend(true);
    }

    public function exportDecBhxhByMonth($month, $year)
    {
        $file_name = $this->createIncDecBhxhFile($month, $year, false);
        Alert::toast('Tải file thành công!!', 'success', 'top-right');
        return response()->download($file_name)->deleteFileAfterSend(true);
    }

    private function createIncDecBhxhFile($month, $year, $is_increase)
    {
        // Make new sheet
        $spreadsheet = new Spreadsheet();

        //Set font
        $styleArray = array(
            'font'  => array(
                'name'  => 'Times New Roman',
                'size' => 11,
            ),
        );
        $spreadsheet->getDefaultStyle()
                    ->applyFromArray($styleArray);

        //Create the first worksheet
        $w_sheet = $spreadsheet->getActiveSheet();

        //Set sheet title
        $w_sheet->setTitle("Tăng BHXH");

        //Set title of report
        if ($is_increase) {
            $w_sheet->setCellValue('C1', 'BÁO CÁO PHÁT SINH TĂNG BHXH THÁNG ' . $month . '-' . $year);
        } else {
            $w_sheet->setCellValue('C1', 'BÁO CÁO PHÁT SINH GIẢM BHXH THÁNG ' . $month . '-' . $year);
        }
        $w_sheet->getStyle("C1")
                    ->getFont()
                    ->setSize(13)
                    ->setBold(true);

        //Set column width and column name
        $w_sheet->getColumnDimension('A')->setWidth(6);
        $w_sheet->getStyle("A3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('A3', 'STT');

        $w_sheet->getColumnDimension('B')->setWidth(6);
        $w_sheet->getStyle("B3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('B3', 'MÃ');

        $w_sheet->getColumnDimension('C')->setWidth(30);
        $w_sheet->getStyle("C3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('C3', 'HỌ TÊN');

        $w_sheet->getColumnDimension('D')->setWidth(15);
        $w_sheet->getStyle("D3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('D3', 'SỐ BHXH');

        $w_sheet->getColumnDimension('E')->setWidth(15);
        $w_sheet->getStyle("E3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('E3', 'SỐ CCCD');

        $w_sheet->getColumnDimension('F')->setWidth(15);
        $w_sheet->getStyle("F3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('F3', 'NGÀY SINH');

        $w_sheet->getColumnDimension('G')->setWidth(15);
        $w_sheet->getStyle("G3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('G3', 'GIỚI TÍNH');

        $w_sheet->getColumnDimension('H')->setWidth(25);
        $w_sheet->getStyle("H3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('H3', 'VỊ TRÍ');

        $w_sheet->getColumnDimension('I')->setWidth(35);
        $w_sheet->getStyle("I3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('I3', 'ĐỊA CHỈ');

        $w_sheet->getColumnDimension('J')->setWidth(20);
        $w_sheet->getStyle("J3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('J3', 'SỐ ĐIỆN THOẠI');

        $w_sheet->getColumnDimension('K')->setWidth(25);
        $w_sheet->getStyle("K3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('K3', 'SỐ HỢP ĐỒNG');

        $w_sheet->getColumnDimension('L')->setWidth(50);
        $w_sheet->getStyle("L3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        if ($is_increase) {
            $w_sheet->setCellValue('L3', 'NGÀY KÝ HĐ');
        } else {
            $w_sheet->setCellValue('L3', 'NGÀY NGHỈ');
        }

        $w_sheet->getColumnDimension('M')->setWidth(20);
        $w_sheet->getStyle("M3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('M3', 'LƯƠNG BHXH');

        $w_sheet->getColumnDimension('N')->setWidth(15);
        $w_sheet->getStyle("N3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        $w_sheet->setCellValue('N3', 'TỶ LỆ ĐÓNG');

        $w_sheet->getColumnDimension('O')->setWidth(25);
        $w_sheet->getStyle("O3")
                ->getBorders()
                ->getOutline()
                ->setBorderStyle(Border::BORDER_THIN);
        if ($is_increase) {
            $w_sheet->setCellValue('O3', 'TIỀN TĂNG BHXH');
        } else {
            $w_sheet->setCellValue('O3', 'TIỀN GIẢM BHXH');
        }

        //Set bold for column name
        $w_sheet->getStyle("A3:O3")
                    ->getFont()
                    ->setSize(13)
                    ->setBold(true);

        //Get all increase bhxh by month, year
        if ($is_increase) {
            $inc_dec_insurances = IncreaseDecreaseInsurance::where('increase_confirmed_month', '!=', null)
                                                            ->where('is_increase', true)
                                                            ->whereMonth('increase_confirmed_month', $month)
                                                            ->whereYear('increase_confirmed_month', $year)
                                                            ->get();
        } else {
            //Get all decrease bhxh by month, year
            $inc_dec_insurances = IncreaseDecreaseInsurance::where('decrease_confirmed_month', '!=', null)
                                                            ->where('is_decrease', true)
                                                            ->whereMonth('decrease_confirmed_month', $month)
                                                            ->whereYear('decrease_confirmed_month', $year)
                                                            ->get();
        }


        $index = 0;
        $start_row = 3;
        foreach ($inc_dec_insurances as $inc_dec_insurance) {
            $index += 1;
            //Write STT
            $w_sheet->getStyle('A'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $w_sheet->setCellValue('A' . ($start_row + $index), $index);
            //Write code
            $w_sheet->getStyle('B'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $w_sheet->setCellValue('B' . ($start_row + $index), $inc_dec_insurance->employee_work->employee->code);
            //Write name
            $w_sheet->getStyle('C'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $w_sheet->setCellValue('C' . ($start_row + $index), $inc_dec_insurance->employee_work->employee->name);
            //Write BHXH
            $w_sheet->getStyle('D'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $w_sheet->setCellValue('D' . ($start_row + $index), $inc_dec_insurance->employee_work->employee->bhxh);
            //Write CCCD
            $w_sheet->getStyle('E'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $w_sheet->setCellValue('E' . ($start_row + $index), $inc_dec_insurance->employee_work->employee->cccd);
            //Write date of birth
            $w_sheet->getStyle('F'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $w_sheet->setCellValue('F' . ($start_row + $index), date('d/m/Y', strtotime($inc_dec_insurance->employee_work->employee->date_of_birth)));
            //Write gender
            $w_sheet->getStyle('G'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $w_sheet->setCellValue('G' . ($start_row + $index), $inc_dec_insurance->employee_work->employee->gender);
            //Write company job
            $w_sheet->getStyle('H'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $w_sheet->setCellValue('H' . ($start_row + $index), $inc_dec_insurance->employee_work->company_job->name);
            //Write address
            $w_sheet->getStyle('I'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $w_sheet->setCellValue('I' . ($start_row + $index),
                                    $inc_dec_insurance->employee_work->employee->address
                                    . ', '
                                    .  $inc_dec_insurance->employee_work->employee->commune->name
                                    .', '
                                    .  $inc_dec_insurance->employee_work->employee->commune->district->name
                                    .', '
                                    . $inc_dec_insurance->employee_work->employee->commune->district->province->name);
            //Write phone
            $w_sheet->getStyle('J'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $w_sheet->setCellValue('J' . ($start_row + $index), $inc_dec_insurance->employee_work->employee->phone);
            //Write contract code
            $w_sheet->getStyle('K'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);

            $employee_contract = EmployeeContract::where('code', $inc_dec_insurance->employee_work->contract_code)->first();

            $w_sheet->setCellValue('K' . ($start_row + $index), $employee_contract->code);
            //Write contract start date/end date
            $w_sheet->getStyle('L'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            if ($is_increase) {
                $w_sheet->setCellValue('L' . ($start_row + $index), $inc_dec_insurance->employee_work->start_date);
            } else {
                $w_sheet->setCellValue('L' .($start_row + $index),
                                        $inc_dec_insurance->employee_work->end_date .
                                        ' (' . $inc_dec_insurance->employee_work->off_type->name .
                                        ' - số QĐ: ' .
                                        $inc_dec_insurance->employee_work->employee->code .
                                        '/' .
                                        date('Y', strtotime($inc_dec_insurance->employee_work->end_date)) .
                                        '/QĐ-HH' .
                                        ')');
            }
            //Write insurance salary
            $w_sheet->getStyle('M'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $employee_salary = $this->getEmployeeSalaryByMonthYear($inc_dec_insurance->employee_work->employee_id, $month, $year);
            if ($employee_salary) {
                $w_sheet->setCellValue('M' . ($start_row + $index), $employee_salary->insurance_salary);
            } else {
                $w_sheet->setCellValue('M' . ($start_row + $index), 'Chưa khai báo lương');
            }
            //Write pay rate
            $w_sheet->getStyle('N'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            $employee_insurance = EmployeeInsurance::where('employee_id', $inc_dec_insurance->employee_work->employee_id)
                                                    ->where('insurance_id', 1)
                                                    ->first();
            if ($employee_insurance) {
                $w_sheet->setCellValue('N' . ($start_row + $index), $employee_insurance->pay_rate . '%');
            } else {
                $w_sheet->setCellValue('N' . ($start_row + $index), 'Chưa khai báo BHXH');
            }
            //Write bhxh increase/decrease
            $w_sheet->getStyle('O'. ($start_row + $index))
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
            if ($employee_insurance) {
                $employee_salary = $this->getEmployeeSalaryByMonthYear($inc_dec_insurance->employee_work->employee_id, $month, $year);
                if ($employee_salary) {
                    $bhxh_increase = $employee_salary->insurance_salary * $employee_insurance->pay_rate / 100;
                    $w_sheet->setCellValue('O' . ($start_row + $index), $bhxh_increase);
                } else {
                    $w_sheet->setCellValue('O' . ($start_row + $index), 'Chưa khai báo lương');
                }
            } else {
                $w_sheet->setCellValue('O' . ($start_row + $index), 'Chưa khai báo BHXH');
            }
        }

        //Save to file
        $writer = new Xlsx($spreadsheet);
        if ($is_increase) {
            $file_name = 'Báo cáo phát sinh tăng BHXH tháng ' . Carbon::now()->format('m-Y') . '.xlsx';
        } else {
            $file_name = 'Báo cáo phát sinh giảm BHXH tháng ' . Carbon::now()->format('m-Y') . '.xlsx';
        }
        $writer->save($file_name);

        return $file_name;
    }
}
