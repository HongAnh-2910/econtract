<div class="modal fade" id="{{ $element_id ?? '' }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    @csrf
{{--    @method('DELETE')--}}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $content ?? '' ? $content : 'Bạn chắc chắn muốn xoá ?' }}
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-primary button-account-edit ml-2 py-2 px-5 box-shadow-account bg-white text-dark"
                        data-bs-dismiss="modal">Đóng
                </button>
                <button type="submit"
                        class="btn btn-success button-account-edit py-2 px-5 box-shadow-account dashboard__button--primary">Đồng ý
                </button>
            </div>
        </div>
    </div>
</div>
