<!-- Document Tab -->
<div class="active tab-pane" id="tab-document">
    <h4>Giấy tờ cần ký</h4>
    <a href="{{ route('admin.documents.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Thêm</a>
    <br>
    <br>
    <table id="documents-table" class="table table-bordered table-striped">
        <thead>
        <tr>
        <th>STT</th>
        <th>Tên giấy tờ</th>
        <th>Trạng thái</th>
        <th>Thao tác</th>
        </tr>
        </thead>
    </table>
</div>



