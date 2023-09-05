<div class="modal fade text-left w-100" id="showCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
        <div class="modal-content" style="overflow-y: scroll">
            <h3 class="text-center my-4 text-uppercase" id="myModalLabel20">Chi tiết khách hàng </h3>
            <div class="container-fluid px-5">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="font-weight-bold customer__show--sizeText">Mã KH:</div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="customer__show--sizeText" id="customer_code_show"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="font-weight-bold customer__show--sizeText">Mã số thuế:</div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="customer__show--sizeText" id="tax_code_show"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="font-weight-bold customer__show--sizeText">Tên giám đốc:</div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="customer__show--sizeText " id="name_show"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="font-weight-bold customer__show--sizeText">Tên công ty:</div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="customer__show--sizeText " id="name_company_show"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="font-weight-bold customer__show--sizeText">Địa chỉ:</div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="customer__show--sizeText " id="address_show"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="font-weight-bold customer__show--sizeText">Số điện thoại:</div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="customer__show--sizeText " id="phone_number_show"></p>
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="id" id="id" value="{{ $customer->id }}" hidden>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="font-weight-bold customer__show--sizeText">Số tài khoản:</div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="customer__show--sizeText" id="account_number_show"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="font-weight-bold customer__show--sizeText">Hình thức thanh toán:
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="customer__show--sizeText" id="payments_show"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="font-weight-bold customer__show--sizeText">Loại khách hàng:</div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="customer__show--sizeText" id="customer_type_show"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="font-weight-bold customer__show--sizeText">Email:</div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="customer__show--sizeText" id="email_show"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="font-weight-bold customer__show--sizeText">Tại ngân hàng:</div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="customer__show--sizeText mb-md-0 mb-3" id="name_bank_show"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-md-4 my-4 mx-md- 5 d-flex justify-content-md-end justify-content-center">
                <button type="button" data-uri-show="{{ route('web.customers.show') }}" id="formEditCustomer"
                    class="btn btn-primary ml-1 button__add--customer" data-bs-toggle="modal"
                    data-id="{{ $customer->id }}" data-bs-target="#editCustomer" data-toggle="modal">
{{--                    <i class="bx bx-check d-block d-sm-none"></i>--}}
                    <span >Sửa thông tin</span>
                </button>

                <button type="button" class="btn btn-light-secondary button__add--customer mx-3"
                    data-bs-dismiss="modal">
{{--                    <i class="bx bx-x d-block d-sm-none"></i>--}}
                    <span>Đóng</span>
                </button>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#formEditCustomer').click(function() {
            $('#showCustomer').modal('hide');
            var id = $('#id').val();
            var uri = $(this).attr('data-uri-show');
            var uriShow = uri + '/' + id;
            $.ajax({
                url: uriShow,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#customer_code_edit').val(data.customer_code);
                    $('#tax_code_edit').val(data.tax_code);
                    $('#name_edit').val(data.name);
                    $('#name_company_edit').val(data.name_company);
                    $('#address_edit').val(data.address);
                    $('#phone_number_edit').val(data.phone_number);
                    $('#account_number_edit').val(data.account_number);
                    $('#payments_edit').val(data.payments);
                    $('#customer_type_edit').val(data.customer_type);
                    $('#email_edit').val(data.email);
                    $('.name_bank_edit').val(data.name_bank);
                    $('#id-edit').val(data.id);
                },
                error: function() {
                    console.log('error');
                }
            })
        })
    })
</script>
