<div class="modal fade" id="application__modal--changeStatus" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Duyệt đơn từ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="application__changeStatus--id" hidden>
                <p>Duyệt 1 đơn từ đã chọn</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="application__changeStatus--review"
                    data-bs-dismiss="modal">Duyệt</button>
                <button type="button" class="btn btn-danger" id="application__changeStatus--notReview"
                    data-bs-dismiss="modal">Không Duyệt</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#application__changeStatus--review').on('click', function() {
            console.log('ok');
            var id = $('#application__changeStatus--id').val();
            var uri = '{{ route('web.applications.changeStatusReview') }}';
            var url = uri + '/' + id;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                type: 'POST',
                success: function() {
                    location.reload();
                }
            })
        })
    })
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#application__changeStatus--notReview').on('click', function() {
            var id = $('#application__changeStatus--id').val();
            var uri = '{{ route('web.applications.changeStatusNotReview') }}';
            var url = uri + '/' + id;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                type: 'POST',
                success: function() {
                    location.reload();
                }
            })
        })
    })
</script>
