@section('title')
{{ 'Sửa đánh giá cuối năm' }}
@endsection

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Summernote -->
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
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
              <li class="breadcrumb-item"><a href="{{ route('admin.hr.year_reviews.index') }}">Tất cả đánh giá cuối năm</a></li>
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
                    <form class="form-horizontal" method="post" action="{{ route('admin.hr.year_reviews.update', $employee_year_review->id) }}" name="update_year_review" id="update_year_review" novalidate="novalidate">
                        {{ csrf_field() }}
                        @method('PATCH')
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                  <div class="control-group">
                                      <label class="required-field" class="control-label">Năm</label>
                                      <input class="form-control" type="number" name="year" id="year" value="{{$employee_year_review->year}}">
                                  </div>
                                </div>
                                <div class="col-4">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">KPI trung bình</label>
                                        <input class="form-control" type="number" name="kpi_average" id="kpi_average" step="any" value="{{$employee_year_review->kpi_average}}">
                                    </div>
                                </div>
                                <div class="col-4">
                                  <div class="control-group">
                                        <label class="required-field" class="control-label">Kết quả</label>
                                        <div class="controls">
                                            <select name="result" id="result" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                <option value="Xuất sắc" @if('Xuất sắc' == $employee_year_review->result) selected="selected" @endif>Xuất sắc</option>
                                                <option value="Tốt" @if('Tốt' == $employee_year_review->result) selected="selected" @endif>Tốt</option>
                                                <option value="Đạt" @if('Đạt' == $employee_year_review->result) selected="selected" @endif>Đạt</option>
                                                <option value="Cải thiện" @if('Cải thiện' == $employee_year_review->result) selected="selected" @endif>Cải thiện</option>
                                            </select>
                                        </div>
                                  </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label class="control-label">Chi tiết</label>
                                    <textarea id="detail" name="detail">
                                        {!! $employee_year_review->detail !!}
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
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
        theme: 'bootstrap4'
        })
    })

    // Summernote
    $("#detail").on("summernote.enter", function(we, e) {
        $(this).summernote("pasteHTML", "<br><br>");
        e.preventDefault();
    });
    $('#detail').summernote({
        height: 90,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
        ]
    })
</script>
@endpush
