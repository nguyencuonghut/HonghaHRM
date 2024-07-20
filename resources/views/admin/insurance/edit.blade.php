@section('title')
{{ 'Sửa bảo hiểm' }}
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
            <h1 class="m-0">Sửa bảo hiểm</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.hr.insurances.index') }}">Tất cả bảo hiểm</a></li>
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
                    <form class="form-horizontal" method="post" action="{{ route('admin.hr.insurances.update', $employee_insurance->id) }}" name="update_insurance" id="update_insurance" novalidate="novalidate">
                        {{ csrf_field() }}
                        @method('PATCH')
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="control-group">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Loại bảo hiểm</label>
                                            <div class="controls">
                                                <select name="insurance_id" id="insurance_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    @foreach ($insurances as $insurance)
                                                        <option value="{{$insurance->id}}" @if($insurance->id == $employee_insurance->insurance_id) selected="selected" @endif>{{$insurance->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Tỷ lệ đóng (%)</label>
                                        <input class="form-control" type="number" name="pay_rate" id="pay_rate" step="any" value="{{$employee_insurance->pay_rate}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                  <label class="required-field">Thời gian bắt đầu</label>
                                  <div class="input-group date" id="insurance_s_date" data-target-input="nearest">
                                      <input type="text" name="insurance_s_date" class="form-control datetimepicker-input" value="{{date('d/m/Y', strtotime($employee_insurance->start_date))}}" data-target="#insurance_s_date"/>
                                      <div class="input-group-append" data-target="#insurance_s_date" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <label class="required-field">Thời gian kết thúc</label>
                                  <div class="input-group date" id="insurance_e_date" data-target-input="nearest">
                                      <input type="text" name="insurance_e_date" class="form-control datetimepicker-input"value="{{date('d/m/Y', strtotime($employee_insurance->end_date))}}" data-target="#insurance_e_date"/>
                                      <div class="input-group-append" data-target="#insurance_e_date" data-toggle="datetimepicker">
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
        $('#insurance_s_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#insurance_e_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    })
</script>
@endpush
