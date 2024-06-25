<!-- Working Tab -->
<div class="tab-pane" id="tab-working">
    <div class="card card-secondary">
        <div class="card-header">
            Quá trình làm việc
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @can('create-working')
            <a href="#create_working{{' . $employee->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_working{{$employee->id}}"><i class="fas fa-plus"></i></a>
            <br>
            <br>
            @endcan
            <table id="employee-workings-table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Vị trí</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Trạng thái</th>
                    @can('create-working')
                    <th>Thao tác</th>
                    @endcan
                  </tr>
                </thead>
                <tbody>
                    @foreach ($employee_works as $employee_work)
                    <tr>
                      @php
                          $company_job = App\Models\CompanyJob::findOrFail($employee_work->company_job_id);
                          $action_edit_working = '<a href="' . route("admin.workings.edit", $employee_work->id) . '" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                  <a href="'.route("admin.workings.getOff", $employee_work->id) . '" class="btn btn-secondary btn-sm"><i class="fas fa-power-off"></i></a>
                                  <form style="display:inline" action="'. route("admin.workings.destroy", $employee_work->id) . '" method="POST">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                  <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';

                          $action = '';
                          if (Auth::user()->can('create-working')) {
                              $action = $action . $action_edit_working;
                          }
                      @endphp
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
                      <td>{{date('d/m/Y', strtotime($employee_work->start_date))}}</td>
                      <td>
                        @if ($employee_work->end_date)
                          {{date('d/m/Y', strtotime($employee_work->end_date))}}
                        @else
                        -
                        @endif
                      </td>
                      <td>
                        <span class="badge @if ("On" == $employee_work->status) badge-success @else badge-danger @endif">
                            {{$employee_work->status}}
                        </span>
                      </td>
                      @can('create-working')
                      <td>{!! $action !!}</td>
                      @endcan
                    </tr>
                  @endforeach
                </tbody>
            </table>

            <!-- Modals for create employee working -->
            <form class="form-horizontal" method="post" action="{{ route('admin.workings.store') }}" name="create_working" id="create_working" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="create_working{{$employee->id}}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Hồ sơ của {{$employee->name}}</h4>
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
                                                    <select name="company_job_id" id="company_job_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
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
                                    <div class="col-12">
                                        <label class="required-field">Thời gian bắt đầu</label>
                                        <div class="input-group date" id="s_date" data-target-input="nearest">
                                            <input type="text" name="s_date" class="form-control datetimepicker-input" data-target="#s_date"/>
                                            <div class="input-group-append" data-target="#s_date" data-toggle="datetimepicker">
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
</div>


@push('scripts')
<script>
    $(function () {
        //Date picker
        $('#s_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });
</script>
@endpush



