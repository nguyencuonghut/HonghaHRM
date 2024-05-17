<!-- Announcement Tab -->
<div class="tab-pane fade" id="custom-tabs-one-profile-1" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-1">
    <h2>{{$proposal->company_job->name}}</h2>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            @if('Nhân sự' == Auth::user()->role->name
                && !$proposal->announcement
                && $proposal->plan)
                <button type="button" class="btn btn-success float-left" data-toggle="modal" data-target="#create_announcement">
                    Tạo
                </button>
            @endif
            @if ($proposal->announcement)
            <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                <address>
                    <strong>Kênh đã đăng</strong><br>
                    @foreach ($proposal->announcement->social_media as $item)
                        {{$item->name}}<br>
                    @endforeach
                </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                <address>
                    <strong>Trạng thái</strong><br>
                    <span class="badge badge-success">{{$proposal->announcement->status}}<br></span>
                </address>
                </div>
                <!-- /.col -->
            </div>
            @endif
        </div>
      </div>
</div>


<!-- Modals for create announcement -->
<form class="form-horizontal" method="post" action="{{ route('admin.recruitment.announcements.store') }}" name="make_announcement" id="make_announcement" novalidate="novalidate">
    {{ csrf_field() }}
    <div class="modal fade" id="create_announcement">
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
                                <label class="required-field" class="control-label">Kênh đã đăng</label>
                                <div class="controls">
                                    <select name="social_media_id[]" id="social_media_id[]" data-placeholder="Chọn" class="form-control select2" multiple="multiple" style="width: 100%;">
                                        @foreach($social_media as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
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

