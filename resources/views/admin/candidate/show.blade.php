@section('title')
{{ 'Chi tiết ứng viên' }}
@endsection

@extends('layouts.base')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Chi tiết {{$candidate->name}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.recruitment.candidates.index') }}">Tất cả ứng viên</a></li>
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
            <div class="col-md-4">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">

                    <h3 class="profile-username text-center">{{$candidate->name}}</h3>

                    <p class="text-muted text-center">{{$candidate->email}}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b class="float-left">Điện thoại</b> <a class="float-right">{{$candidate->phone}}</a>
                        </li>
                        <li class="list-group-item">
                            <b class="float-left">Ngày sinh</b> <a class="float-right">{{date('d/m/Y', strtotime($candidate->date_of_birth))}}</a>
                        </li>
                        <li class="list-group-item">
                            <b class="float-left">CCCD</b> <a class="float-right">{{$candidate->cccd}}</a>
                        </li>
                        <li class="list-group-item">
                            <b class="float-left">Địa chỉ</b> <a class="float-right">{{$candidate->commune->name}} - {{$candidate->commune->district->name}} - {{$candidate->commune->district->province->name}}</a>
                        </li>
                        <li class="list-group-item">
                            <b class="float-left">Trình độ</b>
                            <a class="float-right">
                                @php
                                    $educations_info = '';

                                    foreach ($candidate->educations as $education) {
                                        $candidate_education = App\Models\CandidateEducation::where('candidate_id', $candidate->id)->where('education_id', $education->id)->first();
                                        $educations_info = $educations_info . $education->name . ' - ' . $candidate_education->major . '<br>';

                                    }
                                @endphp
                                {!! $educations_info !!}
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
                </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-8">
                <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tất cả ứng tuyển</h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table id="proposal-table" class="table">
                                <thead>
                                <tr>
                                  <th>Vị trí</th>
                                  <th>Bộ phận</th>
                                  <th>Phòng ban</th>
                                  <th>Đợt</th>
                                  <th>CV</th>
                                  <th>Kết quả</th>
                                  <th>Thời gian</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($candidate->proposals as $proposal)
                                    <tr>
                                      <td>{{$proposal->company_job->name}}</td>
                                      <td>
                                        @if ($proposal->company_job->division_id)
                                        {{$proposal->company_job->division->name}}
                                        @else
                                        -
                                        @endif
                                      </td>
                                      <td>{{$proposal->company_job->department->name}}</td>
                                      @php
                                          $proposal_candidate = App\Models\ProposalCandidate::where('candidate_id', $candidate->id)->where('proposal_id', $proposal->id)->first();
                                          $url = '<a target="_blank" href="../../../' . $proposal_candidate->cv_file . '"><i class="far fa-file-pdf"></i></a>';
                                      @endphp
                                      <td>{{ $proposal_candidate->batch}}</td>
                                      <td>{!! $url !!}</td>
                                      <td>-</td>
                                      <td>{{ date('d/m/Y', strtotime($proposal_candidate->created_at)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                              </table>
                        </div>
                    <!-- /.table-responsive -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection



