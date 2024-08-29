@section('title')
{{ 'Tăng giảm BHXH theo tháng' }}
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
          <h1 class="m-0">Tất cả tăng - giảm BHXH tháng</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Tăng Giảm BHXH tháng {{$month}}/{{$year}}</li>
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
            <form class="form-horizontal" method="post" action="{{route('admin.reports.incDecBhxhByMonth')}}" name="filter_by_month" id="filter_by_month" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-4">
                        <div class="control-group">
                            <label class="control-label">Chọn tháng</label>
                            <div class="input-group date" id="month_of_year" data-target-input="nearest">
                                <input type="text" id="month_of_year" name="month_of_year" class="form-control datetimepicker-input" value="{{$month . '/' . $year}}" data-target="#month_of_year"/>
                                <div class="input-group-append" data-target="#month_of_year" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls mt-2">
                                <input type="submit" value="Tìm" class="btn btn-success">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
            <div class="card card-secondary">
                <div class="card-header">
                    Phát sinh tăng
                </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="{{route('admin.reports.exportIncBhxhByMonth', ['month' => $month, 'year' => $year])}}" class="btn btn-sm btn-primary"><i class="fas fa-cloud-download-alt"></i></a>

                <table id="inc-employees-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>STT</th>
                    <th>Mã</th>
                    <th>Họ tên</th>
                    <th>Ngày phát sinh tăng</th>
                    <th>Tháng báo tăng</th>
                    <th>Lương BHXH</th>
                    <th>Tiền tăng BHXH</th>
                    <th>Tiền tăng BHTN</th>
                  </tr>
                  <tfoot>
                    <tr>
                        <th colspan="6">Tổng tăng</th>
                        <th id="total_inc_bhxh"></th>
                        <th id="total_inc_bhtn"></th>
                    </tr>
                  </tfoot>
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
                    Phát sinh giảm
                </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="{{route('admin.reports.exportDecBhxhByMonth', ['month' => $month, 'year' => $year])}}" class="btn btn-sm btn-primary"><i class="fas fa-cloud-download-alt"></i></a>

                <table id="dec-employees-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>STT</th>
                    <th>Mã</th>
                    <th>Họ tên</th>
                    <th>Ngày phát sinh giảm</th>
                    <th>Lương BHXH</th>
                    <th>Tiền giảm BHXH</th>
                    <th>Tiền giảm BHTN</th>
                  </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th colspan="5">Tổng giảm</th>
                        <th id="total_dec_bhxh"></th>
                        <th id="total_dec_bhtn"></th>
                    </tr>
                  </tfoot>
                </table>
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

      var month =  {{ Js::from($month) }};
      var yar =  {{ Js::from($year) }};
      // Datatables
      $('#inc-employees-table').DataTable({
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
        //dom: 'Blfrtip',
        ajax: ' {!! route('admin.reports.incBhxhByMonthData', ['month' => $month, 'year' => $year]) !!}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'start_date', name: 'start_date'},
            {data: 'increase_confirmed_month', name: 'increase_confirmed_month'},
            {data: 'insurance_salary', name: 'insurance_salary'},
            {data: 'bhxh_increase', name: 'bhxh_increase'},
            {data: 'bhtn_increase', name: 'bhtn_increase'},
        ],
        drawCallback:function(settings) {
            var api = this.api();
            var intVal = function(i) {
                return typeof i === 'string' ?
                i.replace(/[\,]/g, '') * 1:
                typeof i === 'number' ?
                i : 0;
            };

            var total_inc_bhxh = api
                .column(6)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $('#total_inc_bhxh').html(total_inc_bhxh.toLocaleString(
                undefined, // leave undefined to use the visitor's browser
                            // locale or a string like 'en-US' to override it.
                { minimumFractionDigits: 0 }
            ));

            var total_inc_bhtn = api
                .column(7)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $('#total_inc_bhtn').html(total_inc_bhtn.toLocaleString(
                undefined, // leave undefined to use the visitor's browser
                            // locale or a string like 'en-US' to override it.
                { minimumFractionDigits: 0 }
            ));
        }
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
        //             columns: [0,1,2,3,4]
        //         }
        //     },
        //     {
        //         extend: 'csv',
        //         footer: true,
        //         exportOptions: {
        //             columns: [0,1,2,3,4]
        //         }

        //     },
        //     {
        //         extend: 'excel',
        //         footer: true,
        //         exportOptions: {
        //             columns: [0,1,2,3,4]
        //         }
        //     },
        //     {
        //         extend: 'pdf',
        //         footer: true,
        //         exportOptions: {
        //             columns: [0,1,2,3,4]
        //         }
        //     },
        //     {
        //         extend: 'print',
        //         footer: true,
        //         exportOptions: {
        //             columns: [0,1,2,3,4]
        //         }
        //     },
        //     {
        //         extend: 'colvis',
        //         footer: true,
        //         exportOptions: {
        //             columns: [0,1,2,3,4]
        //         }
        //     }
        // ],
        // dom: 'Blfrtip',
        ajax: ' {!! route('admin.reports.decBhxhByMonthData', ['month' => $month, 'year' => $year]) !!}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'end_date', name: 'end_date'},
            {data: 'insurance_salary', name: 'insurance_salary'},
            {data: 'bhxh_decrease', name: 'bhxh_decrease'},
            {data: 'bhtn_decrease', name: 'bhtn_decrease'},
        ],
        drawCallback:function(settings) {
            var api = this.api();
            var intVal = function(i) {
                return typeof i === 'string' ?
                i.replace(/[\,]/g, '') * 1:
                typeof i === 'number' ?
                i : 0;
            };

            var total_dec_bhxh = api
                .column(5)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $('#total_dec_bhxh').html(total_dec_bhxh.toLocaleString(
                undefined, // leave undefined to use the visitor's browser
                            // locale or a string like 'en-US' to override it.
                { minimumFractionDigits: 0 }
            ));

            var total_dec_bhtn = api
                .column(6)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $('#total_dec_bhtn').html(total_dec_bhtn.toLocaleString(
                undefined, // leave undefined to use the visitor's browser
                            // locale or a string like 'en-US' to override it.
                { minimumFractionDigits: 0 }
            ));
        }
        });
    });
  </script>
@endpush
