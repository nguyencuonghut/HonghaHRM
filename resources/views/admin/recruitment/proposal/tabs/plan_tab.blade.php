<!-- Plan Tab -->
<div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
    <h2>{{$proposal->company_job->name}}</h2>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            @if('Nhân sự' == Auth::user()->role->name
                && !$proposal->plan
                && 'Đã duyệt' == $proposal->status)
                <button type="button" class="btn btn-success float-left" data-toggle="modal" data-target="#create_plan">
                    Tạo
                </button>
            @endif
            @if ($proposal->plan)
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
                    <strong>Ngân sách</strong><br>
                    {{number_format($proposal->plan->budget, 0, '.', ',')}} <sup>đ</sup><br>
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
                    {{date('d/m/Y H:i', strtotime($proposal->plan->created_at))}}<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Người tạo</strong><br>
                    {{$proposal->plan->creator->name}}<br>
                  </address>
                </div>
            </div>

            <hr>
            <div class="row invoice-info">
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <address>
                      <strong>Cách thức</strong><br>
                      @foreach ($proposal->plan->methods as $method)
                      {{$method->name}}<br>
                      @endforeach
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Người phê duyệt</strong><br>
                    @if ($proposal->plan->approver_id)
                      {{$proposal->plan->approver->name}}
                    @endif
                    @if ($proposal->plan->approver_result)
                        @if($proposal->plan->approver_result == 'Đồng ý')
                            <span class="badge badge-success">Đồng ý</span>
                        @else
                            <span class="badge badge-danger">Từ chối</span> <br>
                            @if ($proposal->plan->approver_comment)
                                (<small>{{$proposal->plan->approver_comment}}</small>)
                            @endif
                        @endif
                    @endif
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <address>
                      <strong>Trạng thái</strong><br>
                      @if($proposal->plan->status == 'Mở')
                          <span class="badge badge-primary">Mở</span>
                      @else
                          <span class="badge badge-success">Đã duyệt</span>
                      @endif
                    </address>
                </div>
            </div>
            @endif
        </div>

        <div class="card-footer clearfix">
            @if ('Ban lãnh đạo' == Auth::user()->role->name
                && $proposal->plan)
                <button type="button" class="btn btn-success float-left" data-toggle="modal" data-target="#create_plan_approve">
                    Phê duyệt
                </button>
            @endif
        </div>
    </div>
</div>


<!-- Modals for create plan -->
<form class="form-horizontal" method="post" action="{{ route('admin.recruitment.plans.store') }}" name="make_plan" id="make_plan" novalidate="novalidate">
    {{ csrf_field() }}
    <div class="modal fade" id="create_plan">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="proposal_id" id="proposal_id" value="{{$proposal->id}}">
                    <div class="row">
                        <div class="col-12">
                            <div class="control-group">
                                <label class="required-field" class="control-label">Cách thức tuyển</label>
                                <div class="controls">
                                    <select name="method_id[]" id="method_id[]" data-placeholder="Chọn" class="form-control select2" multiple="multiple" style="width: 100%;">
                                        @foreach($methods as $method)
                                            <option value="{{$method->id}}">{{$method->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="control-group">
                                <label class="control-label">Ngân sách (VNĐ)</label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="budget" id="budget" required="">
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


@if ($proposal->plan)
<!-- Modals for plan approve -->
<form class="form-horizontal" method="post" action="{{ route('admin.recruitment.plans.approve', $proposal->plan->id) }}" name="make_plan_approve" id="make_plan_approve" novalidate="novalidate">
    {{ csrf_field() }}
    <div class="modal fade" id="create_plan_approve">
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
@endif
