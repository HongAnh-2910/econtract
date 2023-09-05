<!-- Upload file modal -->

<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg"
         role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-titlbtn align-self-baseline mt-2e" id="exampleModalCenterTitle">
                    Tải lên tài liệu
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="show__error--message text-danger mx-2 mt-2"></div>
            <div class="dropzone mt-3 mx-2" id="file-dropzone"></div>
            <div class="form-group mt-5 mx-2 modal__upload--file">
                <label for="userList">Chọn người dùng:</label>
                <select id="userList" name="user_list" class="form-control" multiple></select>
            </div>
            <div class="modal-footer">
                <button type="submit"
                        class="btn btn-primary btn__close--dropzone button-account-edit ml-2 box-shadow-account bg-white text-dark"
                        data-bs-dismiss="modal">Đóng
                </button>
                <button id="uploadFileButton" type="submit"
                        class="btn btn-success button-account-edit box-shadow-account dashboard__button--primary">Lưu
                </button>
            </div>
        </div>
    </div>
</div>
