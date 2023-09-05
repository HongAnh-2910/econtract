<form class="needs-validation" method="POST" action="{{ route('web.departments.store') }}" novalidate>
    @csrf
    <div class="modal fade" id="staticBackdrop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tạo phòng ban</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên phòng ban :</label>
                        <input name="name_department" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
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
                                    <option value="{{ $department->id }}">{{ str_repeat('---  ',$department->level).$department->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- validate--}}
<script>
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

