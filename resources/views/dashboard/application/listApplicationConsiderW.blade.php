
@if(request()->status == config('statuses.recommend') && $countRecommend ==0 && $considerApplication->count() == 0)
    <tr>
        <td colspan="9" class="text-center">Không có dữ liệu...</td>
    </tr>
@elseif(request()->status == config('statuses.rest')  && $countRest ==0 && $considerApplication->count() == 0)
    <tr>
        <td colspan="9" class="text-center">Không có dữ liệu...</td>
    </tr>
@else
@foreach ($considerApplication as $application)
    @if(request()->status == config('statuses.rest') && $application->application_type == config('statuses.rest'))
        @include('dashboard.application.ItemListDecisionApplication' , compact('application'))
    @elseif(request()->status == config('statuses.recommend') && $application->application_type == config('statuses.recommend'))
        @include('dashboard.application.ItemListDecisionApplication' , compact('application'))
    @elseif(request()->status == config('statuses.all'))
        @include('dashboard.application.ItemListDecisionApplication' , compact('application'))
    @elseif(request()->status == '')
        @include('dashboard.application.ItemListDecisionApplication' , compact('application'))
    @endif
@endforeach
@endif
