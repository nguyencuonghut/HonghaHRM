@section('title')
{{ 'Chi tiết đề xuất' }}
@endsection

@push('styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endpush

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
                          @if ('Đã duyệt' == $proposal->status)
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Kế hoạch</a>
                          </li>
                          @endif
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
                            <!-- Candidate Tab -->
                            <div class="tab-pane fade" id="custom-tabs-one-profile-2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-2">
                                <h2>{{$proposal->company_job->name}}</h2>
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        @if('Nhân Sự' == Auth::user()->role->name
                                        && $proposal->announcement)
                                            <button type="button" class="btn btn-success float-left" data-toggle="modal" data-target="#create_candidate">
                                                Tạo
                                            </button>
                                            <br>
                                            <br>
                                        @endif
                                        @php
                                            $candidates = App\Models\RecruitmentCandidate::where('proposal_id', $proposal->id)->get();
                                        @endphp
                                        @if ($candidates->count())
                                          <table id="candidates-table" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                              <th>STT</th>
                                              <th style="width: 12%;">Tên</th>
                                              <th style="width: 12%;">Email</th>
                                              <th>Số điện thoại</th>
                                              <th>Ngày sinh</th>
                                              <th>Địa chỉ</th>
                                              <th>CV</th>
                                              <th>Thao tác</th>
                                            </tr>
                                            </thead>
                                          </table>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Announcement Tab -->
                            <div class="tab-pane fade" id="custom-tabs-one-profile-1" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-1">
                                <h2>{{$proposal->company_job->name}}</h2>
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        @if('Nhân Sự' == Auth::user()->role->name
                                            && !$proposal->announcement)
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
                                        && 'Nhân Sự' == Auth::user()->role->name)
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

                        <!-- Plan Tab -->
                        @if ('Đã duyệt' == $proposal->status)
                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                            <h2>{{$proposal->company_job->name}}</h2>
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    @if('Nhân Sự' == Auth::user()->role->name
                                        && !$proposal->plan)
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
                        @endif
                      </div>
                      <!-- /.card -->
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
                                                    @foreach($methods as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
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

            <!-- Modals for create candiate -->
            <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.candidates.store') }}" enctype="multipart/form-data" name="make_candidate" id="make_candidate" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="create_candidate">
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
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Họ tên</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="name" id="name" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Email</label>
                                            <div class="controls">
                                                <input type="email" class="form-control" name="email" id="email" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Số điện thoại</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="phone" id="phone" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="required-field">Ngày sinh</label>
                                        <div class="input-group date" id="date_of_birth" data-target-input="nearest">
                                            <input type="text" name="date_of_birth" class="form-control datetimepicker-input" data-target="#date_of_birth"/>
                                            <div class="input-group-append" data-target="#date_of_birth" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">CCCD</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="cccd" id="cccd" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="required-field">Ngày cấp</label>
                                        <div class="input-group date" id="issued_date" data-target-input="nearest">
                                            <input type="text" name="issued_date" class="form-control datetimepicker-input" data-target="#issued_date"/>
                                            <div class="input-group-append" data-target="#issued_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Nơi cấp</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="issued_by" id="issued_by" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Giới tính</label>
                                            <div class="controls">
                                                <select name="gender" id="gender" data-placeholder="Chọn giới tính" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    <option value="Nam">Nam</option>
                                                    <option value="Nữ">Nữ</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Địa chỉ</label>
                                            <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_commune">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <div class="controls">
                                                <select name="commune_id" id="commune_id" data-placeholder="Chọn địa chỉ" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn địa chỉ --" disabled="disabled" selected="selected">-- Chọn địa chỉ --</option>
                                                    @foreach($communes as $commune)
                                                        <option value="{{$commune->id}}">{{$commune->name}} - {{$commune->district->name}} - {{$commune->district->province->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">CV</label>
                                            <div class="custom-file text-left">
                                                <input type="file" name="cv_file" accept="application/pdf" class="custom-file-input" id="cv_file">
                                                <label class="custom-file-label" for="cv_file">Chọn file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Nhận CV qua</label>
                                            <div class="controls">
                                                <select name="receive_method" id="receive_method" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    @foreach ($receive_methods as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Đợt</label>
                                            <div class="controls">
                                                <select name="batch" id="batch" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    <option value="Đợt 1">Đợt 1</option>
                                                    <option value="Đợt 2">Đợt 2</option>
                                                    <option value="Đợt 3">Đợt 3</option>
                                                    <option value="Đợt 4">Đợt 4</option>
                                                    <option value="Đợt 5">Đợt 5</option>
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

            <!-- Modals for create commune -->
            <form class="form-horizontal" method="post" action="{{ route('admin.communes.store') }}" name="create_commune" id="create_commune" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="add_commune">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Thêm xã/phường</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Tên xã/phường</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="name" id="name" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Thuộc quận/huyện </label>
                                            <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_district">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <div class="controls">
                                                <select name="district_id" id="district_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn quận/huyện --" disabled="disabled" selected="selected">-- Chọn quận/huyện --</option>
                                                    @foreach($districts as $district)
                                                        <option value="{{$district->id}}">{{$district->name}} - {{$district->province->name}}</option>
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
              <!-- /.modal -->


              <!-- Modals for create district -->
              <form class="form-horizontal" method="post" action="{{ route('admin.districts.store') }}" name="create_district" id="create_district" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="add_district">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Thêm Quận Huyện</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Tên quận/huyện</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="name" id="name" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Thuộc tỉnh </label>
                                            <div class="controls">
                                                <select name="province_id" id="province_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn tỉnh --" disabled="disabled" selected="selected">-- Chọn tỉnh --</option>
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->id}}">{{$province->name}}</option>
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
              <!-- /.modal -->

        </div>
    </section>
</div>
@endsection


@push('scripts')
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>


<style type="text/css">
    .dataTables_wrapper .dt-buttons {
    margin-bottom: -3em
  }
</style>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
        theme: 'bootstrap4'
        })

        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        //Date picker
        $('#date_of_birth').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#issued_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        $("#candidates-table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            buttons: [
                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }

                },
                {
                    extend: 'excel',
                    footer: true,
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                },
                {
                    extend: 'colvis',
                    footer: true,
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                }
            ],
            dom: 'Blfrtip',
            ajax: ' {!! route('admin.recruitment.candidates.data', $proposal->id) !!}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'date_of_birth', name: 'date_of_birth'},
                {data: 'addr', name: 'addr'},
                {data: 'cv_file', name: 'cv_file'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ]
        }).buttons().container().appendTo('#candidates-table_wrapper .col-md-6:eq(0)');
    })
</script>
@endpush
