{{--@if (count($applications) == 0)--}}
{{--    <tr>--}}
{{--        <td colspan="9" class="text-center">Không có dữ liệu...</td>--}}
{{--    </tr>--}}
{{--@else--}}
{{--    @foreach ($applications as $application)--}}
{{--        <tr class="border-bottom text-center" id="results">--}}
{{--            <td>--}}
{{--                <input class="checkbox" type="checkbox" data-id="{{ $application->id }}">--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                <img src="{{ \Illuminate\Support\Facades\Auth::user()->avatar_link }}" alt="avatar"--}}
{{--                    class="rounded-circle customer__table--img image__permission--round" />--}}
{{--            </td>--}}
{{--            <td>{{ $application->code }}</td>--}}
{{--            <td>--}}
{{--                <a type="button" data-uri="{{ route('application.show', $application->id) }}"--}}
{{--                    id="showApplicationButton" class="btn ml-1 customer__list--name" data-bs-toggle="modal"--}}
{{--                    data-toggle="modal" data-bs-target="#application__modal--show_{{ $application->id }}">--}}
{{--                    {{ $application->name }}--}}
{{--                </a>--}}
{{--            </td>--}}

{{--            @include('dashboard.application.show' , ['id' => $application->id] ,--}}
{{--            ['application'=> $application])--}}

{{--            @if ($application->status == 'Chờ duyệt')--}}
{{--                <td>--}}
{{--                    <button type="button" id="application__button--showModalChangeStatus" class="btn btn-warning"--}}
{{--                        data-bs-toggle="modal" data-bs-target="#application__modal--changeStatus" class="dropdown-item"--}}
{{--                        data-uri="{{ route('application.show', $application->id) }}">--}}
{{--                        {{ $application->status }}--}}
{{--                    </button>--}}
{{--                </td>--}}
{{--            @elseif ($application->status == 'Đã duyệt')--}}
{{--                <td class="text-success">--}}
{{--                    {{ $application->status }}--}}
{{--                </td>--}}
{{--            @elseif ($application->status == 'Không duyệt')--}}
{{--                <td class="text-danger">--}}
{{--                    {{ $application->status }}--}}
{{--                </td>--}}
{{--            @endif--}}



{{--            <td>{{ $application->application_type }}</td>--}}
{{--            <td>{{ $application->department_id }}</td>--}}
{{--            <td>{{ $application->position }}</td>--}}
{{--            <td>{{ date('d/m/Y', strtotime($application->created_at)) }}</td>--}}
{{--            <td>--}}
{{--                @php--}}
{{--                    $informationDays = $application->dateTimeOfApplications;--}}
{{--                    $countDay = 0;--}}
{{--                    foreach ($informationDays as $informationDay) {--}}
{{--                        $to_date = Illuminate\Support\Carbon::createFromFormat('Y-m-d H:s:i', $informationDay->information_day_2);--}}
{{--                        $from_date = Illuminate\Support\Carbon::createFromFormat('Y-m-d H:s:i', $informationDay->information_day_4);--}}
{{--                        $countDay += $to_date->diffInDays($from_date);--}}
{{--                    }--}}
{{--                    echo $countDay . ' Ngày';--}}
{{--                @endphp--}}
{{--            </td>--}}
{{--            <td class="description__application application__description--text">{!! $application->description !!}</td>--}}
{{--            <td><a class="m-3" type="button" href="{{ route('application.edit', $application->id) }}"><i--}}
{{--                        class="fas fa-edit"></i></a></td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--@endif--}}

@if (count($applications) == 0)
    <tr>
        <td colspan="9" class="text-center">Không có dữ liệu...</td>
    </tr>
@else
    @foreach ($applications as $application)
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
            <td>{{ $application->code }}</td>
            <td>
                <a type="button" data-uri="{{ route('web.applications.show', $application->id) }}"
                   id="showApplicationButton" class="btn ml-1 customer__list--name"
                   data-bs-toggle="modal" data-toggle="modal"
                   data-bs-target="#application__modal--show_{{ $application->id }}">
                    {{ $application->name }}
                </a>
            </td>
            @include('dashboard.application.show' , ['id' => $application->id] ,
            ['application'=> $application])
            @if ($application->status == 'Chờ duyệt')
                @if (Auth::id() == $application->user_id)
                    <td>
                        <button type="button" id="application__button--showModalChangeStatus"
                                class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#application__modal--changeStatus"
                                class="dropdown-item"
                                data-uri="{{ route('web.applications.show', $application->id) }}">
                            {{ $application->status }}
                        </button>
                    </td>
                @else
                    <td class="text-warning">
                        {{ $application->status }}
                    </td>
                @endif
            @elseif ($application->status == 'Đã duyệt')
                <td class="text-success">
                    {{ $application->status }}
                </td>
            @elseif ($application->status == 'Không duyệt')
                <td class="text-danger">
                    {{ $application->status }}
                </td>
            @endif
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
            <td>{{ date('d/m/Y', strtotime($application->created_at)) }}</td>
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
    @endforeach
@endif
{{--    @include('dashboard.application.changeStatus')--}}
