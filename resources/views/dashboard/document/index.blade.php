@extends('layouts.dashboard', ['key' => 'dashboard_document'])

@section('extra_cdn')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.theme.default.min.css') }}">

    <script src="jquery.min.js"></script>
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
@endsection

@section('content')
    <div class="container-fluid custom__container--fluid">
        @if(request()->status != config('statuses.trash') && request()->status != config('statuses.share'))
            @include('dashboard.document.create_folder_modal')

            @include('dashboard.document.upload_file_modal')
        @endif
        <div class="title__contract mt-2">
            <div class="header__button--upload">
                @if(request()->status == config('statuses.trash') || request()->status == config('statuses.share'))
                    <button class="document__button--gradient btn text-white btn__action--disabled disabled" data-bs-toggle="modal">
                        Tải tài liệu
                    </button>
                @else
                    <button class="document__button--gradient btn text-white" data-bs-toggle="modal" data-bs-target="#uploadFileModal">
                        Tải tài liệu
                    </button>
                @endif

                @if(request()->status != config('statuses.trash') && request()->status != config('statuses.share'))
                    {!! Form::open(['url' => route('web.files.multipleDelete'), 'method' => 'POST']) !!}
                    <input type="hidden" name="file_list" id="fileList" />
                    <input type="hidden" name="folder_list" id="folderList" />
                    @include('dashboard.document.modal', ['content' => 'Bạn chắc chắn muốn xoá các tài liệu này?', 'element_id' => 'multipleConfirmModal'])
                    {!! Form::close() !!}
                    <button class="btn text-white bg-danger ml-sm-2 d-none justify-content-center" id="deleteAllButton" data-bs-toggle="modal"
                            data-bs-target="#multipleConfirmModal">
                        Xoá tất cả
                    </button>
                @elseif(request()->status != config('statuses.share'))
                    {!! Form::open(['url' => route('web.folders.multipleForceDelete'), 'method' => 'POST']) !!}
                    <input type="hidden" name="file_list" id="fileList" />
                    <input type="hidden" name="folder_list" id="folderList" />
                    @include('dashboard.document.modal', ['content' => 'Bạn chắc chắn muốn xoá vĩnh viễn các tài liệu này?', 'element_id' => 'multipleConfirmModal'])
                    {!! Form::close() !!}
                    <button class="btn text-white bg-danger ml-sm-2 d-none justify-content-center" id="deleteAllButton" data-bs-toggle="modal"
                            data-bs-target="#multipleConfirmModal">
                        Xoá vĩnh viễn
                    </button>
                @endif

                @if(request()->status == config('statuses.trash'))
                    {!! Form::open(['url' => route('web.folders.multipleRestore'), 'method' => 'POST']) !!}
                    <input type="hidden" name="file_list" class="fileList" />
                    <input type="hidden" name="folder_list" class="folderList" />
                    @include('dashboard.document.modal', ['content' => 'Bạn chắc chắn muốn khôi phục lại các tài liệu này?', 'element_id' => 'confirmRestoreModal'])
                    {!! Form::close() !!}
                    <button class="btn btn-success text-white ml-sm-2 d-none justify-content-center" id="restoreAllButton" data-bs-toggle="modal"
                            data-bs-target="#confirmRestoreModal">
                        Khôi phục
                    </button>
                @endif
            </div>
        </div>
        <div class="header__status--contract">
            <div class="header__document--list @if(request()->status == config('statuses.trash') || request()->status == config('statuses.share')) mb-3 @endif">
                <div class="">
                    <ul class="header__status--navigation header__status--contract-list list-unstyled d-md-flex d-none">
                        <li class="customer__li--border">
                            @php
                                $countAll = 0;
                                if (isset($folder->children)) {
                                    $countAll += $folder->children->count();
                                }
                                if (isset($folder->files)) {
                                    $countAll += $folder->files->count();
                                }
                            @endphp
                            <a href="{{ route('web.folders.index', ['status'=>'all', 'page' => null]) }}">
                                <span
                                        class="header__status--fz table__contract--item-color document__header--text2 {{ request()->input('status') == config('statuses.all') || request()->input('status') == null ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Tất cả ({{ $countAll }})</span>
                            </a>
                        </li>
                        <li class="customer__li--border">
                            <a href="{{ route('web.folders.index', ['status'=>'trash', 'page' => null]) }}">
                                <span
                                        class="header__status--fz table__contract--item-color document__header--text2 {{ request()->input('status') == config('statuses.trash') ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Đã xoá</span>
                            </a>
                        </li>
                        <li class="customer__li--border">
                            <a href="{{ route('web.folders.index', ['status'=>'all_private', 'page' => null]) }}">
                                <span
                                        class="header__status--fz table__contract--item-color document__header--text2 {{ request()->input('status') == 'all_private' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Tài liệu cá nhân</span>
                            </a>
                        </li>
                        <li class="customer__li--border">
                            <a href="{{ route('web.folders.index', ['status'=>'share', 'page' => null]) }}">
                                <span
                                        class="header__status--fz table__contract--item-color document__header--text2 {{ request()->input('status') == config('statuses.share') ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Tài liệu được chia sẻ</span>
                            </a>
                        </li>
                    </ul>
                    {{--                    respon--}}
                    <div class="owl-carousel owl-theme text-center d-md-none d-block">
                        <div class="item" data-merge="6">
                            @php
                                $countAll = 0;
                                if (isset($folder->children)) {
                                    $countAll += $folder->children->count();
                                }
                                if (isset($folder->files)) {
                                    $countAll += $folder->files->count();
                                }
                            @endphp
                            <a href="{{ route('web.folders.index', ['status'=>'all', 'page' => null]) }}">
                                <span
                                        class="header__status--fz table__contract--item-color document__header--text2 {{ request()->input('status') == config('statuses.all') || request()->input('status') == null ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Tất cả ({{ $countAll }})</span>
                            </a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ route('web.folders.index', ['status'=>'trash', 'page' => null]) }}">
                                <span
                                        class="header__status--fz table__contract--item-color document__header--text2 {{ request()->input('status') == config('statuses.trash') ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Đã xoá</span>
                            </a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ route('web.folders.index', ['status'=>'all_private', 'page' => null]) }}">
                                <span
                                        class="header__status--fz table__contract--item-color document__header--text2 {{ request()->input('status') == config('statuses.all_private') ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Tài liệu cá nhân</span>
                            </a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ route('web.folders.index', ['status'=>'share', 'page' => null]) }}">
                                <span
                                        class="header__status--fz table__contract--item-color document__header--text2 {{ request()->input('status') == config('statuses.share') ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Tài liệu được chia sẻ</span>
                            </a>
                        </div>
                    </div>
                    <script>
                      $('.owl-carousel').owlCarousel({
                        items: 1,
                        loop: true,
                        startPosition: 1,
                        margin: 10,
                        merge: true,
                        startPosition: {{ $statusFolder}},
                        responsive: {
                          678: {
                            mergeFit: true
                          },
                          1000: {
                            mergeFit: false
                          }
                        }
                      });
                    </script>
                </div>
                @if(request()->status != config('statuses.trash') && request()->status != config('statuses.share'))
                    <div class="header__action--document">
                        <div class="header__status--search">
                            @if( isset($is_back) && $is_back == 1 )
                                <div class="d-flex flex-column align-items-center justify-content-center mr-3">
                                    <a href="javascript:history.back()">
                                        <img class="img__create--folder ml-3 mb-1" style="width: 26px;height:20px" src="{{ asset('images/svg/back_arrow.svg') }}" alt="back_icon" />
                                        <span class="document__header--text d-block">Quay lại</span></a>
                                </div>
                            @endif
                            <div class="d-flex flex-column align-items-center justify-content-center ml-3 mr-3">
                                <a class="btn__action--style" href="#" data-bs-toggle="modal" data-bs-target="#createFolderModal">
                                    <img class="img__create--folder ml-4 mb-1" src="{{ asset('images/svg/folder.svg') }}" alt="folder_icon" />
                                    <img class="img__folder--hover ml-4 mb-1" src="{{ asset('images/svg/create_folder_hover.svg') }}" alt="folder_icon" />
                                    <span class="document__header--text d-block">Tạo thư mục</span></a>
                            </div>
                            <div class="dropdown dropleft d-flex flex-column align-items-center justify-content-center ml-3">
                                <a class="btn__action--style btn__export--file d-flex flex-column justify-content-center align-items-center dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false" href="#">
                                    <img class="img__create--folder" src="{{ asset('images/svg/export.svg') }}" alt="export_icon" />
                                    <img class="img__folder--hover" src="{{ asset('images/svg/export_hover.svg') }}" alt="export_icon" />
                                    <div class="mt-1 document__header--text">Export</div>
                                </a>
                                <div class="dropdown-menu dropdown__modal--export" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('web.folders.exportFiles', ['status' => request()->status, 'slug' => $slug, 'typeExport' => 'rar']) }}"
                                       target="_blank">.rar</a>
                                    <a class="dropdown-item" href="{{ route('web.folders.exportFiles', ['status' => request()->status, 'slug' => $slug, 'typeExport' => 'zip']) }}"
                                       target="_blank">.zip</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        {{--      end-header-status  --}}
    </div>
    <div id="previewModal" class="image__thumb--modal">
        <span class="image__preview--close">&times;</span>
        <img class="image__thumb--modal-content" id="img01" />
        <div id="caption"></div>
    </div>
    <div class="table__contract container-fluid custom__container--fluid">
        <div class="col-md-12 px-0">
            <div class="table__contract--bg bg-white table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th scope="col" class="position-relative table__contract--item-fz text-center">
                            @if(request()->status != config('statuses.share'))
                                <div class="form-check d-flex flex-row justify-content-center">
                                    <input class="form-check-input" data-status="{{request()->status}}" type="checkbox" value="" id="formCheckAll">
                                </div>
                            @else
                                <div>Loại</div>
                            @endif
                            <img class="position-absolute" src="{{ asset('images/hinh.png') }}" alt="position_icon"
                                 style="top: 0px; left: 0px">
                        </th>
                        @if(request()->status != config('statuses.share'))
                            <th scope="col" class="table__contract--item-fz">Loại</th>
                        @endif
                        <th scope="col" class="table__contract--item-fz">Người tạo</th>
                        <th scope="col" class="text-center table__contract--item-fz" style="min-width: 200px;">Tên thư mục</th>
                        <th scope="col" class="text-center table__contract--item-fz">Kích thước</th>
                        <th scope="col" class="text-center table__contract--item-fz">Phân quyền</th>
                        <th scope="col" class="table__contract--item-fz text-center">Ngày tạo</th>
                        <th scope="col" class="table__contract--item-fz text-center">Tải xuống</th>
                        @if(request()->status != config('statuses.share'))
                            <th scope="col" class="table__contract--item-fz text-center"></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    <!-- All Section -->
                    @if(count($folderChildren) > 0 || count($fileOfFolder) > 0)
                        <!-- Show Folder -->
                        @if (request()->page == null || request()->page == 1)
                            @foreach ($folderChildren as $key => $folderItem)
                                <tr @if(request()->status != config('statuses.trash')) class="btn__document--navigate" @endif>
                                    @if(request()->status != config('statuses.share'))
                                        <td class="table__contract--color">
                                            <div class="form-check d-flex flex-row justify-content-center">
                                                <input class="form-check-input dashboard__form--checkbox delete-folder-checkbox"
                                                       type="checkbox" name="folderCheckbox[]" value="{{ $folderItem->id }}" />
                                            </div>
                                        </td>
                                    @endif
                                    <td class="table__contract--color @if(request()->status == config('statuses.share')) text-center @endif"><img width="35" height="29"
                                                                                                                                                  src="{{ asset('images/svg/group_folder.svg') }}"
                                                                                                                                                  alt="folder_icon" />
                                    </td>
                                    <td class="table__contract--item-color">
                                        <div>
                                            <img src="{{ $folderItem->user->avatar_link }}"
                                                 class="rounded-circle document__body--avatar image__permission--round" />
                                        </div>
                                    </td>
                                    <td class="table__contract--item-color text-center text-break dashboard__document--name">
                                        @if(request()->status != config('statuses.trash'))
                                            <a class="btn__action--navigate" href="{{ route('web.folders.show', [$folderItem, 'status' => request()->status]) }}">{{ $folderItem->name }}</a>
                                        @else
                                            <a class="btn__action--navigate">{{ $folderItem->name }}</a>
                                        @endif
                                    </td>
                                    <td class="table__contract--item-color text-center"></td>
                                    <td class="table__contract--item-color">
                                        <div class="table__contract--item--box text-center">
                                            <div class="box__contract d-inline-block">
                                                @include('dashboard.document.document_folder_permission', ['folderItem' => $folderItem])
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table__contract--item-color text-center">{{ \Carbon\Carbon::parse($folderItem->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center modal__export--file">
                                            <a href="{{ route('web.folders.exportFiles', ['status' => request()->status, 'slug' => $folderItem->slug]) }}" target="_blank"
                                               class="btn__document--download">
                                                <i class="far fa-arrow-alt-circle-down"></i>
                                            </a>
                                        </div>
                                    </td>
                                    @if(request()->status != config('statuses.share'))
                                        <td>
                                        @if(request()->input('status') == config('statuses.trash'))
                                            <!-- Delete hard confirm form -->
                                            {!! Form::open(['url' => route('web.folders.forceDestroy', ['id' => $folderItem->id]), 'method' => 'DELETE']) !!}
                                            @include('dashboard.document.modal', ['content' => 'Bạn chắc chắn muốn xoá vĩnh viễn ?', 'id' => $folderItem->id, 'element_id' => 'deleteHardConfirmModal_folder_' . $folderItem->id])
                                            {!! Form::close() !!}
                                            <!-- Restore confirm form -->
                                                {!! Form::open(['url' => route('web.folders.restore', ['id' => $folderItem->id]), 'method' => 'GET']) !!}
                                                @include('dashboard.document.modal', ['content' => 'Bạn chắc chắn muốn khôi phục ?', 'id' => $folderItem->id, 'element_id' => 'restoreConfirmModal_folder_' . $folderItem->id])
                                                {!! Form::close() !!}

                                                <div class="dropdown dropleft modal__document--crud">
                                                    <a type="button" class="d-block dashboard__button--dropdown" id="dropdownMenuButton" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h list__users--color--cursor"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown__custom--position"
                                                         aria-labelledby="dropdownMenuButton">
                                                        <button class="dropdown-item" type="submit"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteHardConfirmModal_folder_{{ $folderItem->id }}">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                            <span class="ml-2">Xoá vĩnh viễn</span>
                                                        </button>
                                                        <button class="dropdown-item" type="submit"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#restoreConfirmModal_folder_{{ $folderItem->id }}">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                            <span class="ml-2">Khôi phục</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                {!! Form::open(['url' => route('web.folders.destroy', $folderItem->id), 'method' => 'DELETE']) !!}
                                                @include('dashboard.document.modal', ['content' => 'Bạn chắc chắn muốn xoá ?', 'id' => $folderItem->id, 'element_id' => 'deleteFolderConfirmModal_' . $folderItem->id])
                                                {!! Form::close() !!}
                                                <div class="dropdown dropleft modal__document--crud">
                                                    <a type="button" class="d-block dashboard__button--dropdown" id="dropdownMenuButton" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h list__users--color--cursor"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown__custom--position"
                                                         aria-labelledby="dropdownMenuButton">
                                                        <a class="btn__action--dropdown dropdown-item d-inline-block" href="#" data-bs-toggle="modal"
                                                           data-bs-target="#deleteFolderConfirmModal_{{ $folderItem->id }}">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                            <span class="ml-2">Xoá</span>
                                                        </a>
                                                        <a class="btn__action--dropdown dropdown-item get__by--id--folder" href="#" data-bs-toggle="modal"
                                                           data-bs-target="#exampleModalLong">
                                                            <i class="fas fa-undo-alt"></i>
                                                            <input type="text" class="value__id--file" value="{{ $folderItem->id }}" hidden />
                                                            <span class="ml-2">Chuyển</span>
                                                        </a>
                                                        <a class="dropdown-item get__by--rename--folder" href="#" data-bs-toggle="modal"
                                                           data-bs-target="#renameFolderModal">
                                                            <i class="far fa-folder-open"></i>
                                                            <input type="text" class="value__id--rename--folder" value="{{ $folderItem->id }}" hidden />
                                                            <span class="ml-2">Đổi tên</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif

                        <!-- Show Files -->
                        @foreach($fileOfFolder as $file)
                            <tr class="btn__document--navigate">
                                @if(request()->status != config('statuses.share'))
                                    <td scope="row" class=" table__contract--item-color">
                                        <div class="form-check d-flex flex-row justify-content-center">
                                            <input class="form-check-input dashboard__form--checkbox delete-checkbox"
                                                   type="checkbox" name="flleCheckbox[]" value="{{ $file->id }}" />
                                        </div>
                                    </td>
                                @endif
                                <td class="table__contract--color @if(request()->status == config('statuses.share')) text-center @endif"><img width="35" height="29"
                                                                                                                                              src="{{ get_extension_thumb($file->type) }}"
                                                                                                                                              alt="excel_icon" />
                                </td>
                                <td class="table__contract--item-color ">
                                    <div>
                                        <img src="{{ $file->user->avatar_link }}"
                                             class="rounded-circle document__body--avatar image__permission--round" />
                                    </div>
                                </td>
                                <td class="table__contract--item-color dashboard__document--name text-center text-break">
                                    @if(check_is_image($file->type))
                                        <a data-src="{{ get_file_thumb($file->name) }}"
                                           class="image__thumb--preview btn__action--navigate" href="#">{{ $file->name }}</a>
                                    @elseif(check_is_pdf($file->type))
                                        <a class="btn__action--navigate" target="_blank"
                                           href="{{ route('web.files.pdfPreview', ['filename' => $file->name, 'status' => request()->status]) }}">{{ $file->name }}</a>
                                    @else
                                        <a class="btn__action--navigate" href="#">{{ $file->name }}</a>
                                    @endif
                                </td>
                                <td class="table__contract--item-color text-center">{{ $file->size ? $file->size.' kb': '' }}</td>
                                <td class="table__contract--item-color">
                                    <div class="table__contract--item--box text-center">
                                        <div class="box__contract d-inline-block">
                                            @include('dashboard.document.document_permission', ['file' => $file])
                                        </div>
                                    </div>
                                </td>
                                <td class="table__contract--item-color text-center">{{ \Carbon\Carbon::parse($file->created_at)->format('d/m/Y') }}</td>
                                <td class="text-secondary cursor">
                                    <div class="d-flex flex-row justify-content-center modal__export--file">
                                        <a class="btn__document--download" href="{{ route('web.files.downloadFile', ['filename' => $file->name]) }}"><i
                                                    class="far fa-arrow-alt-circle-down"></i></a>
                                    </div>
                                </td>
                                @if(request()->status != config('statuses.share'))
                                    <td>
                                    @if(request()->input('status') == 'trash')
                                        <!-- Delete hard confirm form -->
                                        {!! Form::open(['url' => route('web.files.forceDestroy', ['id' => $file->id]), 'method' => 'DELETE']) !!}
                                        @include('dashboard.document.modal', ['content' => 'Bạn chắc chắn muốn xoá vĩnh viễn ?', 'id' => $file->id, 'element_id' => 'deleteHardConfirmModal_file_' . $file->id])
                                        {!! Form::close() !!}
                                        <!-- Restore confirm form -->
                                            {!! Form::open(['url' => route('web.files.restore', ['id' => $file->id]), 'method' => 'GET']) !!}
                                            @include('dashboard.document.modal', ['content' => 'Bạn chắc chắn muốn khôi phục ?', 'id' => $file->id, 'element_id' => 'restoreConfirmModal_file_' . $file->id])
                                            {!! Form::close() !!}

                                            <div class="dropdown dropleft modal__document--crud">
                                                <a type="button" class="d-block dashboard__button--dropdown" id="dropdownMenuButton" data-toggle="dropdown"
                                                   aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h list__users--color--cursor"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown__custom--position"
                                                     aria-labelledby="dropdownMenuButton">
                                                    <button class="dropdown-item" type="submit"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteHardConfirmModal_file_{{ $file->id }}">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                        <span class="ml-2">Xoá vĩnh viễn</span>
                                                    </button>
                                                    <button class="dropdown-item" type="submit"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#restoreConfirmModal_file_{{ $file->id }}">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                        <span class="ml-2">Khôi phục</span>
                                                    </button>
                                                </div>
                                            </div>
                                        @else
                                            {!! Form::open(['url' => route('web.files.destroy', $file->id), 'method' => 'DELETE']) !!}
                                            @include('dashboard.document.modal', ['content' => 'Bạn chắc chắn muốn xoá ?', 'id' => $file->id, 'element_id' => 'deleteConfirmModal_' . $file->id])
                                            {!! Form::close() !!}
                                            <div class="dropdown dropleft modal__document--crud">
                                                <a type="button" class="d-block dashboard__button--dropdown" id="dropdownMenuButton" data-toggle="dropdown"
                                                   aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h list__users--color--cursor"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown__custom--position"
                                                     aria-labelledby="dropdownMenuButton">
                                                    <a class="btn__action--dropdown dropdown-item d-inline-block" href="#" data-bs-toggle="modal"
                                                       data-bs-target="#deleteConfirmModal_{{ $file->id }}">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                        <span class="ml-2">Xoá</span>
                                                    </a>
                                                    <a class="btn__action--dropdown dropdown-item get__by--id--folder" href="#" data-bs-toggle="modal"
                                                       data-bs-target="#exampleModalLong">
                                                        <i class="fas fa-undo-alt"></i>
                                                        <input type="text" class="value__id--file--s" value="{{ $file->id }}" hidden />
                                                        <span class="ml-2">Chuyển</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">
                                <h5 class="text-center">Thư mục trống</h5>
                            </td>
                        </tr>
                    @endif
                    {{--                    @endif--}}
                    </tbody>
                </table>
                {!! Form::open(['url' => route('web.folders.folderMoved'), 'method' => 'POST', 'class' => 'form__move--document']) !!}
                <input type="hidden" id="parent_sub_id" name="id" />
                <input type="hidden" id="folder_sub_id" name="folder_id" />
                <input type="hidden" id="files_sub_id" name="files_id" />
                {!! Form::close() !!}

                {{ $fileOfFolder->links('pagination') }}
            </div>
        </div>
        <input type="hidden" class="search_id">
        @include('dashboard.document.modal_folder_files')
        @include('dashboard.document.rename_folder')
    </div>
    {{--search--}}
    <script>
      $(document).ready(function () {
        let select = document.querySelector('.onchange__search');
        select.oninput = function ( e ) {
          let search = e.target.value;
          let id_folder = $('.search_id').val();
          let data = { search: search, id_folder: id_folder };
          $.ajax(
            {
              url: "{{ route('web.folders.searchAjax') }}",
              data: data,
              method: 'GET',
              dataType: 'html',
              success: function ( data ) {
                $('ul.list__file--parent').remove();
                $('.box__folder').html(data);
              },
            }
          );
        };
      });
    </script>

    {{--rename folder--}}

    <script>
      $(document).ready(function () {
        $('.get__by--rename--folder').click(function () {
          let id = $(this).find('.value__id--rename--folder').val();
          let data = { id: id };
          $.ajax(
            {
              url: "{{ route('web.folders.folderRename') }}",
              data: data,
              method: 'GET',
              dataType: 'html',
              success: function ( data ) {
                $('.modal__content--rename').html(data);
              },
            }
          );
        });
      });
    </script>

    {{--get_id_folder--}}
    <script>
      $(document).ready(function () {
        $('.button__click--add--contract').click(function () {
          $('.form__move--document').submit();
        });
      });
    </script>
    <script>
      $(document).ready(function () {
        $('.get__by--id--folder').click(function () {
          let id = $(this).find('.value__id--file').val();
          let id_file = $(this).find('.value__id--file--s').val();
          $('.search_id').val(id);
          let data = { id: id, id_file: id_file };
          $.ajax(
            {
              url: "{{ route('web.folders.showFolderAjax') }}",
              data: data,
              method: 'GET',
              dataType: 'html',
              success: function ( data ) {
                $('input#folder_sub_id').val(id);
                $('input#files_sub_id').val(id_file);
                $('.content__upload--file--contract').html(data);
              },
            }
          );
        });
      });
    </script>
    {{--search-ajax--}}
    <script type="text/javascript">
      // select perrmission user when upload file
      $('#userList').select2({
        minimumInputLength: 1,
        placeholder: 'Chọn người dùng...',
        'language': {
          'noResults': function () {
            return 'Không tìm thấy kết quả nào';
          },
          inputTooShort: function () {
            return 'Nhập ít nhất một ký tự';
          }
        },
        ajax: {
          url: '{{ route('web.users.searchAjax') }}',
          dataType: 'json',
          delay: 250,
          method: 'get',
          processResults: function ( data ) {
            console.log(data);
            return {
              results: $.map(data, function ( data ) {
                return {
                  text: `${data.name} (${data.email})`,
                  id: data.id
                };
              })
            };
          },
          data: function ( params ) {
            const query = {
              search: params.term
            };
            return query;
          },
          error: function ( error ) {
            console.log(error);
          },
          cache: true
        }
      });
    </script>
    <script>
      // edit permission user
      $(document).ready(function () {
        $(document).on('click', function ( evt ) {
          var BtnPermission = '.dashboard__permission--add-button';
          var modalDashboad = '.dashboard__permission--modal';
          var btnDropDown = '.dashboard__button--dropdown';
          var btnRemove = '.select2-selection__choice__remove';
          var modalResult = '.select2-results';

          if (!$(evt.target).closest(modalResult).length && !$(evt.target).closest(btnRemove).length && !$(evt.target).closest(BtnPermission).length && !$(evt.target).closest(btnDropDown).length && !$(evt.target).closest(modalDashboad).length) {
            $('.table__contract--bg').addClass('table-responsive');
          }
        });

        $('.dashboard__button--dropdown').on('click', function ( e ) {
          if ($(window).width() >= '768') {
            e.preventDefault();
            if ($(this).parent().hasClass('show')) {
              $(this).closest('.table__contract--bg').addClass('table-responsive');
            } else {
              $(this).closest('.table__contract--bg').removeClass('table-responsive');
            }
          }
        });

        $('.dashboard__permission--add-button').on('click', function ( e ) {
          if ($(window).width() >= '768') {
            console.log(e);
            e.preventDefault();
            $(this).closest('.table__contract--bg').removeClass('table-responsive');
          }
        });
      });


    </script>
    <script>
      // show select permission user modal
      $(document).ready(function () {
        function clickOutSideSelect2() {
          $(document).mouseup(function ( e ) {
            var resultOps = '.select2-results';
            var pmsModal = '.dashboard__permission--modal';
            var target = $(e.target);

            if (!target.closest(resultOps).length && !target.closest(pmsModal).length) {
              $('.dashboard__permission--modal').removeClass('d-flex').addClass('d-none');
            }
          });
        }

        clickOutSideSelect2();

        $('.dashboard__permission--add-button').on('click', function () {
          var fileId = $(this).data('id');

          $('.dashboard__permission--modal').not($(this).parent().find('.dashboard__permission--modal')).removeClass('d-flex').addClass('d-none');

          var addButtonModal = $(this).parent().find('#permissionModal_' + fileId);

          var permissonSelect = $('#permissionList_' + fileId);

          if (addButtonModal.hasClass('d-none')) {
            addButtonModal.removeClass('d-none').addClass('d-flex');

            const dataUser = addButtonModal.data('user');

            permissonSelect.select2({
              minimumInputLength: 1,
              placeholder: 'Chọn người dùng...',
              'language': {
                'noResults': function () {
                  return 'Không tìm thấy kết quả nào';
                },
                inputTooShort: function () {
                  return 'Nhập ít nhất một ký tự';
                }
              },
              ajax: {
                url: '{{ route('web.users.searchAjax') }}',
                dataType: 'json',
                delay: 250,
                method: 'get',
                processResults: function ( data ) {
                  clickOutSideSelect2();
                  return {
                    results: $.map(data, function ( data ) {
                      return {
                        text: `${data.name} (${data.email})`,
                        id: data.id
                      };
                    })
                  };
                },
                data: function ( params ) {
                  const query = {
                    search: params.term
                  };
                  return query;
                },
                error: function ( error ) {
                  console.log(error);
                },
                cache: true
              }
            });

            permissonSelect.empty();
            var userIdArray = [];
            dataUser.map(item => {
              // selectUser.append($("<option/>")
              //     .val(item.id)
              //     .text(item.name))
              //     .val(item.id)
              userIdArray.push(item.id);
              permissonSelect.append($('<option>', { value: item.id, text: item.name }));

            });
            permissonSelect.val(userIdArray).trigger('change');
            // permissonSelect.trigger("change");

          } else {
            addButtonModal.removeClass('d-flex').addClass('d-none');
          }
        });
      });
    </script>
    <script>
      $(document).ready(function () {
        Popper.Defaults.modifiers.preventOverflow = { enabled: false };

        $('#formCheckAll').on('click', function () {
          if ($(this).prop('checked')) {
            $('.dashboard__form--checkbox').prop('checked', true);
          } else {
            $('.dashboard__form--checkbox').prop('checked', false);
          }
        });
      });
    </script>
    <script>
      $(document).ready(function () {
        // delete multiple document
        $('#deleteAllButton').click(function () {
          let valFile = [];
          let valFolder = [];
          $('.delete-checkbox:checked').each(function ( i ) {
            valFile[i] = $(this).val();
          });
          $('.delete-folder-checkbox:checked').each(function ( i ) {
            valFolder[i] = $(this).val();
          });
          $('#fileList').val(valFile);
          $('#folderList').val(valFolder);
        });

        // restore multiple document
        $('#restoreAllButton').click(function () {
          let valFile = [];
          let valFolder = [];
          $('.delete-checkbox:checked').each(function ( i ) {
            valFile[i] = $(this).val();
          });
          $('.delete-folder-checkbox:checked').each(function ( i ) {
            valFolder[i] = $(this).val();
          });

          $('.fileList').val(valFile);
          $('.folderList').val(valFolder);
        });

        $('.delete-checkbox, .delete-folder-checkbox, #formCheckAll').change(function () {
          let valFile = [];
          let valFolder = [];
          const buttonElement = $('#deleteAllButton');
          var btnRestore = $('#restoreAllButton');
          $('.delete-checkbox:checked').each(function ( i ) {
            valFile[i] = $(this).val();
          });
          $('.delete-folder-checkbox:checked').each(function ( i ) {
            valFolder[i] = $(this).val();
          });
          if (valFile.length + valFolder.length > 0 && valFile.length !== null) {
            buttonElement.removeClass('d-none').addClass('d-flex');
            btnRestore.removeClass('d-none').addClass('d-flex');
          } else {
            buttonElement.removeClass('d-flex').addClass('d-none');
            btnRestore.removeClass('d-flex').addClass('d-none');
          }
        });
      });
    </script>
    <script>
      $(document).ready(function () {
        const previewImageModal = $('#previewModal');
        const previewImage = $('.image__thumb--preview');
        const modalImg = $('#img01');

        previewImage.on('click', function ( e ) {
          e.preventDefault();
          const srcImage = $(this).data('src');
          previewImageModal.css('display', 'block');
          modalImg.attr('src', srcImage);
        });

        $('.image__preview--close').on('click', function () {
          previewImageModal.css('display', 'none');
        });
      });
    </script>
    <script type="text/javascript">
      $(document).ready(function () {
        $(document).on('click', function ( e ) {
          var inputHidden = $(e.target).closest('.dz-hidden-input');
          var fileDropZone = $(e.target).closest('#file-dropzone');
          if (inputHidden.length || fileDropZone.length) {
            $('.show__error--message').children().fadeOut(1500);
          }
        });
      });

      Dropzone.options.fileDropzone =
        {
          url: '{{ route('web.files.store', ["parent_id" => $folder->id]) }}',
          maxFilesize: 5,
          dictDefaultMessage: 'Kéo thả hoặc chọn tập tin để tải lên',
          // maxFiles: 8,
          autoProcessQueue: false,
          headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          acceptedFiles: '.jpeg,.jpg,.png,.gif,.docx,.pdf,.doc',
          addRemoveLinks: true,
          parallelUploads: 10,
          timeout: 60000,
          uploadMultiple: true,
          init: function () {
            var $this = this;

            var myDropzone = this;
            // Update selector to match your button
            $('#uploadFileButton').click(function ( e ) {
              e.preventDefault();
              myDropzone.processQueue();
            });

            // $('.btn__close--dropzone').on('click', function (e) {
            //     $this.removeAllFiles(true);
            //     $('.show__error--message').children().remove();
            // });
          },
          sending: function ( file, xhr, formData ) {
            $users = $('#userList').val();
            formData.append('users', $users);
          },
          removedfile: function ( file ) {
            $(file.previewElement).remove();
            if (!$('#file-dropzone .dz-preview').length) {
              $('#file-dropzone').removeClass('dz-started');
            }
          },
          success: function ( file, response ) {
            console.log(response);
            if (response.message === 'success') {
              location.reload();
            }
          },
          error: function ( file, response ) {
            $(file.previewElement).remove();
            var $selectorError = $('.show__error--message');
            if (!$('#file-dropzone .dz-preview').length) {
              $('#file-dropzone').removeClass('dz-started');
            }

            if (!$selectorError.children().length) {
              $selectorError.append('<span>*Chú ý: Mỗi tài liệu phải có kích thước nhỏ hơn 5MB và phải là một trong các định dạng (.jpeg,.jpg,.png,.gif,.docx,.pdf,.doc)</span>');
            } else {
              $selectorError.children().removeAttr('style');
            }
          }
        };
    </script>

    {{--  initialize navigation on tr  --}}
    <script>
      $(document).ready(function () {
        $('.btn__document--navigate').on('click', function ( e ) {
          // except DOMs
          var checkbox = '.dashboard__form--checkbox';
          var svgIcon = '.list__users--color--cursor';
          var download = '.btn__document--download';
          var btnCrud = '.modal__document--crud';
          var btnInDD = '.btn__action--dropdown';
          var modal = '.modal';
          var btnContract = '.table__contract--item--box .box__contract';
          var btnRemove = '.select2-selection__choice__remove';
          // end except DOMs
          if (!$(e.target).closest(btnRemove).length && !$(e.target).closest(btnContract).length && !$(e.target).closest(modal).length && !$(e.target).closest(btnInDD).length && !$(e.target).closest(btnCrud).length && !$(e.target).closest(checkbox).length && !$(e.target).closest(svgIcon).length && !$(e.target).closest(download).length) {
            var btnAction = $(this).find('.btn__action--navigate');
            if (btnAction.hasClass('image__thumb--preview')) {
              console.log(btnAction.data('src'));
              var srcImage = btnAction.data('src');
              $('#previewModal').css('display', 'block');
              $('#img01').attr('src', srcImage);
            } else if (btnAction.attr('target') === '_blank') {
              window.open(btnAction.attr('href'), '_blank');
            } else if (btnAction.attr('href') !== '#') {
              window.location.href = btnAction.attr('href');
            }
          }
        });
      });
    </script>
    {{--  end navigation on tr  --}}
@endsection
