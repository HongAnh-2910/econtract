


<div class="modal fade" id="exampleModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa hợp đồng này ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="submit" id="application__multiple--delete" class="btn dashboard__button--primary text-white">Đồng ý</button>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function (){
        $('#application__multiple--delete').on('click', function() {
            var ids = [];
            $('.checkbox:checked').each(function() {
                ids.push($(this).attr('data-id'))
            })
            const data = {ids : ids}
            $.ajax({
                url: "{{ route('web.contracts.deleteContract') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: 'POST',
                data: data,
                dataType: 'html',
                success: function (data) {
                    console.log(data)
                    location.reload(data);
                },
            })
        })
    })
    </script>

