@section('title')
{{ 'Kết thúc QT công tác' }}
@endsection

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Summernote -->
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
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
            <h1 class="m-0">Kết thúc QT công tác</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.hr.workings.index') }}">Tất cả QT công tác</a></li>
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
                    <form class="form-horizontal" method="post" action="{{ route('admin.hr.workings.off', $employee_work->id) }}" name="off_working" id="off_working" novalidate="novalidate">
                        {{ csrf_field() }}
                        <!-- /.card-header -->
                        <div class="card-body">
                            @php
                                $employee_contract = App\Models\EmployeeContract::where('employee_id', $employee_work->employee_id)->orderBy('id', 'desc')->first();
                            @endphp
                            <div class="row">
                                <div class="col-6">
                                  <label class="required-field">Thời gian kết thúc</label>
                                  <div class="input-group date" id="e_date" data-target-input="nearest">
                                      <input type="text" name="e_date" class="form-control datetimepicker-input"
                                            @if($employee_contract->end_date)
                                                value="{{date('d/m/Y', strtotime($employee_contract->end_date))}}"
                                            @else
                                                value="{{date('d/m/Y', strtotime($employee_work->end_date))}}"
                                            @endif data-target="#e_date"
                                      />
                                      <div class="input-group-append" data-target="#e_date" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group">
                                        <div class="control-group">
                                            <label class="control-label">Phân loại nghỉ việc</label>
                                            <div class="controls">
                                                <select name="off_type_id" id="off_type_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    @foreach ($off_types as $off_type)
                                                    <option value="{{$off_type->id}}" @if($off_type->id == $employee_work->off_type_id) selected="selected" @endif>{{$off_type->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label class="control-label">Lý do nghỉ</label>
                                    <textarea id="off_reason" name="off_reason">
                                        @if ($employee_work->off_reason)
                                        {{$employee_work->off_reason}}
                                        @endif
                                    </textarea>
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
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
        theme: 'bootstrap4'
        })

        // Summernote
        $("#off_reason").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
        $('#off_reason').summernote({
            height: 90,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
            ]
        })

        //Date picker
        $('#e_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    })
</script>
@endpush
