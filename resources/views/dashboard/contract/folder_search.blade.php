@if($folderParent->count() > 0)
    @foreach($folderParent as $parent)
        @if(!empty($idFolder))
            @if( $idFolder != $parent->id)
        <li class="d-flex py-4 border-bottom content__upload--file--item">
            <input type="hidden" data-uri="{{ route('web.contracts.contractFile',$parent->id) }}" data-id="{{ $parent->id }}"
                   id="content__upload--file--id">
            <div class="content__upload--file--icon">
                <img height="33" src="{{ asset('images/svg/group_folder.svg') }}">
            </div>
            <div class="content__upload--file--title pl-4">
                <div class="content__upload--title--top">
                    {{ $parent->name }}
                </div>
                <span class="content__upload--title--kb">800 KB</span>
            </div>
        </li>
            @endif
        @else
            <li class="d-flex py-4 border-bottom content__upload--file--item">
                <input type="hidden" data-uri="{{ route('web.contracts.contractFile',$parent->id) }}" data-id="{{ $parent->id }}"
                       id="content__upload--file--id">
                <div class="content__upload--file--icon">
                    <img height="33" src="{{ asset('images/svg/group_folder.svg') }}">
                </div>
                <div class="content__upload--file--title pl-4">
                    <div class="content__upload--title--top">
                        {{ $parent->name }}
                    </div>
                    <span class="content__upload--title--kb">800 KB</span>
                </div>
            </li>
        @endif
    @endforeach
    @else
        <div class="text text-danger">Thư mục bạn tìm không tồn tại</div>
@endif


<script>
    $(document).ready(function () {
        $('li.content__upload--file--item').click(function () {
            var id = $(this).find('#content__upload--file--id').attr('data-id');
            var uri = $(this).find('#content__upload--file--id').attr('data-uri');
            data = {id: id}
            $.ajax(
                {
                    url: uri,
                    data: data,
                    method: 'GET',
                    dataType: 'html',
                    success: function (data) {
                        $('.html_file').html(data);
                    },
                }
            )
        })
    })
</script>



