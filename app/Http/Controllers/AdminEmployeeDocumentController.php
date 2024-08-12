<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\EmployeeWork;
use App\Models\Document;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use Carbon\Carbon;

class AdminEmployeeDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'document_id' => 'required',
        ];
        $messages = [
            'employee_id.required' => 'Số phiếu hồ sơ nhân sự không hợp lệ.',
            'document_id.required' => 'Bạn phải chọn tên giấy tờ',
        ];

        $request->validate($rules,$messages);

        // Check if employee document existed or not
        $my_employee_documents = EmployeeDocument::where('employee_id', $request->employee_id)
                                                    ->where('document_id', $request->document_id)
                                                    ->get();
        if ($my_employee_documents->count()) {
            Alert::toast('Giấy tờ đã được khai báo!', 'error', 'top-right');
            return redirect()->back();
        }

        // Create new
        $employee_document = new EmployeeDocument();
        $employee_document->employee_id = $request->employee_id;
        $employee_document->document_id = $request->document_id;

        if ($request->hasFile('file_path')) {
            $path = 'dist/employee_document';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('file_path');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $employee_document->file_path = $path . '/' . $name;
        }
        $employee_document->save();

        Alert::toast('Tạo trạng thái giấy tờ thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeDocument $employeeDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeDocument $employeeDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'employee_id' => 'required',
            'document_id' => 'required',
        ];
        $messages = [
            'employee_id.required' => 'Số phiếu hồ sơ nhân sự không hợp lệ.',
            'document_id.required' => 'Bạn phải chọn tên giấy tờ',
        ];

        $request->validate($rules,$messages);

        // Update the EmployeeDocument
        $employee_document = EmployeeDocument::findOrFail($id);
        $employee_document->employee_id = $request->employee_id;
        $employee_document->document_id = $request->document_id;

        if ($request->hasFile('file_path')) {
            $path = 'dist/employee_document';

            !file_exists($path) && mkdir($path, 0777, true);

            $file = $request->file('file_path');
            $name = time() . rand(1,100) . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $employee_document->file_path = $path . '/' . $name;
        }
        $employee_document->save();

        Alert::toast('Sửa trạng thái giấy tờ thành công!', 'success', 'top-right');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee_document = EmployeeDocument::findOrFail($id);
        $employee_document->destroy($employee_document->id);
        Alert::toast('Xóa trạng thái giấy tờ thành công!', 'success', 'top-right');
        return redirect()->back();
    }
}
