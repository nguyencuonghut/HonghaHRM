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
                <div class="col-12 col-sm-12">
                    <div class="card card-secondary card-outline card-tabs">
                      <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" href="#tab-information" data-toggle="tab">Thông tin</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-document" data-toggle="tab">Hồ sơ</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-probation" data-toggle="tab">Thử việc</a></li>
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
                          @include('admin.employee.tabs.information_tab')
                          @include('admin.employee.tabs.document_tab')
                          @include('admin.employee.tabs.probation_tab')
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
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
@endsection



