@section('title')
{{ 'Dự kiến tăng giảm BHXH' }}
@endsection
@push('styles')
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
          <h1 class="m-0">Tất cả dự kiến tăng - giảm BHXH</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Dự kiến tăng Giảm BHXH</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        Dự kiến phát sinh tăng
                    </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="inc-employees-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã</th>
                        <th>Họ tên</th>
                        <th>Vị trí</th>
                        <th>Tháng dự kiến tăng</th>
                        <th>Xác nhận tăng</th>
                    </tr>
                    </thead>
                    </table>
                  </div>
              </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        Dự kiến phát sinh giảm
                    </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <a href="{{route('admin.reports.exportDecBhxh')}}" class="btn btn-sm btn-primary"><i class="fas fa-cloud-download-alt"></i></a>

                    <table id="dec-employees-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã</th>
                        <th>Họ tên</th>
                        <th>Tháng dự kiến giảm</th>
                    </tr>
                    </thead>
                    </table>
                  </div>
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
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

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


<style type="text/css">
    .dataTables_wrapper .dt-buttons {
    margin-bottom: -3em
  }
</style>


<script>
    $(function () {
      //Date picker
      $('#month_of_year').datetimepicker({
          format: 'MM/YYYY',
          minViewMode: 'months',
          viewMode: 'months',
          pickTime: false
      });
      // Datatables
      $('#inc-employees-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        processing: true,
        serverSide: true,
        buttons: [
            {
                extend: 'copy',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'csv',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3]
                }

            },
            {
                extend: 'excel',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'pdf',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'print',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
            {
                extend: 'colvis',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3]
                }
            }
        ],
        dom: 'Blfrtip',
        ajax: {
          url: "{{ route('admin.reports.candidateIncBhxhData') }}",
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'company_job', name: 'company_job'},
            {data: 'start_date', name: 'start_date'},
            {data: 'actions', name: 'actions'},
        ],
        });

       $('#dec-employees-table').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        processing: true,
        serverSide: true,
        // buttons: [
        //     {
        //         extend: 'copy',
        //         footer: true,
        //         exportOptions: {
        //             columns: [0,1,2,3,4,5,6]
        //         }
        //     },
        //     {
        //         extend: 'csv',
        //         footer: true,
        //         exportOptions: {
        //             columns: [0,1,2,3,4,5,6]
        //         }

        //     },
        //     {
        //         extend: 'excel',
        //         footer: true,
        //         exportOptions: {
        //             columns: [0,1,2,3,4,5,6]
        //         }
        //     },
        //     {
        //         extend: 'pdf',
        //         footer: true,
        //         exportOptions: {
        //             columns: [0,1,2,3,4,5,6]
        //         }
        //     },
        //     {
        //         extend: 'print',
        //         footer: true,
        //         exportOptions: {
        //             columns: [0,1,2,3,4,5,6]
        //         }
        //     },
        //     {
        //         extend: 'colvis',
        //         footer: true,
        //         exportOptions: {
        //             columns: [0,1,2,3,4,5,6]
        //         }
        //     }
        // ],
        // dom: 'Blfrtip',
        ajax: {
          url: "{{ route('admin.reports.decBhxhData') }}",
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'end_date', name: 'end_date'},
        ],
        });
    });
  </script>
@endpush
