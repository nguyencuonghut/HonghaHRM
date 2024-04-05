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
                    <i class="fas fa-list"></i>
                </a>
            </div>
            @auth('admin')
            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#import_user">
                <i class="fas fa-file-excel"></i> Import
            </button>
            @endauth
        </div>
      <div class="card-body pb-0">
        <div class="row">
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
                Digital Strategist
            </div>
            <div class="card-body pt-0">
                <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
                Digital Strategist
            </div>
            <div class="card-body pt-0">
                <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img src="../../dist/img/user2-160x160.jpg" alt="user-avatar" class="img-circle img-fluid">
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
                Digital Strategist
            </div>
            <div class="card-body pt-0">
                <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
                Digital Strategist
            </div>
            <div class="card-body pt-0">
                <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img src="../../dist/img/user2-160x160.jpg" alt="user-avatar" class="img-circle img-fluid">
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
                Digital Strategist
            </div>
            <div class="card-body pt-0">
                <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
                Digital Strategist
            </div>
            <div class="card-body pt-0">
                <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
                Digital Strategist
            </div>
            <div class="card-body pt-0">
                <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
                Digital Strategist
            </div>
            <div class="card-body pt-0">
                <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
                Digital Strategist
            </div>
            <div class="card-body pt-0">
                <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img src="../../dist/img/user2-160x160.jpg" alt="user-avatar" class="img-circle img-fluid">
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
                </div>
            </div>
            </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <nav aria-label="Contacts Page Navigation">
        <ul class="pagination justify-content-center m-0">
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item"><a class="page-link" href="#">6</a></li>
            <li class="page-item"><a class="page-link" href="#">7</a></li>
            <li class="page-item"><a class="page-link" href="#">8</a></li>
        </ul>
        </nav>
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
