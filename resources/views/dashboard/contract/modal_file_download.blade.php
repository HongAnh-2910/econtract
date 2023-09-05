<div class="modal fade" data-button="" id="fileDownload" style="z-index: 10000" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tải hợp đồng </h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <label for=""> <b>Lưu ý</b> Sau khi hoàn tất tải về, bạn vui lòng <b>kiểm tra lại toàn bộ thông tin hợp đồng </b> và thực hiện 1 trong 2 thao tác sau:</label><br>
                    <label for=""> <b>1. Ký bằng Chữ ký số (Bên A) và Tải lên hợp đồng đã ký</b></label><br>
                    <label for=""> Hoặc </label><br>
                    <label for=""> <b>2. Gửi Hợp đồng gốc đã ký, đóng dấu môc trước (Bên A) về OneSign</b></label>
            </div>
            <div class="modal-footer">
{{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>--}}
{{--                    <button type="button" data-dismiss="modal" id="file-accept" class="btn btn-primary file-accept">Đồng ý</button>--}}
                <a href="{{route('web.files.downloadZipFile', ['contractId' => $contractId])}}">
                    <button class="btn complete--client btn__client--complete " style="background-color: #3D1BBB">Tải xuống</button>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function encodeImageFileAsURL(data) {
        let file = $(data)[0].files[0] ? $(data)[0].files[0].name : 'Chọn file ảnh';
        $('.signatureImageLabel').html(file);
    }
    let fileParent = $('#fileUpload');
    fileParent.find('#file-accept').on('click',function () {
        let fileCurrent = $('#signatureImage')[0].files[0] ? $('#signatureImage')[0].files[0].name : '';
        let contractId  = {!! json_encode($contractId) !!};
        let email       = {!! json_encode($email) !!};
        if(fileCurrent != '') {
            let res = confirm("Bạn có đồng ý upload file hợp đồng '" + fileCurrent + "' không ?");
            // let res = confirm("Bạn có đồng ý thêm file không ?");
            let formData = new FormData();
            formData.append('file', $('#signatureImage')[0].files[0]);
            formData.append('contractId',contractId);
            formData.append('email',email);
            console.log($('#signatureImage')[0].files[0]);
            console.log(formData);
            if(res){
                $.ajax(
                    {
                        url: '{{ route('web.contracts.clientUpload') }}',
                        data: formData,
                        method: 'POST',
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            console.log('upload thanh cong');
                        },
                    }
                )
            }
            else {
                alert('qqqqq');
            }
        }
    })
</script>
