<!-- Candidate Tab -->
<div class="tab-pane fade" id="custom-tabs-one-profile-2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-2">
    <h2>{{$proposal->company_job->name}}</h2>
    <div class="card card-secondary">
        <div class="card-header">
            Danh sách ứng viên
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if('Nhân sự' == Auth::user()->role->name
                && $proposal->announcement)
                    <button type="button" class="btn btn-success float-left" data-toggle="modal" data-target="#add_proposal_candidate">
                        Thêm
                    </button>
                    <br>
                    <br>
            @endif
            <div class="table-responsive">
              <table id="candidates-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 12%;">Tên</th>
                  <th style="width: 12%;">Email</th>
                  <th>Điện thoại</th>
                  <th>Ngày sinh</th>
                  <th>CCCD</th>
                  <th>Địa chỉ</th>
                  <th>CV</th>
                  <th>Đợt</th>
                  <th>Thao tác</th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($proposal->candidates as $candidate)
                    <tr>
                      <td>
                        <a href="{{route('admin.recruitment.candidates.show', $candidate->id)}}">{{$candidate->name}}</a>
                      </td>
                      <td>{{$candidate->email}}</td>
                      <td>{{$candidate->phone}}</td>
                      <td>{{ date('d/m/Y', strtotime($candidate->date_of_birth)) }}</td>
                      <td>{{$candidate->cccd}}</td>
                      <td> {{$candidate->address}}, {{$candidate->commune->name}}, {{$candidate->commune->district->name}}, {{$candidate->commune->district->province->name}}</td>
                      @php
                          $proposal_candidate = App\Models\ProposalCandidate::where('proposal_id', $proposal->id)->where('candidate_id', $candidate->id)->first();
                          $url = '<a target="_blank" href="../../../' . $proposal_candidate->cv_file . '"><i class="far fa-file-pdf"></i></a>';
                          $action = '<a href="#edit{{' . $proposal_candidate->id . '}}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $proposal_candidate->id. '"><i class="fas fa-edit"></i></a>
                                        <form style="display:inline" action="'. route("admin.recruitment.proposal_candidates.destroy", $proposal_candidate->id) . '" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                      @endphp
                      <td>{!! $url !!}</td>
                      <td>{{$proposal_candidate->batch}}</td>
                      <td>{!! $action !!}</td>
                    </tr>
                    <!-- Modals for edit proposal_candidate -->
                    <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('admin.recruitment.proposal_candidates.update', $proposal_candidate->id) }}" name="update_proposal_candidate" id="update_proposal_candidate" novalidate="novalidate">
                        {{ csrf_field() }}
                        @method('PATCH')
                        <div class="modal fade" tabindex="-1" id="edit{{$proposal_candidate->id}}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>Sửa ứng viên</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="proposal_id" id="proposal_id" value="{{$proposal->id}}">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="required-field" class="control-label">Chọn ứng viên</label>
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#create_candidate">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <div class="controls">
                                                    <select name="candidate_id" id="candidate_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                        @foreach($candidates as $candidate)
                                                            <option value="{{$candidate->id}}" @if ($candidate->id == $proposal_candidate->candidate_id) selected @endif>{{$candidate->name}} - {{$candidate->email}} - CCCD {{$candidate->cccd}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">CV</label>
                                                    <div class="custom-file text-left">
                                                        <input type="file" name="cv_file" accept="application/pdf" class="custom-file-input" id="cv_file">
                                                        <label class="custom-file-label" for="cv_file">Chọn file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">Nguồn tin</label>
                                                    <div class="controls">
                                                        <select name="cv_receive_method_id" id="cv_receive_method_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                            <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                            @foreach ($receive_methods as $receive_method)
                                                                <option value="{{$receive_method->id}}" @if ($receive_method->id == $proposal_candidate->cv_receive_method_id) selected @endif>{{$receive_method->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="control-group">
                                                    <label class="required-field" class="control-label">Đợt</label>
                                                    <div class="controls">
                                                        <select name="batch" id="batch" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                            <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                            <option value="Đợt 1" @if ('Đợt 1' == $proposal_candidate->batch) selected @endif>Đợt 1</option>
                                                            <option value="Đợt 2" @if ('Đợt 2' == $proposal_candidate->batch) selected @endif>Đợt 2</option>
                                                            <option value="Đợt 3" @if ('Đợt 3' == $proposal_candidate->batch) selected @endif>Đợt 3</option>
                                                            <option value="Đợt 4" @if ('Đợt 4' == $proposal_candidate->batch) selected @endif>Đợt 4</option>
                                                            <option value="Đợt 5" @if ('Đợt 5' == $proposal_candidate->batch) selected @endif>Đợt 5</option>
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
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>


<!-- Modals for create proposal_candidate -->
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('admin.recruitment.proposal_candidates.store') }}" name="create_proposal_candidate" id="create_proposal_candidate" novalidate="novalidate">
{{ csrf_field() }}
<div class="modal fade" id="add_proposal_candidate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Thêm ứng viên</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="proposal_id" id="proposal_id" value="{{$proposal->id}}">
                <div class="row">
                    <div class="col-12">
                        <label class="required-field" class="control-label">Nhập ứng viên</label>
                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#create_candidate">
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="controls">
                            <select name="candidate_id" id="candidate_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                @foreach($candidates as $candidate)
                                    <option value="{{$candidate->id}}">{{$candidate->name}} - {{$candidate->email}} - {{$candidate->phone}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="control-group">
                            <label class="required-field" class="control-label">CV</label>
                            <div class="custom-file text-left">
                                <input type="file" name="cv_file" accept="application/pdf" class="custom-file-input" id="cv_file">
                                <label class="custom-file-label" for="cv_file">Chọn file</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="control-group">
                            <label class="required-field" class="control-label">Nguồn tin</label>
                            <div class="controls">
                                <select name="cv_receive_method_id" id="cv_receive_method_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                    @foreach ($receive_methods as $receive_method)
                                        <option value="{{$receive_method->id}}">{{$receive_method->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="control-group">
                            <label class="required-field" class="control-label">Đợt</label>
                            <div class="controls">
                                <select name="batch" id="batch" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                    <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                    <option value="Đợt 1">Đợt 1</option>
                                    <option value="Đợt 2">Đợt 2</option>
                                    <option value="Đợt 3">Đợt 3</option>
                                    <option value="Đợt 4">Đợt 4</option>
                                    <option value="Đợt 5">Đợt 5</option>
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


<!-- Modals for create candiate -->
<form class="form-horizontal" method="post" action="{{ route('admin.recruitment.candidates.store') }}" enctype="multipart/form-data" name="make_candidate" id="make_candidate" novalidate="novalidate">
    {{ csrf_field() }}
    <div class="modal fade" id="create_candidate">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Tạo mới ứng viên</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="proposal_id" id="proposal_id" value="{{$proposal->id}}">
                    <div class="row">
                        <div class="col-4">
                            <div class="control-group">
                                <label class="required-field" class="control-label">Họ tên</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="name" id="name" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="control-group">
                                <label class="control-label">Email</label>
                                <div class="controls">
                                    <input type="email" class="form-control" name="email" id="email" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="control-group">
                                <label class="required-field" class="control-label">Số điện thoại</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="phone" id="phone" required="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="control-group">
                                <label class="control-label">Số điện thoại người thân</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="relative_phone" id="relative_phone" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="required-field">Ngày sinh</label>
                            <div class="input-group date" id="date_of_birth" data-target-input="nearest">
                                <input type="text" name="date_of_birth" class="form-control datetimepicker-input" data-target="#date_of_birth"/>
                                <div class="input-group-append" data-target="#date_of_birth" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="control-group">
                                <label class="control-label">CCCD</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="cccd" id="cccd" required="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <label class="control-label">Ngày cấp</label>
                            <div class="input-group date" id="issued_date" data-target-input="nearest">
                                <input type="text" name="issued_date" class="form-control datetimepicker-input" data-target="#issued_date"/>
                                <div class="input-group-append" data-target="#issued_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div><div class="col-4">
                            <div class="control-group">
                                <label class="control-label">Nơi cấp</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="issued_by" id="issued_by" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="control-group">
                                <label class="required-field" class="control-label">Giới tính</label>
                                <div class="controls">
                                    <select name="gender" id="gender" data-placeholder="Chọn giới tính" class="form-control select2" style="width: 100%;">
                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="control-group">
                                <label class="required-field" class="control-label">Số nhà, thôn, xóm</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="address" id="address" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="control-group">
                                <label class="required-field" class="control-label">Địa chỉ</label>
                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_commune">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <div class="controls">
                                    <select name="commune_id" id="commune_id" data-placeholder="Chọn địa chỉ" class="form-control select2" style="width: 100%;">
                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                        @foreach($communes as $commune)
                                            <option value="{{$commune->id}}">{{$commune->name}} - {{$commune->district->name}} - {{$commune->district->province->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="required-field" class="control-label">Học vấn</label>
                            <table class="table table-bordered" id="dynamicTable">
                                <tr>
                                    <th class="required-field" style="width: 40%;">
                                        Trường
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#make_school">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </th>
                                    <th class="required-field" style="width: 25%;">Trình độ</th>
                                    <th>Ngành</th>
                                    <th>#</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="addmore[0][school_id]" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" disabled>Chọn trường</option>
                                            @foreach($schools as $school)
                                                <option value="{{$school->id}}">{{$school->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="addmore[0][degree_id]" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" disabled>Chọn trình độ</option>
                                            @foreach($degrees as $degree)
                                                <option value="{{$degree->id}}">{{$degree->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="addmore[0][major]" placeholder="Ngành" class="form-control" /></td>
                                    <td><button type="button" name="add_school" id="add_school" class="btn btn-success"><i class="fas fa-plus"></i></button></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label class="required-field" class="control-label">Kinh nghiệm</label>
                            <textarea id="experience" name="experience">
                            </textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label class="control-label">Ghi chú</label>
                            <textarea id="note" name="note">
                            </textarea>
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


<!-- Modals for create commune -->
<form class="form-horizontal" method="post" action="{{ route('admin.communes.store') }}" name="create_commune" id="create_commune" novalidate="novalidate">
    {{ csrf_field() }}
    <div class="modal fade" id="add_commune">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Thêm xã/phường</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="control-group">
                                <label class="required-field" class="control-label">Tên xã/phường</label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="name" id="name" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="control-group">
                                <label class="required-field" class="control-label">Thuộc quận/huyện </label>
                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_district">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <div class="controls">
                                    <select name="district_id" id="district_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                        <option value="-- Chọn quận/huyện --" disabled="disabled" selected="selected">-- Chọn quận/huyện --</option>
                                        @foreach($districts as $district)
                                            <option value="{{$district->id}}">{{$district->name}} - {{$district->province->name}}</option>
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


