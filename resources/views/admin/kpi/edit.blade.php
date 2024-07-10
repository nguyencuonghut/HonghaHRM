@section('title')
{{ 'Sửa KPI' }}
@endsection

@push('styles')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@extends('layouts.base')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sửa KPI</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.hr.contracts.index') }}">Tất cả KPI</a></li>
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
                    <form class="form-horizontal" method="post" action="{{ route('admin.hr.kpis.update', $employee_kpi->id) }}" name="update_kpi" id="update_kpi" novalidate="novalidate">
                        {{ csrf_field() }}
                        @method('PATCH')
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                  <div class="control-group">
                                      <label class="required-field" class="control-label">Năm</label>
                                      <input class="form-control" type="number" name="year" id="year" value="{{$employee_kpi->year}}">
                                  </div>
                                </div>
                                <div class="col-4">
                                    <div class="control-group">
                                          <label class="required-field" class="control-label">Tháng</label>
                                          <div class="controls">
                                              <select name="month" id="month" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                  <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                  <option value="Tháng 1" @if("Tháng 1" == $employee_kpi->month) selected="selected" @endif>Tháng 1</option>
                                                  <option value="Tháng 2" @if("Tháng 2" == $employee_kpi->month) selected="selected" @endif>Tháng 2</option>
                                                  <option value="Tháng 3" @if("Tháng 3" == $employee_kpi->month) selected="selected" @endif>Tháng 3</option>
                                                  <option value="Tháng 4" @if("Tháng 4" == $employee_kpi->month) selected="selected" @endif>Tháng 4</option>
                                                  <option value="Tháng 5" @if("Tháng 5" == $employee_kpi->month) selected="selected" @endif>Tháng 5</option>
                                                  <option value="Tháng 6" @if("Tháng 6" == $employee_kpi->month) selected="selected" @endif>Tháng 6</option>
                                                  <option value="Tháng 7" @if("Tháng 7" == $employee_kpi->month) selected="selected" @endif>Tháng 7</option>
                                                  <option value="Tháng 8" @if("Tháng 8" == $employee_kpi->month) selected="selected" @endif>Tháng 8</option>
                                                  <option value="Tháng 9" @if("Tháng 9" == $employee_kpi->month) selected="selected" @endif>Tháng 9</option>
                                                  <option value="Tháng 10" @if("Tháng 10" == $employee_kpi->month) selected="selected" @endif>Tháng 10</option>
                                                  <option value="Tháng 11" @if("Tháng 11" == $employee_kpi->month) selected="selected" @endif>Tháng 11</option>
                                                  <option value="Tháng 12" @if("Tháng 12" == $employee_kpi->month) selected="selected" @endif>Tháng 12</option>
                                              </select>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                  <div class="control-group">
                                      <label class="required-field" class="control-label">Điểm</label>
                                      <input class="form-control" type="number" name="score" id="score" value="{{$employee_kpi->score}}">
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

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
        theme: 'bootstrap4'
        })
    })
</script>
@endpush
