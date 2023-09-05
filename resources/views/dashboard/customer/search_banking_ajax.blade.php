<div class="col-md-12 px-0">
    <select class="form-select item__data--bankingCustomer cursor" size="3" aria-label="size 5 select example"
        style="background: no-repeat">
        @if ($bankList->count() > 0)
            <div class="col-md-12">
                @foreach ($bankList as $banking)
                    <option class="value__banking--active my-2" value="{{ $banking->vn_name }}">
                        {{ $banking->vn_name }}
                        <div class="tem__data--banking--ky text-right">
                            ({{ $banking->shortName }})
                        </div>
                    </option>
                @endforeach
            </div>
        @else
            <option class="text-center">Tên ngân hàng không đúng...</option>
        @endif
    </select>
</div>

<!--   Add_banking   -->
<script>
    $(document).ready(function() {
        $('.value__banking--active').click(function() {
            var value = $(this).val();
            var active_input = $('#data__banking--addEnterprise').val(value);
            if (active_input) {
                $('.blade__search--bankingEnterprise').css('display', 'none');
            }
        })
    })
</script>
<script>
    $(document).ready(function() {
        $('.value__banking--active').click(function() {
            var value = $(this).val();
            var active_input = $('#data__banking--addPersonal').val(value);
            if (active_input) {
                $('.blade__search--bankingPersonal').css('display', 'none');
            }
        })
    })
</script>
<!--   Edit_banking   -->
<script>
    $(document).ready(function() {
        $('.item__data--bankingCustomer').click(function() {
            var value = $(this).val();
            var active_input = $('#data__banking--edit').val(value);
            if (active_input) {
                $('.blade__search--bankingEdit').css('display', 'none');
            }
        })
    })
</script>
