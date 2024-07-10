<!-- Contract Tab -->
@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

<div class="tab-pane" id="tab-contract">
    <div class="card card-secondary">
        <div class="card-header">
            Hợp đồng
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @can('create-contract')
            <a href="#create_contract{{' . $employee->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_contract{{$employee->id}}"><i class="fas fa-plus"></i></a>
            <br>
            <br>
            @endcan
            <table id="employee-contracts-table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Số HĐ</th>
                    <th>Hợp đồng</th>
                    <th>Vị trí</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Trạng thái</th>
                    <th>File</th>
                    @can('create-contract')
                    <th style="width:12%;">Thao tác</th>
                    @endcan
                  </tr>
                </thead>
                <tbody>
                    @foreach ($employee_contracts as $employee_contract)
                    <tr>
                        <td>{{$employee_contract->code}}</td>
                      @php
                          $company_job = App\Models\CompanyJob::findOrFail($employee_contract->company_job_id);
                          $action_edit_contracts = '<a href="' . route("admin.hr.contracts.edit", $employee_contract->id) . '" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="'.route("admin.hr.contracts.getOff", $employee_contract->id) . '" class="btn btn-secondary btn-sm"><i class="fas fa-power-off"></i></a>
                                  <form style="display:inline" action="'. route("admin.hr.contracts.destroy", $employee_contract->id) . '" method="POST">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                  <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';

                          $action = '';
                          if (Auth::user()->can('create-working')) {
                              $action = $action . $action_edit_contracts;
                          }
                      @endphp
                      <td>{{$employee_contract->contract_type->name}}</td>
                      <td>
                        @php
                            $company_job_str = '';
                            if ($company_job->division_id) {
                                $company_job_str .= $company_job->name . ' - '. $company_job->division->name . ' - ' . $company_job->department->name;
                            } else {
                                $company_job_str .= $company_job->name . ' - ' . $company_job->department->name;
                            }
                        @endphp
                        {!! $company_job_str !!}
                      </td>
                      <td>{{date('d/m/Y', strtotime($employee_contract->start_date))}}</td>
                      <td>
                        @if ($employee_contract->end_date)
                          {{date('d/m/Y', strtotime($employee_contract->end_date))}}
                        @else
                        -
                        @endif
                      </td>
                      <td>
                        <span class="badge @if ("On" == $employee_contract->status) badge-success @else badge-danger @endif">
                            {{$employee_contract->status}}
                        </span>
                      </td>
                      @php
                            $url = '';
                            if ($employee_contract->file_path) {
                                $url .= '<a target="_blank" href="../../../' . $employee_contract->file_path . '"><i class="far fa-file-pdf"></i></a>';
                            }
                      @endphp
                      <td>{!! $url !!}</td>
                      @can('create-contract')
                      <td>{!! $action !!}</td>
                      @endcan
                    </tr>
                  @endforeach
                </tbody>
            </table>

            <!-- Modals for create employee contract -->
            <form class="form-horizontal" method="post" action="{{ route('admin.hr.contracts.store') }}" enctype="multipart/form-data" name="create_contract" id="create_contract" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="create_contract{{$employee->id}}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Hợp đồng của {{$employee->name}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-group">
                                            <div class="control-group">
                                                <label class="required-field" class="control-label">Vị trí</label>
                                                <div class="controls">
                                                    <select name="contract_company_job_id" id="contract_company_job_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                        @foreach ($company_jobs as $company_job)
                                                            <option value="{{$company_job->id}}">{{$company_job->name}} {{$company_job->division_id ? (' - ' . $company_job->division->name) : ''}} {{$company_job->department_id ? ( ' - ' . $company_job->department->name) : ''}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <div class="control-group">
                                                <label class="required-field" class="control-label">Số HĐ</label>
                                                <div class="controls">
                                                    <input class="form-control" type="text" name="code" id="code">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <div class="control-group">
                                                <label class="required-field" class="control-label">Loại HĐ</label>
                                                <div class="controls">
                                                    <select name="contract_type_id" id="contract_type_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                        @foreach ($contract_types as $contract_type)
                                                            <option value="{{$contract_type->id}}">{{$contract_type->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <label class="required-field">Thời gian bắt đầu</label>
                                        <div class="input-group date" id="contract_s_date" data-target-input="nearest">
                                            <input type="text" name="contract_s_date" class="form-control datetimepicker-input" data-target="#contract_s_date"/>
                                            <div class="input-group-append" data-target="#contract_s_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label>Thời gian kết thúc</label>
                                        <div class="input-group date" id="contract_e_date" data-target-input="nearest">
                                            <input type="text" name="contract_e_date" class="form-control datetimepicker-input" data-target="#contract_e_date"/>
                                            <div class="input-group-append" data-target="#contract_e_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-group">
                                            <label class="control-label">File (pdf)</label>
                                            <div class="custom-file text-left">
                                                <input type="file" name="file_path" accept="application/pdf" class="custom-file-input" id="file_path">
                                                <label class="custom-file-label" for="img_path">Chọn file</label>
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
        $('#contract_s_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#contract_e_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
</script>
@endpush



