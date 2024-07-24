<!-- Salary Tab -->
@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

<div class="tab-pane" id="tab-salary">
    <!-- Salary table -->
    <div class="card card-secondary">
        <div class="card-header">
            Lương
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @can('create-salary')
            <a href="#create_salary{{' . $employee->id . '}}" class="btn btn-success mb-2" data-toggle="modal" data-target="#create_salary{{$employee->id}}"><i class="fas fa-plus"></i></a>
            @endcan
            <br>
            <table id="employee-salaries-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Lương vị trí</th>
                        <th>Lương năng lực</th>
                        <th>Phụ cấp vị trí</th>
                        <th>Lương BHXH</th>
                        <th>Trạng thái</th>
                        @can('create-salary')
                        <th>Thao tác</th>
                        @endcan
                    </tr>
                </thead>
            </table>

            <!-- Modals for create employee salary -->
            <form class="form-horizontal" method="post" action="{{ route('admin.hr.salaries.store', $employee->id) }}" name="create_salary" id="create_salary" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="create_salary{{$employee->id}}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Lương của {{$employee->name}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                                <div class="row">
                                    <div class="col-3">
                                      <div class="control-group">
                                          <label class="required-field" class="control-label">Lương vị trí</label>
                                          <input class="form-control" type="number" name="position_salary" id="position_salary">
                                      </div>
                                    </div>
                                    <div class="col-3">
                                      <div class="control-group">
                                          <label class="required-field" class="control-label">Lương năng lực</label>
                                          <input class="form-control" type="number" name="capacity_salary" id="capacity_salary">
                                      </div>
                                    </div>
                                    <div class="col-3">
                                      <div class="control-group">
                                          <label class="required-field" class="control-label">Phụ cấp vị trí</label>
                                          <input class="form-control" type="number" name="position_allowance" id="position_allowance">
                                      </div>
                                    </div>
                                    <div class="col-3">
                                      <div class="control-group">
                                          <label class="required-field" class="control-label">Lương bảo hiểm</label>
                                          <input class="form-control" type="number" name="insurance_salary" id="insurance_salary">
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
<style type="text/css">
    .dataTables_wrapper .dt-buttons {
    margin-bottom: -3em
  }
</style>


<script>
    $(function () {
      $("#employee-salaries-table").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        buttons: [
            {
                extend: 'copy',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3,4,5]
                }
            },
            {
                extend: 'csv',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3,4,5]
                }

            },
            {
                extend: 'excel',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3,4,5]
                }
            },
            {
                extend: 'pdf',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3,4,5]
                }
            },
            {
                extend: 'print',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3,4,5]
                }
            },
            {
                extend: 'colvis',
                footer: true,
                exportOptions: {
                    columns: [0,1,2,3,4,5]
                }
            }
        ],
        dom: 'Blfrtip',
        ajax: ' {!! route('admin.hr.salaries.employeeData', $employee->id) !!}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'position_salary', name: 'position_salary'},
            {data: 'capacity_salary', name: 'capacity_salary'},
            {data: 'position_allowance', name: 'position_allowance'},
            {data: 'insurance_salary', name: 'insurance_salary'},
            {data: 'status', name: 'status'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
       ]
      }).buttons().container().appendTo('#employee-salaries-table_wrapper .col-md-6:eq(0)');
    });
  </script>
@endpush





