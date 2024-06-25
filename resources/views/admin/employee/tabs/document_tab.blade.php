<!-- Document Tab -->
@push('styles')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

<div class="tab-pane" id="tab-document">
    <div class="card card-secondary">
        <div class="card-header">
            Danh sách giấy tờ
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @can('create-document')
            <a href="#create_document{{' . $employee->id . '}}" class="btn btn-success" data-toggle="modal" data-target="#create_document{{$employee->id}}"><i class="fas fa-plus"></i></a>
            <br>
            <br>
            @endcan
            <table id="employee-documents-table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Tên giấy tờ</th>
                    <th>File</th>
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
                                  <form style="display:inline" action="'. route("admin.hr.employees.document.destroy", $employee_document->id) . '" method="POST">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                  <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';

                          $action = '';
                          if (Auth::user()->can('create-document')) {
                              $action = $action . $action_edit_document;
                          }
                      @endphp
                      <td>{!! $document->name !!}</td>
                      @php
                            $url = '';
                            if ($employee_document->file_path) {
                                $url .= '<a target="_blank" href="../../../' . $employee_document->file_path . '"><i class="far fa-file-pdf"></i></a>';
                            } else {
                                $url .= ' - ';
                            }
                      @endphp
                      <td>{!! $url !!}</td>
                      @can('create-document')
                      <td>{!! $action !!}</td>
                      @endcan

                      <!-- Modals for edit employee document -->
                      <form class="form-horizontal" method="post" action="{{ route('admin.hr.employees.document.update', $employee_document->id) }}" enctype="multipart/form-data" name="update_document" id="update_document" novalidate="novalidate">
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
                                                <div class="control-group">
                                                    <label class="control-label">File (pdf)</label>
                                                    <div class="custom-file text-left">
                                                        <input type="file" name="file_path" accept="application/pdf" class="custom-file-input" id="file_path">
                                                        <label class="custom-file-label" for="img_path">Chọn file</label>
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

            <!-- Modals for create employee document -->
            <form class="form-horizontal" method="post" action="{{ route('admin.hr.employees.document.store', $employee->id) }}" enctype="multipart/form-data" name="create_document" id="create_document" novalidate="novalidate">
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
                                        <div class="control-group">
                                            <label class="control-label">File (pdf)</label>
                                            <div class="custom-file text-left">
                                                <input type="file" name="file_path" accept="application/pdf" class="custom-file-input" id="file_path">
                                                <label class="custom-file-label" for="img_path">Chọn file</label>
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
    </div>

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

        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    })
</script>
@endpush




