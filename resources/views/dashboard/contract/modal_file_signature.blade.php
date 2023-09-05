<div class="modal fade" data-button="" id="fileSignature{{$areaItem->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chữ ký ảnh</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="application__file--inputFile">
                        <div class="custom-file">
                            <input type="hidden" id="typeSignature" name="type" value="2">
                            <input type="file" name="file" class="custom-file-input" id="signatureImage" onchange="encodeImageFileAsURL(this)" required="required">
                            <label class="custom-file-label signatureImageLabel" for="exampleInputFile">Chọn file ảnh</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" data-dismiss="modal" id="file-accept-create" class="btn btn-primary file-accept">Đồng ý</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function encodeImageFileAsURL(data) {
        let f = $(data)[0].files[0];
        let file = $(data)[0].files[0] ? $(data)[0].files[0].name : 'Chọn file ảnh';
        $('.signatureImageLabel').html(file);
    }
</script>
