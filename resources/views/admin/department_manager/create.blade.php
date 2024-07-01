@section('title')
{{ 'Thêm quản lý phòng/ban' }}
@endsection

@push('styles')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@extends('layouts.base')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Thêm quản lý phòng/ban</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.department_managers.index') }}">Tất quản lý phòng/ban</a></li>
              <li class="breadcrumb-item active">Thêm</li>
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
                <div class="col-12">
                    <div class="card">
                    <form class="form-horizontal" method="post" action="{{ route('admin.department_managers.store') }}" name="add_department_manager" id="add_department_manager" novalidate="novalidate">{{ csrf_field() }}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Phòng ban</label>
                                        <div class="controls">
                                            <select name="department_id" id="department_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                @foreach($departments as $department)
                                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Quản lý</label>
                                        <div class="controls">
                                            <select name="manager_id" id="manager_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                @foreach($managers as $manager)
                                                    <option value="{{$manager->id}}">{{$manager->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="control-group">
                                <div class="controls">
                                    <input type="submit" value="Thêm" class="btn btn-success">
                                </div>
                            </div>
                        <div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
        theme: 'bootstrap4'
        })
    });
</script>
@endpush
