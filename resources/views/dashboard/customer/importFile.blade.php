<div class="modal fade" id="customer__modal--importFile" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('web.customers.importExcel') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="application__file--inputFile">
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="customFile" required="required">
                            <label class="custom-file-label" for="exampleInputFile">Choose Excel File: .xlsx, .xls</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </form>
        </div>
    </div>
</div>
