@section('title')
{{ 'Nhân sự' }}
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
          <h1 class="m-0">Tất cả nhân sự</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Nhân sự</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card card-solid">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group float-right">
                        <a href="{{route('admin.hr.employees.gallery')}}" class="btn btn-info {{Route::is('admin.hr.employees.gallery') ? 'active' : ''}}">
                            <i class="fas fa-th"></i>
                        </a>
                        <a href="{{route('admin.hr.employees.index')}}" class="btn btn-info {{Route::is('admin.hr.employees.index') ? 'active' : ''}}">
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <form action="{{route('admin.hr.employees.gallery')}}" method="get" novalidate="novalidate">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="search" name="search" id="search" class="form-control form-control-lg" placeholder="Nhập từ khóa tìm kiếm">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
      <div class="card-body pb-0">
        @if($employees->count())
        <div class="row">
            @foreach ($employees as $employee)
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                    <div class="card-header text-muted border-bottom-0">
                    @php
                        $employee_works = App\Models\EmployeeWork::where('employee_id', $employee->id)->where('status', 'On')->get();
                        $i = 0;
                        $length = $employee_works->count();
                        $departments_list = '';
                        foreach ($employee_works as $item) {
                            if(++$i === $length) {
                                $departments_list =  $departments_list . $item->company_job->department->name;
                            } else {
                                $departments_list = $departments_list . $item->company_job->department->name . ' | ';
                            }
                        }
                    @endphp
                        {{$departments_list}}
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                        <div class="col-7">
                            <h2 class="lead"><b>{{$employee->code}}|{{$employee->name}}</b></h2>
                            @php
                                $employee_works = App\Models\EmployeeWork::where('employee_id', $employee->id)->where('status', 'On')->get();
                                $i = 0;
                                $length = $employee_works->count();
                                $employee_works_list = '';
                                foreach ($employee_works as $item) {
                                    if(++$i === $length) {
                                        $employee_works_list =  $employee_works_list . $item->company_job->name;
                                    } else {
                                        $employee_works_list = $employee_works_list . $item->company_job->name . ' | ';
                                    }
                                }
                            @endphp
                            <p class="text-muted text-sm">{{$employee_works_list}} </p>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-birthday-cake"></i></span>{{date('d/m/Y', strtotime($employee->date_of_birth))}}</li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-id-badge"></i></span>{{$employee->cccd}}</li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-map-marker-alt"></i></span>{{$employee->commune->name}}, {{$employee->commune->district->name}}, {{$employee->commune->district->province->name}}</li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mobile-alt"></i></span>{{$employee->phone}}</li>
                            </ul>
                        </div>
                        <div class="col-5 text-center">
                            <img src="{{asset($employee->img_path)}}" alt="employee-avatar" class="img-circle img-fluid">
                        </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                        <a href="{{route('admin.hr.employees.show', $employee->id)}}" class="btn btn-sm btn-primary">
                            <i class="fas fa-user"></i> Chi tiết
                        </a>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach
      </div>
      @else
        Không tìm thấy kết quả
      @endif
    </div>

    <!-- /.card-body -->
    <div class="card-footer">
        {{-- @if ($paginator->hasPages()) --}}
        <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
                {{ $employees->appends(request()->except('page'))->links() }}
            </ul>
        </nav>
        {{-- @endif --}}
    </div>
    <!-- /.card-footer -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
