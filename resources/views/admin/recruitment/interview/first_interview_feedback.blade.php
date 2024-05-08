@section('title')
{{ 'Phản hồi phỏng vấn lần 1' }}
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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Phản hồi phỏng vấn lần 1</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.recruitment.proposals.index') }}">Tất cả đề xuất</a></li>
              <li class="breadcrumb-item active">Phản hồi phỏng vấn lần 1</li>
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
                        <form class="form-horizontal" method="post" action="{{ route('admin.recruitment.first_interview_invitation.update', $first_interview_invitation->proposal_candidate_id) }}" name="create_first_interview_feedback" id="create_first_interview_feedback" novalidate="novalidate">
                            @method('PATCH')
                            {{ csrf_field() }}
                            <div class="card-body">
                                <input type="hidden" name="proposal_candidate_id" id="proposal_candidate_id" value="{{$first_interview_invitation->proposal_candidate_id}}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Phản hồi</label>
                                            <div class="controls">
                                                <select name="feedback" id="feedback" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                    <option value="Đồng ý" @if ($first_interview_invitation && 'Đồng ý' == $first_interview_invitation->feedback) selected="selected" @endif>Đồng ý</option>
                                                    <option value="Từ chối" @if ($first_interview_invitation && 'Từ chối' == $first_interview_invitation->feedback) selected="selected" @endif>Từ chối</option>
                                                    <option value="Hẹn lại" @if ($first_interview_invitation && 'Hẹn lại' == $first_interview_invitation->feedback) selected="selected" @endif>Hẹn lại</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label>Ghi chú</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="note" id="note" required="" value="{{$first_interview_invitation->note}}">
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="control-group">
                                    <div class="controls">
                                        <input type="submit" value="Lưu" class="btn btn-success">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /.modal -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
        theme: 'bootstrap4'
        })

        //Date picker
        $("#interview_time_get").datetimepicker({
            format: 'DD/MM/YYYY HH:mm',
            icons: { time: 'far fa-clock' }
        });
    });
</script>
@endpush
