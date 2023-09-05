<div class="modal fade text-left w-100" id="addPersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
    aria-hidden="true" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
        <div class="modal-content" style="overflow-y: scroll; transform: translateX(2px);">
            <h3 class="text-center my-4 text-uppercase" id="myModalLabel20">Thêm mới khách hàng </h3>
            <form method="POST" action="{{ route('web.customers.store') }}" name="myForm" class="needs-validation"
                novalidate>
                @csrf
                <div class="container-fluid px-5">
                    <div class="row">
                        <div class="col-md-2 col-12">
                            <div class="mt-md-5 pt-md-2 mt-4 ">Tên khách hàng: <span class="text-danger">*</span></div>
                        </div>
                        <div class="col-md-10 col-12">
                            <div class="row">
                                <div class="col-md-6 col-12 pl-md-0">
                                    <input type="text" placeholder="Tên khách hàng" class="form-control mt-md-5 pt-md-2 mt-0 name"
                                        name="name"  required>
                                    <div class="invalid-feedback ml-2">
                                        *Tên khách hàng không được để trống
                                    </div>
                                    <div class="ml-2">
                                        @error('name')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="mx-md-2 mt-md-5 pt-md-2 mt-4 pl-md-3">Email: <span class="text-danger">*</span></div>
                                </div>
                                <div class="col-md-4 col-12 pl-md-0">
                                    <input type="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" placeholder="Email" class="form-control mx-md-2 mt-md-5 pt-md-2 mt-1 email"
                                        name="email" required>
                                    <div class="invalid-feedback ml-2">
                                        *Vui lòng kiểm tra lại địa chỉ email
                                    </div>
                                    <div class="ml-2">
                                        @error('email')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="mt-md-5 pt-md-2 mt-4">Địa chỉ: <span class="text-danger">*</span></div>
                        </div>
                        <div class="col-md-10 col-12 px-md-0">
                            <div class="col px-0">
                                <input type="text" placeholder="Địa chỉ" class="form-control ml-md-0 mr-md-0 mt-md-5 address"
                                    name="address" required>
                                <div class="invalid-feedback ml-2">
                                    *Địa chỉ không được để trống
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="mt-md-5 pt-md-2 mt-4">Số tài khoản:</div>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6 col-12 px-md-0">
                                    <input type="number" placeholder="Số tài khoản" class="form-control mx-md-0 mt-md-5"
                                        name="account_number">
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="mx-md-2 mt-md-5 pt-md-2 mt-4 text-md-center">Tại ngân hàng:</div>
                                </div>
                                <div class="col-md-4 col-12 pl-md-0">
                                    <input autocomplete="off" type="text" value="{{ old('search') }}"
                                        class="form-select mx-md-2 mt-md-5 pt-md-2 position-relative" name="name_bank"
                                        id="data__banking--addPersonal">
                                    @include('dashboard.customer.search_banking')
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="mt-md-5 pt-md-2 mt-4">Hình thức thanh toán:</div>
                        </div>
                        <div class="col-md-10 col-12 px-md-0">
                            <div class="form-group mx-md-0 mt-md-5 w-md-50 w-100">
                                <select class="form-control" name="payments" >
                                    <option selected>Tiền mặt/Chuyển khoản</option>
                                    <option value="Tiền mặt">Tiền mặt</option>
                                    <option value="Chuyển khoản">Chuyển khoản</option>
                                </select>
                            </div>
                        </div>

                        <input name="customer_type" value="Cá nhân" hidden>

                        <div class="col-md-12 col-12">
                            <div class="row">
                                <div class="col-md-2 col-12">
                                    <div class="mx-md-2 mt-md-5 pt-md-2 mt-3">
                                        Số điện thoại: <span class="text-danger">*</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 pl-md-0">
                                    <input class="form-control mx-md-0 mb-md-0 mb-3 mt-md-5 pt-md-2" maxLength="10" pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" name="phone_number"
                                        placeholder="Số điện thoại" required>
                                    <div class="invalid-feedback ml-2 ">
                                        *Vui lòng kiểm tra lại số điện thoại
                                    </div>
                                    <div class="ml-2">
                                        @error('phone_number')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-md-4 mb-4 mx-md-5 mt-4 d-flex justify-content-md-end justify-content-center">
                    <button type="submit" class="btn btn-primary ml-md-1 button__add--customer mr-md-0 mr-2">
{{--                        <i class="bx bx-check d-block d-sm-none"></i>--}}
                        <span>Lưu</span>
                    </button>
                    <button type="button" class="btn btn-light-secondary hideModal1 button__add--customer mx-md-3 mr-md-0 mr-2"
                        data-bs-dismiss="modal">
{{--                        <i class="bx bx-x d-block d-sm-none"></i>--}}
                        <span>Đóng</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.hideModal1').click((e)=> {
        $('#addPersonal').hide();
        $('.modal-backdrop').addClass('d-none')
    })
</script>
{{-- search_banking --}}
<script>
    $(document).ready(function() {
        // Check modal show and hide banking
        $(document).on('click', function(evt) {
            var modalBanking = '.blade__search--bankingPersonal';
            var BtnAdd = '#data__banking--addPersonal';
            if (!$(evt.target).closest(modalBanking).length && !$(evt.target).closest(BtnAdd).length) {
                $('.blade__search--bankingPersonal').css('display', 'none');
            }
        });

        $('.blade__search--bankingPersonal').css('display', 'none');
        $('#data__banking--addPersonal').keyup(function() {
            var keywork = $(this).val();
            var data = {
                keywork: keywork
            }
            if (keywork != '') {
                $('.blade__search--bankingPersonal').css('display', 'block');
                $.ajax({
                    url: "{{ route('customer.banking') }}",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: 'POST',
                    dataType: 'html',
                    success: function(data) {
                        $('.blade__search--bankingPersonal').html(data);
                    },
                })
            }
        })
    })
</script>

<script>
    $(document).ready(function() {
        $('.blade__search--bankingPersonal').css('display', 'none');
        $('#data__banking--addPersonal').on('click', function() {
            $('.blade__search--bankingPersonal').css('display', 'block');
            $.ajax({
                url: "{{ route('customer.banking') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: 'POST',
                dataType: 'html',
                success: function(data) {
                    $('.blade__search--bankingPersonal').html(data);
                },
            })
        })

    })
</script>

<!--  Api Company  -->
<script>
    $(document).ready(function() {
        $('#buttonGetInfoCompany').on('click', function() {
            let uri = $('input#tax_code').attr('data-uri');
            var data = $('input#tax_code').val();
            var data = {
                data: data
            }
            $.ajax({
                url: uri,
                data: data,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('.name').val(data.ChuSoHuu);
                    $('.name_company').val(data.Title);
                    $('.email').val(data.email);
                    $('.address').val(data.DiaChiCongTy);
                },
            })
        })
    })
</script>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
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
