<!-- Family Tab -->
@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

<div class="tab-pane" id="tab-family">
    @can('create-relative')
        <a href="#create_relative{{' . $employee->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_relative{{$employee->id}}"><i class="fas fa-plus"></i></a>
        <br>
        <br>
    @endcan
    <table id="employee-relatives-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Tên</th>
            <th>Năm sinh</th>
            <th>Nghề nghiệp</th>
            <th>Quan hệ</th>
            <th>Sống cùng</th>
            <th>Sức khỏe</th>
            <th>Hoàn cảnh</th>
            @can('create-relative')
            <th>Thao tác</th>
            @endcan
          </tr>
        </thead>
        <tbody>
            @foreach ($employee_relatives as $employee_relative)
            <tr>
              @php
                  $employee_relative = App\Models\EmployeeRelative::findOrFail($employee_relative->id);
                  $action_edit_relative = '<a href="#edit_relative{{' . $employee_relative->id . '}}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit_relative' . $employee_relative->id. '"><i class="fas fa-edit"></i></a>
                          <form style="display:inline" action="'. route("admin.hr.employees.relative.destroy", $employee_relative->id) . '" method="POST">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                          <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';

                  $action = '';
                  if (Auth::user()->can('create-relative')) {
                      $action = $action . $action_edit_relative;
                  }
              @endphp
              <td>{{$employee_relative->name}}</td>
              <td>{{$employee_relative->year_of_birth}}</td>
              <td>{{$employee_relative->job}}</td>
              <td>{{$employee_relative->type}}</td>
              <td>{{$employee_relative->is_living_together}}</td>
              <td>{{$employee_relative->health}}</td>
              <td>{{$employee_relative->situation}}</td>
              @can('create-relative')
              <td>{!! $action !!}</td>
              @endcan

              <!-- Modals for edit employee relative -->
              <form class="form-horizontal" method="post" action="{{ route('admin.hr.employees.relative.update', $employee_relative->id) }}" name="update_relative" id="update_relative" novalidate="novalidate">
                  @method('PATCH')
                  {{ csrf_field() }}
                  <div class="modal fade" tabindex="-1" id="edit_relative{{$employee_relative->id}}">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h4>{{$employee_relative->name}}</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Tên</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="name" id="name" required="" value="{{$employee_relative->name}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                      <div class="control-group">
                                          <label class="required-field" class="control-label">Năm sinh</label>
                                          <div class="controls">
                                              <input type="number" class="form-control" name="year_of_birth" id="year_of_birth" required="" value="{{$employee_relative->year_of_birth}}">
                                          </div>
                                      </div>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Nghề nghiệp</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="job" id="job" required="" value="{{$employee_relative->job}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group">
                                            <label class="required-field" class="control-label">Sức khỏe</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="health" id="health" required="" value="{{$employee_relative->health}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="control-group">
                                            <div class="control-group">
                                                <label class="required-field" class="control-label">Quan hệ</label>
                                                <div class="controls">
                                                    <select name="type" id="type" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                        <option value="Vợ" @if("Vợ" == $employee_relative->type) selected="selected" @endif>Vợ</option>
                                                        <option value="Chồng" @if("Chồng" == $employee_relative->type) selected="selected" @endif>Chồng</option>
                                                        <option value="Con trai" @if("Con trai" == $employee_relative->type) selected="selected" @endif>Con trai</option>
                                                        <option value="Con gái" @if("Con gái" == $employee_relative->type) selected="selected" @endif>Con gái</option>
                                                        <option value="Bố đẻ" @if("Bố đẻ" == $employee_relative->type) selected="selected" @endif>Bố đẻ</option>
                                                        <option value="Mẹ đẻ" @if("Mẹ đẻ" == $employee_relative->type) selected="selected" @endif>Mẹ đẻ</option>
                                                        <option value="Bố vợ/chồng" @if("Bố vợ/chồng" == $employee_relative->type) selected="selected" @endif>Bố vợ/chồng</option>
                                                        <option value="Mẹ vợ/chồng" @if("Mẹ vợ/chồng" == $employee_relative->type) selected="selected" @endif>Mẹ vợ/chồng</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                      <div class="control-group">
                                          <div class="control-group">
                                              <label class="required-field" class="control-label">Sống cùng</label>
                                              <div class="controls">
                                                  <select name="is_living_together" id="is_living_together" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                      <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                      <option value="Có" @if("Có" == $employee_relative->is_living_together) selected="selected" @endif>Có</option>
                                                      <option value="Không" @if("Không" == $employee_relative->is_living_together) selected="selected" @endif>Không</option>
                                                  </select>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                      <div class="control-group">
                                          <label class="control-label">Hoàn cảnh</label>
                                          <div class="controls">
                                              <input type="text" class="form-control" name="situation" id="situation" required="" value="{{$employee_relative->situation}}">
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
            </tr>
          @endforeach
        </tbody>
    </table>

    <!-- Modals for create employee relative -->
    <form class="form-horizontal" method="post" action="{{ route('admin.hr.employees.relative.store', $employee->id) }}" name="create_relative" id="create_relative" novalidate="novalidate">
        {{ csrf_field() }}
        <div class="modal fade" id="create_relative{{$employee->id}}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Người thân của {{$employee->name}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                        <div class="row">
                            <div class="col-6">
                                <div class="control-group">
                                    <label class="required-field" class="control-label">Tên</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="name" id="name" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                              <div class="control-group">
                                  <label class="required-field" class="control-label">Năm sinh</label>
                                  <div class="controls">
                                      <input type="number" class="form-control" name="year_of_birth" id="year_of_birth" required="">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="control-group">
                                    <label class="required-field" class="control-label">Nghề nghiệp</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="job" id="job" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="control-group">
                                    <label class="required-field" class="control-label">Sức khỏe</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="health" id="health" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="control-group">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Quan hệ</label>
                                        <div class="controls">
                                            <select name="type" id="type" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                <option value="Vợ">Vợ</option>
                                                <option value="Chồng">Chồng</option>
                                                <option value="Con trai">Con trai</option>
                                                <option value="Con gái">Con gái</option>
                                                <option value="Bố đẻ">Bố đẻ</option>
                                                <option value="Mẹ đẻ">Mẹ đẻ</option>
                                                <option value="Bố vợ/chồng">Bố vợ/chồng</option>
                                                <option value="Mẹ vợ/chồng">Mẹ vợ/chồng</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                              <div class="control-group">
                                  <div class="control-group">
                                      <label class="required-field" class="control-label">Sống cùng</label>
                                      <div class="controls">
                                          <select name="is_living_together" id="is_living_together" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                              <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                              <option value="Có">Có</option>
                                              <option value="Không">Không</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                              <div class="control-group">
                                  <label class="control-label">Hoàn cảnh</label>
                                  <div class="controls">
                                      <input type="text" class="form-control" name="situation" id="situation" required="">
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



@push('scripts')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
        theme: 'bootstrap4'
        })
    })
</script>
@endpush




