<!-- Lọc hồ sơ -->
<div class="tab-pane fade" id="custom-tabs-one-profile-3" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-3">
    <h2>{{$proposal->company_job->name}}</h2>
    <div class="card">
        <div class="card-header">
            Danh sách ứng viên
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
              <table id="candidates-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tên</th>
                  <th>Nơi làm việc</th>
                  <th>Mức lương</th>
                  <th>Ghi chú</th>
                  <th>Kết quả</th>
                  <th>Phản hồi</th>
                  <th>Đợt</th>
                  @can('filter-candidate')
                  <th>Thao tác</th>
                  @endcan
                </tr>
                </thead>

                <tbody>
                    @foreach ($proposal->candidates as $candidate)
                    <tr>
                      <td>
                        <a href="{{route('admin.recruitment.candidates.show', $candidate->id)}}">{{$candidate->name}}</a>
                      </td>
                      @php
                          $proposal_candidate = App\Models\ProposalCandidate::where('proposal_id', $proposal->id)->where('candidate_id', $candidate->id)->first();
                          $filter = App\Models\ProposalCandidateFilter::where('proposal_candidate_id', $proposal_candidate->id)->first();
                          $first_interview_invitation = App\Models\FirstInterviewInvitation::where('proposal_candidate_id', $proposal_candidate->id)->first();
                          if ($filter) {
                            if ('Đạt' == $filter->result) {
                                if ($first_interview_invitation) {
                                    $action = '<a href="#candidate_filter{{' . $proposal_candidate->id . '}}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#candidate_filter' . $proposal_candidate->id. '"><i class="fas fa-filter"></i></a>
                                    <a href="' . route("admin.recruitment.first_interview_invitation.add", $proposal_candidate->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i></a>
                                    <a href="' . route("admin.recruitment.first_interview_invitation.feedback", $proposal_candidate->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-reply"></i></a>';
                                } else {
                                    $action = '<a href="#candidate_filter{{' . $proposal_candidate->id . '}}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#candidate_filter' . $proposal_candidate->id. '"><i class="fas fa-filter"></i></a>
                                    <a href="' . route("admin.recruitment.first_interview_invitation.add", $proposal_candidate->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i></a>';
                                }
                            } else {
                                $action = '<a href="#candidate_filter{{' . $proposal_candidate->id . '}}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#candidate_filter' . $proposal_candidate->id. '"><i class="fas fa-filter"></i></a>';
                            }
                          } else {
                            $action = '<a href="#candidate_filter{{' . $proposal_candidate->id . '}}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#candidate_filter' . $proposal_candidate->id. '"><i class="fas fa-filter"></i></a>';
                          }
                      @endphp
                      @if($filter)
                      <td>
                        {{$filter->work_location}}
                      </td>
                      <td>{{number_format($filter->salary, 0, '.', ',')}} <sup>đ</sup></td>
                      <td>
                        {{$filter->note}}
                        @if ($first_interview_invitation)
                         {{$first_interview_invitation->note}}
                        @endif
                      </td>
                      <td>
                        @if($filter->result == 'Đạt')
                            @if ($first_interview_invitation)
                            <i class="fas fa-check-circle" style="color:green;"></i> <i class="fas fa-envelope" style="color:green;"></i>
                            @else
                            <i class="fas fa-check-circle" style="color:green;"></i>
                            @endif
                        @else
                            <i class="fas fa-times-circle" style="color:red;"></i>
                        @endif
                      </td>
                      <td>
                        @if ($first_interview_invitation)
                            @if ('Đồng ý' == $first_interview_invitation->feedback)
                                <span class="badge badge-success">{{$first_interview_invitation->feedback}}</span>
                            @elseif ('Từ chối' == $first_interview_invitation->feedback)
                                <span class="badge badge-danger">{{$first_interview_invitation->feedback}}</span>
                            @else
                                <span class="badge badge-warning">{{$first_interview_invitation->feedback}}</span>
                            @endif
                        @endif
                      </td>
                      @else
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      @endif
                      <td>{{$proposal_candidate->batch}}</td>
                      @can('filter-candidate')
                      <td>{!! $action !!}</td>
                      @endcan
                    </tr>
                    <!-- Modals for proposal_candidate_filter -->
                    @if ($filter)
                    <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.proposal_candidate_filter.update', $proposal_candidate->id) }}" name="update_proposal_candidate_filter" id="update_proposal_candidate_filter" novalidate="novalidate">
                        @method('PATCH')
                    @else
                    <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.proposal_candidate_filter.store', $proposal_candidate->id) }}" name="create_proposal_candidate_filter" id="create_proposal_candidate_filter" novalidate="novalidate">
                    @endif
                        {{ csrf_field() }}
                        <div class="modal fade" tabindex="-1" id="candidate_filter{{$proposal_candidate->id}}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>Lọc ứng viên</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="proposal_candidate_id" id="proposal_candidate_id" value="{{$proposal_candidate->id}}">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="required-field" class="control-label">Nơi làm việc</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" name="work_location" id="work_location" required="" @if ($filter) value="{{$filter->work_location}}" @endif>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">Lương mong muốn</label>
                                                    <div class="custom-file text-left">
                                                        <input type="number" class="form-control" name="salary" id="salary" required="" @if ($filter) value="{{$filter->salary}}" @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="control-group">
                                                    <label class="control-label">Ghi chú</label>
                                                    <div class="custom-file text-left">
                                                        <input type="text" class="form-control" name="filter_note" id="filter_note" required="" @if ($filter) value="{{$filter->note}}" @endif>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">Kết quả</label>
                                                    <div class="controls">
                                                        <select name="result" id="result" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                            <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                            <option value="Đạt" @if ($filter && 'Đạt' == $filter->result) selected="selected" @endif>Đạt</option>
                                                            <option value="Loại" @if ($filter && 'Loại' == $filter->result) selected="selected" @endif>Loại</option>
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
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
