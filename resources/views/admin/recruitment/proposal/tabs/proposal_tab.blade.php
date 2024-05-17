<!-- Proposal Tab -->
<div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
    <h2>{{$proposal->company_job->name}}</h2>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Phòng ban</strong><br>
                    @if ($proposal->company_job->division_id)
                        {{$proposal->company_job->division->name}}<br>
                    @endif
                    {{$proposal->company_job->department->name}}<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Số lượng</strong><br>
                    {{$proposal->quantity}}<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Thời gian cần</strong><br>
                    {{date('d/m/Y', strtotime($proposal->work_time))}}<br>
                  </address>
                </div>
            </div>
            <hr>

            <div class="row invoice-info">
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Lý do</strong><br>
                    {!! $proposal->reason !!}<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Yêu cầu</strong><br>
                    {!! $proposal->requirement !!}<br>
                  </address>
                </div>
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Mức lương</strong><br>
                    @if ($proposal->salary)
                        {{number_format($proposal->salary, 0, '.', ',')}} <sup>đ</sup><br>
                    @endif
                  </address>
                </div>
            </div>
            <!-- /.row -->

            <hr>
            <div class="row invoice-info">
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Ghi chú</strong><br>
                    {!!$proposal->note!!}<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Thời gian tạo</strong><br>
                    {{date('d/m/Y H:i', strtotime($proposal->created_at))}}<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Người tạo</strong><br>
                    {{$proposal->creator->name}}<br>
                  </address>
                </div>
            </div>

            <hr>
            <div class="row invoice-info">
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Trạng thái</strong><br>
                    @if($proposal->status == 'Mở')
                        <span class="badge badge-primary">Mở</span>
                    @elseif($proposal->status == 'Đã kiểm tra')
                        <span class="badge badge-warning">Đã kiểm tra</span>
                    @else
                        <span class="badge badge-success">Đã duyệt</span>
                    @endif
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Người kiểm tra</strong><br>
                    @if ($proposal->reviewer_id)
                      {{$proposal->reviewer->name}}
                    @endif
                    @if ($proposal->reviewer_result)
                        @if($proposal->reviewer_result == 'Đồng ý')
                            <span class="badge badge-success">Đồng ý</span>
                        @else
                            <span class="badge badge-danger">Từ chối</span> <br>
                            @if ($proposal->reviewer_comment)
                                (<small>{{$proposal->reviewer_comment}}</small>)
                            @endif
                        @endif
                    @endif
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Người phê duyệt</strong><br>
                    @if ($proposal->approver_id)
                      {{$proposal->approver->name}}
                    @endif
                    @if ($proposal->approver_result)
                        @if($proposal->approver_result == 'Đồng ý')
                            <span class="badge badge-success">Đồng ý</span>
                        @else
                            <span class="badge badge-danger">Từ chối</span> <br>
                            @if ($proposal->approver_comment)
                                (<small>{{$proposal->approver_comment}}</small>)
                            @endif
                        @endif
                    @endif
                  </address>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            @if (('Mở' == $proposal->status || 'Đã kiểm tra' == $proposal->status)
                && 'Nhân sự' == Auth::user()->role->name)
                <button type="button" class="btn btn-success float-left" data-toggle="modal" data-target="#create_review">
                    Kiểm tra
                </button>
            @endif
            @if (('Đã kiểm tra' == $proposal->status || 'Đã duyệt' == $proposal->status)
                && 'Ban lãnh đạo' == Auth::user()->role->name
                && !$proposal->plan)
                <button type="button" class="btn btn-success float-left" data-toggle="modal" data-target="#create_approve">
                    Phê duyệt
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Modals for review-->
<form class="form-horizontal" method="post" action="{{ route('admin.recruitment.proposals.review', $proposal->id) }}" name="make_review" id="make_review" novalidate="novalidate">
    {{ csrf_field() }}
    <div class="modal fade" id="create_review">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="control-group">
                                <label class="required-field" class="control-label">Kết quả</label>
                                <div class="controls">
                                    <select name="reviewer_result" id="reviewer_result" class="form-control" style="width: 100%;">
                                        <option disabled="disabled" selected="selected" disabled>-- Chọn --</option>
                                            <option value="Đồng ý">Đồng ý</option>
                                            <option value="Từ chối">Từ chối</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="control-group">
                                <label class="control-label">Giải thích</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="reviewer_comment" id="reviewer_comment" required="">
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

<!-- Modals for proposal approve -->
<form class="form-horizontal" method="post" action="{{ route('admin.recruitment.proposals.approve', $proposal->id) }}" name="make_approve" id="make_approve" novalidate="novalidate">
    {{ csrf_field() }}
    <div class="modal fade" id="create_approve">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="control-group">
                                <label class="required-field" class="control-label">Kết quả</label>
                                <div class="controls">
                                    <select name="approver_result" id="approver_result" class="form-control" style="width: 100%;">
                                        <option disabled="disabled" selected="selected" disabled>-- Chọn --</option>
                                            <option value="Đồng ý">Đồng ý</option>
                                            <option value="Từ chối">Từ chối</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="control-group">
                                <label class="control-label">Giải thích</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="approver_comment" id="approver_comment" required="">
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
