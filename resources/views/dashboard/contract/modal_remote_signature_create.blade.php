<div id="myModal" class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-login">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đăng nhập tới VNPT SMARTCA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="modal-body">
                <form action=""  id="remoteSignatureForm" method="">
                    @csrf
{{--                    @foreach ($area as $areaItem)--}}
{{--                        <input type="hidden" name="Signature[]" value="{{$areaItem->id}}">--}}
{{--                    @endforeach--}}
{{--                    <input type="hidden" id="fileIdBase64" name="fileIdBase64" value="{{$fi['fileId']}}">--}}
                    <div class="form-group" id="input-email">
                        <input type="text" class="form-control" id="email" name="email" placeholder="ID" required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="required">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-lg btn-block login-btn">Login</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>
    $('.login-btn').on('click',function (){
        $('#spinner').modal('toggle');
        $('#spinner').modal('show');
        {{--let area = {!! json_encode($area) !!};--}}
        let Signature = [];
        for (let i= 0 ;i< area.length;i++) {
            Signature.push(area[i].id);
        }
        let scale = $('#documentRender #customCanvas0').attr('scale');
        let pdfWidth = $('#documentRender #customCanvas0').attr('width');
        let pdfHeight = $('#documentRender #customCanvas0').attr('height');
        pdfWidth = parseFloat(pdfWidth/scale);
        pdfHeight = parseFloat(pdfHeight/scale);
        let email = $('#email').val();
        let password = $('#password').val();
        let fileIdBase64 = $('#fileIdBase64').val();
        $.ajax(
            {
                url: '{{ route('web.contracts.remoteSignature') }}',
                data: {'width': pdfWidth, 'height' : pdfHeight,'Signature' : Signature,'email' : email , 'password' : password, 'fileIdBase64' : fileIdBase64},
                method: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('#spinner').modal('toggle');
                    $('#spinner').modal('hide');
                    $('#input-email').prepend('<div class="alert input-message alert-danger text-center alert-dismissible"></div>');
                    $('.input-message').html(data.message);
                    if(!data.message) {
                        $('body').html(data.view);
                    }
                },
            }
        )
    })
</script>
