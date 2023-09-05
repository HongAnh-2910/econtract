

<tr class="border-bottom text-center" id="results">
    <td>
        <input class="checkbox" type="checkbox"
               data-id="{{ $application->id }}">
    </td>
    @if ($application->userApplication)
        <td>
            <img
                src="{{ $application->userApplication->img_user ? get_file_thumb('avatar/' . $application->userApplication->img_user) : asset('images/admin.png') }}"
                alt="avatar"
                class="rounded-circle customer__table--img image__permission--round"/>
        </td>
    @else
        <td>
            <img src="{{ asset('images/admin.png') }}" alt="avatar"
                 class="rounded-circle customer__table--img image__permission--round"/>
        </td>
    @endif
    <td>
        <a type="button" data-uri="{{ route('web.applications.show', $application->id) }}"
           id="showApplicationButton" class="btn ml-1 customer__list--name"
           data-bs-toggle="modal" data-toggle="modal"
           data-bs-target="#application__modal--show_{{ $application->id }}">
            {{ $application->code }}
        </a>
    </td>
    <td>{{ $application->name }}</td>
    @include('dashboard.application.show' , ['id' => $application->id] ,
                                ['application'=> $application])
    <td>
        <button style="outline: none ; border: none" class="bg-success text-white px-3 py-2 rounded" disabled>
        Đơn từ theo dõi
        </button>
    </td>
    <td>{{ $application->reason }}</td>
    <td>
        @if (!empty($application->user->departments))
            @foreach ($application->user->departments as $department)
                {{ $department->name }}
            @endforeach
        @else
            Chưa có phòng ban
        @endif
    </td>
    <td>{{ $application->position }}</td>
    <td>
        @if($application->files == '1')
            <a
                href="{{ route('web.files.downloadApplicationFile', ['applicationId' => $application->id]) }}">
                <i class="far fa-arrow-alt-circle-down"></i>
            </a>
        @endif
    </td>
    <td>
    @if(request()->status == 'Đơn đề nghị')
        {{number_format($application->price_proposal , 0 ,'' , '.')."đ"}}
    @else
        @php
            $informationDays = $application->dateTimeOfApplications;
            $countDay = 0;
            foreach ($informationDays as $informationDay) {
                $to_date = Illuminate\Support\Carbon::createFromFormat('Y-m-d H:s:i', $informationDay->information_day_2);
                $from_date = Illuminate\Support\Carbon::createFromFormat('Y-m-d H:s:i', $informationDay->information_day_4);
                $countDay += $to_date->diffInDays($from_date);
            }
            echo $countDay . ' Ngày';
        @endphp
    @endif
    </td>
    <td>{{$application->created_at ?? ''}}</td>
    {{-- <td class="description__application application__description--text">{!! $application->description !!}</td> --}}
    @if ($application->application_type == 'Đơn đề nghị')
        <td><a class="m-3" type="button"
               href="{{ route('web.applications.editProposal', $application->id) }}"><i
                    class="fas fa-edit"></i></a></td>
    @else
        <td><a class="m-3" type="button"
               href="{{ route('web.applications.edit', $application->id) }}"><i
                    class="fas fa-edit"></i></a></td>
    @endif

</tr>
