@section('title')
{{ 'Ứng viên' }}
@endsection
@push('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
          <h1 class="m-0">Tất cả ứng viên</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Ứng viên</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <a href="{{ route('admin.users.create') }}" data-toggle="modal" data-target="#create_candidate" class="btn btn-success"><i class="fas fa-plus"></i> Thêm</a>

                {{-- <button type="button" class="btn btn-success float-left" data-toggle="modal" data-target="#create_candidate">
                    <i class="fas fa-file-plus"></i> Thêm
                </button> --}}
                <br>
                <table id="candidates-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>CCCD</th>
                    <th>Ứng tuyển</th>
                    <th style="width: 12%;">Thao tác</th>
                  </tr>
                  </thead>
                </table>

                <!-- Modals for create candiate -->
                <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.candidates.store') }}" enctype="multipart/form-data" name="make_candidate" id="make_candidate" novalidate="novalidate">
                    {{ csrf_field() }}
                    <div class="modal fade" id="create_candidate">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Tạo mới ứng viên</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="control-group">
                                                <label class="required-field" class="control-label">Họ tên</label>
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
                                                <label class="required-field" class="control-label">Số điện thoại</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" name="phone" id="phone" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="control-group">
                                                <label class="control-label">Số điện thoại người thân</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" name="relative_phone" id="relative_phone" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <label class="required-field">Ngày sinh</label>
                                            <div class="input-group date" id="date_of_birth" data-target-input="nearest">
                                                <input type="text" name="date_of_birth" class="form-control datetimepicker-input" data-target="#date_of_birth"/>
                                                <div class="input-group-append" data-target="#date_of_birth" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="control-group">
                                                <label class="control-label">CCCD</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" name="cccd" id="cccd" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="control-label">Ngày cấp</label>
                                            <div class="input-group date" id="issued_date" data-target-input="nearest">
                                                <input type="text" name="issued_date" class="form-control datetimepicker-input" data-target="#issued_date"/>
                                                <div class="input-group-append" data-target="#issued_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="control-group">
                                                <label class="control-label">Nơi cấp</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" name="issued_by" id="issued_by" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="control-group">
                                                <label class="required-field" class="control-label">Giới tính</label>
                                                <div class="controls">
                                                    <select name="gender" id="gender" data-placeholder="Chọn giới tính" class="form-control select2" style="width: 100%;">
                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                        <option value="Nam">Nam</option>
                                                        <option value="Nữ">Nữ</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="control-group">
                                                <label class="required-field" class="control-label">Địa chỉ</label>
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_commune">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <div class="controls">
                                                    <select name="commune_id" id="commune_id" data-placeholder="Chọn địa chỉ" class="form-control select2" style="width: 100%;">
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
                                            <label class="required-field" class="control-label">Trình độ</label>
                                            <table class="table table-bordered" id="dynamicTable">
                                                <tr>
                                                    <th class="required-field" style="width: 50%;">
                                                        Trường
                                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#make_education">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </th>
                                                    <th>Ngành</th>
                                                    <th style="width: 14%;">Thao tác</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <select name="addmore[0][education_id]" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected" disabled>Chọn trường</option>
                                                            @foreach($educations as $education)
                                                                <option value="{{$education->id}}">{{$education->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="addmore[0][major]" placeholder="Ngành" class="form-control" /></td>
                                                    <td><button type="button" name="add_education" id="add_education" class="btn btn-success"><i class="fas fa-plus"></i></button></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label class="control-label">Ghi chú</label>
                                            <textarea id="note" name="note">
                                            </textarea>
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
                        <!-- /.modal-content -->
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

            <!-- Modals for make education -->
            <form class="form-horizontal" method="post" action="{{ route('admin.educations.store') }}" name="create_education" id="create_education" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="make_education">
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
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@push('scripts')
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
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
        });

        //Date picker
        $('#date_of_birth').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#issued_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        var i = 0;
        $("#add_education").click(function(){
            ++i;
            $("#dynamicTable").append('<tr><td><select name="addmore['+i+'][education_id]" class="form-control select2" style="width: 100%;"><option selected="selected" disabled>Chọn trường</option>@foreach($educations as $education)<option value="{{$education->id}}">{{$education->name}}</option>@endforeach</select></td><td><input type="text" name="addmore['+i+'][major]" placeholder="Ngành" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="fas fa-trash-alt"></i></button></td></tr>');

            //Reinitialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            })
        });

        $(document).on('click', '.remove-tr', function(){
            $(this).parents('tr').remove();
        });

        // Summernote
        $("#note").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
        $('#note').summernote({
            height: 80,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
            ]
        })

      $("#candidates-table").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        buttons: [
            {
                extend: 'copy',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3,4,5,6]
                }
            },
            {
                extend: 'csv',
                footer: true,
                exportOptions: {
                  columns: [0,1,2,3,4,5,6]
                }

            },
            {
                extend: 'excel',
                footer: true,
                exportOptions: {
                  columns: [0,1,2,3,4,5,6]
                }
            },
            {
                extend: 'pdf',
                footer: true,
                exportOptions: {
                  columns: [0,1,2,3,4,5,6]
                }
            },
            {
                extend: 'print',
                footer: true,
                exportOptions: {
                  columns: [0,1,2,3,4,5,6]
                }
            },
            {
                extend: 'colvis',
                footer: true,
                exportOptions: {
                  columns: [0,1,2,3,4,5,6]
                }
            }
        ],
        dom: 'Blfrtip',
        ajax: ' {!! route('admin.recruitment.candidates.data') !!}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'addr', name: 'addr'},
            {data: 'cccd', name: 'cccd'},
            {data: 'recruitments', name: 'recruitments'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
       ]
      }).buttons().container().appendTo('#candidates-table_wrapper .col-md-6:eq(0)');
    });
  </script>
@endpush
