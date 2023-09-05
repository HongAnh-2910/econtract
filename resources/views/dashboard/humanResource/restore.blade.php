<div class="modal fade" id="HRM__modal--restore" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn muốn khôi phục dữ liệu này!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="HRM__multiple--restore">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#HRM__multiple--restore').on('click', function() {
        var ids = [];
        $('.checkbox:checked').each(function() {
            ids.push($(this).attr('data-id'))
        })

        if (ids.length === 0) {
            $("#HRM__multiple--restore").css("display", "none");
        } else {
            var strIds = ids.join(",");
            var uri = '{{ route('web.human-resources.restore') }}';

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
