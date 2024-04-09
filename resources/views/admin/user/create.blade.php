@section('title')
{{ 'Tạo người dùng' }}
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
            <h1 class="m-0">Tạo mới người dùng</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Tất cả người dùng</a></li>
              <li class="breadcrumb-item active">Tạo mới</li>
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
                    <form class="form-horizontal" method="post" action="{{ url('admin/users') }}" name="add_admin" id="add_admin" enctype="multipart/form-data" novalidate="novalidate">{{ csrf_field() }}
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
                                        <label class="required-field" class="control-label">Email</label>
                                        <div class="controls">
                                            <input type="email" class="form-control" name="email" id="email" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Phòng</label>
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_department">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <div class="controls">
                                            <select name="department_id[]" id="department_id[]" data-placeholder="Chọn phòng ban" class="form-control select2" multiple="multiple" style="width: 100%;">
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
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_division">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <div class="controls">
                                            <select name="division_id" id="division_id" data-placeholder="Chọn bộ phận" class="form-control select2" multiple="multiple" style="width: 100%;">
                                                @foreach($divisions as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="control-group">
                                        <label class="control-label">Ảnh</label>
                                        <div class="custom-file text-left">
                                            <input type="file" name="img_path" class="custom-file-input" id="img_path">
                                            <label class="custom-file-label" for="img_path">Chọn ảnh</label>
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

                    <form class="form-horizontal" method="post" action="{{ route('admin.departments.store') }}" name="create_department" id="create_department" novalidate="novalidate">
                        {{ csrf_field() }}
                        <div class="modal fade" id="add_department">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>Thêm phòng ban</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">Mã</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" name="code" id="code" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">Tên</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" name="name" id="name" required="">
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

                      <form class="form-horizontal" method="post" action="{{ route('admin.divisions.store') }}" name="create_division" id="create_division" novalidate="novalidate">
                        {{ csrf_field() }}
                        <div class="modal fade" id="add_division">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>Thêm bộ phận</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">Mã</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" name="code" id="code" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">Tên</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" name="name" id="name" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">Thuộc phòng</label>
                                                    <div class="controls">
                                                        <select name="department_id" id="department_id" data-placeholder="Chọn bộ phận" class="form-control select2" style="width: 100%;">
                                                            @foreach($departments as $key => $value)
                                                                <option value="{{$key}}">{{$value}}</option>
                                                            @endforeach
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
</script>
@endpush
