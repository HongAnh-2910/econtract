<div class="modal fade text-left w-100" id="addEnterprise" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered add_enterprise__add modal-dialog-scrollable modal-full"
         role="document">
        <div class="modal-content" style="overflow-y: scroll; transform: translateX(2px);">
            <h3 class="text-center my-4 text-uppercase" id="myModalLabel20">Thêm mới doanh nghiệp </h3>
            <form method="POST" action="{{ route('web.customers.store') }}" name="myForm" class="needs-validation"
                  novalidate>
                @csrf
                <div class="container-fluid px-5">
                    <div class="row">
                        <div class="col-md-2 col-12">
                            <div class="mt-md-5 mt-4 pt-md-2">Mã số thuế: <span class="text-danger">*</span>
                            </div>
                        </div>
                        <div class="col-md-10 pl-md-0 col-12">
                            <div class="position-relative">
                                <input data-uri="{{ route('web.contracts.getData') }}" type="text" placeholder="Mã số thuế"
                                       class="form-control mx-md-0 mt-md-5 mt-2" name="tax_code" id="tax_code"
                                       value="{{ old('tax_code') }}" required>
                                <div class="invalid-feedback ml-2">
                                    *Mã số thuế không được để trống
                                </div>
                                <button id="buttonGetInfoCompany"
                                        class="btn btn-primary position-absolute button__takeInformation--addCustomer"
                                        type="button">Lấy thông tin
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="mt-md-5 pt-md-2 mt-4">Tên giám đốc: <span class="text-danger">*</span></div>
                        </div>
                        <div class="col-md-10 pl-md-0 col-12">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <input type="text" placeholder="Tên giám đốc"
                                           class="form-control mx-md-0 mt-md-5 name" name="name"
                                           value="{{ old('name') }}" required>
                                    <div class="invalid-feedback ml-2">
                                        *Tên giám đốc không được để trống
                                    </div>
                                    <div class="ml-2">
                                        @error('name')
                                        <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2 col-12 pr-md-0">
                                    <div class="mx-md-2 mt-md-5 pt-md-2 mt-4">Email: <span
                                                class="text-danger">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12 px-md-0">
                                    <input type="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}"
                                           placeholder="Email" class="form-control mx-md-0 mt-md-5 pt-md-2 email"
                                           name="email" value="{{ old('email') }}" required>
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
                            <div class="mt-md-5 pt-md-2 mt-4">Tên công ty: <span class="text-danger">*</span></div>
                        </div>
                        <div class="col-md-10 col-12 px-md-0">
                            <div class="col px-0">
                                <input type="text" placeholder="Tên công ty"
                                       class="form-control mx-md-0 mt-md-5 name_company" name="name_company"
                                       value="{{ old('name_company') }}" required>
                                <div class="invalid-feedback ml-2">
                                    *Tên công ty không được để trống
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="mt-md-5 pt-md-2 mt-4">Địa chỉ: <span class="text-danger">*</span></div>
                        </div>
                        <div class="col-md-10 col-12 px-md-0">
                            <div class="col px-0">
                                <input type="text" value="{{ old('address') }}" placeholder="Địa chỉ"
                                       class="form-control mx-md-0 mt-md-5 address" name="address" required>
                                <div class="invalid-feedback ml-2">
                                    *Địa chỉ không được để trống
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="mt-md-5 pt-md-2 mt-4">Số tài khoản:</div>
                        </div>
                        <div class="col-md-10 col-12">
                            <div class="row">
                                <div class="col-md-6 px-md-0 col-12">
                                    <input type="number" value="{{ old('account_number') }}"
                                           placeholder="Số tài khoản" class="form-control mx-md-0 mt-md-5"
                                           name="account_number">
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="mx-md-2 mt-md-5 pt-md-2 mt-4">Tại ngân hàng:</div>
                                </div>
                                <div class="col-md-4 px-md-0 col-12">
                                    <input autocomplete="off" type="text" value="{{ old('name_bank') }}"
                                           class="form-select mx-md-0 mt-md-5 pt-md-2 position-relative" name="name_bank"
                                           id="data__banking--addEnterprise">
                                    @include('dashboard.customer.search_banking')
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="mt-md-5 pt-md-2 mt-4">Hình thức thanh toán:</div>
                        </div>
                        <div class="col-md-10 px-md-0 col-12">
                            <div class="form-group mx-md-0 mt-md-5 w-md-50 w-100">
                                <select class="form-control" name="payments">
                                    <option class="application__selectOption--disabled" value="" disabled="disabled"
                                            selected="selected">Tiền mặt/Chuyển khoản
                                    </option>
                                    <option value="Tiền mặt">Tiền mặt</option>
                                    <option value="Chuyển khoản">Chuyển khoản</option>
                                </select>
                            </div>
                        </div>

                        <input name="customer_type" value="Doanh nghiệp" hidden>

                        <div class="col-md-12 col-12">
                            <div class="row">
                                <div class="col-md-2 col-12">
                                    <div class="mx-md-2 mt-md-5 mt-3 pt-md-2">
                                        Số điện thoại: <span class="text-danger">*</span>
                                    </div>
                                </div>
                                <div class="col-md-6 pl-md-0 col-12">
                                    <input class="form-control mx-md-0 mt-md-5 mb-md-0 mb-3 pt-md-2 validate--phone"
                                           maxLength="10" pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" name="phone_number"
                                           placeholder="Số điện thoại" value="{{ old('phone_number') }}" required>
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
                <div class="my-md-4 my-4 mx-md-5 d-flex justify-content-md-end justify-content-center">
                    <button type="submit" class="btn btn-primary ml-1 button__add--customer">
                        {{-- <i class="bx bx-check d-block d-sm-none"></i> --}}
                        <span>Lưu</span>
                    </button>
                    <button type="button" class="btn btn-light-secondary button__add--customer mx-3 hideModal"
                            data-bs-dismiss="modal">
                        {{-- <i class="bx bx-x d-block d-sm-none"></i> --}}
                        <span>Đóng</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  $('.hideModal').click(( e ) => {
    $('#addEnterprise').hide();
    $('.modal-backdrop').addClass('d-none');
  });
</script>
<script>
  $(document).ready(function () {
    // Check modal show and hide banking
    $(document).on('click', function ( evt ) {
      var modalBanking = '.blade__search--bankingEnterprise';
      var BtnAdd = '#data__banking--addEnterprise';
      if (!$(evt.target).closest(modalBanking).length && !$(evt.target).closest(BtnAdd).length) {
        $('.blade__search--bankingEnterprise').css('display', 'none');
      }
    });

    $('.blade__search--bankingEnterprise').css('display', 'none');
    $('#data__banking--addEnterprise').keyup(function () {
      var keywork = $(this).val();
      var data = {
        keywork: keywork
      };
      if (keywork != '') {
        $('.blade__search--bankingEnterprise').css('display', 'block');
        $.ajax({
          url: "{{ route('customer.banking') }}",
          data: data,
          headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          method: 'POST',
          dataType: 'html',
          success: function ( data ) {
            $('.blade__search--bankingEnterprise').html(data);
          },
        });
      }
    });
  });
</script>

<script>
  $(document).ready(function () {
    $('.blade__search--bankingEnterprise').css('display', 'none');
    $('#data__banking--addEnterprise').on('click', function () {
      $('.blade__search--bankingEnterprise').css('display', 'block');
      $.ajax({
        url: "{{ route('customer.banking') }}",
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        method: 'POST',
        dataType: 'html',
        success: function ( data ) {
          $('.blade__search--bankingEnterprise').html(data);
        },
      });
    });
  });
</script>

<!--  Api Company  -->
<script>
  $(document).ready(function () {
    $('#buttonGetInfoCompany').on('click', function () {
      let uri = $('input#tax_code').attr('data-uri');
      let taxCode = $('input#tax_code').val();
      $.ajax({
        url: uri,
        data: {
          tax_code: taxCode
        },
        method: 'GET',
        dataType: 'json',
        success: function ( data ) {
          $('.name').val(data.ceo_name);
          $('.name_company').val(data.company_name);
          $('.email').val(data.email);
          $('.address').val(data.address);
        },
      });
    });
  });
</script>

<script>
  (function () {
    'use strict';
    window.addEventListener('load', function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function ( form ) {
        form.addEventListener('submit', function ( event ) {
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
