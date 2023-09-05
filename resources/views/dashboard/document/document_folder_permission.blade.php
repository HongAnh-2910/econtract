@php
    $userNumber = 2;
    $userCount = $folderItem->folderShare->count();
    $userPlus = $userCount - $userNumber;
    $dataUser = [];
    foreach ($folderItem->folderShare as $user)
    {
        $dataUser[] = [
            'id' => $user->id,
            'name' => $user->name . '(' . $user->email .')',
        ];
    }
@endphp
<div class="d-flex flex-row position-relative justify-content-center">
    @if(request()->status != config('statuses.share'))
        @foreach($folderItem->folderShare as $key => $user)
            @if($key < $userNumber)
                <img src="{{ $user->avatar_link }}" class="rounded-circle image__permission--round" width="32" height="32"
                     style="{{ $key > 0 ? 'margin-left: -10px;' : '' }}"/>
            @endif
        @endforeach
        @if($userCount > $userNumber)
            <div style="margin-left: -10px"
                 class="d-flex justify-content-center align-items-center rounded-circle dashboard__permission--avatar-plus bg-white">
                <span class="text__count--account"> +{{ $userPlus }}</span>
            </div>
        @endif
    @else
        <img src="{{ Auth::user()->avatar_link }}" class="rounded-circle image__permission--round" width="32" height="32"/>
    @endif
    @if(request()->status != config('statuses.trash') && request()->status != config('statuses.share'))
        <a class="d-flex justify-content-center align-items-center rounded-circle dashboard__permission--avatar-plus bg-white dashboard__permission--add-button"
           data-id="{{ $folderItem->id }}">
            <i class="fa fa-plus dashboard__sidebar--iconGray" aria-hidden="true"></i>
        </a>
        {!! Form::open(['url' => route('web.folders.updateFolderPermission', ['id' => $folderItem->id]), 'id' => 'permissionForm_'. $folderItem->id]) !!}
        <div id="permissionModal_{{ $folderItem->id }}" data-user="{{ json_encode($dataUser) }}"
             data-src="{{ route('web.folders.updateFolderPermission', ['id' => $folderItem->id]) }}"
             class="position-absolute bg-white px-1 py-1 dashboard__permission--modal d-none bg-white d-flex flex-column" style="z-index: 9">
            <select name="user_list" class="form-control dashboard__permission--list" id="permissionList_{{ $folderItem->id }}"
                    style="width: 200px" multiple></select>
            <button id="submit" class="btn btn-primary align-self-baseline mt-2">Xác nhận</button>
        </div>
        {!! Form::close() !!}
    @endif
</div>
<script>
    $(document).ready(function () {
        $('#permissionForm_' + {{ $folderItem->id }}).on('submit', function (e) {
            e.preventDefault();
            const url = $(this).parent().find('#permissionModal_' + {{ $folderItem->id }}).data('src');
            const userId = $(this).find('select').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax(
                {
                    url: url,
                    method: 'POST',
                    data: {
                        users: userId,
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                }
            )
        })
    })
</script>
