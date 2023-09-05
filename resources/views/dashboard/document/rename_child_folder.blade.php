<form method="POST" action="{{ route('web.folders.folderRenameUpdate' , $folderById->id) }}">
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">
            Đổi tên thư mục
        </h5>
        <button type="button" class="close" data-bs-dismiss="modal"
                aria-label="Close">
            <i data-feather="x"></i>
        </button>
    </div>
    <div class="modal-body mt-2 mx-2">
        <div class="form-group d-md-flex">
            <label for="inputPassword" class="create__contract--form--fz col-md-4 mb-0 pt-2 px-2">Tên thư
                mục</label>
            <div class="col-md-8 pl-0">
                <input type="text" class="form-control px-2" name="folder_name" value="{{ $folderById->name }}">
                <input type="hidden" value="{{ $folderById->id }}">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary button-account-edit ml-2 box-shadow-account bg-white text-dark"
                data-bs-dismiss="modal">
{{--            <i class="bx bx-x d-block d-sm-none"></i>--}}
{{--            <span class="d-none d-sm-block">Đóng</span>--}}
            <span>Đóng</span>
        </button>
        {!! Form::submit('Lưu',['class' => "btn btn-success button-account-edit box-shadow-account dashboard__button--primary"]) !!}
    </div>

</form>
