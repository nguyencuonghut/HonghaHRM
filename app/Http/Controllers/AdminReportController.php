<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeWork;
use Illuminate\Http\Request;
use Datatables;

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
                        if ($request->get('gender') == 'Nam' || $request->get('gender') == 'Nữ') {
                            $instance->where('gender', $request->get('gender'));
                        }
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('date_of_birth', 'LIKE', "%$search%")
                                ->orWhere('company_email', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['name', 'gender'])
                    ->make(true);
        }

        return view('admin.report.birthday');
    }

    public function situation()
    {
        dd("Situation report");

    }

    public function kid_policy()
    {
        dd("Kid policy report");

    }

    public function seniority()
    {
        dd("Seniority report");

    }
}
