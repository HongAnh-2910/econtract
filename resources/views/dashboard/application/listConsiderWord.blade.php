
<div class="form-group position-relative parent_department">
    <i style="position: absolute;top: 12px;right: 9px;z-index: 1;"
       class="fas fa-chevron-down down__active--hover"></i>
    <select
        class="department__select js-example-placeholder-multiple js-states form-control pl-2"
        name="user_consider[]" multiple="multiple">
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
            @if(!empty($users[0]->parent->id))
                    @if($listIdSelect != $users[0]->parent->id)
                        @if(\Illuminate\Support\Facades\Auth::id() != $users[0]->parent->id)
                            <option value="{{ $users[0]->parent->id }}">{{ $users[0]->parent->name}}</option>
                        @endif
                    @endif
            @endif
    </select>
</div>

<script type="text/javascript">
    // select perrmission user when upload file
    $(document).ready(function () {
        $('.department__select').select2({
            placeholder: "Chọn người xem xét",
            allowClear: true,
        });
    });
</script>
