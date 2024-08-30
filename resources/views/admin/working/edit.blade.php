@section('title')
{{ 'Sửa QT công tác' }}
@endsection

@push('styles')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endpush

@extends('layouts.base')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sửa QT công tác</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.hr.workings.index') }}">Tất cả QT công tác</a></li>
              <li class="breadcrumb-item active">Sửa</li>
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
                <div class="col-12">
                    <div class="card">
                    <form class="form-horizontal" method="post" action="{{ route('admin.hr.workings.update', $employee_work->id) }}" name="update_working" id="update_working" novalidate="novalidate">
                        {{ csrf_field() }}
                        @method('PATCH')
                        <!-- /.card-header -->
                        <div class="card-body">
                            @php
                                $employee_contract = App\Models\EmployeeContract::where('employee_id', $employee_work->employee_id)->orderBy('id', 'desc')->first();
                            @endphp
                            <div class="row">
                                <div class="col-6">
                                    <div class="control-group">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Vị trí</label>
                                            <div class="controls">
                                                <select name="company_job_id" id="company_job_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    @foreach ($company_jobs as $company_job)
                                                        <option value="{{$company_job->id}}" @if ($company_job->id == $employee_contract->company_job_id) selected="selected" @endif>{{$company_job->name}} {{$company_job->division_id ? (' - ' . $company_job->division->name) : ''}} {{$company_job->department_id ? ( ' - ' . $company_job->department->name) : ''}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $employee_contracts = App\Models\EmployeeContract::where('employee_id', $employee_work->employee_id)->orderBy('id', 'desc')->get();
                                @endphp
                                <div class="col-6">
                                    <div class="control-group">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Mã hợp đồng</label>
                                            <div class="controls">
                                                <select name="contract_code" id="contract_code" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    @foreach ($employee_contracts as $employee_contract)
                                                        <option value="{{$employee_contract->code}}" @if ($employee_contract->code == $employee_work->contract_code) selected="selected" @endif>{{$employee_contract->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-6">
                                  <label class="required-field">Thời gian bắt đầu</label>
                                  <div class="input-group date" id="s_date" data-target-input="nearest">
                                      <input type="text" name="s_date" class="form-control datetimepicker-input" value="{{date('d/m/Y', strtotime($employee_contract->start_date))}}" data-target="#s_date"/>
                                      <div class="input-group-append" data-target="#s_date" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-6">
                                <div class="control-group">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Phân loại tạo</label>
                                        <div class="controls">
                                            <select name="on_type_id" id="on_type_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                @foreach ($on_types as $on_type)
                                                    <option value="{{$on_type->id}}" @if($on_type->id == $employee_work->on_type_id) selected="selected" @endif>{{$on_type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>

                            <br>
                            <div class="control-group">
                                <div class="controls">
                                    <input type="submit" value="Lưu" class="btn btn-success">
                                </div>
                            </div>
                        <div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


@push('scripts')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
        theme: 'bootstrap4'
        })

        //Date picker
        $('#s_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    })
</script>
@endpush
