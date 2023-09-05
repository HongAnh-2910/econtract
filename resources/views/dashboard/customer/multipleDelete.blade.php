<div class="modal fade" id="customer__modal--multipleDelete" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                <button type="button" class="btn btn-primary" id="multiple_delete">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#multiple_delete').on('click', function() {
        var ids = [];
        $('.checkbox:checked').each(function() {
            ids.push($(this).attr('data-id'))
        })
        if (ids.length === 0) {
            $("#multiple_delete").css("display", "none");
        } else {
            var strIds = ids.join(",");
            var uri = '{{ route('web.customers.deleteMultipleCustomer') }}';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: uri,
                type: 'DELETE',
                data: 'ids=' + strIds,
                success: function() {
                    location.reload();
                }
            })
        }
    })
</script>
