<div class="col-md-12 px-0">
    <div class="item__data--banking p-0 cursor">
        <input type="text" class="value__banking--active change_chart_year"  value="Overall" hidden>
        <span class="pl-1" style="font-size: 14px ; font-weight: normal">Overall</span>
    </div>
    <div class="item__data--banking p-0 cursor">
        <input type="text" class="value__banking--active change_chart_year"  value="Last Year" hidden>
        <span class="pl-1" style="font-size: 14px ; font-weight: normal">Last Year</span>
    </div>
    <div class="item__data--banking p-0 cursor">
        <input type="text" class="value__banking--active change_chart_year"  value="This Year" hidden>
        <span class="pl-1" style="font-size: 14px ; font-weight: normal">This Year</span>
    </div>
    <div class="item__data--banking p-0 cursor">
        <input type="text" class="value__banking--active change_chart_year"  value="Customize" hidden>
        <span class="pl-1" style="font-size: 14px ; font-weight: normal"><input type="date" name="dateTime" value="" class="get_date_time"></span>
    </div>

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
    $(document).ready(() => {
        $('.item__data--banking').on('click' , () => {
            const value =$('.change_chart_year').val();
            const getDate = $('.get_date_time').val();
            let data = {value:value , getDate:getDate}
            $.ajax({
                url:"{{ route('web.human-resources.filterYearChart') }}",
                method: 'GET',
                data : data,
                dataType: 'html',
                success:function success(data)
                {
                    $('.boxHtml__chart-year').html(data)
                }
            })
        })
    })
</script>

{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        $(document).click(function (evt) {--}}
{{--            if($(evt.target).closest('.blade__search--banking'))--}}
{{--            {--}}
{{--                $('.blade__search--banking--1').addClass('d__none--search');--}}

{{--            }--}}
{{--        })--}}
{{--    })--}}
{{--</script>--}}
