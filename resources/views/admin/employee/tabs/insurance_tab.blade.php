<!-- Insurance Tab -->
@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

<div class="tab-pane" id="tab-insurance">
    <div class="card card-secondary">
        <div class="card-header">
            Bảo hiểm
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @can('create-insurance')
            <a href="#create_insurance{{' . $employee->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_insurance{{$employee->id}}"><i class="fas fa-plus"></i></a>
            <br>
            <br>
            @endcan
            <table id="employee-insurances-table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Loại bảo hiểm</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Tỷ lệ đóng (%)</th>
                    @can('create-insurance')
                    <th style="width:12%;">Thao tác</th>
                    @endcan
                  </tr>
                </thead>
                <tbody>
                    @foreach ($employee_insurances as $employee_insurance)
                    <tr>
                        <td>{{$employee_insurance->insurance->name}}</td>
                      @php
                          $action_edit_insurances = '<a href="' . route("admin.hr.insurances.edit", $employee_insurance->id) . '" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                  <form style="display:inline" action="'. route("admin.hr.insurances.destroy", $employee_insurance->id) . '" method="POST">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                  <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';

                          $action = '';
                          if (Auth::user()->can('create-insurance')) {
                              $action = $action . $action_edit_insurances;
                          }
                      @endphp
                      <td>{{date('d/m/Y', strtotime($employee_insurance->start_date))}}</td>
                      <td>{{date('d/m/Y', strtotime($employee_insurance->end_date))}}</td>
                      <td>{{$employee_insurance->pay_rate}}</td>
                      @can('create-insurance')
                      <td>{!! $action !!}</td>
                      @endcan
                    </tr>
                  @endforeach
                </tbody>
            </table>

            <!-- Modals for create employee insurance -->
            <form class="form-horizontal" method="post" action="{{ route('admin.hr.insurances.store') }}" name="create_insurance" id="create_insurance" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="create_insurance{{$employee->id}}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Bảo hiểm của {{$employee->name}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <div class="control-group">
                                                <label class="required-field" class="control-label">Loại bảo hiểm</label>
                                                <div class="controls">
                                                    <select name="insurance_id" id="insurance_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                        @foreach ($insurances as $insurance)
                                                            <option value="{{$insurance->id}}">{{$insurance->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Tỷ lệ đóng (%)</label>
                                            <input class="form-control" type="number" name="pay_rate" id="pay_rate" step="any">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <label class="required-field">Thời gian bắt đầu</label>
                                        <div class="input-group date" id="insurance_s_date" data-target-input="nearest">
                                            <input type="text" name="insurance_s_date" class="form-control datetimepicker-input" data-target="#insurance_s_date"/>
                                            <div class="input-group-append" data-target="#insurance_s_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label>Thời gian kết thúc</label>
                                        <div class="input-group date" id="insurance_e_date" data-target-input="nearest">
                                            <input type="text" name="insurance_e_date" class="form-control datetimepicker-input" data-target="#insurance_e_date"/>
                                            <div class="input-group-append" data-target="#insurance_e_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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


    <div class="card card-secondary">
        <div class="card-header">
            Chế độ BH
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @can('create-insurance')
            <a href="#create_regime{{' . $employee->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_regime{{$employee->id}}"><i class="fas fa-plus"></i></a>
            <br>
            <br>
            @endcan
            <table id="employee-regimes-table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Chế độ</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Đợt thanh toán</th>
                    <th>Số tiền được thanh toán</th>
                    <th>Trạng thái</th>
                    @can('create-insurance')
                    <th style="width:12%;">Thao tác</th>
                    @endcan
                  </tr>
                </thead>
                <tbody>
                    @foreach ($employee_regimes as $employee_regime)
                    <tr>
                      @php
                          $action_edit_regimes = '<a href="' . route("admin.hr.regimes.edit", $employee_regime->id) . '" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                  <form style="display:inline" action="'. route("admin.hr.regimes.destroy", $employee_regime->id) . '" method="POST">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                  <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';

                          $action = '';
                          if (Auth::user()->can('create-insurance')) {
                              $action = $action . $action_edit_regimes;
                          }
                      @endphp
                      <td>{{$employee_regime->regime->name}}</td>
                      <td>
                        @if($employee_regime->off_start_date)
                            {{date('d/m/Y', strtotime($employee_regime->off_start_date))}}
                        @endif
                      </td>
                      <td>
                        @if($employee_regime->off_end_date)
                            {{date('d/m/Y', strtotime($employee_regime->off_end_date))}}
                        @endif
                      </td>
                      <td>{{$employee_regime->payment_period}}</td>
                      <td>
                        @if ($employee_regime->payment_amount)
                            {{number_format($employee_regime->payment_amount, 0, '.', ',')}}
                        @endif
                      </td>
                      <td>
                        <span class="badge @if ("Mở" == $employee_regime->status) badge-success @else badge-secondary @endif">{{$employee_regime->status}}</span>
                      </td>
                      @can('create-insurance')
                      <td>{!! $action !!}</td>
                      @endcan
                    </tr>
                  @endforeach
                </tbody>
            </table>

            <!-- Modals for create employee employee_regime -->
            <form class="form-horizontal" method="post" action="{{ route('admin.hr.regimes.store') }}" name="create_regime" id="create_regime" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="create_regime{{$employee->id}}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Chế độ BH của {{$employee->name}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <div class="control-group">
                                                <label class="required-field" class="control-label">Loại chế độ</label>
                                                <div class="controls">
                                                    <select name="regime_id" id="regime_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                        @foreach ($regimes as $regime)
                                                            <option value="{{$regime->id}}">{{$regime->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="control-label">Đợt thanh toán</label>
                                            <input class="form-control" type="text" name="payment_period" id="payment_period">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                      <label>Thời gian bắt đầu nghỉ</label>
                                      <div class="input-group date" id="off_start_date" data-target-input="nearest">
                                          <input type="text" name="off_start_date" class="form-control datetimepicker-input" data-target="#off_start_date"/>
                                          <div class="input-group-append" data-target="#off_start_date" data-toggle="datetimepicker">
                                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="col-6">
                                      <label>Thời gian kết thúc nghỉ</label>
                                      <div class="input-group date" id="off_end_date" data-target-input="nearest">
                                          <input type="text" name="off_end_date" class="form-control datetimepicker-input" data-target="#off_end_date"/>
                                          <div class="input-group-append" data-target="#off_end_date" data-toggle="datetimepicker">
                                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                          </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
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
        $('#insurance_s_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#insurance_e_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#off_start_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#off_end_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });
</script>
@endpush





