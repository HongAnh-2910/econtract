<div class="modal fade" id="customer__modal--delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <input name="id" id="customer__id--softDelete" value="{{ $customer->id }}" hidden >
                Bạn chắc chắn muốn xóa!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" data-uri-softDelete="{{ route('web.customers.delete') }}" id="customer__button--softDelete">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#customer__button--softDelete').click(function() {
            var id = $('#customer__id--softDelete').val();
            var uri = $(this).attr('data-uri-softDelete');
            var urlSoftDelete = uri + '/' + id;
            $.ajax({
                url: urlSoftDelete,
                method: 'GET',
                success: function () {
                    $('#customer__button--softDelete').modal('hide');
                    location.reload();
                },
            })
        })
    })
</script>
