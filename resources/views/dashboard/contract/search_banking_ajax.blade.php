<div class="col-md-12">
    @if($searchBanking->count() > 0)
        @foreach($searchBanking as $banking)
            <div class="item__data--banking cursor">
                <input type="text" class="value__banking--active" value="{{ $banking->vn_name }}" hidden>
                {{ $banking->vn_name }}
                <div class="tem__data--banking--ky">
                    {{ $banking->shortName }}
                </div>
            </div>
        @endforeach
    @endif
</div>
<style>
    .d__none--search {
        display: none !important;
    }
</style>
{{--{{ add_banking }}--}}
<script>
    $(document).ready(function () {
        if ($('#data__banking').val().length == 0) {
            $('.blade__search--banking--1').removeClass('d__none--search');
            $('.blade__search--banking').css('display','block')
        }
        $('.item__data--banking').click(function () {
            let value = $(this).find('.value__banking--active').val();
            let active_input = $('#data__banking').val(value);
            if (active_input) {
                $('.blade__search--banking--1').addClass('d__none--search');
            }
        })
    })
</script>

<script>
    $(document).ready(function () {
        $(document).click(function (evt) {
            if($(evt.target).closest('.blade__search--banking'))
            {
                $('.blade__search--banking--1').addClass('d__none--search');

            }
        })
    })
</script>

