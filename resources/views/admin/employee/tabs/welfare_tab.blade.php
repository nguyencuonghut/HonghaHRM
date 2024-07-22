<!-- Welfare Tab -->
@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

<div class="tab-pane" id="tab-welfare">
    <div class="card card-secondary">
        <div class="card-header">
            Bảo hiểm
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @can('create-welfare')
            <a href="#create_welfare{{' . $employee->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_welfare{{$employee->id}}"><i class="fas fa-plus"></i></a>
            <br>
            <br>
            @endcan
            <table id="employee-welfares-table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Loại phúc lợi</th>
                    <th>Ngày chi trả</th>
                    <th>Số tiền chi trả (VNĐ)</th>
                    <th>Trạng thái</th>
                    @can('create-welfare')
                    <th style="width:12%;">Thao tác</th>
                    @endcan
                  </tr>
                </thead>
                <tbody>
                    @foreach ($employee_welfares as $employee_welfare)
                    <tr>
                        <td>{{$employee_welfare->welfare->name}}</td>
                      @php
                          $action_edit_welfares = '<a href="' . route("admin.hr.welfares.edit", $employee_welfare->id) . '" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                  <form style="display:inline" action="'. route("admin.hr.welfares.destroy", $employee_welfare->id) . '" method="POST">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                  <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';

                          $action = '';
                          if (Auth::user()->can('create-welfare')) {
                              $action = $action . $action_edit_welfares;
                          }
                      @endphp
                      <td>
                        @if ($employee_welfare->payment_date)
                        {{date('d/m/Y', strtotime($employee_welfare->payment_date))}}
                        @endif
                      </td>
                      <td>
                        @if ($employee_welfare->payment_amount)
                        {{number_format($employee_welfare->payment_amount, 0, '.', ',')}}
                        @endif
                      </td>
                      <td>
                        <span class="badge @if ("Mở" == $employee_welfare->status) badge-success @else badge-secondary @endif">{{$employee_welfare->status}}</span>
                      </td>
                      @can('create-welfare')
                      <td>{!! $action !!}</td>
                      @endcan
                    </tr>
                  @endforeach
                </tbody>
            </table>

            <!-- Modals for create employee welfare -->
            <form class="form-horizontal" method="post" action="{{ route('admin.hr.welfares.store') }}" name="create_welfare" id="create_welfare" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="create_welfare{{$employee->id}}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Phúc lợi của {{$employee->name}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="control-group">
                                            <div class="control-group">
                                                <label class="required-field" class="control-label">Loại phúc lợi</label>
                                                <div class="controls">
                                                    <select name="welfare_id" id="welfare_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                        @foreach ($welfares as $welfare)
                                                            <option value="{{$welfare->id}}">{{$welfare->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label>Ngày chi trả</label>
                                        <div class="input-group date" id="payment_date" data-target-input="nearest">
                                            <input type="text" name="payment_date" class="form-control datetimepicker-input" data-target="#payment_date"/>
                                            <div class="input-group-append" data-target="#payment_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label>Số tiền được thanh toán</label>
                                        <input class="form-control" type="number" name="payment_amount" id="payment_amount">
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
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
        theme: 'bootstrap4'
        });

        //Date picker
        $('#payment_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });
</script>
@endpush





