@section('title')
{{ 'Kết thúc hợp đồng' }}
@endsection

@push('styles')
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
            <h1 class="m-0">Kết thúc hợp đồng</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.hr.contracts.index') }}">Tất cả hợp đồng</a></li>
              <li class="breadcrumb-item active">Kết thúc</li>
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
                    <form class="form-horizontal" method="post" action="{{ route('admin.hr.contracts.off', $employee_contract->id) }}" name="off_working" id="off_working" novalidate="novalidate">
                        {{ csrf_field() }}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                  <label class="required-field">Thời gian kết thúc</label>
                                  <div class="input-group date" id="e_date" data-target-input="nearest">
                                      <input type="text" name="e_date" class="form-control datetimepicker-input" data-target="#e_date" @if($employee_contract->end_date) value="{{date('d/m/Y', strtotime($employee_contract->end_date))}}" @endif/>
                                      <div class="input-group-append" data-target="#e_date" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <label class="required-field">Ngày viết đơn</label>
                                  <div class="input-group date" id="request_terminate_date" data-target-input="nearest">
                                      <input type="text" name="request_terminate_date" class="form-control datetimepicker-input" data-target="#request_terminate_date" @if($employee_contract->request_terminate_date) value="{{date('d/m/Y', strtotime($employee_contract->request_terminate_date))}}" @endif/>
                                      <div class="input-group-append" data-target="#request_terminate_date" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script>
    $(function () {
        //Date picker
        $('#e_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#request_terminate_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    })
</script>
@endpush
