<!-- Productivity Tab -->
@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

<div class="tab-pane" id="tab-productivity">
    <div class="card card-secondary">
        <div class="card-header">
            KPI
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @can('create-productivity')
            <a href="#create_kpi{{' . $employee->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_kpi{{$employee->id}}"><i class="fas fa-plus"></i></a>
            @endcan

            <table id="employee-kpis-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Năm</th>
                        <th>Tháng</th>
                        <th>Điểm</th>
                        @can('create-productivity')
                        <th>Thao tác</th>
                        @endcan
                    </tr>
                </thead>
            </table>

            <!-- Modals for create employee kpi -->
            <form class="form-horizontal" method="post" action="{{ route('admin.hr.kpis.store', $employee->id) }}" name="create_kpi" id="create_kpi" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="create_kpi{{$employee->id}}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>KPI của {{$employee->name}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                                <div class="row">
                                    <div class="col-4">
                                      <div class="control-group">
                                          <label class="required-field" class="control-label">Năm</label>
                                          <input class="form-control" type="number" name="year" id="year" value="{{Carbon\Carbon::now()->year}}">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="control-group">
                                              <label class="required-field" class="control-label">Tháng</label>
                                              <div class="controls">
                                                  <select name="month" id="month" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                      <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                      <option value="Tháng 1" @if(1 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 1</option>
                                                      <option value="Tháng 2" @if(2 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 2</option>
                                                      <option value="Tháng 3" @if(3 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 3</option>
                                                      <option value="Tháng 4" @if(4 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 4</option>
                                                      <option value="Tháng 5" @if(5 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 5</option>
                                                      <option value="Tháng 6" @if(6 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 6</option>
                                                      <option value="Tháng 7" @if(7 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 7</option>
                                                      <option value="Tháng 8" @if(8 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 8</option>
                                                      <option value="Tháng 9" @if(9 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 9</option>
                                                      <option value="Tháng 10" @if(10 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 10</option>
                                                      <option value="Tháng 11" @if(11 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 11</option>
                                                      <option value="Tháng 12" @if(12 == Carbon\Carbon::now()->month - 1) selected="selected" @endif>Tháng 12</option>
                                                  </select>
                                              </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="control-group">
                                          <label class="required-field" class="control-label">Điểm</label>
                                          <input class="form-control" type="number" name="score" id="score">
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
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
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

      $("#employee-kpis-table").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        buttons: [
            {
                extend: 'copy',
                footer: true,
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'csv',
                footer: true,
                exportOptions: {
                    columns: [0,1,2]
                }

            },
            {
                extend: 'excel',
                footer: true,
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'pdf',
                footer: true,
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'print',
                footer: true,
                exportOptions: {
                    columns: [0,1,2]
                }
            },
            {
                extend: 'colvis',
                footer: true,
                exportOptions: {
                    columns: [0,1,2]
                }
            }
        ],
        dom: 'Blfrtip',
        ajax: ' {!! route('admin.hr.kpis.employeeData', $employee->id) !!}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'year', name: 'year'},
            {data: 'month', name: 'month'},
            {data: 'score', name: 'score'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
       ]
      }).buttons().container().appendTo('#employee-kpis-table_wrapper .col-md-6:eq(0)');
    });
  </script>
@endpush




