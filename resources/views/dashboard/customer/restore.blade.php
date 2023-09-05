<div class="modal fade" id="customer__modal--restore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <input name="id" id="customer__id--restore" value="{{ $customer->id }}" hidden >
                Bạn muốn khôi phục dữ liệu!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" data-uri-restore="{{ route('web.customers.restore') }}" id="customer__button--restore">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#customer__button--restore').click(function() {
            var id = $('#customer__id--restore').val();
            var uri = $(this).attr('data-uri-restore');
            var urlrestore = uri + '/' + id;
            $.ajax({
                url: urlrestore,
                method: 'GET',
                success: function () {
                    $('#customer__button--restore').modal('hide');
                    location.reload();
                },
            })
        })
    })
</script>
