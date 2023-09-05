@foreach ($businessName as $k => $business)
    <div class="contract__box--face d-md-flex d-flex-none">
        <div class="col-md-4 fl">
            <div class="form-group">
                <label class="font-weight-normal text-dark" for="exampleInputEmail1">Tên cá
                    nhân,
                    công ty,
                    doanh nghiệp <span class="text-danger">*</span></label>
                <button type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="error__business--{{ $k }} text-danger"></div>
                <input type="text" name="business_name[]" class="form-control p-2 rounded-0 business_name"
                    value="{{ $business }}" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
        </div>
        <div class="col-md-8">
            <div class="row box__input--contract">
                <div class="col-md-4 col-12">
                    <div class="input-group d-md-flex justify-content-md-center d-flex-none">
                        <div class="form-outline position-relative w-100">
                            <label class="form-label font-weight-normal text-dark" for="form1">Trình
                                tự kí
                                <span class="text-danger mb-1">*</span></label>
                            <i class="fas fa-chevron-down position-absolute contract__list--icon--down"></i>
                            <select name="status_signing[]"
                                class="form-control rounded-0 p-2 w-100 contract__list--select--wh"
                                id="exampleFormControlSelect1">
                                @foreach($listStatusReceiver as $key => $value)
                                    @if($key == $statusSigning[$k])
                                        <option selected value="{{ $value }}">{{ $value }}</option>
                                    @else
                                        <option  value="{{ $value }}">{{ $value }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12 mt-md-0 mt-3">
                    <div class="input-group d-md-flex justify-content-center d-flex-none">
                        <div class="form-outline w-100">
                            <label class="form-label font-weight-normal text-dark" for="form1">Số
                                điện thoại
                                <span class="text-danger">*</span></label>
                            <input autocomplete="off" name="phone_contract[]" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" minlength="10" maxlength="10" pattern="[0-9]+" name="phone_contract[]" type="search" id="form1" value="{{ $phoneContract[$k] }}"
                                class="form-control rounded-0 p-2" placeholder="" required />
                            <div class="error__phone--{{ $k }} text-danger" style="font-size: 14px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12 mt-md-0 mt-3">
                    <div class="input-group d-md-flex justify-content-center d-flex-none">
                        <div class="form-outline w-100">
                            <label class="form-label font-weight-normal text-dark" for="form1">Địa
                                chỉ email
                                <span class="text-danger">*</span></label>
                            <div class="error__email--{{ $k }} text-danger"></div>
                            <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  name="email_contract[]" type="search" id="form1" value="{{ $emailContract[$k] }}"
                                class="form-control rounded-0 p-2 receivers__email--contracts" placeholder="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
{{-- validate-js --}}
<script>
    $(document).ready(function() {
        $("input[name*='business_name']").each(function(index) {
            if ($(this).val() == '') {
                $('.error__business--' + index).text(
                    'Tên cá nhân, công ty, doanh nghiệp không được để trống')
            }
        });

        $("input[name*='phone_contract']").each(function(index) {
            if ($(this).val() == '') {
                $('.error__phone--' + index).text('Số điện thoại không được để trống')
            }
        });

        $("input[name*='phone_contract']").each(function(index) {
            if ($(this).val() == '') {
                $('.error__phone--' + index).text('Số điện thoại không được để trống')
            }
        });

        $("input[name*='email_contract']").each(function(index) {
            if ($(this).val() == '') {
                $('.error__email--' + index).text('Địa chỉ email không được để trống')
            }
        });

    })
</script>
