<div class="modal fade" data-button="" id="fileSignature" style="z-index: 10000" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                    <button type="button" data-dismiss="modal" id="file-accept" class="btn btn-primary file-accept">Đồng ý</button>
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
    let fileParent = $('#fileSignature');
    fileParent.find('#file-accept').on('click',function () {
        let filesSelected = fileParent.find('#signatureImage').get()[0].files;
        if (filesSelected.length >0) {
            let fileToLoad = filesSelected[0];
            let fileReader = new FileReader();
            fileReader.onload = function(fileLoadedEvent) {
                let srcData = fileLoadedEvent.target.result;
                $('#ownDigitalSignature').removeClass('justify-content-center');
                $('#ownDigitalSignature').find('.ownSignature--image').attr('src',srcData);
                $('#ownDigitalSignature').find('.ownSignature--image').css('width','100'+'%');
                $('#ownDigitalSignature').find('.ownSignature--image').css('height','100'+'%')
            }
            fileReader.readAsDataURL(fileToLoad);
        }
    })
</script>
