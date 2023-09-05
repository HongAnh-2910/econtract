@extends('layouts.dashboard')
@section('content')
    @if($user_active_qr)
    <form method="POST" action="{{ route('web.applications.createQrCode') }}">
        @csrf
        <button  type="submit" class="btn btn-success">
            Tạo QrCode
        </button>
    </form>
    @endif
    @if($user_id_qr || $usersa)
        {!! QrCode::size(300)->generate(route('web.applications.testQrCodeActive', $user_active_qr1)); !!}
    @endif
@endsection
