@section('title')
{{ 'Thêm nhân sự' }}
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Thêm nhân sự</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.employees.index') }}">Tất cả nhân sự</a></li>
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
                        <form class="form-horizontal" method="post" action="{{ route('admin.employees.store_from_candidate') }}" enctype="multipart/form-data" name="create_employee" id="create_employee" novalidate="novalidate">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Mã</label>
                                            <div class="controls">
                                                <input type="number" class="form-control" name="code" id="name" required="" value="{{$candidate->code}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Họ tên</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="name" id="name" required="" readonly value="{{$candidate->name}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="control-group">
                                            <label class="control-label">Email cá nhân</label>
                                            <div class="controls">
                                                <input type="email" class="form-control" name="private_email" id="private_email" required="" readonly  value="{{$candidate->email}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="control-group">
                                            <label class="control-label">Email công ty</label>
                                            <div class="controls">
                                                <input type="email" class="form-control" name="company_email" id="company_email" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Số điện thoại</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="phone" id="phone" required="" readonly  value="{{$candidate->phone}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="control-group">
                                            <label class="required-field control-label">Số điện thoại người thân</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="relative_phone" id="relative_phone" required="" value="{{$candidate->relative_phone}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label class="required-field">Ngày sinh</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" required="" readonly value="{{date('d/m/Y', strtotime($candidate->date_of_birth))}}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="control-group">
                                            <label class="required-field control-label">CCCD</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="cccd" id="cccd" required="" value="{{$candidate->cccd}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="required-field control-label">Ngày cấp</label>
                                        <div class="input-group date" id="issued_date" data-target-input="nearest">
                                            <input type="text" name="issued_date" class="form-control datetimepicker-input" data-target="#issued_date" @if ($candidate->issued_date) value="{{date('d/m/Y', strtotime($candidate->issued_date))}}" @endif/>
                                            <div class="input-group-append" data-target="#issued_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field control-label">Nơi cấp</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="issued_by" id="issued_by" required="" value="{{$candidate->issued_by}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Giới tính</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="gender" id="gender" required="" readonly value="{{$candidate->gender}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Số nhà thường trú</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="address" id="address" required="" readonly value="{{$candidate->address}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Địa chỉ thường trú</label>
                                            <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_commune">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <div class="controls">
                                                <input type="hidden" name="commune_id" id="commune_id" value="{{$candidate->commune_id}}">
                                                <input type="text" class="form-control" required="" readonly value="{{$candidate->commune->name}} - {{$candidate->commune->district->name}} - {{$candidate->commune->district->province->name}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="control-label">Số nhà tạm trú</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="temp_address" id="temp_address" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="control-label">Địa chỉ tạm trú</label>
                                            <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_commune">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <div class="controls">
                                                <select name="temp_commune_id" id="temp_commune_id" data-placeholder="Chọn địa chỉ" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    @foreach($communes as $commune)
                                                    <option value="{{$commune->id}}">{{$commune->name}} - {{$commune->district->name}} - {{$commune->district->province->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Vị trí</label>
                                            <div class="controls">
                                                <input type="hidden" name="company_job_id" id="company_job_id" value="{{$proposal->company_job_id}}">
                                                <input type="text" class="form-control" required="" readonly value="{{$proposal->company_job->name}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-group">
                                            <label class="control-label">Ảnh</label>
                                            <div class="custom-file text-left">
                                                <input type="file" name="img_path" accept="image/*" class="custom-file-input" id="img_path">
                                                <label class="custom-file-label" for="img_path">Chọn file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label class="required-field" class="control-label">Học vấn</label>
                                        <table class="table table-bordered" id="dynamicTable">
                                            <tr>
                                                <th class="required-field">
                                                    Trường
                                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#make_school">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </th>
                                                <th>Trình độ</th>
                                                <th>Ngành</th>
                                            </tr>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($candidate->schools as $school)
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="addmore[{{$i}}][school_name]" required="" readonly value="{{$school->name}}">
                                                </td>
                                                @php
                                                    $my_candidate_school = App\Models\CandidateSchool::where('school_id', $school->id)->where('candidate_id', $candidate->id)->first();
                                                    $degree = App\Models\Degree::findOrFail($my_candidate_school->degree_id);
                                                @endphp
                                                <td>
                                                    <input type="text" class="form-control" name="addmore[{{$i}}][degree_name]" required="" readonly value="{{$degree->name}}">
                                                </td>
                                                <td><input type="text" name="addmore[{{$i}}][major]" placeholder="Ngành" class="form-control" readonly value="{{$my_candidate_school->major}}"/></td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label class="required-field" class="control-label">Kinh nghiệm</label>
                                        <textarea readonly id="experience" name="experience">
                                            {{$candidate->experience}}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <input type="submit" value="Thêm" class="btn btn-success">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Modals for create commune -->
                        <form class="form-horizontal" method="post" action="{{ route('admin.communes.store') }}" name="create_commune" id="create_commune" novalidate="novalidate">
                            {{ csrf_field() }}
                            <div class="modal fade" id="add_commune">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Thêm xã/phường</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="control-group">
                                                        <label class="required-field" class="control-label">Tên xã/phường</label>
                                                        <div class="controls">
                                                            <input type="text" class="form-control" name="name" id="name" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="control-group">
                                                        <label class="required-field" class="control-label">Thuộc quận/huyện </label>
                                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_district">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                        <div class="controls">
                                                            <select name="district_id" id="district_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                <option value="-- Chọn quận/huyện --" disabled="disabled" selected="selected">-- Chọn quận/huyện --</option>
                                                                @foreach($districts as $district)
                                                                    <option value="{{$district->id}}">{{$district->name}} - {{$district->province->name}}</option>
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
                                </div>
                            </div>
                        </form>
                        <!-- /.modal -->

                        <!-- Modals for create district -->
                        <form class="form-horizontal" method="post" action="{{ route('admin.districts.store') }}" name="create_district" id="create_district" novalidate="novalidate">
                            {{ csrf_field() }}
                            <div class="modal fade" id="add_district">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Thêm Quận Huyện</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="control-group">
                                                        <label class="required-field" class="control-label">Tên quận/huyện</label>
                                                        <div class="controls">
                                                            <input type="text" class="form-control" name="name" id="name" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="control-group">
                                                        <label class="required-field" class="control-label">Thuộc tỉnh </label>
                                                        <div class="controls">
                                                            <select name="province_id" id="province_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                <option value="-- Chọn tỉnh --" disabled="disabled" selected="selected">-- Chọn tỉnh --</option>
                                                                @foreach($provinces as $province)
                                                                    <option value="{{$province->id}}">{{$province->name}}</option>
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

                        <!-- Modals for create school -->
                        <form class="form-horizontal" method="post" action="{{ route('admin.schools.store') }}" name="create_school" id="create_school" novalidate="novalidate">
                            {{ csrf_field() }}
                            <div class="modal fade" id="make_school">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Thêm trường</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="control-group">
                                                        <label class="required-field" class="control-label">Tên trường</label>
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
                    </div>
                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection


@push('scripts')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>


<style type="text/css">
    .dataTables_wrapper .dt-buttons {
    margin-bottom: -3em
  }
</style>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
        theme: 'bootstrap4'
        })
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        //Date picker
        $('#issued_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        // Summernote
        $("#experience").summernote("disable");
        $("#experience").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
        $('#experience').summernote({
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




