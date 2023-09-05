<form class="needs-validation" method="POST" action="{{ route('web.departments.update' , $departmentEdit->id) }}" novalidate>
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Sửa phòng ban</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="exampleInputEmail1">Tên phòng ban :</label>
            <input name="name_department" type="text" class="form-control" id="exampleInputEmail1"
                   aria-describedby="emailHelp"
                   value="{{ $departmentEdit->name }}"
                   placeholder="Tên phòng ban" required>
            <div class="invalid-feedback pl-0">
                Tên phòng ban không được để trống
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Phòng ban cha :</label>
            <select class="form-control" id="exampleFormControlSelect1" name="value_name_department">
                <option value="">Cấp cao nhất</option>
                @if(!empty($listDepartmentLevel))
                    @foreach($listDepartmentLevel as $department)
                        <option
                            @if($department->id == $departmentEdit->parent_id) selected @endif
                            value="{{ $department->id }}">{{ str_repeat('---  ',$department->level).$department->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
        <button type="submit" class="btn btn-primary">Sửa</button>
    </div>
</form>



