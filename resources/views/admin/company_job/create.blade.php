@section('title')
{{ 'Thêm vị trí' }}
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
            <h1 class="m-0">Thêm vị trí</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.company_jobs.index') }}">Tất cả vị trí</a></li>
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
                    <form class="form-horizontal" method="post" action="{{ url('admin/company_jobs') }}" name="add_company_jobs" id="add_company_jobs" enctype="multipart/form-data" novalidate="novalidate">{{ csrf_field() }}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Tên</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="name" id="name" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Chức vụ</label>
                                        <div class="controls">
                                            <select name="position_id" id="position_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                @foreach($positions as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
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

                            <div class="row">
                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Lương bảo hiểm</label>
                                        <div class="controls">
                                            <input type="number" class="form-control" name="insurance_salary" id="insurance_salary" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Lương vị trí</label>
                                        <div class="controls">
                                            <input type="number" class="form-control" name="position_salary" id="position_salary" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Lương năng lực max</label>
                                        <div class="controls">
                                            <input type="number" class="form-control" name="max_capacity_salary" id="max_capacity_salary" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Phụ cấp vị trí</label>
                                        <div class="controls">
                                            <input type="number" class="form-control" name="position_allowance" id="position_allowance" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Tiêu chuẩn tuyển dụng</label>
                                        <div class="custom-file text-left">
                                            <input type="file" name="recruitment_standard_file" accept="application/pdf" class="custom-file-input" id="recruitment_standard_file">
                                            <label class="custom-file-label" for="recruitment_standard_file">Chọn file</label>
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
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
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
</script>
@endpush
