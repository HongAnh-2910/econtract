

        <div class="container-fluid html__box--active">
            @if($list_department->count() > 0)
                @foreach($list_department as $department)
                    <div class="department__wrapper mb-5">
                        <div class="department__wrapper-box d-inline-block">
                            <div class="box d-flex align-items-center">
                                <div class="department__parent department__color d-inline-block">
                    <span class="department__img">
                        <img width="40px" class="department__img--img" style="margin-top: 5px;"
                             src="{{ asset('images/admin.png') }}">
                    </span>
                                    <span class="department__name">
                                        {{ $department->name }}
                                    </span>
                                </div>
                                <div class="department__child  department__child--active position-relative">
                                    @foreach($department->children as $child)
                                        <div class="department__child--item">
                                            <div
                                                class="department__child--item--content justify-content-between  position-relative department__color">
                                                      <span class="department__img">
                                                            <img width="40px" class="department__img--img"
                                                                 src="{{ asset('images/admin.png') }}">
                                                        </span>
                                                <span class="department__name">
                                                    {{ $child->name }}
                                                </span>


                                                <span data-id = {{ $child->id }} class="button__toggle--circle">
                                                    @if($child->children->count() > 0)
                                                        <i class="fas fa-plus-circle"></i>
                                                    @endif
                                                </span>
                                            </div>
                                            <!-- child-->
                                            @if($child->id == $id)
                                            @endif

                                        </div>

                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>


    <script>
        $(document).ready(function () {
            $('.button__toggle--circle').click(function () {
                let id =  $(this).attr('data-id');
                let data = {id:id}
                $.ajax(
                    {
                        url: "{{ route('web.departments.treeChild') }}",
                        data: data,
                        method: 'GET',
                        dataType: 'html',
                        success: function (data) {
                            $('.html__box--active').html(data)
                        },
                    }
                )
            })
        })
    </script>


