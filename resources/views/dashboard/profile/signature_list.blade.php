@extends('layouts.dashboard', ['key' => 'profile_signature', 'menu_type' => 'menu_profile'])
@section('content')
    <div class="container-fluid custom__container--fluid pt-4 pb-5 bg-white">
{{--        <div class="title-account">--}}
{{--            <div class="col-md-12 py-3">--}}
{{--                <h4 class="mb-0">Quản lý chữ ký</h4>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="modal" id="addNewSignature" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex flex-column">
                            <h5 class="mb-0 btn__add--signature"> Thêm mới chữ ký</h5>
                        </div>
                        <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addNewSignatureForm" method="POST" action="{{ route('web.signature-list.store') }}">
                            @csrf
                            <div class="row">
                                <label for="exampleInputEmail1" class="ft-size-account">Sử dụng chuột để ký tên</label>
                                <div class="col-md-12=" id="modal-canvas">
                                    <canvas id="signaturePad" width="480"
                                            height="160">
                                        Get a better browser, bro.
                                    </canvas>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="ft-size-account">Tên chữ ký</label>
                                <input type="text" name="name" class="form-control">
                                <input type="hidden" name="signatureData" id="sig-dataUrl" value="">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" id="sig-submitBtn">Xác nhận</button>
                                    <a class="btn btn-default" id="sig-clearBtn">Xóa</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @include('dashboard.profile.modal_importSignatureImage')
        <div class="list__users--bg bg-white" style="height: 80vh">
            {{--end and search--}}
            <div class="d-flex px-2 mx-2 flex-column">
                @if(request()->status != config('statuses.trash'))
                    <div class="d-flex content__new--signature">
                        <div data-toggle="modal" data-target="#addNewSignature" class="list__users--bg--button text-white rounded mb-3">
                            Thêm mới chữ ký
                        </div>
{{--                        <div data-toggle="modal" data-target="#importSignature" class="ml-2 list__users--bg--button text-white rounded mb-3">--}}
{{--                            Thêm chữ ký ảnh--}}
{{--                        </div>--}}
                    </div>
                @endif
                <ul class="header__status--contract-list d-flex mb-0 mb-4 pl-0 list-unstyled content__new--signature">
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['status'=> config('statuses.all')]) }}">
                            <span class="header__status--fz table__contract--item-color {{ request()->input('status') == config('statuses.all') || !request()->input('status') ? 'list__users--status--color--active list__users--status--color--active1' : 'list__users--status--color' }} ">Tất cả</span>
                        </a>
                    </li>
                    <li class="pl-4">
                        <a href="{{ request()->fullUrlWithQuery(['status'=> config('statuses.trash')]) }}">
                            <span class="header__status--fz table__contract--item-color {{ request()->input('status') == config('statuses.trash') ? 'list__users--status--color--active list__users--status--color--active1' : 'list__users--status--color' }} list__users--status--color">Đã xoá</span>
                        </a>
                    </li>
                </ul>
            </div>
            {{--end-status--}}
            <div class="px-2 pt-3">
                <div class="d-flex flex-wrap">
                    @if (count($signatureTemplateData))
                        @php $t = 0; @endphp
                        @foreach($signatureTemplateData as $signatureItem)
                            <div class="card card__signature--content">
                                {!! Form::open(['url' => route('web.signature-list.destroy', $signatureItem->id), 'method' => 'DELETE']) !!}
                                @include('dashboard.document.modal', ['content' => 'Bạn chắc chắn muốn xoá ?', 'id' => $signatureItem->id, 'element_id' => 'deleteConfirmModal_' . $signatureItem->id])
                                {!! Form::close() !!}
                                @if($signatureItem->type != 2)
                                <img src="{{ $signatureItem->signature }}" class="card-img-top signature_list--image" alt="signature_template">
                                @else
                                    <img src="{{ asset('/images/signatures/'.$signatureItem->path) }}" class="card-img-top signature_list--image" alt="signature_template">
                                @endif
                                <div class="card-body d-flex flex-row justify-content-between px-3">
                                    <span class="card-text text-center font-weight-bold">{{ $signatureItem->name }}</span>
                                    <div class="dropdown dropleft">
                                        <a type="button" class="dashboard__button--dropdown" id="dropdownMenuButton" data-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h list__users--color--cursor"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown__custom--position"
                                             aria-labelledby="dropdownMenuButton">
                                            @if (request()->status == config('statuses.trash'))
                                                {!! Form::open(['url' => route('web.signature-list.restore', $signatureItem->id), 'method' => 'POST']) !!}
                                                <button type="submit" class="dropdown-item d-inline-block" href="#" >
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                    <span class="ml-2">Khôi phục</span>
                                                </button>
                                                {!! Form::close() !!}
                                            @else
                                                <a class="dropdown-item d-inline-block" href="#" data-bs-toggle="modal"
                                                   data-bs-target="#deleteConfirmModal_{{ $signatureItem->id }}">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                    <span class="ml-2">Xoá</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center">
                            <h4 class="text-center">Chữ ký trống</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>

        R = {
            Init: function (){
                console.log('An init');
                R.createSignature();
                // R.RegisterEvent();
            },
            RegisterEvent: function (){

            },
            createSignature: function (canvasId){
                window.requestAnimFrame = (function(callback) {
                    return window.requestAnimationFrame ||
                        window.webkitRequestAnimationFrame ||
                        window.mozRequestAnimationFrame ||
                        window.oRequestAnimationFrame ||
                        window.msRequestAnimaitonFrame ||
                        function(callback) {
                            window.setTimeout(callback, 1000 / 60);
                        };
                })();

                let canvas = document.getElementById('signaturePad');

                var ctx = canvas.getContext("2d");
                ctx.strokeStyle = "#222222";
                ctx.lineWidth = 2;

                var drawing = false;
                var mousePosItem = {
                    x: 0,
                    y: 0
                };
                var mousePos = [];
                var lastPos = [];
                mousePos[canvasId] = mousePosItem;
                lastPos[canvasId] = mousePosItem;

                canvas.addEventListener("mousedown", function(e) {
                    drawing = true;
                    lastPos[canvasId] = getMousePos(canvas, e);
                }, false);

                canvas.addEventListener("mouseup", function(e) {
                    drawing = false;
                }, false);

                canvas.addEventListener("mousemove", function(e) {
                    // console.log(canvas);
                    mousePos[canvasId] = getMousePos(canvas, e);
                    // console.log(mousePos);
                }, false);

                // Add touch event support for mobile
                canvas.addEventListener("touchstart", function(e) {

                }, false);

                canvas.addEventListener("touchmove", function(e) {
                    var touch = e.touches[0];
                    var me = new MouseEvent("mousemove", {
                        clientX: touch.clientX,
                        clientY: touch.clientY
                    });
                    canvas.dispatchEvent(me);
                }, false);

                canvas.addEventListener("touchstart", function(e) {
                    mousePos[canvasId] = getTouchPos(canvas, e);
                    var touch = e.touches[0];
                    var me = new MouseEvent("mousedown", {
                        clientX: touch.clientX,
                        clientY: touch.clientY
                    });
                    canvas.dispatchEvent(me);
                }, false);

                canvas.addEventListener("touchend", function(e) {
                    var me = new MouseEvent("mouseup", {});
                    canvas.dispatchEvent(me);
                }, false);

                function getMousePos(canvasDom, mouseEvent) {
                    var rect = canvasDom.getBoundingClientRect();
                    return {
                        x: mouseEvent.clientX - rect.left,
                        y: mouseEvent.clientY - rect.top
                    }
                }

                function getTouchPos(canvasDom, touchEvent) {
                    var rect = canvasDom.getBoundingClientRect();
                    return {
                        x: touchEvent.touches[0].clientX - rect.left,
                        y: touchEvent.touches[0].clientY - rect.top
                    }
                }

                function renderCanvas() {
                    if (drawing === true) {
                        // console.log(ctx);
                        ctx.moveTo(lastPos[canvasId].x, lastPos[canvasId].y);
                        ctx.lineTo(mousePos[canvasId].x, mousePos[canvasId].y);
                        ctx.stroke();
                        // console.log(lastPos);
                        // console.log(mousePos);
                        lastPos[canvasId] = mousePos[canvasId];
                    }
                }

                // Prevent scrolling when touching the canvas
                document.body.addEventListener("touchstart", function(e) {
                    if (e.target == canvas) {
                        e.preventDefault();
                    }
                }, false);
                document.body.addEventListener("touchend", function(e) {
                    if (e.target == canvas) {
                        e.preventDefault();
                    }
                }, false);
                document.body.addEventListener("touchmove", function(e) {
                    if (e.target == canvas) {
                        e.preventDefault();
                    }
                }, false);

                (function drawLoop() {
                    requestAnimFrame(drawLoop);
                    renderCanvas();
                })();

                function clearCanvas() {
                    canvas.width = canvas.width;
                }

                // Set up the UI

                var signParent = $('#digitalSignature--first' + parseInt(canvasId));
                var modalParent = $('#addNewSignature');


                modalParent.find('#sig-clearBtn').on('click', function () {
                    clearCanvas();
                    modalParent.find('#sig-dataUrl').html("Data URL for your signature will go here!");

                    signParent.find('#eSignature').attr('src', "");
                })

                modalParent.find('#sig-submitBtn').on('click', function () {
                    var dataUrl = canvas.toDataURL();
                    modalParent.find('#sig-dataUrl').val(dataUrl);

                    modalParent.hide();
                    $(".modal-backdrop").hide();
                    signParent.find('.signature-item').attr('src', dataUrl);
                    signParent.find('.signatureFirst--image').css('display', 'none');
                    signParent.find('.signature__text').css('display', 'none');

                    $('#addNewSignatureForm').submit();
                })


                R.RegisterEvent();
            }
        }
        $(document).ready(function (){
            R.Init();
        })

    </script>
    <script>
        $(document).ready(function (){
            // $('#signatureImage').on('change',function (event){
            //     let reader = new FileReader();
            //     reader.readAsDataURL($('#signatureImage')[0].files[0]);
            //     console.log(reader.result);
            //     let f = $('#signatureImage')[0].files[0];
            //     let file = $('#signatureImage')[0].files[0] ? $('#signatureImage')[0].files[0].name : 'Chọn file ảnh';
            //     console.log($('#signatureImage')[0].files[0]);
            //     const canvas = document.createElement('canvas');
            //     const ctx = canvas.getContext('2d');
                // canvas.height = f.naturalHeight;
                // canvas.width = f.naturalWidth;
                // ctx.drawImage(f, 0, 0);
                // let dataURL = canvas.toDataURL();
                // console.log(dataURL);
                // callback(dataURL);
                // $('.signatureImageLabel').html(file);
            // })

        })
    </script>
@endsection
