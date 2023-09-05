@foreach($names as $key=>$value)
<div
    class="modal__contract--list--contract px-2 mt-3 mb-3 border rounded d-flex justify-content-between">
    <div class="modal__contract--list--item d-flex">
        <div class="modal__contract--list--icon d-flex align-items-center pr-2">
            <img width="27px" height="25px" src="{{ get_extension_thumb($type[$key]) }}">
        </div>
        <div class="">
            <span class="modal__contract--list-title">{{ $value }}</span>
            <span class="d-block modal__contract--list-size">{{ number_format($size[$key] , 0 ,'' , '.') }} KB</span>
        </div>
    </div>
    <div class="dropdown d-flex align-items-center px-2 list__users--color--cursor">
        <div class="remove__file--button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
{{--        <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"--}}
{{--             aria-haspopup="true" aria-expanded="false">--}}
{{--            <i style="font-size: 20px" class="fas fa-ellipsis-v"></i>--}}
{{--        </div>--}}
{{--        <div style="width: 60px" class="dropdown-menu"--}}
{{--             aria-labelledby="dropdownMenuButton">--}}
{{--            <form method="POST">--}}
{{--                <button class="dropdown-item"--}}
{{--                        style="font-size: 15px ; outline: none">--}}
{{--                    <i class="fas fa-window-restore"></i>--}}
{{--                    Tác vụ 1--}}
{{--                </button>--}}
{{--            </form>--}}
{{--            <button--}}
{{--                data-toggle="modal" data-target="#exampleModal1"--}}
{{--                class="dropdown-item" type="submit"--}}
{{--                style="font-size: 15px; outline: none"><i--}}
{{--                    class="fa fa-trash"></i> Tác vụ 2--}}
{{--            </button>--}}
{{--        </div>--}}
    </div>
</div>
@endforeach

<script>
    $(document).ready(function () {
        $('.remove__file--button').on('click', function () {
            // lay ten file muon xoa
            const containerFileView = $(this).closest('.modal__contract--list--contract');
            const fileName = containerFileView.find('.modal__contract--list-title').text();

            // lay FileList tu file input va convert sang array
            const fileInput = $('#select_file');
            let files = fileInput.prop("files");
            let fileArray = Array.from(files);
            // xoa file trong FileList neu file do trung ten vs file muon xoa
            fileArray.map((item, index) => {
                if (item.name === fileName) {
                    fileArray.splice(index, 1)
                }
            })

            // set cac file con lai vao filename
            const dt = new DataTransfer();

            fileArray.map(fileItem => {
                dt.items.add(fileItem)

            })
            fileInput.prop("files", dt.files);

            // xoa view chua file do di
            containerFileView.remove()
        })
    })
</script>
