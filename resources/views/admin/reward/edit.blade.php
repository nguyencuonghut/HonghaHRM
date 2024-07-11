@section('title')
{{ 'Sửa khen thưởng' }}
@endsection

@push('styles')
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
            <h1 class="m-0">Sửa khen thưởng</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.hr.rewards.index') }}">Tất cả khen thưởng</a></li>
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
                    <form class="form-horizontal" method="post" action="{{ route('admin.hr.rewards.update', $employee_reward->id) }}" name="update_reward" id="update_reward" novalidate="novalidate">
                        {{ csrf_field() }}
                        @method('PATCH')
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                  <div class="control-group">
                                      <label class="required-field" class="control-label">Số</label>
                                      <input class="form-control" type="text" name="code" id="code" value="{{$employee_reward->code}}">
                                  </div>
                                </div>
                                <div class="col-6">
                                    <label class="required-field">Ngày</label>
                                    <div class="input-group date" id="sign_date" data-target-input="nearest">
                                        <input type="text" name="sign_date" class="form-control datetimepicker-input" value="{{date('d/m/Y', strtotime($employee_reward->sign_date))}}" data-target="#sign_date"/>
                                        <div class="input-group-append" data-target="#sign_date" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label class="required-field control-label">Nội dung</label>
                                    <textarea id="content" name="content">
                                        {!! $employee_reward->content!!}
                                    </textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label class="control-label">Ghi chú</label>
                                    <textarea id="note" name="note">
                                        {!! $employee_reward->note!!}
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
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script>
    $(function () {
        //Date picker
        $('#sign_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        // Summernote
        $("#content").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
        $("#note").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
        $('#content').summernote({
            height: 90,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
            ]
        })
        $('#note').summernote({
            height: 90,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
            ]
        })
    })
</script>
@endpush
