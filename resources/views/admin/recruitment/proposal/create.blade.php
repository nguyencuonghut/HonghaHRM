@section('title')
{{ 'Thêm đề xuất' }}
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
            <h1 class="m-0">Thêm đề xuất</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.recruitment.proposals.index') }}">Tất cả đề xuất</a></li>
              <li class="breadcrumb-item active">Thêm</li>
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
                    <form class="form-horizontal" method="post" action="{{ url('admin/recruitment/proposals') }}" name="add_proposal" id="add_proposal" novalidate="novalidate">{{ csrf_field() }}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Vị trí</label>
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_job">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <div class="controls">
                                            <select name="job_id" id="job_id" data-placeholder="Chọn vị trí" class="form-control select2" style="width: 100%;">
                                                <option value="-- Chọn vị trí --" disabled="disabled" selected="selected">-- Chọn vị trí --</option>
                                                @foreach($jobs as $job)
                                                    <option value="{{$job->id}}">{{$job->name}} - {{$job->division_id ? $job->division->name : ''}} {{$job->department_id ? $job->department->name : ''}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Số lượng</label>
                                        <div class="controls">
                                            <input type="number" class="form-control" name="quantity" id="quantity" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Lý do</label>
                                        <div class="controls">
                                            <textarea id="reason" name="reason">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Yêu cầu</label>
                                        <div class="controls">
                                            <textarea id="requirement" name="requirement">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Mức lương (VNĐ)</label>
                                        <div class="controls">
                                            <input type="number" class="form-control" name="salary" id="salary" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label class="required-field">Thời gian cần</label>
                                    <div class="input-group date" id="work_time" data-target-input="nearest">
                                        <input type="text" name="work_time" class="form-control datetimepicker-input" data-target="#work_time"/>
                                        <div class="input-group-append" data-target="#work_time" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="control-group">
                                        <label class="control-label">Ghi chú</label>
                                        <div class="controls">
                                            <textarea id="note" name="note">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="control-group">
                                <div class="controls">
                                    <input type="submit" value="Thêm" class="btn btn-success">
                                </div>
                            </div>
                        <div>
                    </form>

                    <form class="form-horizontal" method="post" action="{{ route('admin.jobs.store') }}" name="create_job" id="create_job" novalidate="novalidate">
                        {{ csrf_field() }}
                        <div class="modal fade" id="add_job">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>Thêm vị trí</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">Tên</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" name="name" id="name" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">Phòng ban</label>
                                                    <div class="controls">
                                                        <select name="sel_department" id="sel_department" data-placeholder="Chọn phòng ban" class="form-control select2" style="width: 100%;">
                                                            <option value="-- Chọn phòng ban --" disabled="disabled" selected="selected">-- Chọn phòng ban --</option>
                                                            @foreach($departments as $key => $value)
                                                                <option value="{{$key}}">{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="control-group">
                                                    <label class="control-label">Bộ phận</label>
                                                    <div class="controls">
                                                        <select name="sel_division" id="sel_division" data-placeholder="Chọn bộ phận" class="form-control select2" style="width: 100%;">

                                                            <option value='0'>-- Select division --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                        </div>
                      </form>
                      <!-- /.modal -->
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
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
        theme: 'bootstrap4'
        })

        $('#reason').summernote({
            height: 80,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
            ]
        })
        $('#note').summernote({
            height: 80,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
            ]
        })

        $('#requirement').summernote({
            height: 80,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
            ]
        })

        //Remove <p> tag by <br> when enter new line
        $("#reason").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
        $("#requirement").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
        $("#note").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });

        //Date picker
        $('#work_time').datetimepicker({
            format: 'DD/MM/YYYY'
        });


        $("#sel_department").on("change", function() {
            // Department id
            var id = $(this).val();

            // Empty the dropdown
            $('#sel_division').find('option').not(':first').remove();

            console.log(id);
            var url = "{{ route('admin.departments.getDivision', ":id") }}";
            url = url.replace(':id', id);
            // AJAX request
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(response){
                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        // Read data and create <option >
                        for(var i=0; i<len; i++){
                            var id = response['data'][i].id;
                            var name = response['data'][i].name;
                            var option = "<option value='"+id+"'>"+name+"</option>";
                            $("#sel_division").append(option);
                        }
                    }
                }
            });
        });
    });
</script>
@endpush
