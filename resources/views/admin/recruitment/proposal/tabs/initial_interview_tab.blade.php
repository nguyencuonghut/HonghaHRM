
<!-- Phỏng vấn sơ bộ -->
<div class="tab-pane fade" id="custom-tabs-one-profile-4" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-4">
    <h2>{{$proposal->company_job->name}}</h2>
    <!-- Phỏng vấn sơ bộ -->
    <div class="card card-secondary">
        <div class="card-header">
            Phỏng vấn sơ bộ
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
              <table id="candidates-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tên</th>
                  <th>Sức khỏe, ngoại hình</th>
                  <th>Tính cách, thái độ</th>
                  <th>Mức độ ổn định với công việc</th>
                  <th>Tổng điểm</th>
                  <th>Kết quả</th>
                  @can('initial-interview')
                  <th>Thao tác</th>
                  @endcan
                </tr>
                </thead>

                <tbody>
                    @foreach ($proposal->candidates as $candidate)
                    @php
                        $proposal_candidate = App\Models\ProposalCandidate::where('proposal_id', $proposal->id)->where('candidate_id', $candidate->id)->first();
                        $first_interview_invitation = App\Models\FirstInterviewInvitation::where('proposal_candidate_id', $proposal_candidate->id)->first();
                        $initial_interview = App\Models\InitialInterview::where('proposal_candidate_id', $proposal_candidate->id)->first();
                        if ($initial_interview) {
                            $action = '<a href="#initial_interview{{' . $proposal_candidate->id . '}}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#initial_interview' . $proposal_candidate->id. '"><i class="fas fa-check"></i></a>
                                    <form style="display:inline" action="'. route("admin.recruitment.initial_interview.destroy", $proposal_candidate->id) . '" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                        } else {
                            $action = '<a href="#initial_interview{{' . $proposal_candidate->id . '}}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#initial_interview' . $proposal_candidate->id. '"><i class="fas fa-check"></i></a>';
                        }
                    @endphp
                    @if ($first_interview_invitation)
                      @if ('Từ chối' != $first_interview_invitation->feedback)
                        <tr>
                        <td>
                            <a href="{{route('admin.recruitment.candidates.show', $candidate->id)}}">{{$candidate->name}}</a>
                        </td>
                        @if ($initial_interview)
                        <td>{{$initial_interview->health_comment}} - <span class="badge badge-secondary">{{$initial_interview->health_score}}</span></td>
                        <td>{{$initial_interview->attitude_comment}} - <span class="badge badge-secondary">{{$initial_interview->attitude_score}}</span></td>
                        <td>{{$initial_interview->stability_comment}} - <span class="badge badge-secondary">{{$initial_interview->stability_score}}</span></td>
                        <td><span class="badge badge-secondary">{{$initial_interview->total_score}}</span></td>
                        <td>
                            @if('Đạt' == $initial_interview->result)
                              <span class="badge badge-success">{{$initial_interview->result}}</span>
                            @else
                              <span class="badge badge-danger">{{$initial_interview->result}}</span>
                            @endif
                        </td>
                        @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @endif
                        @can('initial-interview')
                        <td>{!! $action !!}</td>
                        @endcan
                        </tr>
                        @endif

                        <!-- Modals for intial_interview -->
                        @if ($initial_interview)
                        <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.initial_interview.update', $proposal_candidate->id) }}" name="update_initial_interview" id="update_initial_interview" novalidate="novalidate">
                            @method('PATCH')
                        @else
                        <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.initial_interview.store', $proposal_candidate->id) }}" name="create_initial_interview" id="create_initial_interview" novalidate="novalidate">
                        @endif
                            {{ csrf_field() }}
                            <div class="modal fade" tabindex="-1" id="initial_interview{{$proposal_candidate->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Phỏng vấn sơ bộ</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="proposal_candidate_id" id="proposal_candidate_id" value="{{$proposal_candidate->id}}">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="control-label">Sức khỏe, ngoại hình</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" name="health_comment" id="health_comment" required="" @if ($initial_interview) value="{{$initial_interview->health_comment}}" @endif>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="control-group">
                                                        <div class="control-group">
                                                            <label class="control-label">Điểm</label>
                                                            <div class="controls">
                                                                <select name="health_score" id="health_score" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                                    <option value="1" @if ($initial_interview && 1 == $initial_interview->health_score) selected="selected" @endif>1</option>
                                                                    <option value="2" @if ($initial_interview && 2 == $initial_interview->health_score) selected="selected" @endif>2</option>
                                                                    <option value="3" @if ($initial_interview && 3 == $initial_interview->health_score) selected="selected" @endif>3</option>
                                                                    <option value="4" @if ($initial_interview && 4 == $initial_interview->health_score) selected="selected" @endif>4</option>
                                                                    <option value="5" @if ($initial_interview && 5 == $initial_interview->health_score) selected="selected" @endif>5</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="control-label">Tính cách, thái độ</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" name="attitude_comment" id="attitude_comment" required="" @if ($initial_interview) value="{{$initial_interview->attitude_comment}}" @endif>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="control-group">
                                                        <label class="required-field" class="control-label">Điểm</label>
                                                        <div class="controls">
                                                            <select name="attitude_score" id="attitude_score" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                                <option value="1" @if ($initial_interview && 1 == $initial_interview->attitude_score) selected="selected" @endif>1</option>
                                                                <option value="2" @if ($initial_interview && 2 == $initial_interview->attitude_score) selected="selected" @endif>2</option>
                                                                <option value="3" @if ($initial_interview && 3 == $initial_interview->attitude_score) selected="selected" @endif>3</option>
                                                                <option value="4" @if ($initial_interview && 4 == $initial_interview->attitude_score) selected="selected" @endif>4</option>
                                                                <option value="5" @if ($initial_interview && 5 == $initial_interview->attitude_score) selected="selected" @endif>5</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="control-label">Mức độ ổn định</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" name="stability_comment" id="stability_comment" required="" @if ($initial_interview) value="{{$initial_interview->stability_comment}}" @endif>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="control-group">
                                                        <label class="required-field" class="control-label">Điểm</label>
                                                        <div class="controls">
                                                            <select name="stability_score" id="stability_score" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                                <option value="1" @if ($initial_interview && 1 == $initial_interview->stability_score) selected="selected" @endif>1</option>
                                                                <option value="2" @if ($initial_interview && 2 == $initial_interview->stability_score) selected="selected" @endif>2</option>
                                                                <option value="3" @if ($initial_interview && 3 == $initial_interview->stability_score) selected="selected" @endif>3</option>
                                                                <option value="4" @if ($initial_interview && 4 == $initial_interview->stability_score) selected="selected" @endif>4</option>
                                                                <option value="5" @if ($initial_interview && 5 == $initial_interview->stability_score) selected="selected" @endif>5</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="control-label">Người phỏng vấn</label>
                                                    <div class="controls">
                                                        <select name="interviewer_id" id="interviewer_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                            <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                            @foreach ($hr_admins as $hr_admin)
                                                            <option value="{{$hr_admin->id}}" @if ($initial_interview && $hr_admin->id == $initial_interview->interviewer_id) selected="selected" @endif>{{$hr_admin->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="control-group">
                                                        <label class="required-field" class="control-label">Kết quả</label>
                                                        <div class="controls">
                                                            <select name="result" id="result" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                                <option value="Đạt" @if ($initial_interview && 'Đạt' == $initial_interview->result) selected="selected" @endif>Đạt</option>
                                                                <option value="Không đạt" @if ($initial_interview && 'Không đạt' == $initial_interview->result) selected="selected" @endif>Không đạt</option>
                                                            </select>
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

                    @endif
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>

    <!-- Thi tuyển -->
    <div class="card card-secondary">
        <div class="card-header">
            Thi tuyển
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
              <table id="exams-result-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tên</th>
                  <th>Điểm</th>
                  <th>Kết quả</th>
                  @can('initial-interview')
                  <th>Thao tác</th>
                  @endcan
                </tr>
                </thead>

                <tbody>
                    @foreach ($proposal->candidates as $candidate)
                    @php
                        $proposal_candidate = App\Models\ProposalCandidate::where('proposal_id', $proposal->id)->where('candidate_id', $candidate->id)->first();
                        $first_interview_invitation = App\Models\FirstInterviewInvitation::where('proposal_candidate_id', $proposal_candidate->id)->first();
                        $exam = App\Models\Examination::where('proposal_candidate_id', $proposal_candidate->id)->first();
                        if ($exam) {
                            $action = '<a href="#exam{{' . $proposal_candidate->id . '}}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exam' . $proposal_candidate->id. '"><i class="fas fa-check"></i></a>
                                    <form style="display:inline" action="'. route("admin.recruitment.exam.destroy", $proposal_candidate->id) . '" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                        } else {
                            $action = '<a href="#exam{{' . $proposal_candidate->id . '}}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exam' . $proposal_candidate->id. '"><i class="fas fa-check"></i></a>';
                        }
                    @endphp
                    @if ($first_interview_invitation)
                      @if ('Từ chối' != $first_interview_invitation->feedback)
                        <tr>
                        <td>
                            <a href="{{route('admin.recruitment.candidates.show', $candidate->id)}}">{{$candidate->name}}</a>
                        </td>
                        @if($exam)
                        <td>
                            {{$exam->candidate_score}}/{{$exam->standard_score}}
                        </td>
                        <td>
                            @if('Đạt' == $exam->result)
                              <span class="badge badge-success">{{$exam->result}}</span>
                            @else
                              <span class="badge badge-danger">{{$exam->result}}</span>
                            @endif
                        </td>
                        @else
                        <td></td>
                        <td></td>
                        @endif
                        @can('create-exams-result')
                        <td>{!! $action !!}</td>
                        @endcan
                        </tr>
                        @endif

                        <!-- Modals for examination -->
                        @if ($exam)
                        <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.exam.update', $proposal_candidate->id) }}" name="update_exam_result" id="update_exam_result" novalidate="novalidate">
                            @method('PATCH')
                        @else
                        <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.exam.store', $proposal_candidate->id) }}" name="create_exam_result" id="create_exam_result" novalidate="novalidate">
                        @endif
                            {{ csrf_field() }}
                            <div class="modal fade" tabindex="-1" id="exam{{$proposal_candidate->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Thi tuyển</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="proposal_candidate_id" id="proposal_candidate_id" value="{{$proposal_candidate->id}}">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="required-field" class="control-label">Điểm chuẩn</label>
                                                    <div class="controls">
                                                        <input type="number" class="form-control" name="standard_score" id="standard_score" required="" @if ($exam) value="{{$exam->standard_score}}" @endif>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="required-field" class="control-label">Điểm thi</label>
                                                    <div class="controls">
                                                        <input type="number" class="form-control" name="candidate_score" id="candidate_score" required="" @if ($exam) value="{{$exam->candidate_score}}" @endif>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="control-group">
                                                        <label class="required-field" class="control-label">Kết quả</label>
                                                        <div class="controls">
                                                            <select name="result" id="result" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                                <option value="Đạt" @if ($exam && 'Đạt' == $exam->result) selected="selected" @endif>Đạt</option>
                                                                <option value="Không đạt" @if ($exam && 'Không đạt' == $exam->result) selected="selected" @endif>Không đạt</option>
                                                            </select>
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

                    @endif
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
