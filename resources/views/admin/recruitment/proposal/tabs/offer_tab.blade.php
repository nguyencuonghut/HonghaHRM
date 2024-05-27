
<!-- Offer chế độ -->
<div class="tab-pane fade" id="custom-tabs-one-profile-7" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-7">
    <h2>{{$proposal->company_job->name}}</h2>
    @foreach ($proposal->candidates as $candidate)
      @php
        $proposal_candidate = App\Models\ProposalCandidate::where('proposal_id', $proposal->id)->where('candidate_id', $candidate->id)->first();
        $second_interview_result = App\Models\SecondInterviewResult::where('proposal_candidate_id', $proposal_candidate->id)->first();
        $offer = App\Models\Offer::where('proposal_candidate_id', $proposal_candidate->id)->first();
      @endphp
      @if ($second_interview_result)
        @if ('Đạt' == $second_interview_result->result)
        <div class="card card-secondary">
            <div class="card-header">
                {{$candidate->name}}
            </div>
            <div class="card-body">
                @if(!$offer)
                  @can('create-offer')
                  <a href="#create_offer{{' . $proposal_candidate->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_offer{{$proposal_candidate->id}}"><i class="fas fa-plus"></i></a>
                  <br>
                  <br>
                  @endcan
                @endif
                <div class="table-responsive">
                    <table id="offer-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Lương hiện tại</th>
                            <th>Lương mong muốn</th>
                            <th>Chi tiết</th>
                            <th>Ghi chú</th>
                            <th>Phản hồi</th>
                            @can('create-offer')
                            <th>Thao tác</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if ($offer)
                          @php
                            $action = '<a href="#edit_offer{{' . $proposal_candidate->id . '}}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit_offer' . $proposal_candidate->id. '"><i class="fas fa-edit"></i></a>
                                    <form style="display:inline" action="'. route("admin.recruitment.offer.destroy", $proposal_candidate->id) . '" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                          @endphp
                          <tr>
                            <td>{{number_format($offer->current_salary, 0, '.', ',')}}<sup>đ</sup></td>
                            <td>{{number_format($offer->desired_salary, 0, '.', ',')}}<sup>đ</sup></td>
                            <td>{!! $offer->detail !!}</td>
                            <td>{!! $offer->note !!}</td>
                            <td>
                                <span class="badge @if ("Đồng ý" == $offer->feedback) badge-success @else badge-danger @endif">{{$offer->feedback}}</span>
                            </td>
                            @can('create-offer')
                            <td>{!! $action !!}</td>
                            @endcan

                            <!-- Modals for edit offer -->
                            <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.offer.update', $proposal_candidate->id) }}" name="update_offer" id="update_offer" novalidate="novalidate">
                                @method('PATCH')
                                {{ csrf_field() }}
                                <div class="modal fade" tabindex="-1" id="edit_offer{{$proposal_candidate->id}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Đề xuất chế độ ứng viên {{$candidate->name}}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="proposal_candidate_id" id="proposal_candidate_id" value="{{$proposal_candidate->id}}">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="required-field" class="control-label">Lương hiện tại</label>
                                                        <div class="controls">
                                                            <input type="number" class="form-control" name="current_salary" id="current_salary" required="" @if ($offer) value="{{$offer->current_salary}}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="required-field" class="control-label">Lương yêu cầu</label>
                                                        <div class="controls">
                                                            <input type="number" class="form-control" name="desired_salary" id="desired_salary" required="" @if ($offer) value="{{$offer->desired_salary}}" @endif>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="control-label">Chi tiết đề xuất</label>
                                                        <div class="controls">
                                                            <textarea type="text" class="form-control" name="detail" id="detail" required="">
                                                                {{$offer->detail}}
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="control-label">Ghi chú</label>
                                                        <div class="controls">
                                                            <input type="text" class="form-control" name="offer_note" id="offer_note" required="" @if ($offer) value="{{$offer->note}}" @endif>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="control-group">
                                                            <div class="control-group">
                                                                <label class="required-field" class="control-label">Phản hồi</label>
                                                                <div class="controls">
                                                                    <select name="feedback" id="feedback" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                                        <option value="Đồng ý" @if ($offer && 'Đồng ý' == $offer->feedback) selected="selected" @endif>Đồng ý</option>
                                                                        <option value="Từ chối" @if ($offer && 'Từ chối' == $offer->feedback) selected="selected" @endif>Từ chối</option>
                                                                    </select>
                                                                </div>
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
                        @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @endif
                    </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modals for create offer -->
        <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.offer.store', $proposal_candidate->id) }}" name="create_offer" id="create_offer" novalidate="novalidate">
            {{ csrf_field() }}
            <div class="modal fade" tabindex="-1" id="create_offer{{$proposal_candidate->id}}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Đề xuất chế độ cho ứng viên {{$candidate->name}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="proposal_candidate_id" id="proposal_candidate_id" value="{{$proposal_candidate->id}}">
                            <div class="row">
                                <div class="col-6">
                                    <label class="required-field" class="control-label">Lương hiện tại</label>
                                    <div class="controls">
                                        <input type="number" class="form-control" name="current_salary" id="current_salary" required="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="required-field" class="control-label">Lương yêu cầu</label>
                                    <div class="controls">
                                        <input type="number" class="form-control" name="desired_salary" id="desired_salary" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label class="control-label">Chi tiết đề xuất</label>
                                    <div class="controls">
                                        <textarea type="text" class="form-control" name="detail" id="detail" required="">
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label class="control-label">Ghi chú</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="offer_note" id="offer_note" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="control-group">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Phản hồi</label>
                                            <div class="controls">
                                                <select name="feedback" id="feedback" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    <option value="Đồng ý">Đồng ý</option>
                                                    <option value="Từ chối">Từ chối</option>
                                                </select>
                                            </div>
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
      @endif
    @endforeach
</div>

@push('scripts')
<script>
    $(function () {
        // Summernote
        $("#detail").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
        $('#detail').summernote({
            height: 90,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
            ]
        });
    });
</script>
@endpush
