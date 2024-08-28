@section('title')
{{ 'Xác nhận tăng BHXH' }}
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
            <h1 class="m-0">Xác nhận tăng BHXH</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.reports.candidateIncDecBhxh') }}">Tất cả dự kiến tăng BHXH</a></li>
              <li class="breadcrumb-item active">Xác nhận</li>
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
                    <form class="form-horizontal" method="post" action="{{ route('admin.increase_insurances.confirm', $increase_insurance->id) }}" name="confirm" id="confirm" novalidate="novalidate">
                        {{ csrf_field() }}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                  <label class="required-field">Chọn tháng tăng</label>
                                  <div class="input-group date" id="confirmed_month" data-target-input="nearest">
                                      <input type="text" name="confirmed_month" class="form-control datetimepicker-input" value="{{date('m/Y', strtotime($increase_insurance->employee_work->start_date))}}" data-target="#confirmed_month"/>
                                      <div class="input-group-append" data-target="#confirmed_month" data-toggle="datetimepicker">
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
        $('#confirmed_month').datetimepicker({
            format: 'MM/YYYY'
        });
    })
</script>
@endpush
