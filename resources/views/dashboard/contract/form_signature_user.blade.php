<div class="contract__box--face d-sm-flex pl-2 pr-2 flex-sm-wrap d-flex-none mb-4 pl-sm-1 pr-sm-0 pr-md-3 pl-md-3 px-lg-2">
    <div class=" col-sm-6 pr-0 pl-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2 col-lg-5 col-xl-4 pr-lg-1">
        <div class="form-group">
            <label class="text-dark pl-2 mb-1 text-nowrap" for="exampleInputEmail1">Tên cá
                nhân,
                công ty,
                doanh nghiệp <span class="text-danger">*</span></label>
            <input type="text" autocomplete="off" name="business_name[]" class="form-control p-2 rounded-0"
                   id="exampleInputEmail1"
                   aria-describedby="emailHelp" required>
            <div class="invalid-feedback pl-0">
                Tên cá nhân, công ty, doanh nghiệp không được để trống
            </div>
        </div>
    </div>
    <div class="form-group pr-0 pl-0 pr-sm-1 pl-sm-1 pl-md-2 pr-md-1 col-sm-6 col-lg-2 pl-lg-1 px-xl-2">
        <div class="input-group d-md-flex justify-content-md-center d-flex-none">
            <div class="form-outline position-relative w-100">
                <label class="form-label pl-2 text-dark font-weight-bold mb-1">Trình
                    tự kí
                    <span class="text-danger mb-1">*</span></label>
                <i class="fas fa-chevron-down position-absolute contract__list--icon--down"></i>
                <select name="status_signing[]" class="form-control rounded-0 p-2 w-100 contract__list--select--wh"
                        id="exampleFormControlSelect1">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
        </div>
    </div>
    <div class=" form-group mt-md-0 col-sm-6 pr-0 pl-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2 pr-lg-1 col-lg-2 px-xl-2">
        <div class="input-group d-md-flex justify-content-center d-flex-none show__invalid--message">
            <div class="form-outline w-100">
                <label class="form-label pl-2 text-dark font-weight-bold mb-1">Số
                    điện thoại
                    <span class="text-danger">*</span></label>
                <input autocomplete="off" name="phone_contract[]" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" minlength="10" maxlength="10" pattern="[0-9]+" type="text" class="phone__number--check form-control rounded-0 p-2"
                       placeholder=" " required/>
                <div class="invalid-feedback pl-0">
                    Số điện thoại không được để trống
                </div>
            </div>
        </div>
    </div>
    <div class="mt-md-0 form-group col-sm-6 pr-0 pl-0 pr-sm-1 pl-sm-1 pl-md-2 pr-md-1 pl-lg-1 col-lg-2 col-xl-3 px-xl-2">
        <div class="input-group d-md-flex justify-content-center d-flex-none show__invalid--message">
            <div class="form-outline w-100">
                <label class="form-label pl-2 text-dark font-weight-bold mb-1">Địa
                    chỉ email
                    <span class="text-danger">*</span></label>
                @error('email_contract.*')
                <div class="text text-danger">{{ $message }}</div>
                @enderror
                <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" autocomplete="off" name="email_contract[]" type="email" class="form-control rounded-0 p-2 receivers__email--contracts"
                       placeholder="" required/>
                <div class="invalid-feedback pl-0">
                    Email của người nhận không được để trống
                </div>
            </div>
        </div>
    </div>
{{--    @if($isShowDeleteButton)--}}
        <div class="col-lg-1 col-12 dashboard__remove--button d-none d-lg-flex align-items-lg-center">
            <label class="form-label mb-1 font-weight-bold text-dark">
                <span class="text-danger"></span></label>
            <div class="input-group d-md-flex justify-content-center d-flex-none">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
        </div>
        <div class="col-lg-1 col-12 dashboard__remove--button d-flex d-lg-none align-items-lg-center">
            <label class="form-label mb-1 font-weight-bold text-dark">
                <span class="text-danger"></span></label>
            <div class="input-group d-md-flex justify-content-center d-flex-none">
                <a class="btn btn-danger text-white px-3 py-2"><i class="fas fa-trash"></i>&nbsp;&nbsp;Xóa</a>
            </div>
        </div>
{{--    @endif--}}
{{--    <div class="col-md-8 px-0 px-md-2">--}}
{{--        <div class="box__input--contract d-md-flex">--}}
{{--            --}}
{{--        </div>--}}
{{--    </div>--}}
</div>

