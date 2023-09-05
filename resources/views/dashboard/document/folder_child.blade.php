<div class="content__item-ajax" data-id="{{ $id }}">
    @if($folders->children->count() >0 || $folders->files->count() > 0)
        @foreach($folders->children as $folder)
            @if($folder->id != $folderId)
                <div
                    class="content__upload--exp--item d-flex justify-content-between mt-2 mb-3 content__exp--hover--active content__exp--item--img1 list__users--color--cursor">
                    <div class="" style="cursor: pointer; min-width: 50px;">
                        <input class="child__value--id" type="hidden"
                               data-uri="{{ route('web.folders.showFolderChild',$folder) }}"
                               data-id="{{ $folder->id }}"
                               id="content__upload--file--id">
                        <img src="{{ asset('images/svg/group_folder.svg') }}">
                    </div>
                    <div class="content__exp--name--file pl-2 pr-3 d-flex align-items-center">
                        <span class="text__document--name">{{ $folder->name }}</span>
                    </div>
                    <div class="content__exp--size--file d-flex align-items-sm-center">
                        9.08 KB
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <h5 class="text-center">Thư mục trống</h5>
    @endif

    @if($folders->files->count() > 0)
        @foreach($folders->files as $file)
            @if($file->id != $filesId)
                <div
                    class="content__upload--exp--item d-flex justify-content-between content__active--file mt-2 mb-3 content__exp--hover--active list__users--color--cursor py-2">
                    <div class="content__exp--item--img d-flex" style="cursor: pointer; min-width: 50px;">
{{--                        <div class="table__contract--color">--}}
{{--                            <div class="form-check d-flex flex-row justify-content-center">--}}
{{--                                <input class="form-check-input dashboard__form--checkbox" type="checkbox"--}}
{{--                                       value="{{ $file->id }}"--}}
{{--                                       id="flexCheckDefault">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <input type="hidden" data-id="{{ $file->id }}"
                               data-file="" ;
                               id="content__upload--file--id">
                        <img width="35" height="29"
                             src="{{ get_extension_thumb($file->type) }}">
                    </div>
                    <div class="content__exp--name--file pl-2 pr-3 d-flex align-items-center">
                        <span class="text__document--name">{{ $file->name }}</span>
                    </div>
                    <div class="content__exp--size--file d-flex align-items-sm-center">
                        {{ $file->size }} KB
                    </div>
                </div>
            @endif
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
            var id = $(this).find('#content__upload--file--id').attr('data-id')
            let files_id = $('#files_sub_id').val();
            let folder_id = $('#folder_sub_id').val();
            let data = {id: id, files_id: files_id, folder_id: folder_id}
            $.ajax(
                {
                    url: uri,
                    data: data,
                    method: 'GET',
                    dataType: 'html',
                    success: function (data) {
                        $('.content__item-ajax').html(data);
                        $('#parent_sub_id').val(id);
                    },
                }
            )
        })
    })
</script>

