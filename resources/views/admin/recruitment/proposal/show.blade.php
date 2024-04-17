@section('title')
{{ 'Chi tiết đề xuất' }}
@endsection


@extends('layouts.base')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Chi tiết đề xuất</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.recruitment.proposals.index') }}">Tất cả đề xuất</a></li>
              <li class="breadcrumb-item active">Chi tiết</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card card-secondary card-outline card-tabs">
                      <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Chi tiết</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Kế hoạch</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab-1" data-toggle="pill" href="#custom-tabs-one-profile-1" role="tab" aria-controls="custom-tabs-one-profile-1" aria-selected="false">Đăng tin</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab-2" data-toggle="pill" href="#custom-tabs-one-profile-2" role="tab" aria-controls="custom-tabs-one-profile-2" aria-selected="false">Ứng viên</a>
                          </li>
                        </ul>
                      </div>
                      <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade" id="custom-tabs-one-profile-2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-2">
                                <h2>{{$proposal->job->name}}</h2>
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                      {{$proposal->creator->name}}
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-one-profile-1" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-1">
                                <h2>{{$proposal->job->name}}</h2>
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                      {{$proposal->job->department->name}}
                                    </div>
                                  </div>
                            </div>

                          <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                            <h2>{{$proposal->job->name}}</h2>
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                          <address>
                                            <strong>Phòng ban</strong><br>
                                            @if ($proposal->job->division_id)
                                                {{$proposal->job->division->name}}<br>
                                            @endif
                                            {{$proposal->job->department->name}}<br>
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
                                            {{number_format($proposal->salary, 0, '.', ',')}} <sup>đ</sup><br>
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
                                    </div>

                                    <hr>
                                    <div class="row invoice-info">
                                        <!-- /.col -->
                                        <div class="col-sm-4 invoice-col">
                                          <address>
                                            <strong>Người tạo</strong><br>
                                            {{$proposal->creator->name}}<br>
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
                                              {{$proposal->approver->name}}<br>
                                            @endif
                                          </address>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    @if (('Mở' == $proposal->status || 'Đã kiểm tra' == $proposal->status)
                                        && 'Nhân Sự' == Auth::user()->role->name)
                                        <button type="button" class="btn btn-success float-left" data-toggle="modal" data-target="#create_review">
                                        Kiểm tra
                                    </button>
                                    @endif
                                    <a href="#">
                                        <button role="button" type="button" class="btn btn-success float-right"> Phê duyệt</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                            <h2>{{$proposal->job->name}}</h2>
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                          {{$proposal->salary}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                      <!-- /.card -->
                    </div>
                  </div>
            </div>

            <!-- Modals -->
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
                                                <select name="reviewer_result" id="approve_result" class="form-control" style="width: 100%;">
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
        </div>
    </section>
</div>
@endsection
