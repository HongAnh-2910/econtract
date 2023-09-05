<div class="box__folder">
    <ul class="list-unstyled mb-0 pb-4 list__file--parent">
        @if($folder->count() > 0)
            @foreach($folder as $parent)
                <li class="d-flex flex-md-column align-items-md-center flex-lg-row py-3 border-bottom content__upload--file--item active__private--folder">
                    <input type="hidden"
                           class="folder__id"
                           data-uri="{{ route('web.folders.showFolderChild',$parent->id) }}"
                           data-id="{{ $parent->id }}"
                           id="content__upload--file--id">
                    <div class="content__upload--file--icon">
                        <img height="33"
                             src="{{ asset('images/svg/group_folder.svg') }}">
                    </div>
                    <div class="content__upload--file--title pl-md-0 pl-3 pl-lg-3 pt-md-2 pt-lg-0">
                        <div class="content__upload--title--top text-md-center text-lg-left">
                            {{ $parent->name }}
                        </div>
                        <span class="content__upload--title--kb text-md-center text-lg-left d-md-inline-block d-lg-inline w-100">800 KB</span>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>


{{--file_ajax--}}
<script>
    $(document).ready(function () {
        $('li.content__upload--file--item').click(function () {
            if($(this).hasClass('active__private--folder'))
            {
                $('li.content__upload--file--item').removeClass('content__exp--yes--active')
                $(this).addClass('content__exp--yes--active');
                let id = $(this).find('#content__upload--file--id').attr('data-id');
                let uri = $(this).find('#content__upload--file--id').attr('data-uri');
                let files_id = $('#files_sub_id').val();
                let folder_id = $('#folder_sub_id').val();
                let data = {id: id , files_id:files_id ,folder_id:folder_id}
                $.ajax(
                    {
                        url: uri,
                        data: data,
                        method: 'GET',
                        dataType: 'html',
                        success: function (data) {
                            $('.html_file').html(data);
                            $('#parent_sub_id').val(id);
                        },
                    }
                )
            }
        })
    })
</script>
