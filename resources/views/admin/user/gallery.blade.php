@section('title')
{{ 'Người dùng' }}
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
          <h1 class="m-0">Tất cả người dùng</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Người dùng</li>
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
            @auth('admin')
            <a href="{{ route('admin.users.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tạo mới</a>
            @endauth
            <div class="btn-group float-right">
                &nbsp;
                <a href="{{route('admin.users.gallery')}}" class="btn btn-info {{Route::is('admin.users.gallery') ? 'active' : ''}}">
                    <i class="fas fa-th"></i>
                </a>
                <a href="{{route('admin.users.index')}}" class="btn btn-info {{Route::is('admin.users.index') ? 'active' : ''}}">
                    <i class="fas fa-bars"></i>
                </a>
            </div>
            @auth('admin')
            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#import_user">
                <i class="fas fa-file-excel"></i> Import
            </button>
            @endauth

            <div class="row">
                &nbsp;
                <div class="col-md-12">
                    <form action="{{route('admin.users.gallery')}}" method="get" novalidate="novalidate">
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
        @if($users->count())
        <div class="row">
            @foreach ($users as $user)
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                    @php
                        $i = 0;
                        $length = count($user->positions);
                        $positions_list = '';
                        foreach ($user->positions as $item) {
                            if(++$i === $length) {
                                $positions_list =  $positions_list . $item->name;
                            } else {
                                $positions_list = $positions_list . $item->name . ', ';
                            }
                        }
                    @endphp
                    <div class="card-header text-muted border-bottom-0">
                        {{$positions_list}}
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                        <div class="col-7">
                            <h2 class="lead"><b>{{$user->name}}</b></h2>
                            @php
                                $i = 0;
                                $length = count($user->departments);
                                $departments_list = '';
                                foreach ($user->departments as $item) {
                                    if(++$i === $length) {
                                        $departments_list =  $departments_list . $item->name;
                                    } else {
                                        $departments_list = $departments_list . $item->name . ', ';
                                    }
                                }
                            @endphp
                            <p class="text-muted text-sm">{{$departments_list}} </p>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span>{{$user->email}}</li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-map-marker-alt"></i></span>Đồng Văn, Duy Tiên, Hà Nam</li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>0974936497</li>
                            </ul>
                        </div>
                        <div class="col-5 text-center">
                            <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                        </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                        <a href="#" class="btn btn-sm btn-primary">
                            <i class="fas fa-user"></i> Xem chi tiết
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
    <!-- Modal -->
    <form class="form-horizontal" method="post" action="{{ route('admin.users.import') }}" enctype="multipart/form-data" name="import-user" id="import-user" novalidate="novalidate">
        {{ csrf_field() }}
        <div class="modal fade" id="import_user">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <div class="custom-file text-left">
                                <input type="file" name="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Chọn file</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
    </form>
    <!-- /.modal -->

    <!-- /.card-body -->
    <div class="card-footer">
        {{-- @if ($paginator->hasPages()) --}}
        <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
                {{ $users->appends(request()->except('page'))->links() }}
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


@push('scripts')


  <script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
  </script>
@endpush
