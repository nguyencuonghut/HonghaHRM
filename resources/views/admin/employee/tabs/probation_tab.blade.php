<!-- Contract Tab -->
@push('styles')
<!-- Summernote -->
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endpush

<div class="tab-pane" id="tab-probation">
    @can('create-probation')
        <a href="#create_probation{{' . $employee->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_probation{{$employee->id}}"><i class="fas fa-plus"></i></a>
        <br>
        <br>
    @endcan
    @foreach ($probations as $probation)
    <div class="card card-secondary">
        <div class="card-header">
            @php
                $proposal = App\Models\RecruitmentProposal::findOrFail($probation->proposal_id);
            @endphp
            {{$proposal->company_job->name}} - {{$proposal->company_job->department->name}}, ngày cần {{date('d/m/Y', strtotime($proposal->work_time))}}
            <span class="float-right">{{date('d/m/Y', strtotime($probation->start_date))}} - {{date('d/m/Y', strtotime($probation->end_date))}}</span>
        </div>
        <div class="card-body">
            @can('create-probation')
            <a href="#create_plan{{' . $probation->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_plan{{$probation->id}}"><i class="fas fa-plus"></i></a>
            <br>
            <br>
            @endcan
            <table id="employee-probations-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nội dung công việc</th>
                    <th>Yêu cầu đạt được</th>
                    <th>Deadline</th>
                    <th>Người hướng dẫn</th>
                    <th>Kết quả</th>
                    @can('create-probation')
                    <th>Thao tác</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                    @php
                        $plans = App\Models\Plan::where('probation_id', $probation->id)->get();
                    @endphp
                    @foreach ($plans as $plan)
                    @php
                        $action_edit_plan = '<a href="' . route("admin.plans.edit", $plan->id) . '" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                <form style="display:inline" action="'. route("admin.plans.destroy", $plan->id) . '" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                    @endphp
                    <tr>
                        <td>{{$plan->work_title}}</td>
                        <td>{!! $plan->work_requirement !!}</td>
                        <td>{{date('d/m/Y', strtotime($plan->work_deadline))}}</td>
                        <td>{{$plan->instructor}}</td>
                        <td>{!! $plan->work_result !!}</td>
                        <td>{!! $action_edit_plan !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modals for create employee probation plan -->
        <form class="form-horizontal" method="post" action="{{ route('admin.plans.store', $employee->id) }}" name="create_plan" id="create_plan" novalidate="novalidate">
            {{ csrf_field() }}
            <div class="modal fade" id="create_plan{{$probation->id}}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Kế hoạch thử việc cho vị trí {{$proposal->company_job->name}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="probation_id" id="probation_id" value="{{$employee->id}}">

                            <div class="row">
                                <div class="col-12">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Nội dung công việc</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="work_title" id="work_title" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label class="required-field" class="control-label">Yêu cầu</label>
                                    <textarea id="work_requirement" name="work_requirement">
                                    </textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label class="required-field">Deadline</label>
                                    <div class="input-group date" id="work_deadline" data-target-input="nearest">
                                        <input type="text" name="work_deadline" class="form-control datetimepicker-input" data-target="#work_deadline"/>
                                        <div class="input-group-append" data-target="#work_deadline" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="control-label">Người hướng dẫn</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="instructor" id="instructor" required="">
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
    @endforeach


    <!-- Modals for create employee probation -->
    <form class="form-horizontal" method="post" action="{{ route('admin.probations.store', $employee->id) }}" name="create_probation" id="create_probation" novalidate="novalidate">
        {{ csrf_field() }}
        <div class="modal fade" id="create_probation{{$employee->id}}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Kế hoạch thử việc của {{$employee->name}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">

                        <div class="row">
                            <div class="col-12">
                                <label class="required-field">Thời gian bắt đầu</label>
                                <div class="input-group date" id="start_date" data-target-input="nearest">
                                    <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#start_date"/>
                                    <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label class="required-field">Thời gian kết thúc</label>
                                <div class="input-group date" id="end_date" data-target-input="nearest">
                                    <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#end_date"/>
                                    <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
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


@push('scripts')
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script>
    $(function () {
        // Summernote
        $("#work_requirement").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
        $('#work_requirement').summernote({
            height: 90,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
            ]
        })

        //Date picker
        $('#start_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#end_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#work_deadline').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });
</script>
@endpush



