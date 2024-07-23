<?php

namespace App\Http\Controllers;

use App\Models\CompanyJob;
use App\Models\Employee;
use App\Models\EmployeeWork;
use App\Models\EmployeeRelative;
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
            ->editColumn('start_date', function ($employee_works) {
                return date('d/m/Y', strtotime($employee_works->start_date));
            })
            ->editColumn('insurance_salary', function ($employee_works) {
                return number_format($employee_works->employee->company_job->insurance_salary, 0, '.', ',');
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
            ->editColumn('insurance_salary', function ($employee_works) {
                return number_format($employee_works->company_job->insurance_salary, 0, '.', ',');
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
        $employee_works = EmployeeWork::where('on_type_id', 2)->whereMonth('start_date', $month)->whereYear('start_date', $year)->select('*');
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
            ->editColumn('insurance_salary', function ($employee_works) {
                return number_format($employee_works->company_job->insurance_salary, 0, '.', ',');
            })
            ->rawColumns(['name'])
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
            ->editColumn('insurance_salary', function ($employee_works) {
                return number_format($employee_works->company_job->insurance_salary, 0, '.', ',');
            })
            ->rawColumns(['name'])
            ->make(true);
    }
}
