@section('title')
{{ 'Trang chủ' }}
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
            <h1 class="m-0">Admin Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Admin Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$departments->count()}}</h3>

                <p>Tổng số phòng/ban</p>
              </div>
              <div class="icon">
                <i class="fas fa-sitemap"></i>
              </div>
              <a href="{{route('admin.hr.orgs.index')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$employees->count()}}</h3>

                <p>Tổng số nhân sự</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="{{route('admin.hr.employees.index')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{$recruitment_proposals->count()}}</h3>

                <p>Tổng số yêu cầu tuyển dụng</p>
              </div>
              <div class="icon">
                <i class="fas fa-search-location"></i>
              </div>
              <a href="{{route('admin.recruitment.proposals.index')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$probations->count()}}</h3>

                <p>Tổng số thử việc</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-check"></i>
              </div>
              <a href="{{route('admin.hr.probations.index')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{$birthdays->count()}}</h3>

                  <p>Sinh nhật trong tháng</p>
                </div>
                <div class="icon">
                  <i class="fas fa-birthday-cake"></i>
                </div>
                <a href="{{route('admin.reports.birthday')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{$situations->count()}}</h3>

                  <p>Gia đình hoàn cảnh</p>
                </div>
                <div class="icon">
                  <i class="fas fa-hand-holding-heart"></i>
                </div>
                <a href="{{route('admin.reports.situation')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3>{{$kid_policies->count()}}</h3>

                  <p>Chế độ 1/6</p>
                </div>
                <div class="icon">
                  <i class="fas fa-baby"></i>
                </div>
                <a href="{{route('admin.reports.kid_policy')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{$seniorities->count()}}</h3>

                  <p>Thâm niên > 5 năm</p>
                </div>
                <div class="icon">
                  <i class="fas fa-award"></i>
                </div>
                <a href="{{route('admin.reports.seniority')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
