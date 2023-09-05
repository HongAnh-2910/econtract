<div class="modal fade" id="customer__modal--permanentlyDeletedMultipleCustomer" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn muốn xóa vĩnh viễn dữ liệu này!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="permanentlyDeletedMultipleCustomer">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#permanentlyDeletedMultipleCustomer').on('click', function() {
        var ids = [];
        $('.checkbox:checked').each(function() {
            ids.push($(this).attr('data-id'))
        })

        if (ids.length === 0) {
            $("#permanentlyDeletedMultipleCustomer").css("display", "none");
        } else {
            var strIds = ids.join(",");
            var uri = '{{ route('web.customers.permanentlyDeletedMultipleCustomer') }}';

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
