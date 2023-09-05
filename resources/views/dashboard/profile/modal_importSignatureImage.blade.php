<div class="modal fade" id="importSignature" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chữ ký ảnh</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('web.signature-list.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="application__file--inputFile">
                        <div class="custom-file">
                            <input type="hidden" id="typeSignature" name="type" value="2">
                            <input type="file" name="file" class="custom-file-input" id="signatureImage" onchange="encodeImageFileAsURL()" required="required">
                            <label class="custom-file-label signatureImageLabel" for="exampleInputFile">Chọn file ảnh</label>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1" class="ft-size-account">Tên chữ ký</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function encodeImageFileAsURL() {
        // let filesSelected = document.getElementById('signatureImage').files;
        // if (filesSelected.length > 0) {
        //     let fileToLoad = filesSelected[0];
        //     let fileReader = new FileReader();
        //     fileReader.onload = function(fileLoadedEvent) {
        //         let srcData = fileLoadedEvent.target.result;
        //         let newImage = document.createElement('img');
        //         newImage.src = srcData;
        //         $('#signatureData').val(newImage.getAttribute('src'));
        //     }
        //     fileReader.readAsDataURL(fileToLoad);
        // }
        let f = $('#signatureImage')[0].files[0];
        let file = $('#signatureImage')[0].files[0] ? $('#signatureImage')[0].files[0].name : 'Chọn file ảnh';
        $('.signatureImageLabel').html(file);
    }
</script>
