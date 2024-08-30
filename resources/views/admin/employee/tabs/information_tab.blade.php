<!-- Information Tab -->
<div class="active tab-pane" id="tab-information">
    <div class="post">
        <div class="user-block">
          <img class="img-circle img-bordered-sm" src="{{asset($employee->img_path)}}" alt="user image">
          <span class="username">
            <a href="#">{{$employee->code}} - {{$employee->name}}</a>
          </span>
          @php
            $employee_works = App\Models\EmployeeWork::where('employee_id', $employee->id)->where('status', 'On')->get();
            $employee_work_str = '';
            $i = 0;
            $length = count($employee_works);
            // Trường hợp nhân sự đang có QT công tác ở trạng thái On
            if ($length) {
                foreach ($employee_works as $employee_work) {
                    $company_job = App\Models\CompanyJob::findOrFail($employee_work->company_job_id);
                    if(++$i === $length) {
                        $employee_work_str .= $company_job->name . ' - ' . $company_job->department->name;
                    } else {
                        $employee_work_str .= $company_job->name . ' - ' . $company_job->department->name . ' | ';
                    }
                }
            }
            // Trường hợp nhân sự đang không có QT công tác ở trạng thái On
            else {
                // Trường hợp đã có QT công tác, nhưng ở trạng thái Off
                $off_employee_works = App\Models\EmployeeWork::where('employee_id', $employee->id)->where('status', 'Off')->get();
                $latest_employee_work = App\Models\EmployeeWork::where('employee_id', $employee->id)->where('status', 'Off')->orderBy('id', 'desc')->first();
                if ($off_employee_works->count()) {
                    if ($latest_employee_work->off_type) {
                        $employee_work_str .= $latest_employee_work->company_job->name . ' - ' . $latest_employee_work->off_type->name;
                    } else {
                        $employee_work_str .= $latest_employee_work->company_job->name;
                    }
                } else {
                    $employee_work_str .= '!! Chưa tạo QT công tác !!';
                }
            }
          @endphp
          <span class="description">{{$employee_work_str}}</span>
        </div>
        <!-- /.user-block -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Điện thoại</strong><br>
                    - Cá nhân: {{$employee->phone}}<br>
                    - Người thân: {{$employee->relative_phone}}<br>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Email</strong><br>
                    @if ($employee->private_email)
                    {{$employee->private_email}}<br>
                    @endif
                    @if ($employee->company_email)
                    {{$employee->company_email}}<br>
                    @endif
                </address>
            </div>
            <!-- /.col -->
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Ngày sinh</strong><br>
                    {{date('d/m/Y', strtotime($employee->date_of_birth))}}
                </address>
            </div>
        </div>
        <hr>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>CCCD</strong><br>
                    - Số: {{$employee->cccd}}<br>
                    - Ngày cấp: {{date('d/m/Y', strtotime($employee->issued_date))}}<br>
                    - Cấp bởi: {{$employee->issued_by}}<br>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Địa chỉ</strong><br>
                    @if ($employee->temporary_address)
                    - Thường trú: {{$employee->address}}, {{$employee->commune->name}}, {{$employee->commune->district->name}}, {{$employee->commune->district->province->name}} <br>
                    - Tạm trú: {{$employee->temporary_address}}, {{$employee->temporary_commune->name}}, {{$employee->temporary_commune->district->name}}, {{$employee->temporary_commune->district->province->name}} <br>
                    @else
                    {{$employee->address}}, {{$employee->commune->name}}, {{$employee->commune->district->name}}, {{$employee->commune->district->province->name}} <br>
                    @endif
                </address>
            </div>
            <!-- /.col -->
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Học vấn</strong><br>
                    @php
                        $schools_info = '';

                        foreach ($employee->schools as $school) {
                            $employee_school = App\Models\EmployeeSchool::where('employee_id', $employee->id)->where('school_id', $school->id)->first();
                            $degree = App\Models\Degree::findOrFail($employee_school->degree_id);
                            if ($employee_school->major) {
                                $schools_info = $schools_info . $school->name . ' - ' . $degree->name . ' - ' . $employee_school->major . '<br>';
                            } else {
                                $schools_info = $schools_info . $school->name;
                            }

                        }
                    @endphp
                    {!! $schools_info !!}
                </address>
            </div>
        </div>
        <hr>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Giới tính</strong><br>
                    {{$employee->gender}}<br>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Số BHXH</strong><br>
                    {{$employee->bhxh}}<br>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Tình trạng hôn nhân</strong><br>
                    {{$employee->marriage_status}}<br>
                </address>
            </div>
        </div>
        <hr>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Ngày vào</strong><br>
                    {{date('d/m/Y', strtotime($employee->join_date))}}<br>
                </address>
            </div>
            <!-- /.col -->
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Kinh nghiệm</strong><br>
                    {!! $employee->experience !!}
                </address>
            </div>
        </div>
        <hr>
    </div>
</div>




