<!-- Document Tab -->
@push('styles')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

<div class="active tab-pane" id="tab-document">
    @can('create-document')
    <a href="#create_document{{' . $employee->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_document{{$employee->id}}"><i class="fas fa-plus"></i></a>
    <br>
    <br>
    @endcan
    <table id="employee-documents-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Tên giấy tờ</th>
            <th>Trạng thái</th>
            @can('create-document')
            <th>Thao tác</th>
            @endcan
          </tr>
        </thead>
        <tbody>
            @foreach ($employee_documents as $employee_document)
            <tr>
              @php
                  $document = App\Models\Document::findOrFail($employee_document->document_id);
                  $action_edit_document = '<a href="#edit_document{{' . $employee_document->id . '}}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit_document' . $employee_document->id. '"><i class="fas fa-edit"></i></a>
                          <form style="display:inline" action="'. route("admin.employees.document.destroy", $employee_document->id) . '" method="POST">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                          <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';

                  $action = '';
                  if (Auth::user()->can('create-document')) {
                      $action = $action . $action_edit_document;
                  }
              @endphp
              <td>{!! $document->name !!}</td>
              <td>
                  <span class="badge @if ("Đã ký" == $employee_document->status) badge-success @else badge-danger @endif">{{$employee_document->status}}</span>
              </td>
              @can('create-document')
              <td>{!! $action !!}</td>
              @endcan

              <!-- Modals for edit employee document -->
              <form class="form-horizontal" method="post" action="{{ route('admin.employees.document.update', $employee_document->id) }}" name="update_document" id="update_document" novalidate="novalidate">
                  @method('PATCH')
                  {{ csrf_field() }}
                  <div class="modal fade" tabindex="-1" id="edit_document{{$employee_document->id}}">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h4>Hồ sơ của {{$employee->name}}</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                  <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">

                                  <div class="row">
                                      <div class="col-12">
                                          <div class="control-group">
                                              <div class="control-group">
                                                  <label class="required-field" class="control-label">Tên giấy tờ</label>
                                                  <div class="controls">
                                                      <select name="document_id" id="document_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                          <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                          @foreach ($documents as $document)
                                                              <option value="{{$document->id}}" @if ($employee_document && $document->id == $employee_document->document_id) selected="selected" @endif>{{$document->name}}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-12">
                                          <label class="required-field" class="control-label">Trạng thái</label>
                                          <div class="controls">
                                              <select name="status" id="status" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                  <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                  <option value="Đã ký" @if ($employee_document && 'Đã ký' == $employee_document->status) selected="selected" @endif>Đã ký</option>
                                                  <option value="Chưa ký" @if ($employee_document && 'Chưa ký' == $employee_document->status) selected="selected" @endif>Chưa ký</option>
                                              </select>
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

    <!-- Modals for create employee document -->
    <form class="form-horizontal" method="post" action="{{ route('admin.employees.document.store', $employee->id) }}" name="create_document" id="create_document" novalidate="novalidate">
        {{ csrf_field() }}
        <div class="modal fade" id="create_document{{$employee->id}}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Hồ sơ của {{$employee->name}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                        <div class="row">
                            <div class="col-12">
                                <div class="control-group">
                                    <div class="control-group">
                                        <label class="required-field" class="control-label">Tên giấy tờ</label>
                                        <div class="controls">
                                            <select name="document_id" id="document_id" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                                <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                                @foreach ($documents as $document)
                                                    <option value="{{$document->id}}">{{$document->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label class="required-field" class="control-label">Trạng thái</label>
                                <div class="controls">
                                    <select name="status" id="status" data-placeholder="Chọn" class="form-control select2" style="width: 100%;">
                                        <option value="-- Chọn --" disabled="disabled" selected="selected">-- Chọn --</option>
                                        <option value="Đã ký">Đã ký</option>
                                        <option value="Chưa ký">Chưa ký</option>
                                    </select>
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




