

<!-- Modal confirm -->
<div class="modal fade " style="transform: translateY(18%)" id="modalDeleteId_{{ $user->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <form method="POST" action="{{ route('web.profile.delete', $user->id) }}">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn chắc chắn muốn xoá thành viên ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Huỷ
                    </button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </form>
</div>
