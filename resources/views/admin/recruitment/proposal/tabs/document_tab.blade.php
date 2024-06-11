<!-- Giấy tờ cần ký -->
<div class="tab-pane fade" id="custom-tabs-one-profile-9" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-9">
    <h2>{{$proposal->company_job->name}}</h2>
    @foreach ($proposal->candidates as $candidate)
      @php
        $proposal_candidate = App\Models\ProposalCandidate::where('proposal_id', $proposal->id)->where('candidate_id', $candidate->id)->first();
        $offer = App\Models\Offer::where('proposal_candidate_id', $proposal_candidate->id)->first();
        $proposal_candidate_documents = App\Models\ProposalCandidateDocument::where('proposal_candidate_id', $proposal_candidate->id)->get();
      @endphp
      @if ($offer)
        @if (null != $offer->result && 'Không đạt' != $offer->result)
        <div class="card card-secondary">
            <div class="card-header">
                {{$candidate->name}}
            </div>
            <div class="card-body">
                  @can('create-document')
                  <a href="#create_document{{' . $proposal_candidate->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_document{{$proposal_candidate->id}}"><i class="fas fa-plus"></i></a>
                  <br>
                  <br>
                  @endcan
                <div class="table-responsive">
                    <table id="document-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên giấy giờ</th>
                            <th>Trạng thái</th>
                            @can('create-document')
                            <th>Thao tác</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                          @foreach ($proposal_candidate_documents as $proposal_candidate_document)
                          <tr>
                            @php
                                $document = App\Models\Document::findOrFail($proposal_candidate_document->document_id);
                                $action_edit_document = '<a href="#edit_document{{' . $proposal_candidate_document->id . '}}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit_document' . $proposal_candidate_document->id. '"><i class="fas fa-edit"></i></a>
                                        <form style="display:inline" action="'. route("admin.recruitment.document.destroy", $proposal_candidate_document->id) . '" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                        <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';

                                $action = '';
                                if (Auth::user()->can('create-document')) {
                                    $action = $action . $action_edit_document;
                                }
                            @endphp
                            <td>{!! $document->name !!}</td>
                            <td>
                                <span class="badge @if ("Đã ký" == $proposal_candidate_document->status) badge-success @else badge-danger @endif">{{$proposal_candidate_document->status}}</span>
                            </td>
                            @can('create-document')
                            <td>{!! $action !!}</td>
                            @endcan

                            <!-- Modals for edit proposal candidate document -->
                            <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.document.update', $proposal_candidate_document->id) }}" name="update_document" id="update_document" novalidate="novalidate">
                                @method('PATCH')
                                {{ csrf_field() }}
                                <div class="modal fade" tabindex="-1" id="edit_document{{$proposal_candidate_document->id}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Giấy tờ cần ký của {{$candidate->name}}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="proposal_candidate_id" id="proposal_candidate_id" value="{{$proposal_candidate->id}}">

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="control-group">
                                                            <div class="control-group">
                                                                <label class="required-field" class="control-label">Tên giấy tờ</label>
                                                                <div class="controls">
                                                                    <select name="document_id" id="document_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                                        @foreach ($documents as $document)
                                                                            <option value="{{$document->id}}" @if ($proposal_candidate_document && $document->id == $proposal_candidate_document->document_id) selected="selected" @endif>{{$document->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="required-field" class="control-label">Trạng thái</label>
                                                        <div class="controls">
                                                            <select name="status" id="status" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                                <option value="Đã ký" @if ($proposal_candidate_document && 'Đã ký' == $proposal_candidate_document->status) selected="selected" @endif>Đã ký</option>
                                                                <option value="Chưa ký" @if ($proposal_candidate_document && 'Chưa ký' == $proposal_candidate_document->status) selected="selected" @endif>Chưa ký</option>
                                                            </select>
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
                </div>
            </div>
        </div>

        <!-- Modals for create proposal candidate document -->
        <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.document.store', $proposal_candidate->id) }}" name="create_document" id="create_document" novalidate="novalidate">
            {{ csrf_field() }}
            <div class="modal fade" tabindex="-1" id="create_document{{$proposal_candidate->id}}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Giấy tờ cần ký của {{$candidate->name}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="proposal_candidate_id" id="proposal_candidate_id" value="{{$proposal_candidate->id}}">
                            <div class="row">
                                <div class="col-12">
                                    <div class="control-group">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Tên giấy tờ</label>
                                            <div class="controls">
                                                <select name="document_id" id="document_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    @foreach ($documents as $document)
                                                        <option value="{{$document->id}}">{{$document->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label class="required-field" class="control-label">Trạng thái</label>
                                    <div class="controls">
                                        <select name="status" id="status" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                            <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                            <option value="Đã ký">Đã ký</option>
                                            <option value="Chưa ký">Chưa ký</option>
                                        </select>
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
