@section('title')
{{ 'Chi tiết đề xuất' }}
@endsection

@push('styles')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
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
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Kế hoạch</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab-1" data-toggle="pill" href="#custom-tabs-one-profile-1" role="tab" aria-controls="custom-tabs-one-profile-1" aria-selected="false">Đăng tin</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab-2" data-toggle="pill" href="#custom-tabs-one-profile-2" role="tab" aria-controls="custom-tabs-one-profile-2" aria-selected="false">Ứng viên</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab-3" data-toggle="pill" href="#custom-tabs-one-profile-3" role="tab" aria-controls="custom-tabs-one-profile-3" aria-selected="false">Lọc hồ sơ</a>
                          </li>
                        </ul>
                      </div>
                      <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
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

                            <!-- Candidate Tab -->
                            <div class="tab-pane fade" id="custom-tabs-one-profile-2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-2">
                                <h2>{{$proposal->company_job->name}}</h2>
                                <div class="card">
                                    <div class="card-header">
                                        Danh sách ứng viên
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        @if('Nhân sự' == Auth::user()->role->name
                                            && $proposal->announcement)
                                                <button type="button" class="btn btn-success float-left" data-toggle="modal" data-target="#add_proposal_candidate">
                                                    Thêm
                                                </button>
                                        @endif
                                        <br>
                                        <br>
                                        <div class="table-responsive">
                                          <table id="candidates-table" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                              <th style="width: 12%;">Tên</th>
                                              <th style="width: 12%;">Email</th>
                                              <th>Điện thoại</th>
                                              <th>Ngày sinh</th>
                                              <th>CCCD</th>
                                              <th>Địa chỉ</th>
                                              <th>CV</th>
                                              <th>Đợt</th>
                                              <th>Thao tác</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($proposal->candidates as $candidate)
                                                <tr>
                                                  <td>
                                                    <a href="{{route('admin.recruitment.candidates.show', $candidate->id)}}">{{$candidate->name}}</a>
                                                  </td>
                                                  <td>{{$candidate->email}}</td>
                                                  <td>{{$candidate->phone}}</td>
                                                  <td>{{ date('d/m/Y', strtotime($candidate->date_of_birth)) }}</td>
                                                  <td>{{$candidate->cccd}}</td>
                                                  <td>{{$candidate->commune->name}} - {{$candidate->commune->district->name}} - {{$candidate->commune->district->province->name}}</td>
                                                  @php
                                                      $proposal_candidate = App\Models\ProposalCandidate::where('proposal_id', $proposal->id)->where('candidate_id', $candidate->id)->first();
                                                      $url = '<a target="_blank" href="../../../' . $proposal_candidate->cv_file . '"><i class="far fa-file-pdf"></i></a>';
                                                      $action = '<a href="#edit{{' . $proposal_candidate->id . '}}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $proposal_candidate->id. '"><i class="fas fa-edit"></i></a>
                                                                    <form style="display:inline" action="'. route("admin.recruitment.proposal_candidates.destroy", $proposal_candidate->id) . '" method="POST">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                                                <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                                                  @endphp
                                                  <td>{!! $url !!}</td>
                                                  <td>{{$proposal_candidate->batch}}</td>
                                                  <td>{!! $action !!}</td>
                                                </tr>
                                                <!-- Modals for edit proposal_candidate -->
                                                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('admin.recruitment.proposal_candidates.update', $proposal_candidate->id) }}" name="update_proposal_candidate" id="update_proposal_candidate" novalidate="novalidate">
                                                    {{ csrf_field() }}
                                                    @method('PATCH')
                                                    <div class="modal fade" tabindex="-1" id="edit{{$proposal_candidate->id}}">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4>Sửa ứng viên</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="proposal_id" id="proposal_id" value="{{$proposal->id}}">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label class="required-field" class="control-label">Chọn ứng viên</label>
                                                                            <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#create_candidate">
                                                                                <i class="fas fa-plus"></i>
                                                                            </button>
                                                                            <div class="controls">
                                                                                <select name="candidate_id" id="candidate_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                                                    @foreach($candidates as $candidate)
                                                                                        <option value="{{$candidate->id}}" @if ($candidate->id == $proposal_candidate->candidate_id) selected @endif>{{$candidate->name}} - {{$candidate->email}} - CCCD {{$candidate->cccd}}</option>
                                                                                    @endforeach
                                                                                </select>
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
                                                                                <label class="required-field" class="control-label">Nguồn tin</label>
                                                                                <div class="controls">
                                                                                    <select name="cv_receive_method_id" id="cv_receive_method_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                                                        @foreach ($receive_methods as $receive_method)
                                                                                            <option value="{{$receive_method->id}}" @if ($receive_method->id == $proposal_candidate->cv_receive_method_id) selected @endif>{{$receive_method->name}}</option>
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
                                                                                        <option value="Đợt 1" @if ('Đợt 1' == $proposal_candidate->batch) selected @endif>Đợt 1</option>
                                                                                        <option value="Đợt 2" @if ('Đợt 2' == $proposal_candidate->batch) selected @endif>Đợt 2</option>
                                                                                        <option value="Đợt 3" @if ('Đợt 3' == $proposal_candidate->batch) selected @endif>Đợt 3</option>
                                                                                        <option value="Đợt 4" @if ('Đợt 4' == $proposal_candidate->batch) selected @endif>Đợt 4</option>
                                                                                        <option value="Đợt 5" @if ('Đợt 5' == $proposal_candidate->batch) selected @endif>Đợt 5</option>
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

              <!-- Modals for create proposal_candidate -->
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('admin.recruitment.proposal_candidates.store') }}" name="create_proposal_candidate" id="create_proposal_candidate" novalidate="novalidate">
                    {{ csrf_field() }}
                    <div class="modal fade" id="add_proposal_candidate">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Thêm ứng viên</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="proposal_id" id="proposal_id" value="{{$proposal->id}}">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="required-field" class="control-label">Nhập ứng viên</label>
                                            <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#create_candidate">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <div class="controls">
                                                <select name="candidate_id" id="candidate_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    @foreach($candidates as $candidate)
                                                        <option value="{{$candidate->id}}">{{$candidate->name}} - {{$candidate->email}} - {{$candidate->phone}}</option>
                                                    @endforeach
                                                </select>
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
                                                <label class="required-field" class="control-label">Nguồn tin</label>
                                                <div class="controls">
                                                    <select name="cv_receive_method_id" id="cv_receive_method_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                        @foreach ($receive_methods as $receive_method)
                                                            <option value="{{$receive_method->id}}">{{$receive_method->name}}</option>
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
              <!-- /.modal -->

            <!-- Modals for create candiate -->
            <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.candidates.store') }}" enctype="multipart/form-data" name="make_candidate" id="make_candidate" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="create_candidate">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Tạo mới ứng viên</h4>
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
                                        <div class="control-group">
                                            <label class="control-label">Số điện thoại người thân</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="relative_phone" id="relative_phone" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <label class="required-field">Ngày sinh</label>
                                        <div class="input-group date" id="date_of_birth" data-target-input="nearest">
                                            <input type="text" name="date_of_birth" class="form-control datetimepicker-input" data-target="#date_of_birth"/>
                                            <div class="input-group-append" data-target="#date_of_birth" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="control-label">CCCD</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="cccd" id="cccd" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="control-label">Ngày cấp</label>
                                        <div class="input-group date" id="issued_date" data-target-input="nearest">
                                            <input type="text" name="issued_date" class="form-control datetimepicker-input" data-target="#issued_date"/>
                                            <div class="input-group-append" data-target="#issued_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="control-label">Nơi cấp</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="issued_by" id="issued_by" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Địa chỉ</label>
                                            <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_commune">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <div class="controls">
                                                <select name="commune_id" id="commune_id" data-placeholder="Chọn địa chỉ" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
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
                                        <label class="required-field" class="control-label">Trình độ</label>
                                        <table class="table table-bordered" id="dynamicTable">
                                            <tr>
                                                <th class="required-field" style="width: 50%;">
                                                    Trường
                                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#make_education">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </th>
                                                <th>Ngành</th>
                                                <th style="width: 14%;">Thao tác</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select name="addmore[0][education_id]" class="form-control select2" style="width: 100%;">
                                                        <option selected="selected" disabled>Chọn trường</option>
                                                        @foreach($educations as $education)
                                                            <option value="{{$education->id}}">{{$education->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="text" name="addmore[0][major]" placeholder="Ngành" class="form-control" /></td>
                                                <td><button type="button" name="add_education" id="add_education" class="btn btn-success"><i class="fas fa-plus"></i></button></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label class="required-field" class="control-label">Kinh nghiệm</label>
                                        <textarea id="experience" name="experience">
                                        </textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label class="control-label">Ghi chú</label>
                                        <textarea id="note" name="note">
                                        </textarea>
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

            <!-- Modals for make education -->
            <form class="form-horizontal" method="post" action="{{ route('admin.educations.store') }}" name="create_education" id="create_education" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal fade" id="make_education">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Thêm trường</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Tên trường</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="name" id="name" required="">
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
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
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

        var i = 0;
        $("#add_education").click(function(){
            ++i;
            $("#dynamicTable").append('<tr><td><select name="addmore['+i+'][education_id]" class="form-control select2" style="width: 100%;"><option selected="selected" disabled>Chọn trường</option>@foreach($educations as $education)<option value="{{$education->id}}">{{$education->name}}</option>@endforeach</select></td><td><input type="text" name="addmore['+i+'][major]" placeholder="Ngành" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="fas fa-trash-alt"></i></button></td></tr>');

            //Reinitialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            })
        });

        $(document).on('click', '.remove-tr', function(){
            $(this).parents('tr').remove();
        });

        // Summernote
        $("#experience").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
        $("#note").on("summernote.enter", function(we, e) {
            $(this).summernote("pasteHTML", "<br><br>");
            e.preventDefault();
        });
        $('#experience').summernote({
            height: 90,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
            ]
        });
        $('#note').summernote({
            height: 50,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
            ]
        });
    })
</script>
@endpush
