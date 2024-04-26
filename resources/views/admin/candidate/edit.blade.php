@section('title')
{{ 'Sửa ứng viên' }}
@endsection

@push('styles')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endpush

@extends('layouts.base')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sửa: {{$candidate->name}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.recruitment.candidates.index') }}">Tất cả ứng viên</a></li>
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
                        <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.candidates.update', $candidate->id) }}" name="make_candidate" id="make_candidate" novalidate="novalidate">
                            {{ csrf_field() }}
                            @method('PATCH')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Họ tên</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="name" id="name" required="" value="{{$candidate->name}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Email</label>
                                            <div class="controls">
                                                <input type="email" class="form-control" name="email" id="email" required="" value="{{$candidate->email}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Số điện thoại</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="phone" id="phone" required="" value="{{$candidate->phone}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="required-field">Ngày sinh</label>
                                        <div class="input-group date" id="date_of_birth" data-target-input="nearest">
                                            <input type="text" name="date_of_birth" class="form-control datetimepicker-input" data-target="#date_of_birth" value="{{date('d/m/Y', strtotime($candidate->date_of_birth))}}"/>
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
                                                <input type="text" class="form-control" name="cccd" id="cccd" required="" value="{{$candidate->cccd}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="required-field">Ngày cấp</label>
                                        <div class="input-group date" id="issued_date" data-target-input="nearest">
                                            <input type="text" name="issued_date" class="form-control datetimepicker-input" data-target="#issued_date" value="{{date('d/m/Y', strtotime($candidate->issued_date))}}"/>
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
                                                <input type="text" class="form-control" name="issued_by" id="issued_by" required="" value="{{$candidate->issued_by}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Giới tính</label>
                                            <div class="controls">
                                                <select name="gender" id="gender" data-placeholder="Chọn giới tính" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    <option value="Nam" @if ('Nam' == $candidate->gender) selected @endif>Nam</option>
                                                    <option value="Nữ" @if ('Nữ' == $candidate->gender) selected @endif>Nữ</option>
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
                                                        <option value="{{$commune->id}}" @if ($commune->id == $candidate->commune_id) selected @endif>{{$commune->name}} - {{$commune->district->name}} - {{$commune->district->province->name}}</option>
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
                                                <th class="required-field">Trường</th>
                                                <th>Ngành</th>
                                                <th style="width: 14%;"><button type="button" name="add_education" id="add_education" class="btn btn-success">Thêm</button></th>
                                            </tr>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($candidate->educations as $candidate_education)
                                            <tr>
                                                <td>
                                                    <select name="addmore[{{$i}}][education_id]" class="form-control select2" style="width: 100%;">
                                                        <option selected="selected" disabled>Chọn trường</option>
                                                        @foreach($educations as $education)
                                                            <option value="{{$education->id}}" @if ($education->id == $candidate_education->id) selected @endif>{{$education->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                @php
                                                    $my_candidate_education = App\Models\CandidateEducation::where('education_id', $candidate_education->id)->where('candidate_id', $candidate->id)->first();

                                                @endphp
                                                <td><input type="text" name="addmore[{{$i}}][major]" placeholder="Ngành" class="form-control" value="{{$my_candidate_education->major}}"/></td>
                                                <td><button type="button" class="btn btn-danger remove-tr">Xóa</button></td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <input type="submit" value="Sửa" class="btn btn-success">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection


@push('scripts')
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

        //Date picker
        $('#date_of_birth').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#issued_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        var i = 100;
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
    })
</script>
@endpush




