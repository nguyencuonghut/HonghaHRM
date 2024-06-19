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
    <table id="employee-probations-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Vị trí</th>
            <th>Thời gian thử việc</th>
            <th>Người tạo</th>
            @can('create-probation')
            <th>Thao tác</th>
            @endcan
          </tr>
        </thead>
        <tbody>
            @foreach ($probations as $probation)
            <tr>
              @php
                  $probation = App\Models\Probation::findOrFail($probation->id);
                  $proposal = App\Models\RecruitmentProposal::findOrFail($probation->proposal_id);
                  $action_edit_probation = '<a href="#edit_probation{{' . $probation->id . '}}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit_probation' . $probation->id. '"><i class="fas fa-edit"></i></a>
                          <form style="display:inline" action="'. route("admin.probations.destroy", $probation->id) . '" method="POST">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                          <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';

                  $action = '';
                  if (Auth::user()->can('create-probation')) {
                      $action = $action . $action_edit_probation;
                  }
              @endphp
              <td>{{ $proposal->company_job->name }} - {{$proposal->company_job->department->name}}</td>
              <td>
                @php
                    $url = '<a href="'.route('admin.probations.show', $probation->id).'">'.date('d/m/Y', strtotime($probation->start_date)). ' - ' . date('d/m/Y', strtotime($probation->end_date)) . '</a>';
                @endphp
                {!! $url !!}
              </td>
              <td>{{ $probation->creator->name }}</td>
              @can('create-probation')
              <td>{!! $action !!}</td>
              @endcan

              <!-- Modals for edit employee probation -->
              <form class="form-horizontal" method="post" action="{{ route('admin.probations.update', $probation->id) }}" name="update_probation" id="update_probation" novalidate="novalidate">
                  @method('PATCH')
                  {{ csrf_field() }}
                  <div class="modal fade" tabindex="-1" id="edit_probation{{$probation->id}}">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h4>Thử việc của {{$employee->name}}, vị trí {{$proposal->company_job->name}}</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="required-field">Thời gian bắt đầu</label>
                                        <div class="input-group date" id="start_date" data-target-input="nearest">
                                            <input type="text" name="start_date" class="form-control datetimepicker-input" value="{{date('d/m/Y', strtotime($probation->start_date))}}" data-target="#start_date"/>
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
                                            <input type="text" name="end_date" class="form-control datetimepicker-input" value="{{date('d/m/Y', strtotime($probation->end_date))}}" data-target="#end_date"/>
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
            </tr>
          @endforeach
        </tbody>
    </table>

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



