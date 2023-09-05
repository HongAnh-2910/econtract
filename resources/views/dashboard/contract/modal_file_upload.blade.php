<div class="modal fade" data-button="" id="fileUpload" style="z-index: 10000" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tải lên hợp đồng </h5>
                <button class="btn complete--client btn__client--complete btn-upload" style="margin-left: 205px;background-color: #3D1BBB">Tải lên</button>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="application__file--inputFile" style="margin-bottom: 10px">
{{--                        <div class="custom-file">--}}
{{--                            <input type="hidden" id="typeSignature" name="type" value="2">--}}
{{--                            <input type="file" name="file" class="custom-file-input" id="signatureImage" onchange="encodeImageFileAsURL(this)" required="required">--}}
{{--                            <label class="custom-file-label signatureImageLabel" for="exampleInputFile">Upload file hợp đồng đã ký</label>--}}
{{--                        </div>--}}
                    </div>
                    <input type="checkbox" id="checkContract" name="checkContract" value="confirm">
                    <label for=""> Bạn cần đảm bảo</label><br>
                    <label for=""> <b>- Đã đọc , hiểu rõ và đồng ý các điều khoản </b>trong hợp đồng</label><br>
                    <label for=""> <b>- Đảm bảo tính xác thực </b>và chịu trách nhiệm các thông tin đã cung cấp: <b>Thông tin chủ thẻ, số CMND/CCCD</b></label><br>
                </div>
                <div class="modal-footer" style="min-height: 73px">
                    <div id="confirm-button">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="button" data-dismiss="modal" id="file-accept" class="btn btn-primary file-accept">Đồng ý</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function encodeImageFileAsURL(data) {
        let file = $(data)[0].files[0] ? $(data)[0].files[0].name : 'Chọn file ảnh';
        $('.signatureImageLabel').html(file);
    }
    $('.btn-upload').on('click',function (){
        $('#signatureImage').click();
    });
    $('#confirm-button').css('display','none');
    $('#checkContract').on('click',function (){
        let checked = $("#checkContract:checked").length;
        if(checked == 0) {
            $('#confirm-button').css('display','none');
        }
        else{
            $('#confirm-button').css('display','block');
        }
    })
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
                            location.href = '{{route('web.commons.signatureComplete')}}';
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
