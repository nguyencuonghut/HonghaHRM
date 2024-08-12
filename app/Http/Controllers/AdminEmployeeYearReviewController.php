<?php

namespace App\Http\Controllers;

use App\Models\EmployeeYearReview;
use Illuminate\Http\Request;
use Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeYearReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.year_review.index');
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
            'employee_id' => 'required',
            'year' => 'required',
            'kpi_average' => 'required',
            'result' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id nhân sự không đúng.',
            'year.required' => 'Bạn cần nhập năm.',
            'kpi_average.required' => 'Bạn cần nhập tháng.',
            'result.required' => 'Bạn cần nhập kết quả.',
        ];

        $request->validate($rules, $messages);

        $employee_year_review = new EmployeeYearReview();
        $employee_year_review->employee_id = $request->employee_id;
        $employee_year_review->year = $request->year;
        $employee_year_review->kpi_average = $request->kpi_average;
        $employee_year_review->result = $request->result;
        if ($request->detail) {
            $employee_year_review->detail = $request->detail;
        }
        $employee_year_review->save();

        Alert::toast('Nhập đánh giá năm thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeYearReview $employeeYearReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee_year_review = EmployeeYearReview::findOrFail($id);
        return view('admin.year_review.edit', ['employee_year_review' => $employee_year_review]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'year' => 'required',
            'kpi_average' => 'required',
            'result' => 'required',
        ];

        $messages = [
            'year.required' => 'Bạn cần nhập năm.',
            'kpi_average.required' => 'Bạn cần nhập tháng.',
            'result.required' => 'Bạn cần nhập kết quả.',
        ];

        $request->validate($rules, $messages);

        $employee_year_review = EmployeeYearReview::findOrFail($id);
        $employee_year_review->year = $request->year;
        $employee_year_review->kpi_average = $request->kpi_average;
        $employee_year_review->result = $request->result;
        if ($request->detail) {
            $employee_year_review->detail = $request->detail;
        }
        $employee_year_review->save();

        Alert::toast('Sửa đánh giá năm thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_year_review->employee_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_year_review = EmployeeYearReview::findOrFail($id);
        $employee_year_review->destroy($id);

        Alert::toast('Xóa đánh giá năm thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    public function employeeData($employee_id)
    {
        $employee_year_reviews = EmployeeYearReview::where('employee_id', $employee_id)->orderBy('id', 'desc')->get();
        return Datatables::of($employee_year_reviews)
            ->addIndexColumn()
            ->editColumn('year', function ($employee_year_reviews) {
                return $employee_year_reviews->year;
            })
            ->editColumn('kpi_average', function ($employee_year_reviews) {
                return $employee_year_reviews->kpi_average;
            })
            ->editColumn('result', function ($employee_year_reviews) {
                if($employee_year_reviews->result == 'Xuất sắc') {
                    return '<span class="badge" style="background-color: purple; color:white;">Xuất sắc</span>';
                } else if($employee_year_reviews->result == 'Tốt'){
                    return '<span class="badge badge-success">Tốt</span>';
                }
                else if($employee_year_reviews->result == 'Đạt'){
                    return '<span class="badge badge-warning">Đạt</span>';
                }
                else {
                    return '<span class="badge badge-danger">Cải thiện</span>';
                }
            })
            ->editColumn('detail', function ($employee_year_reviews) {
                return $employee_year_reviews->detail;
            })
            ->addColumn('actions', function ($employee_year_reviews) {
                $action = '<a href="' . route("admin.hr.year_reviews.edit", $employee_year_reviews->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.hr.year_reviews.destroy", $employee_year_reviews->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['result', 'actions', 'detail'])
            ->make(true);
    }

    public function anyData()
    {
        $employee_year_reviews = EmployeeYearReview::join('employees', 'employees.id', 'employee_year_reviews.employee_id')
                                                    ->orderBy('employees.code', 'desc')
                                                    ->get();
        return Datatables::of($employee_year_reviews)
            ->addIndexColumn()
            ->editColumn('department', function ($employee_year_reviews) {
                $employee_works = EmployeeWork::where('employee_id', $employee_year_reviews->employee_id)->where('status', 'On')->get();
                $employee_department_str = '';
                $i = 0;
                $length = count($employee_works);
                if ($length) {
                    foreach ($employee_works as $employee_work) {
                        if(++$i === $length) {
                            $employee_department_str .= $employee_work->company_job->department->name;
                        } else {
                            $employee_department_str .= $employee_work->company_job->department->name;
                            $employee_department_str .= ' | ';
                        }
                    }
                } else {
                    $employee_department_str .= '!! Chưa gán vị trí công việc !!';
                }
                return $employee_department_str;
            })
            ->editColumn('employee', function ($employee_year_reviews) {
                return '<a href="' . route("admin.hr.employees.show", $employee_year_reviews->employee_id) . '">' . $employee_kpis->employee->name . '</a>';
            })
            ->editColumn('year', function ($employee_year_reviews) {
                return $employee_year_reviews->year;
            })
            ->editColumn('kpi_average', function ($employee_year_reviews) {
                return $employee_year_reviews->kpi_average;
            })
            ->editColumn('result', function ($employee_year_reviews) {
                return $employee_year_reviews->result;
            })
            ->editColumn('detail', function ($employee_year_reviews) {
                return $employee_year_reviews->detail;
            })
            ->addColumn('actions', function ($employee_year_reviews) {
                $action = '<a href="' . route("admin.hr.kpis.edit", $employee_year_reviews->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.hr.kpis.destroy", $employee_year_reviews->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['department', 'employee', 'actions'])
            ->make(true);
    }
}
