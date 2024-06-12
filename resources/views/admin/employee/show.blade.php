@section('title')
{{ 'Chi tiết nhân sự' }}
@endsection

@extends('layouts.base')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Hồ sơ {{$employee->name}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.employees.index') }}">Tất cả nhân sự</a></li>
              <li class="breadcrumb-item active">Chi tiết</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-4">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                    src="{{asset($employee->img_path)}}"
                                    alt="User profile picture">
                            </div>

                        <h3 class="profile-username text-center">{{$employee->name}}</h3>
                        <p class="text-muted text-center">
                            {{$employee->company_job->name}}
                            @if ($employee->company_job->division_id)
                            <br>{{$employee->company_job->division->name}}
                            @endif
                            - {{$employee->company_job->department->name}}
                        </p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Chi tiết</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <strong><i class="fas fa-mobile-alt mr-1"></i> Điện thoại</strong>
                      <p class="text-muted">
                        - Cá nhân: {{$employee->phone}} <br>
                        @if($employee->relative_phone)
                        - Người thân: {{$employee->relative_phone}}
                        @endif
                      </p>
                      <hr>

                      <strong><i class="fas fa-calendar-alt mr-1"></i> Ngày sinh</strong>
                      <p class="text-muted">
                        {{date('d/m/Y', strtotime($employee->date_of_birth))}}
                      </p>
                      <hr>

                      @if ($employee->cccd)
                      <strong><i class="fas fa-id-card mr-1"></i> CCCD</strong>
                      <p class="text-muted">
                        - Số: {{$employee->cccd}} <br>
                        - Cấp bởi: {{$employee->issued_by}}
                      </p>
                      <hr>
                      @endif

                      <strong><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ</strong>
                      <p class="text-muted">
                        - Thường trú: {{$employee->address}}, {{$employee->commune->name}}, {{$employee->commune->district->name}}, {{$employee->commune->district->province->name}}
                        @if ($employee->temporary_address)
                        <br>- Tạm trú: {{$employee->temporary_address}}, {{$employee->temporary_commune->name}}, {{$employee->temporary_commune->district->name}}, {{$employee->temporary_commune->district->province->name}}
                        @endif
                      </p>
                      <hr>

                      <strong><i class="fas fa-graduation-cap mr-1"></i> Trình độ</strong>
                      <p class="text-muted">
                        @php
                            $schools_info = '';

                            foreach ($employee->schools as $school) {
                                $employee_school = App\Models\EmployeeSchool::where('employee_id', $employee->id)->where('school_id', $school->id)->first();
                                if ($employee_school->major) {
                                    $schools_info = $schools_info . $school->name . ' - ' . $employee_school->major . '<br>';
                                } else {
                                    $schools_info = $schools_info . $school->name;
                                }

                            }
                        @endphp
                        {!! $schools_info !!}
                      </p>

                      <strong><i class="fas fa-suitcase mr-1"></i> Kinh nghiệm</strong>
                      <p class="text-muted">
                        {!! preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $employee->experience) !!}
                      </p>
                      <hr>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header p-2">
                      <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#tab-document" data-toggle="tab">Giấy tờ cần ký</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab-family" data-toggle="tab">Gia đình</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab-contract" data-toggle="tab">Hợp đồng</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab-working" data-toggle="tab">Công tác</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab-productivity" data-toggle="tab">Hiệu suất</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab-training" data-toggle="tab">Đào tạo</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab-insurance" data-toggle="tab">Bảo hiểm</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab-salary" data-toggle="tab">Lương</a></li>
                      </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                      <div class="tab-content">
                        @include('admin.employee.tabs.document_tab')
                        @include('admin.employee.tabs.family_tab')
                        @include('admin.employee.tabs.contract_tab')
                        @include('admin.employee.tabs.working_tab')
                        @include('admin.employee.tabs.productivity_tab')
                        @include('admin.employee.tabs.training_tab')
                        @include('admin.employee.tabs.insurance_tab')
                        @include('admin.employee.tabs.salary_tab')
                      </div>
                      <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                  </div>
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection



