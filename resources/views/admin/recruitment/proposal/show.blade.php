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
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab-4" data-toggle="pill" href="#custom-tabs-one-profile-4" role="tab" aria-controls="custom-tabs-one-profile-4" aria-selected="false">Phỏng vấn sơ bộ</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab-5" data-toggle="pill" href="#custom-tabs-one-profile-5" role="tab" aria-controls="custom-tabs-one-profile-5" aria-selected="false">Phỏng vấn lần 1</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab-6" data-toggle="pill" href="#custom-tabs-one-profile-6" role="tab" aria-controls="custom-tabs-one-profile-6" aria-selected="false">Phỏng vấn lần 2</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab-7" data-toggle="pill" href="#custom-tabs-one-profile-7" role="tab" aria-controls="custom-tabs-one-profile-7" aria-selected="false">Offer chế độ</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab-8" data-toggle="pill" href="#custom-tabs-one-profile-8" role="tab" aria-controls="custom-tabs-one-profile-8" aria-selected="false">Báo cáo</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab-9" data-toggle="pill" href="#custom-tabs-one-profile-9" role="tab" aria-controls="custom-tabs-one-profile-9" aria-selected="false">Giấy tờ cần ký</a>
                          </li>
                        </ul>
                      </div>
                      <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            @include('admin.recruitment.proposal.tabs.document_tab')
                            @include('admin.recruitment.proposal.tabs.report_tab')
                            @include('admin.recruitment.proposal.tabs.offer_tab')
                            @include('admin.recruitment.proposal.tabs.second_interview_tab')
                            @include('admin.recruitment.proposal.tabs.first_interview_tab')
                            @include('admin.recruitment.proposal.tabs.initial_interview_tab')
                            @include('admin.recruitment.proposal.tabs.proposal_candidate_filter_tab')
                            @include('admin.recruitment.proposal.tabs.candidate_tab')
                            @include('admin.recruitment.proposal.tabs.announcement_tab')
                            @include('admin.recruitment.proposal.tabs.proposal_tab')
                            @include('admin.recruitment.proposal.tabs.plan_tab')
                      </div>
                      <!-- /.card -->
                    </div>
                  </div>
            </div>







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
