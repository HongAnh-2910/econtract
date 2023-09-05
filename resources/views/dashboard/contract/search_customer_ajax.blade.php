@if($searchCustomer->count() > 0)
    @foreach($searchCustomer as $customer)
        <div class="item__data--banking cursor">
            <input type="text" class="value__tax_code--active" value="{{ $customer->tax_code }}" hidden>
            <input type="text" class="value__name--active" value="{{ $customer->name }}" hidden>
            <input type="text" class="value__email--active" value="{{ $customer->email }}" hidden>
            <input type="text" class="value__name_cty--active" value="{{ $customer->name_company }}" hidden>
            <input type="text" class="value__address--active" value="{{ $customer->address }}" hidden>
            <input type="text" class="value__account_number--active" value="{{ $customer->account_number}}" hidden>
            <input type="text" class="value__name_bank--active" value="{{ $customer->name_bank}}" hidden>
            <input type="text" class="value__payments--active" value="{{ $customer->payments}}" hidden>
            {{ $customer->name }}
            <div class="tem__data--banking--ky">
                {{ $customer->email }}
            </div>
        </div>
    @endforeach
@endif
<style>
    .d__none--search {
        display: none !important;
    }
</style>
{{--{{ add_banking }}--}}
<script>
    $(document).ready(function () {
        if ($('#data__customer').val().length == 0) {
            $('.blade__search--customer--1').removeClass('d__none--search');
            $('.blade__search--customer').css('display', 'block')
        }
        $('.item__data--banking').click(function () {
            let tax_code = $(this).find('.value__tax_code--active').val();
            let name = $(this).find('.value__name--active').val();
            let email = $(this).find('.value__email--active').val();
            let company = $(this).find('.value__name_cty--active').val();
            let address = $(this).find('.value__address--active').val();
            let accountNum = $(this).find('.value__account_number--active').val();
            let bank = $(this).find('.value__name_bank--active').val();
            let payments = $(this).find('.value__payments--active').val();

            let taxCode_input = $('#code_contract_stt').val(tax_code);
            let active_input = $('#data__customer').val(name);
            let email_input = $('.name_email').val(email);
            let company_input = $('.name_cty').val(company);
            let address_input = $('.addres_cty').val(address);
            let accountNum_input = $('.stk_contract').val(accountNum);
            let bank_input = $('#data__banking').val(bank);
            if (payments == 'Tiền mặt') {
                let payments_input = $('#payments').val(1);
            }
            if (payments == 'Chuyển khoản') {
                let payments_input = $('#payments').val(2);
            }
            if (active_input) {
                $('.blade__search--customer--1').addClass('d__none--search');
            }
        })
    })
</script>

<script>
    $(document).ready(function () {
        $(document).click(function (evt) {
            if ($(evt.target).closest('.blade__search--customer')) {
                $('.blade__search--customer--1').addClass('d__none--search');

            }
        })
    })
</script>

