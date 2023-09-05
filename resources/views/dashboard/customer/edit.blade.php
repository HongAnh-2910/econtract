<div class="modal fade text-left w-100" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
    aria-hidden="true">
    <div class="modal-dialog modal__hide--edit modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
        <div class="modal-content" style="overflow-y: scroll">

            <h3 class="text-center my-4 text-uppercase" id="myModalLabel20">Sửa khách hàng </h3>
            <form class="needs-validation" novalidate>
                <div class="container-fluid px-5">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-md-4 col-12">
                                    <div class="m-md-3 text-md-right text-left font-weight-bold customer__show--sizeText">Mã số thuế
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div>
                                        <input class="m-md-3 customer__show--sizeText form-control" name="tax_code"
                                            id="tax_code_edit" value="{{ $customer->tax_code }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="m-md-3 mt-md-0 mt-4 text-md-right text-left font-weight-bold customer__show--sizeText">Tên giám đốc
                                        <span class="text-danger">*</span></div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div>
                                        <input class="m-md-3 customer__show--sizeTex form-control" name="name"
                                            id="name_edit" value="{{ $customer->name }}" required>
                                        <div class="invalid-feedback ml-3">
                                            *Tên giám đốc không được để trống
                                        </div>
                                        <div class="ml-2">
                                            @error('name')
                                                <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="m-md-3 mt-md-0 mt-4 text-md-right text-left font-weight-bold customer__show--sizeText">Tên công ty
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div>
                                        <input class="m-md-3 customer__show--sizeText form-control" name="name_company"
                                            id="name_company_edit" value="{{ $customer->name_company }}">
                                        <div class="invalid-feedback ml-3">
                                            *Tên công ty không được để trống
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="m-md-3 mt-md-0 mt-4 text-md-right text-left font-weight-bold customer__show--sizeText">Địa chỉ <span
                                            class="text-danger">*</span></div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div>
                                        <input class="m-md-3  customer__show--sizeText form-control" name="address"
                                            id="address_edit" value="{{ $customer->address }}" required>
                                        <div class="invalid-feedback ml-3">
                                            *Địa chỉ không được để trống
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="m-md-3 mt-md-0 mt-4 text-md-right text-left font-weight-bold customer__show--sizeText">Số điện thoại
                                        <span class="text-danger">*</span></div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div>
                                        <input class="m-md-3  customer__show--sizeText form-control" maxLength="10" pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" name="phone_number"
                                            id="phone_number_edit" value="{{ $customer->phone_number }}" required>
                                        <div class="invalid-feedback ml-3">
                                            *Số điện thoại không được để trống
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="text" class="m-md-3  customer__show--sizeText form-control" name="id" id="id-edit"
                                value="{{ $customer->id }}" hidden>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="m-md-3 mt-md-0 mt-4 text-md-right text-left font-weight-bold customer__show--sizeText">Số tài khoản
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <input class="m-md-3   customer__show--sizeText form-control" name="account_number"
                                        id="account_number_edit" value="{{ $customer->account_number }}">
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="m-md-3 mt-md-0 mt-4 text-md-right text-left font-weight-bold customer__show--sizeText">Hình thức
                                        thanh toán</div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <select class="m-md-3  customer__show--sizeText form-control" name="payments"
                                        id="payments_edit">
                                        <option>Tiền mặt/Chuyển khoản</option>
                                        <option @if ($customer->payments === 'cash') selected
                                        @else @endif value="cash">Tiền mặt</option>
                                        <option @if ($customer->payments === 'transfer') selected
                                        @else @endif value="transfer">Chuyển khoản</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="m-md-3 mt-md-0 mt-4 text-md-right text-left font-weight-bold customer__show--sizeText">Loại khách
                                        hàng
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <select class="m-md-3  customer__show--sizeText form-control" name="customer_type"
                                        id="customer_type_edit">
                                        <option>Cá Nhân/Doanh Nghiệp</option>
                                        <option @if ($customer->customer_type === 'personal') selected
                                        @else @endif value="personal">Cá Nhân</option>
                                        <option @if ($customer->customer_type === 'enterprise') selected
                                        @else @endif value="enterprise">Doanh Nghiệp</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="m-md-3 mt-md-0 mt-4 text-md-right text-left font-weight-bold customer__show--sizeText">Email <span
                                            class="text-danger">*</span></div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div>
                                        <input type="email"  pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" class="m-md-3 customer__show--sizeText form-control"
                                            name="email" id="email_edit" value="{{ $customer->email }}" required>
                                        <div class="invalid-feedback ml-3">
                                            *Email không được để trống
                                        </div>
                                        @error('email')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="m-md-3 mt-md-0 mt-4 text-md-right text-left font-weight-bold customer__show--sizeText">Tại ngân hàng
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <input autocomplete="off" type="text" value="{{ old('search') }}"
                                        class="m-md-3 mb-md-0 mb-3 customer__show--sizeText form-select name_bank_edit" name="name_bank"
                                        id="data__banking--edit">
                                    @include('dashboard.customer.search_banking')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-4 mx-5 d-flex justify-content-end">
                    <button type="submit" data-uri-edit="{{ route('web.customers.update') }}" id="buttonSaveFormEdit"
                        class="btn btn-primary ml-1 button__add--customer">
{{--                        <i class="bx bx-check d-block d-sm-none"></i>--}}
                        <span >Sửa thông tin</span>
                    </button>

                    <button type="button"  id="closeEditButton"
                        class="px-md-0 px-3 btn btn-light-secondary button__add--customer mx-3" data-bs-dismiss="modal">
{{--                        <i class="bx bx-x d-block d-sm-none"></i>--}}
                        <span >Đóng</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        const editCus = document.getElementById('editCustomer')
        editCus.onclick = function (e)
        {
          if(!e.target.closest('.modal__hide--edit'))
          {
              $('.modal-backdrop').addClass('d-none')
          }
        }
        // $('#editCustomer').click(()=>{
        //     console.log($('#editCustomer').closest('.modal__hide--edit'))
        //     // $('.modal-backdrop').addClass('d-none')
        // })
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

{{-- search_banking --}}
<script>
    $(document).ready(function() {
        // Check modal show and hide banking
        $(document).on('click', function(evt) {
            var modalBanking = '.blade__search--bankingEdit';
            var BtnAdd = '#data__banking--edit';
            if (!$(evt.target).closest(modalBanking).length && !$(evt.target).closest(BtnAdd).length) {
                $('.blade__search--bankingEdit').css('display', 'none');
            }
        });

        $('.blade__search--bankingEdit').css('display', 'none');
        $('#data__banking--edit').keyup(function() {
            var keywork = $(this).val();
            var data = {
                keywork: keywork
            }
            if (keywork != '') {
                $('.blade__search--bankingEdit').css('display', 'block');
                $.ajax({
                    url: "{{ route('customer.banking') }}",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: 'POST',
                    dataType: 'html',
                    success: function(data) {
                        $('.blade__search--bankingEdit').html(data);
                    },
                })
            }
        })
    })
</script>

<script>
    $(document).ready(function() {
        $('.blade__search--bankingEdit').css('display', 'none');
        $('#data__banking--edit').on('click', function() {
            $('.blade__search--bankingEdit').css('display', 'block');
            $.ajax({
                url: "{{ route('customer.banking') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: 'POST',
                dataType: 'html',
                success: function(data) {
                    console.log(data);
                    $('.blade__search--bankingEdit').html(data);
                },
            })
        })
    })
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#buttonSaveFormEdit').click(function() {
            $('#showCustomer').modal('hide');

            var id = $('#id-edit').val();
            var uri = $(this).attr('data-uri-edit');
            var uriEdit = uri + '/' + id;

            var customer_code = $('#customer_code_edit').val();
            var tax_code = $('#tax_code_edit').val();
            var name = $('#name_edit').val();
            var name_company = $('#name_company_edit').val();
            var address = $('#address_edit').val();
            var phone_number = $('#phone_number_edit').val();
            var account_number = $('#account_number_edit').val();
            var payments = $('#payments_edit').val();
            var customer_type = $('#customer_type_edit').val();
            var email = $('#email_edit').val();
            var name_bank = $('.name_bank_edit').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: uriEdit,
                method: 'POST',
                data: {
                    customer_code: customer_code,
                    tax_code: tax_code,
                    name: name,
                    name_company: name_company,
                    address: address,
                    phone_number: phone_number,
                    account_number: account_number,
                    payments: payments,
                    customer_type: customer_type,
                    email: email,
                    name_bank: name_bank,
                },
                success: function() {
                    $('#editCustomer').modal('hide');
                    location.reload();
                },
                error: function() {
                    console.log('errors');
                }
            })
        })
    })
</script>

<script>
    $(document).ready(function() {
        $("#closeEditButton").click(function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        })
    })
</script>
