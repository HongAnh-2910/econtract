<div class="content__item-ajax">
    @if($folders != null)
        @if($folders->children->count() >0 || $folders->files->count() > 0)
            @foreach($folders->children as $folder)
                <div
                    class="content__upload--exp--item d-flex justify-content-between mt-2 mb-3 content__exp--hover--active content__exp--item--img1 list__users--color--cursor">
                    <div class="" style="cursor: pointer; min-width: 50px;">
                        <input type="hidden" data-uri="{{ route('web.contracts.contractFile',$folder) }}" data-id="{{ $folder->id }}"
                               id="content__upload--file--id">
                        <img src="{{ asset('images/svg/group_folder.svg') }}">
                    </div>
                    <div class="content__exp--name--file d-flex text-break pr-3 pl-2 align-items-center">
                        <span class="text__document--name">{{ $folder->name }}</span>
                    </div>
                    <div class="content__exp--size--file d-flex align-items-center">
                        9.08 KB
                    </div>
                </div>
            @endforeach
        @else
            <h5 class="text-center">Thư mục trống</h5>
        @endif
    @endif
    @if($folders != null)
        @if($folders->files->count() > 0)
            @foreach($folders->files as $file)
                <div
                    class="content__upload--exp--item d-flex justify-content-between content__active--file mt-2 mb-3 content__exp--hover--active list__users--color--cursor py-2">
                    <div class="content__exp--item--img d-flex custom__item--img">
                        <div class="table__contract--color">
                            <div class="form-check d-flex flex-row justify-content-center">
                                <input class="form-check-input dashboard__form--checkbox" type="checkbox"
                                       value="{{ $file->id }}"
                                       id="flexCheckDefault">
                            </div>
                        </div>
                        <input type="hidden" data-id="{{ $file->id }}"
                               data-file=""
                               id="content__upload--file--id">
                    </div>
                    <div class="content__exp--name--file d-flex text-break align-items-center flex-column pr-3 pl-2">
                        <img class="" width="35" height="29"
                             src="{{ get_extension_thumb($file->type) }}">
                        <span class="text__document--name">{{ $file->name }}</span>
                    </div>
                    <div class="content__exp--size--file d-flex custom__size--file">
                        {{ $file->size }} KB
                    </div>
                </div>
            @endforeach
        @endif
    @endif
    @if($files->count() > 0)
        @foreach($files as $file)
            <div
                class="content__upload--exp--item d-flex justify-content-between content__active--file mt-2 mb-3 content__exp--hover--active list__users--color--cursor py-2">
                <div class="content__exp--item--img d-flex custom__item--img">
                    <div class="table__contract--color">
                        <div class="form-check d-flex flex-row justify-content-center">
                            <input class="form-check-input dashboard__form--checkbox" type="checkbox"
                                   value="{{ $file->id }}"
                                   id="flexCheckDefault">
                        </div>
                    </div>
                    <input type="hidden" data-id="{{ $file->id }}"
                           data-file=""
                           id="content__upload--file--id">
                </div>
                <div class="content__exp--name--file d-flex text-break align-items-center flex-column pr-3 pl-2">
                    <img width="35" height="29" src="{{ get_extension_thumb($file->type) }}">
                    <span class="text__document--name">{{ $file->name }}</span>
                </div>
                <div class="content__exp--size--file d-flex align-items-center">
                    {{ $file->size }} KB
                </div>
            </div>
        @endforeach
    @endif
</div>

<script>
    $(document).ready(function () {
        $('.content__active--file').click(function () {
            $(this).toggleClass('content__exp--yes--active');
            $(this).find('.dashboard__form--checkbox').val();
            if (($(this).hasClass('content__exp--yes--active'))) {
                $(this).find('.dashboard__form--checkbox').attr('checked', 'checked')
            } else {
                $(this).find('.dashboard__form--checkbox').removeAttr('checked', 'checked')
            }
        })
    })
</script>

<script>
    $(document).ready(function () {
        $('.content__exp--item--img1').click(function () {
            var uri = $(this).find('#content__upload--file--id').attr('data-uri')
            var id_folder = $(this).find('#content__upload--file--id').attr('data-id')
            data = {id_folder: id_folder}
            $.ajax(
                {
                    url: uri,
                    data: data,
                    method: 'GET',
                    dataType: 'html',
                    success: function (data) {
                        $('.content__item-ajax').html(data);
                    },
                }
            )
        })
    })
</script>

