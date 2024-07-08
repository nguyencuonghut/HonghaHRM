<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use App\Models\CompanyJob;
use App\Models\EmployeeContract;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class AdminEmployeeContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.contract.index');
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
            'contract_company_job_id' => 'required',
            'contract_type_id' => 'required',
            'contract_s_date' => 'required',
        ];

        $messages = [
            'employee_id.required' => 'Số Id nhân sự chưa có.',
            'contract_company_job_id.required' => 'Bạn cần chọn Vị trí.',
            'contract_type_id.required' => 'Bạn cần chọn loại hợp đồng.',
            'contract_s_date.required' => 'Bạn cần nhập ngày bắt đầu.',
        ];

        $request->validate($rules, $messages);

        // Create new EmployeeContract
        $employee_contract = new EmployeeContract();
        $employee_contract->employee_id = $request->employee_id;
        $employee_contract->company_job_id = $request->contract_company_job_id;
        $employee_contract->contract_type_id = $request->contract_type_id;
        $employee_contract->start_date = Carbon::createFromFormat('d/m/Y', $request->contract_s_date);
        if ($request->contract_e_date) {
            $employee_contract->end_date = Carbon::createFromFormat('d/m/Y', $request->contract_e_date);
        }

        if ($request->hasFile('file_path')) {
            $path = 'dist/employee_contract';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('file_path');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $employee_contract->file_path = $path . '/' . $name;
        }

        $employee_contract->status = 'On';
        $employee_contract->save();

        Alert::toast('Thêm hợp đồng mới thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeContract $employeeContract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee_contract = EmployeeContract::findOrFail($id);
        $company_jobs = CompanyJob::all();
        $contract_types = ContractType::all();
        return view('admin.contract.edit', [
            'employee_contract' => $employee_contract,
            'company_jobs' => $company_jobs,
            'contract_types' => $contract_types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'company_job_id' => 'required',
            'contract_type_id' => 'required',
            's_date' => 'required',
        ];

        $messages = [
            'company_job_id.required' => 'Bạn cần chọn Vị trí.',
            'contract_type_id.required' => 'Bạn cần chọn loại hợp đồng.',
            's_date.required' => 'Bạn cần nhập ngày bắt đầu.',
        ];

        $request->validate($rules, $messages);

        // Create new EmployeeContract
        $employee_contract = EmployeeContract::findOrFail($id);
        $employee_contract->company_job_id = $request->company_job_id;
        $employee_contract->contract_type_id = $request->contract_type_id;
        $employee_contract->start_date = Carbon::createFromFormat('d/m/Y', $request->s_date);
        if ($request->e_date) {
            $employee_contract->end_date = Carbon::createFromFormat('d/m/Y', $request->e_date);
        }

        if ($request->hasFile('file_path')) {
            $path = 'dist/employee_contract';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('file_path');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $employee_contract->file_path = $path . '/' . $name;
        }

        $employee_contract->status = 'On';
        $employee_contract->save();

        Alert::toast('Sửa hợp đồng mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_contract->employee_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_contract = EmployeeContract::findOrFail($id);
        $employee_contract->destroy($id);

        Alert::toast('Xóa hợp đồng thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    public function anyData()
    {
        $employee_contracts = EmployeeContract::orderBy('employee_id', 'asc')->get();
        return Datatables::of($employee_contracts)
            ->addIndexColumn()
            ->editColumn('employee_name', function ($employee_contracts) {
                return '<a href=' . route("admin.hr.employees.show", $employee_contracts->employee_id) . '>' . $employee_contracts->employee->name . '</a>' ;
            })
            ->editColumn('company_job', function ($employee_contracts) {
                if ($employee_contracts->company_job->division_id) {
                    return $employee_contracts->company_job->name . ' - ' . $employee_contracts->company_job->division->name .  '- ' . $employee_contracts->company_job->department->name;

                } else {
                    return $employee_contracts->company_job->name . ' - ' . $employee_contracts->company_job->department->name;
                }
            })
            ->editColumn('contract', function ($employee_contracts) {
                return $employee_contracts->contract_type->name;
            })
            ->editColumn('start_date', function ($employee_contracts) {
                return date('d/m/Y', strtotime($employee_contracts->start_date));
            })
            ->editColumn('end_date', function ($employee_contracts) {
                if ($employee_contracts->end_date) {
                    return date('d/m/Y', strtotime($employee_contracts->end_date));
                } else {
                    return '-';
                }
            })
            ->editColumn('status', function ($employee_contracts) {
                if ('On' == $employee_contracts->status) {
                    return '<span class="badge badge-success">' . $employee_contracts->status . '</span>';
                } else {
                    return '<span class="badge badge-danger">' . $employee_contracts->status . '</span>';
                }
            })
            ->editColumn('file', function ($employee_contracts) {
                $url = '';
                if ($employee_contracts->file_path) {
                    $url .= '<a target="_blank" href="../../../' . $employee_contracts->file_path . '"><i class="far fa-file-pdf"></i></a>';
                    return $url;
                } else {
                    return $url;
                }

            })
            ->rawColumns(['employee_name', 'status', 'file'])
            ->make(true);
    }


    public function getOff($id)
    {
        $employee_contract = EmployeeContract::findOrFail($id);
        return view('admin.contract.off', ['employee_contract' => $employee_contract]);
    }

    public function off(Request $request, $id)
    {
        $rules = [
            'e_date' => 'required',
        ];

        $messages = [
            'e_date.required' => 'Bạn phải nhập ngày kết thúc.',
        ];

        $request->validate($rules, $messages);

        // Off the EmployeeContract
        $employee_contract = EmployeeContract::findOrFail($id);
        $employee_contract->status = 'Off';
        $employee_contract->end_date = Carbon::createFromFormat('d/m/Y', $request->e_date);
        $employee_contract->save();

        Alert::toast('Cập nhật thành công!', 'success', 'top-right');
        return redirect()->route('admin.hr.employees.show', $employee_contract->employee_id);
    }
}
