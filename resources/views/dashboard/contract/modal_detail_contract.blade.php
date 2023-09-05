@if($itemContract->count() > 0)
    <div class="container-fluid exampleModalLong--1" style="overflow-y: scroll">
        <div class="bg-white mt-4 mx-sm-5 mx-0">
            @include('dashboard.spinner_modal')
            <div class="row">
                <div class="col-md-12 modal__contract--bg--header">
                    <span class="text-dark pl-3 d-inline-block py-1">THÔNG TIN KHÁCH HÀNG</span>
                </div>
            </div>
            <div class="d-md-flex">
                <div class="col-md-6 pl-0">
                    <div class="modal__contract--info--left d-flex">
                        <div class="col-md-12 mt-4 d-flex flex-wrap">
                            <div class="modal__contract--info--title create__contract--form--fz mb-4 w-50">Mã Hợp
                                đồng <span class="text-danger">*</span></div>
                            <div
                                class="modal__contract--info--title create__contract--form--fz mb-4 w-50 modal__contract--info--active">
                                {{ $itemContract->code }}
                            </div>
                            <div class="modal__contract--info--title create__contract--form--fz mb-4 w-50">Loại
                                hợp đồng
                            </div>
                            <div
                                class="modal__contract--info--title create__contract--form--fz mb-4  w-50 modal__contract--info--active">
                                Hợp đồng nội bộ
                            </div>
                            <div class="modal__contract--info--title create__contract--form--fz mb-4 w-50">Mã số
                                thuế
                            </div>
                            <div
                                class="modal__contract--info--title create__contract--form--fz mb-4  w-50 modal__contract--info--active">
                                {{ $itemContract->code_fax }}
                            </div>
                            <div class="modal__contract--info--title create__contract--form--fz mb-4 w-50">Tên
                                khách hàng
                            </div>
                            <div
                                class="modal__contract--info--title create__contract--form--fz mb-4 w-50 pb-1 modal__contract--info--active">
                                {{ $itemContract->name_customer }}
                            </div>
                            <div class="modal__contract--info--title create__contract--form--fz mb-4 w-50">Tên
                                công ty
                            </div>
                            <div
                                class="modal__contract--info--title create__contract--form--fz mb-4 w-50 pb-1 modal__contract--info--active">
                                {{ $itemContract->name_cty }}
                            </div>
                            <div style="font-size: 16px"
                                 class="modal__contract--info--title create__contract--form--fz mb-4 w-50">Hình
                                thức thanh toán
                            </div>
                            <div
                                class="modal__contract--info--title create__contract--form--fz mb-4  w-50 modal__contract--info--active">
                                @if($itemContract->payments == 1)
                                    Tiền mặt
                                @elseif($itemContract->payments == 2)
                                    Chuyển khoản
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pl-0">
                    <div class="modal__contract--info--right">
                        <div class="col-md-12 mt-0 mt-md-4  d-flex flex-wrap">
                            <div class="modal__contract--info--title create__contract--form--fz mb-4 w-50">Ngày
                                hợp đồng
                            </div>
                             <div
                                class="modal__contract--info--title create__contract--form--fz mb-4  w-50 modal__contract--info--active">
                                {{ $itemContract->created_at }}
                            </div>
                            <div class="modal__contract--info--title create__contract--form--fz mb-4 w-50">Email
                                <span class="text-danger">*</span></div>
                            <div
                                class="text-break modal__contract--info--title create__contract--form--fz mb-4  w-50 modal__contract--info--active">
                                {{ $itemContract->email }}
                            </div>
                            <div class="modal__contract--info--title create__contract--form--fz mb-4 w-50">Địa
                                chỉ <span class="text-danger">*</span></div>
                            <div
                                class="modal__contract--info--title create__contract--form--fz mb-4 pb-1 w-50 modal__contract--info--active">
                                {{ $itemContract->address }}
                            </div>
                            <div class="modal__contract--info--title create__contract--form--fz mb-4 w-50">Tại
                                ngân hàng
                            </div>
                            <div
                                class="modal__contract--info--title create__contract--form--fz mb-4 w-50 pb-1 modal__contract--info--active">
                                {{ $itemContract->banking->vn_name ?? ''  }}
                            </div>
                            <div class="modal__contract--info--title create__contract--form--fz mb-4 w-50">Số tài
                                khoản
                            </div>
                            <div
                                class="modal__contract--info--title create__contract--form--fz mb-4 w-50 modal__contract--info--active">
                                {{ $itemContract->name_account }}
                            </div>
                        </div>
                        <div class="col-md-8 mt-4">
                        </div>
                    </div>
                </div>
            </div>
            {{--end-detail  --}}
            <div class="row">
                <div class="col-md-12 modal__contract--bg--header">
                    <span class="text-dark pl-3 d-inline-block py-1">DANH SÁCH HỢP ĐỒNG</span>
                </div>
            </div>
            {{--end-list-contract-header--}}
            <div class="row">
                @if($itemContract->files->count() > 0)
                    @foreach($itemContract->files as $file)
                        <div class="col-md-12">
                            <div class="modal__contract--list--contract pl-3 mt-3 mb-3">
                                <div class="modal__contract--list--item d-flex">
                                    <div class="modal__contract--list--icon d-flex align-items-center pr-2">
                                        <img width="27" height="25" src="{{ get_extension_thumb($file->type) }}">
                                        <input type="text" data-url ="{{ route('web.contracts.contractEdit', $itemContract->id) }}" class="get__class--by--contract"  hidden>
                                    </div>
                                    <div class="">
                                        <span class="modal__contract--list-title text-break">{{ $file->name }}</span>
                                        <span class="d-block modal__contract--list-size">{{ $file->size }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                {{--file_model_file--}}
                @if($listFilesContract->count() > 0)
                    @foreach($listFilesContract as $file)
                        <div class="col-md-12">
                            <div class="modal__contract--list--contract pl-3 mt-3 mb-3">
                                <div class="modal__contract--list--item d-flex">
                                    <div class="modal__contract--list--icon d-flex align-items-center pr-2">
                                        <img width="27" height="25" src="{{ get_extension_thumb($file->type) }}">
                                        <input type="text" data-url ="{{ route('web.contracts.contractEdit', $itemContract->id) }}" class="get__class--by--contract"  hidden>
                                    </div>
                                    <div class="">
                                        <span class="modal__contract--list-title text-break">{{ $file->name }}</span>
                                        <span class="d-block modal__contract--list-size">{{ $file->size }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            {{--listFollow--}}
            <div class="row">
                @if($listFollow->count() > 0 && $listFollow[0]->email_follow)
                <div class="col-md-12 modal__contract--bg--header">
                    <span class="text-dark pl-3 d-inline-block py-1">DANH SÁCH NGƯỜI THEO DÕI</span>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="modal__contract--list--contract pl-3 mt-3 mb-3">
                                @foreach($listFollow as $follow)
                                    @if($follow->email_follow)
                            <p class="name_follow">{{ $follow->email_follow }}<span style="font-size: 14px" class="{{ $follow->active_screen != null ? 'text-success' : 'text-warning' }} ml-2">
                                    {{ $follow->active_screen != null ? 'Đã xem' : 'Chưa xem' }}
                                    @endif
                                </span></p>
                                @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
            {{-- end-list-word--}}
            <div class="row">
                <div class="col-md-12 modal__contract--bg--header">
                    <span class="text-dark pl-3 d-inline-block py-1">TRẠNG THÁI HỢP ĐỒNG</span>
                </div>
            </div>
            <div class="mt-4 mb-5">
                @if(isset($itemContract))
                    <div class="col-md-6 col-12 dashboard__contract--status">
                        @if($itemContract->status == 'success')
                            <div class="d-flex align-items-center">
                                <i class="fa fa-check fa-1x text-success" aria-hidden="true"></i>
                                <h5 class="ml-3 mb-0 text-success">Hoàn thành</h5>
                            </div>
                        @else
                            @if($itemContract->is_mailed)
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-exclamation text-warning" aria-hidden="true"></i>
                                    <h5 class="ml-3 mb-0 text-warning">Chưa hoàn thành</h5>
                                </div>
                            @else
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-exclamation text-warning" aria-hidden="true"></i>
                                    <h5 class="ml-3 mb-0 text-warning">Chưa phát hành</h5>
                                </div>
                            @endif

                        @endif


                        <ul class="dashboard__timeline">
                            @foreach($itemContract->signatures->where('token','!=',null)->sortBy('sign_sequence') as $key => $signature)
                                <li class="{{ $signature->is_signature ? 'dashboard__timeline--active' : '' }}">
                                    <div class="d-flex align-items-md-center justify-content-between align-items-start flex-md-row flex-column">
                                        <a target="_blank" href="">Thứ tự {{ $signature->sign_sequence }}:</a>
                                        <a href="#" class="float-right">{{ \Carbon\Carbon::parse($signature->signatured_at)->format('d/m/Y H:i') }}</a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <span>Người ký:</span>
                                            <span>Email</span>
                                            <span>Trạng thái:</span>
                                        </div>
                                        <div class="d-flex flex-column ml-4">
                                            <span class="font-weight-bold">{{ $signature->name }}</span>
                                            <span>
                                                {{ $signature->email }}
                                                <!-- Neu chua ky va contract da duoc mail thi moi cho gui lai email -->
                                                    @if(!$signature->is_signature && $itemContract->is_mailed)
                                                        <a href="#" data-signature="{{ $signature->id }}" class="text-warning pe-auto dashboard__resend--button">(Gửi lại)</a>
                                                    @endif
                                            </span>
                                            <span class="{{ $signature->is_signature ? 'text-success': 'text-warning' }}">{{ $signature->signature_status }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="container-fluid px-0">
        <div class="modal__contract--bg--header">
            <div class="d-flex justify-content-end pr-3 pb-3 flex-wrap">
                <div class="d-flex justify-content-center mt-2 flex-wrap">
                    @if(!$itemContract->is_mailed)
                        @if($itemContract->status == 'wait_approval')
                            <form id="formPublish" method="POST" action="{{ route('web.contracts.publishContract') }}" class="d-flex flex-row mr-1">
                                @csrf
                                <input type="hidden" name="contract_id" value="{{ $itemContract->id }}" />
                                <button type="submit"
                                        class="btn btn-success button-account-edit text-center box-shadow-account btn__action--contacts bg-success">Gửi email
                                </button>
                            </form>
                        @endif
                        @if($itemContract->status == 'wait_approval' || $itemContract->status == 'canceled')
                            <a href="{{ route('web.contracts.contractEdit', ['slug' => $itemContract->slug]) }}"
                               class="btn__action--contacts btn btn-primary button-account-edit text-center box-shadow-account click__edit--a"
                               style="background-color: #F26D21">Sửa
                            </a>
                       @endif
                    @endif
                </div>
                <div class="d-flex ml-2 justify-content-center mt-2">
                    <button type="submit"
                            class="btn btn-primary btn__action--contacts button-account-edit text-center box-shadow-account"
                            data-dismiss="modal" style="background-color: #5442BC">Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.dashboard__resend--button').on('click', function () {
                const signatureId = $(this).data('signature')
                const data = {signature: signatureId}
                const spinner = $('#spinner-modal');
                spinner.removeClass('d-none')
                spinner.addClass('d-flex')

                $.ajax(
                    {
                        url: '{{ route('web.contracts.resendEmail') }}',
                        data: data,
                        method: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            spinner.removeClass('d-flex')
                            spinner.addClass('d-none')
                            $('.dashboard__contract--status').prepend('<div class="alert alert-success alert-dismissible">Gửi mail thành công</div>');
                        },
                    }
                )
            })
        })
    </script>
@endif
