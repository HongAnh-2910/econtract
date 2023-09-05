<div class="modal fade" id="customer__modal--permanentlyDeleted" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input name="id" id="customer__id--permanentlyDeleted" value="{{ $customer->id }}" hidden >
                Bạn muốn xóa vĩnh viễn!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" data-uri-permanentlyDeleted="{{ route('web.customers.permanentlyDeleted') }}" id="customer__button--permanentlyDeleted">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#customer__button--permanentlyDeleted').click(function() {
            var id = $('#customer__id--permanentlyDeleted').val();
            var uri = $(this).attr('data-uri-permanentlyDeleted');
            var urlpermanentlyDeleted = uri + '/' + id;
            $.ajax({
                url: urlpermanentlyDeleted,
                method: 'GET',
                success: function () {
                    $('#customer__button--permanentlyDeleted').modal('hide');
                    location.reload();
                },
            })
        })
    })
</script>
