

{{--    modal--}}
<div class="modal fade text-left w-100 pr-0" id="exampleModalLong" tabindex="-1"
     role="dialog" aria-labelledby="myModalLabel20" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
         role="document">
        <div class="modal-content" style="border-radius: 25px;height: 538px">
            <div class="container-fluid px-4" style="overflow-y: scroll">
                <div class="row">
                    <div style="font-size: 18px" class="error__move-file text-danger text-center mt-3"></div>
                    <div class="col-md-12 modal__search--folders">
                        <div class="content__upload--search--contract">
                            <div class="py-2">
                                <input autocomplete="off" name="search" type="text"
                                       class="form-control onchange__search text__search--folder" id="exampleInputPassword1" placeholder="Tìm kiếm" />
                            </div>
                        </div>
                        <div class="header__upload--contract d-none d-md-flex py-2">
                            <button
                                class="btn btn-primary rounded button__click--add--contract button-account-edit px-5 box-shadow-account"
                                data-dismiss="modal"
                                style="background-color: #5442BC">Thêm vào
                            </button>
                        </div>
                    </div>
                </div>
                {{--end-header-upload--}}
                <div class="row">
                    <div class="col-md-3">
                        <div class="col-md-12 pl-0 border-right mt-md-0 mt-2">
                            <div class="content__upload--file--contract">

                                {{-- files--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="content__upload--file-exp">
                            <div class="row">
                                <div class="col-md-12 text-center mt-3 mb-4 d-flex d-md-block">
                                    <div class="d-md-block d-none">Thông tin</div>
                                    <div class="header__upload--contract d-flex d-md-none py-2">
                                        <button
                                            class="btn btn-primary rounded button__click--add--contract button-account-edit px-5 box-shadow-account"
                                            data-dismiss="modal"
                                            style="background-color: #5442BC">Thêm vào
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 pr-0">
                                        <div class="content__upload--exp--info d-flex justify-content-between">
                                            <div class="content__upload--exp--table">
                                                Thông tin
                                            </div>
                                            <div class="content__upload--exp--table">
                                                Tên file
                                            </div>
                                            <div class="content__upload--exp--table">
                                                Kích thước
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--  end-header-table--}}
                                <div class="row">
                                    <div class="col-md-12 html_file pr-0">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
