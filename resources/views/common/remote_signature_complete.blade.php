@extends('layouts.auth')
@section('content')
    <div class="modal" id="modal-notify" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="right-container-content">
        <div class="">
            <h4>Bạn đã ký số hợp đồng thành công. Vui lòng vào app mobile để xác nhận</h4>
            @if (session('message_signature'))
                <div class="alert alert-success">{{ session('message_signature') }}</div>
            @endif
            <form action="{{route('web.contracts.reviewFilePdf')}}" method="post">
                @csrf
                <input type="hidden" id="fileName" name="fileName" value="{{$fileName}}">
                <input type="hidden" id="token" name="token"  value="{{$token}}">
                <input type="hidden" id="tranId" name="tranId" value="{{$tranId}}">
                <button type="btn" class="rounded p-2  sign-submit text-white  border-0 text-center" style="background-color : #7763e7;" id="sign-submit">Xác nhận kí thành công</button>
            </form>
        </div>
    </div>
    <script>
        let fileName = $('#fileName').val();
        let token = $('#token').val();
        let tranId = $('#tranId').val();
        $('#sign-submit').on('click',function (){
            $.ajax(
                {
                    url: '{{route('web.contracts.reviewFilePdf')}}',
                    data: {'fileName': fileName, 'token' : token,'tranId' : tranId},
                    method: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (data) {
                       $('.modal-body').text(data.message);
                       $('#modal-notify').show();
                    },
                }
            )
        })
    </script>
@endsection
