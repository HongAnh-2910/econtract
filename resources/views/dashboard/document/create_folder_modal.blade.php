<!-- Create folder modal -->
<div class="modal fade" id="createFolderModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable"
         role="document">
        {!! Form::open(['url' => route('web.folders.store'), 'class' => 'modal-content']) !!}
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">
                    Tạo thư mục
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body mt-2 mx-2">
                <div class="form-group row">
                    <label for="inputPassword" class="create__contract--form--fz col-md-4 mb-0 py-2 px-4 px-md-2">Tên thư
                        mục</label>
                    <div class="col-md-8">
                        {!! Form::text('folder_name', null, ['placeholder' => 'Tên thư mục', 'class' => 'form-control']) !!}
                        {!! Form::hidden('parent_id', $folder->id) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary button-account-edit ml-2 box-shadow-account bg-white text-dark"
                        data-bs-dismiss="modal">
{{--                    <i class="bx bx-x d-block d-sm-none"></i>--}}
{{--                    <span class="d-none d-sm-block">Đóng</span>--}}
                    <span>Đóng</span>
                </button>
                {!! Form::submit('Lưu',['class' => "btn btn-success button-account-edit box-shadow-account dashboard__button--primary"]) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
