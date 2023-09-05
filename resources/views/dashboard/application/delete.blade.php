<div class="modal fade" id="application__modal--multipleDelete" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn muốn xóa dữ liệu này!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="application__multiple--delete">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#application__multiple--delete').on('click', function() {
        var ids = [];
        $('.checkbox:checked').each(function() {
            ids.push($(this).attr('data-id'))
        })

        if (ids.length === 0) {
            $("#application__multiple--delete").css("display", "none");
        } else {
            var strIds = ids.join(",");
            var uri = '{{ route('web.applications.destroy') }}';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: uri,
                type: 'GET',
                data: 'ids=' + strIds,
                success: function() {
                    location.reload();
                }
            })
        }
    })
</script>
