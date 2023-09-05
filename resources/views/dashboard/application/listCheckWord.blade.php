

@if (empty($users))
    <input class="form-control" placeholder="Chưa có thành viên" disabled>
@else
    <select class="form-control onChangeUser" name="user_id">
        <option selected disabled hidden>Chọn người kiểm duyệt</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
        @if(!empty($users[0]->parent->id))
            @foreach($listIdSelect as $selectId)
                @if($selectId != $users[0]->parent->id)
            @if(\Illuminate\Support\Facades\Auth::id() != $users[0]->parent->id)
                <option value="{{ $users[0]->parent->id }}">{{ $users[0]->parent->name}}</option>
            @endif
                @endif
            @endforeach
        @endif
    </select>
@endif
