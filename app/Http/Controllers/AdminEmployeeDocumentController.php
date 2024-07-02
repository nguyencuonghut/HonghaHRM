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

    public function makeSampleHdtv($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
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
        $w_sheet->setTitle("HĐTV");

        // Thông tin cty
        $w_sheet->mergeCells("A2:D4");
        $w_sheet->setCellValue('A2', 'CÔNG TY CỔ PHẦN DINH DƯỠNG HỒNG HÀ');
        $w_sheet->getStyle("A2")
                    ->getFont()
                    ->setSize(13)
                    ->setBold(true);
        $w_sheet->getStyle("A2")->getAlignment()->setWrapText(true);
        $w_sheet->getStyle("A2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $w_sheet->getStyle("A2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // Thông tin nước
        $w_sheet->mergeCells("E2:J2");
        $w_sheet->getRowDimension('2')->setRowHeight(30);
        $w_sheet->setCellValue('E2', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $w_sheet->getStyle("E2")
                    ->getFont()
                    ->setSize(13)
                    ->setBold(true);
        $w_sheet->getStyle("E2")->getAlignment()->setWrapText(true);
        $w_sheet->getStyle("E2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $w_sheet->getStyle("E2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


        $w_sheet->mergeCells("E3:J3");
        $w_sheet->setCellValue('E3', 'Độc lập - Tự do - Hạnh phúc');
        $w_sheet->getStyle("E3")
                    ->getFont()
                    ->setSize(13)
                    ->setBold(true);
        $w_sheet->getStyle("E3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $w_sheet->mergeCells("E4:J4");
        $w_sheet->setCellValue('E4', '-----o0o-----');
        $w_sheet->getStyle("E4")
                    ->getFont()
                    ->setSize(13);
        $w_sheet->getStyle("E4")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Số hợp đồng
        $w_sheet->mergeCells("A5:D5");
        $w_sheet->setCellValue('A5', 'Số: ' . $employee->code .'/' .  Carbon::now()->format('Y') .'/HĐTV-HH');
        $w_sheet->getStyle("A5")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Thời gian
        $w_sheet->mergeCells("E5:J5");
        $w_sheet->setCellValue('E5', 'Hà Nam, ngày ' . Carbon::now()->format('d') . ' tháng ' . Carbon::now()->format('m') . ' năm ' . Carbon::now()->format('Y'));
        $w_sheet->getStyle("E5")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Tên hợp đồng
        $w_sheet->mergeCells("A7:J8");
        $w_sheet->setCellValue('A7', 'HỢP ĐỒNG THỬ VIỆC');
        $w_sheet->getStyle("A7")
                    ->getFont()
                    ->setBold(true)
                    ->setSize(18);
        $w_sheet->getStyle("A7")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $w_sheet->getStyle("A7")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


        // Căn cứ
        $w_sheet->mergeCells("A9:J9");
        $w_sheet->getRowDimension('9')->setRowHeight(30);
        $w_sheet->setCellValue('A9', '- Căn cứ Bộ Luật lao động được Quốc Hội nước Cộng Hòa Xã Hội Chủ Nghĩa Việt Nam thông qua ngày 18/6/2012.');
        $w_sheet->getStyle("A9")->getAlignment()->setWrapText(true);

        // Nhu cầu
        //$w_sheet->mergeCells("A10:J10");
        $w_sheet->setCellValue('A10', '- Theo nhu cầu và thỏa thuận của các Bên.');

        // Thời gian, địa điểm
        $w_sheet->mergeCells("A11:J11");
        $w_sheet->getRowDimension('11')->setRowHeight(30);
        $w_sheet->setCellValue('A11', 'Hôm nay, ngày ' . Carbon::now()->format('d') . ' tháng ' . Carbon::now()->format('m') . ' năm ' . Carbon::now()->format('Y') . ' tại Công ty Cổ phần Dinh Dưỡng Hồng Hà, chúng tôi gồm:');
        $w_sheet->getStyle("A11")->getAlignment()->setWrapText(true);

        // Bên A
        $w_sheet->setCellValue('A12', 'Bên A: Công ty cổ phần dinh dưỡng Hồng Hà');
        $w_sheet->getStyle("A12")
                    ->getFont()
                    ->setBold(true);

        // Địa chỉ bên A
        $w_sheet->mergeCells("A13:J13");
        $w_sheet->setCellValue('A13', '- Địa chỉ: KCN Đồng Văn, phường Bạch Thượng, huyện Duy Tiên, tỉnh Hà Nam.');
        $w_sheet->getStyle("A13")->getAlignment()->setWrapText(true);

        // Đại diện bên A
        $w_sheet->setCellValue('A14', '- Đại diện');
        $w_sheet->setCellValue('C14', 'Ông Tạ Văn Toại');
        $w_sheet->getStyle("C14")
                    ->getFont()
                    ->setBold(true);

        $w_sheet->setCellValue('G14', '- Quốc tịch: Việt Nam');
        $w_sheet->setCellValue('A15', '- Chức vụ:');
        $w_sheet->setCellValue('C15', 'Giám đốc khối Kiểm Soát');

        // Bên B
        $w_sheet->setCellValue('A16', 'Bên B:');
        $w_sheet->getStyle("A16")
                    ->getFont()
                    ->setBold(true);
        $w_sheet->setCellValue('C16', $employee->name);
        $w_sheet->getStyle("C16")
                    ->getFont()
                    ->setBold(true);
        $w_sheet->setCellValue('G16', '- Quốc tịch: Việt Nam');

        $w_sheet->setCellValue('A17', '- Sinh ngày:');
        $w_sheet->setCellValue('C17', date('d/m/Y', strtotime($employee->date_of_birth)));
        $w_sheet->getStyle("C17")
                    ->getFont()
                    ->setBold(true);

        $objRichText = new RichText();
        $objRichText->createText('- Số CCCD: ');
        $objBold = $objRichText->createTextRun($employee->cccd);
        $objBold->getFont()->setBold(true);
        $objBold->getFont()->setName("Times New Roman");
        $w_sheet->getCell('A18')->setValue($objRichText);
        $w_sheet->getStyle("A18")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $w_sheet->mergeCells("A18:C18");

        $objRichText = new RichText();
        $objRichText->createText('- Ngày cấp: ');
        $objBold = $objRichText->createTextRun(date('d/m/Y', strtotime($employee->issued_date)));
        $objBold->getFont()->setBold(true);
        $objBold->getFont()->setName("Times New Roman");
        $w_sheet->getCell('D18')->setValue($objRichText);
        $w_sheet->getStyle("D18")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $w_sheet->mergeCells("D18:F18");

        $objRichText = new RichText();
        $objRichText->createText('- Nơi cấp: ');
        $objBold = $objRichText->createTextRun($employee->issued_by);
        $objBold->getFont()->setBold(true);
        $objBold->getFont()->setName("Times New Roman");
        $w_sheet->getCell('G18')->setValue($objRichText);
        $w_sheet->mergeCells("G18:J18");
        $w_sheet->getRowDimension('18')->setRowHeight(30);
        $w_sheet->getStyle("G18")->getAlignment()->setWrapText(true);
        $w_sheet->getStyle("G18")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // Địa chỉ bên B
        $w_sheet->setCellValue('A19', '- Địa chỉ:');
        $w_sheet->setCellValue('C19', $employee->address . ', ' . $employee->commune->name . ', ' . $employee->commune->district->name . ', ' . $employee->commune->district->province->name);
        $w_sheet->getStyle("C19")
                    ->getFont()
                    ->setBold(true);

        // Thỏa thuận
        $w_sheet->setCellValue('A20', 'Thỏa thuận ký kết Hợp đồng thử việc và cam kết làm đúng những điều khoản sau đây:');

        // Điều 1
        $objRichText = new RichText();
        $objUnderlined = $objRichText->createTextRun("Điều 1:");
        $objUnderlined->getFont()->setUnderline(true);
        $objUnderlined->getFont()->setBold(true);
        $objUnderlined->getFont()->setSize(12);
        $objUnderlined->getFont()->setName("Times New Roman");
        $objRichText->createText(' Thời gian hợp đồng, địa điểm làm việc, công việc phải làm');
        $w_sheet->getCell("A21")->setValue($objRichText);
        $w_sheet->getStyle("A21")
                ->getFont()
                ->setBold(true);

        $objRichText = new RichText();
        $objRichText->createText('1. Loại hợp đồng: ');
        $objBold = $objRichText->createTextRun('Hợp đồng thử việc');
        $objBold->getFont()->setBold(true);
        $objBold->getFont()->setName("Times New Roman");
        $w_sheet->getCell('A22')->setValue($objRichText);

        $w_sheet->setCellValue('A23', '- Thời hạn hợp đồng từ ngày ................ đến ngày ................');
        $w_sheet->setCellValue('A24', '2. Địa điểm làm việc: Nhà máy Công ty Cổ phần dinh dưỡng Hồng Hà và địa bàn khác theo sự phân công của cấp trên.');
        $w_sheet->getRowDimension('24')->setRowHeight(30);
        $w_sheet->getStyle("A24")->getAlignment()->setWrapText(true);
        $w_sheet->mergeCells("A24:J24");

        $w_sheet->setCellValue('A25', '3. Công việc phải làm');
        $w_sheet->setCellValue('A26', '- Chức danh:');

        $employee_work = EmployeeWork::where('employee_id', $employee->id)->where('status', 'On')->orderBy('id', 'desc')->first();
        $w_sheet->setCellValue('C26', $employee_work->company_job->name);
        $w_sheet->getStyle("C26")
                ->getFont()
                ->setBold(true);

        $w_sheet->mergeCells("A27:J27");
        $w_sheet->setCellValue('A27', '- Công việc phải làm: Theo bản mô tả công việc và những công việc theo sự phân công của cấp trên.');
        $w_sheet->getRowDimension('27')->setRowHeight(30);
        $w_sheet->getStyle("27")->getAlignment()->setWrapText(true);
        $w_sheet->mergeCells("A27:J27");

        // Điều 2
        $objRichText = new RichText();
        $objUnderlined = $objRichText->createTextRun("Điều 2:");
        $objUnderlined->getFont()->setUnderline(true);
        $objUnderlined->getFont()->setBold(true);
        $objUnderlined->getFont()->setSize(12);
        $objUnderlined->getFont()->setName("Times New Roman");
        $objRichText->createText(' Chế độ làm việc');
        $w_sheet->getCell("A28")->setValue($objRichText);
        $w_sheet->getStyle("A28")
                ->getFont()
                ->setBold(true);
        $w_sheet->setCellValue('A29', '- Thời giờ làm việc: Thời gian làm việc theo quy định tại công ty.');
        $w_sheet->setCellValue('A30', '- Được cấp phát những thiết bị, dụng cụ: Cần thiết theo yêu cầu của công việc.');
        $w_sheet->setCellValue('A31', '- Được đảm bảo điều kiện an toàn và vệ sinh lao động tại nơi làm việc theo quy định hiện hành của Nhà nước.');
        $w_sheet->mergeCells("A31:J31");
        $w_sheet->getRowDimension('31')->setRowHeight(30);
        $w_sheet->getStyle("A31")->getAlignment()->setWrapText(true);


        // Điều 3
        $objRichText = new RichText();
        $objUnderlined = $objRichText->createTextRun("Điều 3:");
        $objUnderlined->getFont()->setUnderline(true);
        $objUnderlined->getFont()->setBold(true);
        $objUnderlined->getFont()->setSize(12);
        $objUnderlined->getFont()->setName("Times New Roman");
        $objRichText->createText(' Quyền lợi và nghĩa vụ của người lao động');
        $w_sheet->getCell("A32")->setValue($objRichText);
        $w_sheet->getStyle("A32")
                ->getFont()
                ->setBold(true);
        $w_sheet->setCellValue('A33', '1. Quyền lợi:');
        $w_sheet->getStyle("A33")
                ->getFont()
                ->setBold(true);
        $w_sheet->setCellValue('A34', '- Phương tiện đi lại làm việc: tự túc.');
        $w_sheet->setCellValue('A35', '- Mức lương:');
        $w_sheet->setCellValue('C35', number_format(4500000, 0, '.', ',') . ' đồng/tháng');
        $w_sheet->getStyle("C35")
                ->getFont()
                ->setBold(true);
        $w_sheet->setCellValue('A36', 'Bằng chữ:');

        $w_sheet->setCellValue('A37', '- Hình thức trả lương: Tiền mặt hoặc chuyển khoản qua Ngân hàng 01 lần trước ngày 10 của  tháng kế tiếp.');
        $w_sheet->mergeCells("A37:J37");
        $w_sheet->getRowDimension('37')->setRowHeight(30);
        $w_sheet->getStyle("A37")->getAlignment()->setWrapText(true);

        $w_sheet->setCellValue('A38', '- Được trang bị bảo hộ lao động: Theo quy định của Công ty.');

        $w_sheet->setCellValue('A39', '- Tiền thưởng: Tùy thuộc vào kết quả kinh doanh của Công ty và theo sự đánh giá kết quả làm việc của Tổng Giám đốc Công ty.');
        $w_sheet->mergeCells("A39:J39");
        $w_sheet->getRowDimension('39')->setRowHeight(30);
        $w_sheet->getStyle("A39")->getAlignment()->setWrapText(true);

        $w_sheet->setCellValue('A40', '- Chế độ nghỉ ngơi, nghỉ phép, lễ Tết...: Được nghỉ hàng tuần vào ngày Chủ Nhật, các ngày lễ Tết theo sự quy định của Nhà nước và theo quy định của Công ty.');
        $w_sheet->mergeCells("A40:J40");
        $w_sheet->getRowDimension('40')->setRowHeight(30);
        $w_sheet->getStyle("A40")->getAlignment()->setWrapText(true);

        $w_sheet->setCellValue('A41', '- Những thoả thuận khác: Phải được sự đồng ý của hai bên.');

        $w_sheet->setCellValue('A42', '2. Nghĩa vụ:');
        $w_sheet->getStyle("A42")
                ->getFont()
                ->setBold(true);

        $w_sheet->setCellValue('A43', '- Hoàn thành những nội dung công việc đã cam kết trong Hợp đồng.');
        $w_sheet->setCellValue('A44', '- Chấp hành nội quy, kỷ luật lao động, quy định của Công ty....');

        $w_sheet->setCellValue('A45', '- Nêu cao tinh thần tự giác trong công việc, cộng đồng doanh nghiệp và các mối quan hệ nơi đang làm việc.');
        $w_sheet->mergeCells("A45:J45");
        $w_sheet->getRowDimension('45')->setRowHeight(30);
        $w_sheet->getStyle("A45")->getAlignment()->setWrapText(true);

        $w_sheet->setCellValue('A46', '- Có trách nhiệm bảo vệ tài sản, vật chất trong Công ty.');
        $w_sheet->setCellValue('A47', '- Tuyệt đối không sử dụng khách hàng của công ty để trục lợi cá nhân.');

        $w_sheet->setCellValue('A48', '- Trường hợp nhân viên được cử đi học các khóa đào tạo nâng cao nghiệp vụ: Phải cam kết sau khóa học sẽ phục vụ cho Công ty, nếu nhân viên nghỉ việc trước thời gian quy định của Công ty thì phải hoàn trả 100% số tiền học phí mà công ty đã chi trả cho việc đào tạo nhân viên đó.');
        $w_sheet->mergeCells("A48:J48");
        $w_sheet->getRowDimension('48')->setRowHeight(45);
        $w_sheet->getStyle("A48")->getAlignment()->setWrapText(true);

        $w_sheet->setCellValue('A49', '- Trong thời gian còn hiệu lực hợp đồng và sau khi nghỉ việc tại Công ty nhân viên không được phép tiết lộ, cung cấp thông tin của Công ty cho bất kỳ tổ chức bên ngoài nào khi chưa được sự đồng ý từ phía Công ty.');
        $w_sheet->mergeCells("A49:J49");
        $w_sheet->getRowDimension('49')->setRowHeight(45);
        $w_sheet->getStyle("A49")->getAlignment()->setWrapText(true);

        $w_sheet->setCellValue('A50', '- Trong thời gian còn hiệu lực hợp đồng, nếu nghỉ việc nhân viên phải có trách nhiệm thông báo cho Công ty.');
        $w_sheet->getRowDimension('50')->setRowHeight(30);
        $w_sheet->getStyle("A50")->getAlignment()->setWrapText(true);
        $w_sheet->mergeCells("A50:J50");

        // Điều 4
        $objRichText = new RichText();
        $objUnderlined = $objRichText->createTextRun("Điều 4:");
        $objUnderlined->getFont()->setUnderline(true);
        $objUnderlined->getFont()->setBold(true);
        $objUnderlined->getFont()->setSize(12);
        $objUnderlined->getFont()->setName("Times New Roman");
        $objRichText->createText(' Nghĩa vụ và quyền hạn của người sử dụng lao động');
        $w_sheet->getCell("A51")->setValue($objRichText);
        $w_sheet->getStyle("A51")
                ->getFont()
                ->setBold(true);

        $w_sheet->setCellValue('A52', '1. Nghĩa vụ:');
        $w_sheet->getStyle("A52")
                ->getFont()
                ->setBold(true);

        $w_sheet->setCellValue('A53', '- Bảo đảm điều kiện làm việc và thực hiện đầy đủ những điều khoản trong hợp đồng.');
        $w_sheet->setCellValue('A54', '- Thanh toán đầy đủ, đúng thời hạn các chế độ và quyền lợi cho người lao động theo hợp đồng.');

        $w_sheet->setCellValue('A55', '2. Quyền hạn:');
        $w_sheet->getStyle("A55")
                ->getFont()
                ->setBold(true);

        $w_sheet->mergeCells("A56:J56");
        $w_sheet->getRowDimension('56')->setRowHeight(30);
        $w_sheet->getStyle("A56")->getAlignment()->setWrapText(true);
        $w_sheet->setCellValue('A56', '- Quản lý và điều hành người lao động hoàn thành công việc theo Hợp đồng (bố trí, điều chuyển, tạm ngừng việc).');

        $w_sheet->mergeCells("A57:J57");
        $w_sheet->getRowDimension('57')->setRowHeight(30);
        $w_sheet->getStyle("A57")->getAlignment()->setWrapText(true);
        $w_sheet->setCellValue('A57', '- Tạm hoãn, chấm dứt hợp đồng lao động mà không phải báo trước khi người lao động thử việc không đạt yêu cầu.');

        $w_sheet->setCellValue('A58', '- Các quyền và nghĩa vụ khác theo quy định của pháp luật.');

        // Điều 5
        $objRichText = new RichText();
        $objUnderlined = $objRichText->createTextRun("Điều 5:");
        $objUnderlined->getFont()->setUnderline(true);
        $objUnderlined->getFont()->setBold(true);
        $objUnderlined->getFont()->setSize(12);
        $objUnderlined->getFont()->setName("Times New Roman");
        $objRichText->createText(' Điều khoản thi hành');
        $w_sheet->getCell("A59")->setValue($objRichText);
        $w_sheet->getStyle("A59")
                ->getFont()
                ->setBold(true);

        $w_sheet->mergeCells("A60:J60");
        $w_sheet->getRowDimension('60')->setRowHeight(30);
        $w_sheet->getStyle("A60")->getAlignment()->setWrapText(true);
        $w_sheet->setCellValue('A60', '- Những vấn đề về lao động không ghi trong hợp đồng này thì áp dụng theo quy định của pháp luật về lao động.');

        $w_sheet->setCellValue('A61', '- Hợp đồng này được lập thành 02 bản có giá trị như nhau, mỗi bên giữ 01 bản và có hiệu lực kể từ ngày ký.');
        $w_sheet->mergeCells("A61:J61");
        $w_sheet->getRowDimension('61')->setRowHeight(30);
        $w_sheet->getStyle("A61")->getAlignment()->setWrapText(true);

        $w_sheet->mergeCells("A62:J62");
        $w_sheet->setCellValue('A62', '- Khi hai bên ký kết phụ lục hợp đồng thì nội dung của phụ lục hợp đồng cũng có giá trị như các nội dung của bản hợp đồng này.');
        $w_sheet->getRowDimension('62')->setRowHeight(30);
        $w_sheet->getStyle("A62")->getAlignment()->setWrapText(true);
        $w_sheet->mergeCells("A62:J62");

        $w_sheet->getStyle("A64")
                ->getFont()
                ->setBold(true);
        $w_sheet->mergeCells("A64:E64");
        $w_sheet->setCellValue('A64', 'Đại diện bên B');        $w_sheet->getStyle("A64")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        $w_sheet->getStyle("F64")
                ->getFont()
                ->setBold(true);
        $w_sheet->mergeCells("F64:J64");
        $w_sheet->setCellValue('F64', 'Đại diện bên A');$w_sheet->getStyle("F64")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $w_sheet->getStyle("A69")
                ->getFont()
                ->setBold(true);
        $w_sheet->mergeCells("A69:E69");
        $w_sheet->setCellValue('A69', $employee->name);
        $w_sheet->getStyle("A69")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $w_sheet->getStyle("F69")
                ->getFont()
                ->setBold(true);
        $w_sheet->mergeCells("F69:J69");
        $w_sheet->setCellValue('F69', 'Tạ Văn Toại');
        $w_sheet->getStyle("F69")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        //Save to file
        $writer = new Xlsx($spreadsheet);
        $file_name = 'HĐTV-' . $employee->code . '-' . $employee->name . '.xlsx';
        $writer->save($file_name);

        Alert::toast('Tải file thành công!!', 'success', 'top-right');
        return response()->download($file_name)->deleteFileAfterSend(true);

    }
}
