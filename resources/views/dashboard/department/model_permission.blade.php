
<div class="modal fade" id="exampleModalPermission__{{ $departmentLevel->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    @php $permissionExists = $departmentLevel->permissions()->pluck('permission.id')->toArray(); @endphp
    <form method="POST" action="{{ route('web.profile.updatePermissionDepartment', $departmentLevel->id) }}">
        @csrf
{{--        @method('DELETE')--}}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Phân quyền phòng ban</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap">
                        @foreach($listPermissions as $permission)
                            <div class="w-50">
                                <input @if(in_array($permission->id, $permissionExists)) checked @endif id="permissionChecked{{$k}}_{{$permission->permission_alias}}" type="checkbox" name="checkedPermissions[]" value="{{$permission->id}}" />
                                <label class="ml-1" for="permissionChecked{{$k}}_{{$permission->permission_alias}}"> {{$permission->name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Huỷ
                    </button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </form>
</div>
