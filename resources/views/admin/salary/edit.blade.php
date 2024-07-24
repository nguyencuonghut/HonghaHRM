@section('title')
{{ 'Sửa lương' }}
@endsection

@extends('layouts.base')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sửa lương</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.hr.salaries.index') }}">Tất cả lương</a></li>
              <li class="breadcrumb-item active">Sửa</li>
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
                    <form class="form-horizontal" method="post" action="{{ route('admin.hr.salaries.update', $employee_salary->id) }}" name="update_salary" id="update_salary" novalidate="novalidate">
                        {{ csrf_field() }}
                        @method('PATCH')
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Lương vị trí</label>
                                        <input class="form-control" type="number" name="position_salary" id="position_salary" value="{{$employee_salary->position_salary}}">
                                    </div>
                                  </div>
                                  <div class="col-3">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Lương năng lực</label>
                                        <input class="form-control" type="number" name="capacity_salary" id="capacity_salary" value="{{$employee_salary->capacity_salary}}">
                                    </div>
                                  </div>
                                  <div class="col-3">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Phụ cấp vị trí</label>
                                        <input class="form-control" type="number" name="position_allowance" id="position_allowance" value="{{$employee_salary->position_allowance}}">
                                    </div>
                                  </div>
                                  <div class="col-3">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Lương bảo hiểm</label>
                                        <input class="form-control" type="number" name="insurance_salary" id="insurance_salary" value="{{$employee_salary->insurance_salary}}">
                                    </div>
                                  </div>
                            </div>

                            <br>
                            <div class="control-group">
                                <div class="controls">
                                    <input type="submit" value="Lưu" class="btn btn-success">
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
