<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAppendix;
use App\Models\EmployeeContract;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Datatables;

class AdminEmployeeAppendixController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.appendix.index');
    }

    /**
     * Add new ContractAppendix
     */
    public function getAdd($employee_contract_id)
    {
        $employee_contract = EmployeeContract::findOrFail($employee_contract_id);
        return view('admin.appendix.add',
                    [
                        'employee_contract' => $employee_contract,
                    ]);
    }

    public function add(Request $request)
    {
        $rules = [
            'employee_id' => 'required',
            'employee_contract_id' => 'required',
            'code' => 'required',
            'description' => 'required',
            'reason' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số id nhân sự không hợp lệ.',
            'employee_contract_id.required' => 'Số id hợp đồng không hợp lệ.',
            'code.required' => 'Bạn phải nhập số phụ lục.',
            'description.required' => 'Bạn phải nhập mô tả.',
            'reason.required' => 'Bạn phải chọn lý do.',
        ];

        $request->validate($rules, $messages);

        $employee_appendix = new EmployeeAppendix();
        $employee_appendix->employee_id = $request->employee_id;
        $employee_appendix->employee_contract_id = $request->employee_contract_id;
        $employee_appendix->code = $request->code;
        $employee_appendix->description = $request->description;
        $employee_appendix->reason = $request->reason;
        if ($request->hasFile('file_path')) {
            $path = 'dist/employee_appendix';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('file_path');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $employee_appendix->file_path = $path . '/' . $name;
        }
        $employee_appendix->save();

        Alert::toast('Thêm phụ lục mới thành công. Bạn cần tạo QT công tác!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_appendix->employee_contract->employee->id);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeAppendix $employeeAppendix)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee_appendix = EmployeeAppendix::findOrFail($id);
        return view('admin.appendix.edit', ['employee_appendix' => $employee_appendix]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'code' => 'required',
            'description' => 'required',
            'reason' => 'required',
        ];

        $messages = [
            'code.required' => 'Bạn phải nhập số phụ lục.',
            'description.required' => 'Bạn phải nhập mô tả.',
            'reason.required' => 'Bạn phải chọn lý do.',
        ];

        $request->validate($rules, $messages);

        $employee_appendix = EmployeeAppendix::findOrFail($id);
        $employee_appendix->code = $request->code;
        $employee_appendix->description = $request->description;
        $employee_appendix->reason = $request->reason;
        if ($request->hasFile('file_path')) {
            $path = 'dist/employee_appendix';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('file_path');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $employee_appendix->file_path = $path . '/' . $name;
        }
        $employee_appendix->save();

        Alert::toast('Sửa phụ lục mới thành công. Bạn cần tạo QT công tác!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_appendix->employee_contract->employee->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_appendix = EmployeeAppendix::findOrFail($id);
        $employee_appendix->destroy($id);

        Alert::toast('Xóa phụ lục thành công. Bạn cần cập nhật QT công tác!', 'success', 'top-right');
        return redirect()->back();
    }

    public function anyData()
    {
        $employee_appendixs = EmployeeAppendix::orderBy('employee_id', 'asc')->get();
        return Datatables::of($employee_appendixs)
            ->addIndexColumn()
            ->editColumn('employee_name', function ($employee_appendixs) {
                return '<a href=' . route("admin.hr.employees.show", $employee_appendixs->employee_id) . '>' . $employee_appendixs->employee->name . '</a>' ;
            })
            ->editColumn('company_job', function ($employee_appendixs) {
                if ($employee_appendixs->employee_contract->company_job->division_id) {
                    return $employee_appendixs->employee_contract->company_job->name . ' - ' . $employee_appendixs->employee_contract->company_job->division->name .  '- ' . $employee_appendixs->employee_contract->company_job->department->name;

                } else {
                    return $employee_appendixs->employee_contract->company_job->name . ' - ' . $employee_appendixs->employee_contract->company_job->department->name;
                }
            })
            ->editColumn('code', function ($employee_appendixs) {
                return $employee_appendixs->code;
            })
            ->editColumn('contract_code', function ($employee_appendixs) {
                return$employee_appendixs->employee_contract->code;
            })
            ->editColumn('description', function ($employee_appendixs) {
                return $employee_appendixs->description;
            })
            ->editColumn('reason', function ($employee_appendixs) {
                return $employee_appendixs->reason;
            })
            ->editColumn('file', function ($employee_appendixs) {
                $url = '';
                if ($employee_appendixs->file_path) {
                    $url .= '<a target="_blank" href="../../../' . $employee_appendixs->file_path . '"><i class="far fa-file-pdf"></i></a>';
                    return $url;
                } else {
                    return $url;
                }

            })
            ->rawColumns(['employee_name', 'description', 'file'])
            ->make(true);
    }
}
