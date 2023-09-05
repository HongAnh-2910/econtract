@extends('dashboard.contract.signature_layout')
@section('content')
    @foreach($file as $fi)
        @include('dashboard.contract.modal_remote_signature')
        <div class="file_base64_encode" data-fileBaseId="{{$fi['fileId']}}">{{ $fi['fileContent'] }}</div>
    @endforeach
    @include('dashboard.spinner')
    <input type="hidden" id="coordinate" name="coordinate" value="{{ $area }}">
    <input id="count-area" type="hidden" value="{{ count($area) }}">
{{--    @include('dashboard.contract.modal_remote_signature')--}}
{{--    @include('dashboard.contract.modal_file_signature')--}}
    @include('dashboard.contract.modal_file_upload')
    @include('dashboard.contract.modal_file_download')
    <input type="hidden" id="contract_id" name="contract_id" value="{{$contractId}}">
    @foreach($area as $index => $areaItem)
        @include('dashboard.contract.modal_file_signature')
        <div class="modal  modal-signature" id="{{ $areaItem->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block">
                        <h5 class="d-inline-block">Ký tên</h5>
                        <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="">
                            <button class="btn btn-primary" id="">Draw</button>
                            <button class="btn btn-default border " data-dismiss="modal" data-toggle="modal" data-target="#fileSignature{{$areaItem->id}}" id="">Từ file</button>
                            <button class="btn btn-default border " data-dismiss="modal" data-toggle="modal" data-target="#myModal" id="">Ký số</button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12=" id="modal-canvas">
                                <canvas data-id="{{ $areaItem->id }}" class="drawArea" id="sig-canvas__{{ $areaItem->id }}" width="480"
                                        height="160">
                                    Get a better browser, bro.
                                </canvas>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary" id="sig-submitBtn">Xác nhận</button>
                                <button class="btn btn-default border" id="sig-clearBtn">Xóa</button>
                                @if($sampleSignature != '' && isset($sampleSignature))
                                    <img style="display: none" id="sig-sampleImg" type="hidden" src="{{$sampleSignature->signature}}">
                                    <button class="btn btn-primary" id="sig-sampleBtn">Chữ ký mẫu</button>
                                @endif
                            </div>
                        </div>
                        <br/>
                        <div class="row" style="display: none">
                            <div class="col-md-12">
                                <textarea id="sig-dataUrl" class="form-control" rows="5">Data URL for your signature will go here!</textarea>
                            </div>
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <div class="navbar-contract--client container-fluid d-flex justify-content-sm-between flex-sm-row flex-column">
        <div class="navbar-contract--client__text d-flex align-items-center mb-2 mb-sm-0 ml-md-4 ml-0 justify-content-center justify-content-sm-start text-center">
            Chọn vị trí ký và thêm vào chữ ký của bạn
        </div>
        <div class="d-flex align-items-center justify-content-center">
            <div>
                <a href="{{route('web.contracts.index')}}">
                    <button class="btn complete--client mr-0 btn__client--complete mb-2 mb-sm-0 mr-3">Xem hợp đồng</button>
                </a>
            </div>
            <button class="btn complete--client mr-0 btn__client--complete mb-2 mb-sm-0 mr-3" data-dismiss="modal" data-toggle="modal" data-target="#fileDownload">
                Tải xuống
            </button>
            <button class="btn complete--client mr-0 btn__client--complete mb-2 mb-sm-0 mr-3" data-dismiss="modal" data-toggle="modal" data-target="#fileUpload">
                Tải lên
            </button>
            <a href="{{route('web.files.signaturePreviewPdf',['id' => $fi['fileId']])}}" class="mr-2" data-previewId="" target="_blank">
                <button class="btn complete--client mr-0 mr-sm-2 btn__client--complete mb-2 mb-sm-0" onclick="">
                    Xem trước
                </button>
            </a>
            <button class="btn complete--client mr-0 btn__client--complete mb-2 mb-sm-0 mr-3"  data-dismiss="modal" data-toggle="modal" data-target="#myModal">Ký số</button>
            <button class="btn complete--client mr-0 mr-sm-2 btn__client--complete mb-2 mb-sm-0" onclick="clientSign()">Ký ảnh</button>
        </div>
    </div>
    <div class="page">
        <i class="page-angle fas fa-angle-double-left"></i>
        <div id="left-angle">
            <i class="page-angle custom-angle fas fa-angle-left"></i>
        </div>
        <input class="page__box" value="1"/>
        <div>/</div>
        <span class="page__number"></span>
        <div id="right-angle">
            <i class="page-angle fas fa-angle-right"></i>
        </div>
        <i class="page-angle custom-angle fas fa-angle-double-right"></i>
    </div>

    <div class="container-fluid container-content d-flex flex-md-row flex-column justify-content-between">
        @foreach($file as $key => $fi)
            <div class="document_preview d-md-none d-flex mb-3 {{! $key ? 'active__file--contract' : ''}}" data-key="{{$key}}" data-fileId="{{$fi['fileId']}}" id="document_preview--mb">
                <img class="document_preview--icon" src="{{asset('/images/svg/pdf.svg')}}">
                <div class="document_preview--name">{{$fi['fileName']}}</div>
            </div>
        @endforeach
        <div class="container-content__signature overflow-auto d-flex flex-column pt-3">
            <p style="font-family: Roboto;font-style: normal;font-weight: normal;font-size: 22px;line-height: 20px;text-align: center;letter-spacing: 0.06em;color: #FA0000;">Thứ tự ký</p>
            @foreach($area as $signItem)
                <div style="border: 1px solid #DDDDDD; box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1); box-sizing: border-box" class="d-flex flex-column mx-2 py-3 px-2">
                    <p class="text-break">{{substr( $signItem->file->name, strpos( $signItem->file->name, '_')+1, strlen( $signItem->file->name))}}</p>
{{--                    <p class="text-break">{{ $signItem->email }}</p>--}}
                    <p class="text-break">Người ký: <span style="color: #ffa45f">{{ $signItem->name }} ({{ $signItem->email }}) </span></p>
{{--                    <p class="text-break">Loại ký: Ký tên</p>--}}
                </div>
            @endforeach
        </div>
        <div class="container-content__signature d-none">
            <div class="signature-information" id="signature-information">
                <div class="company__selection mx-3 mt-3 py-2 px-2">
                    <span class="company-text">CÔNG TY TNHH THỌ XUÂN</span>
                    <i class="company-angle fas fa-angle-down"></i>
                </div>
                <div class="company__title--text text-center mt-4 px-2">TRƯỜNG THÔNG TIN</div>
                <div class="company__title--text-small px-2 text-center mt-2 mb-5">Kéo thả các trường thông tin dưới đây để
                    thêm ô nhập hoặc ô ký vào bản hợp đồng
                </div>
                <div class="digitalSignature--first d-flex justify-content-center align-items-center handle-press-sign"
                     id="digitalSignature--first" data-toggle="modal" onclick="">
                    <img class="signature--image" id="signatureFirst--image"
                         src="{{ asset('images/Signature_block.png') }}">
                    <img id="eSignature" src="" class="img-fluid signature-item">
                </div>
                <div class="digitalSignature--second d-flex justify-content-center align-items-center" id="digitalSignature--second" data-toggle="modal">
                    <img  src="{{asset('images/Signature_block_2.png')}}">
                    <span class="signature__text ml-4">Ký nháy</span>
                </div>
            </div>
        </div>
        <div class="container-content__contract overflow-auto ">
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            @if(session('error_message'))
                <div class="alert alert-danger">{{ session('error_message') }}</div>
            @endif
            <div id="documentRender" class="documentRender"></div>
        </div>
        <div class="container-content__list d-flex flex-column align-items-center overflow-auto ">
            @foreach($file as $key => $fi)
                <div class="document_preview d-none d-md-flex {{! $key ? 'active__file--contract' : ''}}" data-key="{{$key}}" data-fileId="{{$fi['fileId']}}" id="document_preview">
                    <img class="document_preview--icon" src="{{asset('/images/svg/pdf.svg')}}">
                    <div class="document_preview--name">{{$fi['fileName']}}</div>
                </div>
            @endforeach
            <div class="file_preview mt-2" id="file_preview">
            </div>
        </div>
    </div>
    <script src="{{asset('vendor/pdf/signature.config.js')}}"></script>
    <script src="{{asset('vendor/pdf/signature-pad.config.js')}}"></script>
    @if(isset ($area))
        <script>
            function sigStart(data) {
                let countArea = document.getElementById('count-area').value;
                for (let i = 1; i <= countArea; i++) {
                    let canvasStart = document.getElementById('sig-canvas__' + i);
                    canvasStart.width = canvasStart.width;

                }
            }

            $(document).ready(function () {
                $('.digitalSignature--first').on('show.bs.modal', function (e) {
                    let button = e.relatedTarget;
                    if($(button).hasClass('ui-resizable"')) {
                        e.stopPropagation();
                        alert('121212');
                    }
                });
                function resizalbeElement (element,id) {
                    element.resizable({
                        // aspectRatio: element.width() / element.height(),
                        // maxHeight: 70,
                        // maxWidth: 190,
                        // minHeight: 25,
                        start : function (e) {
                            e.preventDefault();
                        },
                        stop : function (e) {
                            // let modal = $('.modal#' + parseInt(id));
                            // modal.hide();
                            e.stopPropagation();
                            e.preventDefault();
                        }
                    });
                }
                function checkSignature(datapage,datafileId) {
                    $('.handle-press-sign').addClass('d-none').removeClass('d-flex');
                    $('div[data-page= '+datapage+' ][data-fileId = '+datafileId+']').addClass('d-flex').removeClass('d-none');
                }
                // resizalbeElement($('#digitalSignature--first'));
                $('.document_preview').on('click', function (e,callback){
                    var $btnThis = $(this);
                    // $(this).addClass('active__file--contract');
                    $('.document_preview').each(function () {
                        if($(this).data('key') == $btnThis.data('key')) {
                            $(this).addClass('active__file--contract');
                        } else {
                            $(this).removeClass('active__file--contract');
                        }
                    });

                    $('.page__box').val(1);
                    value = 1;
                    fileId = $(this).attr('data-fileId');
                    checkSignature(value,fileId);
                    let pdfFile = $('[data-fileBaseId = '+fileId+']').html();
                    let pdfData = atob(pdfFile);
                    loadingTask = pdfjs.getDocument( {data: pdfData} );
                    renderPDF(loadingTask, $('#documentRender'), parrent_width,1);
                    renderPDF(loadingTask, $('#file_preview'), $('#file_preview').width(),1)
                    if (typeof callback !== 'undefined') {
                        setTimeout(callback,1200);
                    }
                });
                var value = $('.page__box').val();
                $('#left-angle').on('click',function (){
                    if(value > 1){
                        value--;
                        checkSignature(value,fileId);
                        $('.page__box').val(value);
                        renderPDF(loadingTask, $('#documentRender'), parrent_width,value);
                        renderPDF(loadingTask, $('#file_preview'), $('#file_preview').width(),value);
                    }
                });
                $('#right-angle').on('click',function (){
                    var maxValue = $('.page__number').html();
                    if(value < maxValue){
                        value++;
                        checkSignature(value,fileId);
                        $('.page__box').val(value);
                        renderPDF(loadingTask, $('#documentRender'), parrent_width,value);
                        renderPDF(loadingTask, $('#file_preview'), $('#file_preview').width(),value);
                    }
                });
                $('#documentRender').css('position', 'relative');
                var text = '';
                var area = $('#coordinate').val();
                var areaArray = JSON.parse(area);
                const countAreaArray = {!! json_encode($area) !!};
                countAreaArray.map((item, index) => {
                        let ele = $('#digitalSignature--first').clone();
                        // $(ele).on('show.bs.modal', function (e) {
                        //     console.log('aaaa');
                        //     let button = e.relatedTarget;
                        //     if($(button).hasClass('ui-resizable')) {
                        //         e.stopPropagation();
                        //         console.log('121212');
                        //     }
                        // });
                        resizalbeElement($(ele),item.id);
                        if(item.type != 3) {
                            $(ele).css('width', item.width + '%');
                            $(ele).css('height', item.height + '%');
                            $(ele).attr('data-target', '#' + parseInt(item.id));
                            $(ele).attr('id', 'digitalSignature--first' + item.id);
                            $(ele).attr('data-id', item.id);
                            $(ele).attr('data-page', item.dataPage);
                            $(ele).attr('data-fileId', item.file_id);
                            $(ele).attr('data-type', item.type);
                            if($(ele).attr('data-fileId') != fileId){
                                $(ele).addClass('d-none');
                            }
                            if(item.type == 2) {
                                $(ele).find('#signatureFirst--image').attr('src','{{asset('/images/Signature_block_2.png')}}');
                            }
                            var x = parseFloat(item.dataX);
                            var y = parseFloat(item.dataY);
                            var coorX = x.toString() + '%';
                            var coorY = y.toString() + '%';
                            $(ele).css('left', coorX);
                            $(ele).css('top', coorY);
                            $(ele).css('marginLeft', 0);
                            $('#documentRender').append(ele);
                            if(item.dataPage != 1) {
                                ele.removeClass('d-flex');
                                ele.addClass('d-none');
                            }
                        }
                })
                $('#sig-submitBtn').on('click', function () {
                    $('#exampleModal').modal('hide');
                    $('body').css('overflow-y', 'scroll');
                    $('body').css('padding-right', '0px', '!important');
                });
                $('#closeModal').on('click', function () {
                    $('#exampleModal').modal('hide');
                });
                R.Init();
            });
        </script>
    @endif
    <script>
        'use strict';
        var pdfjs = window['pdfjs-dist/build/pdf'];
        var str = $('.file_base64_encode').eq(0).html();
        var pdfData = atob(str);
        function renderPDF (setPDF, canvasContainer, options,number) {
            var page_number = $('.page__number');
            function renderPage(page) {
                var scale = options/page.getViewport(1).width;
                var viewport = page.getViewport(scale);
                var canvas = document.createElement('canvas');
                if( canvasContainer.hasClass('documentRender')) {
                    canvas.setAttribute('id', 'customCanvas'+ page.pageIndex);
                }
                canvas.setAttribute('file-id', fileId);
                canvas.setAttribute('scale', scale);
                canvas.style.zIndex = 10;
                if(page.pageIndex != (number-1)) {
                    canvas.style.display = 'none';
                }
                var contex = canvas.getContext('2d');
                var renderContext = {
                    canvasContext: contex,
                    viewport: viewport
                };
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                canvas.setAttribute('class','customCanvas');
                canvasContainer.append(canvas);
                page.render(renderContext);
            }

            function pageNumber(pdfDoc) {
                canvasContainer.find('canvas').remove();
                for(var page = 1; page <= pdfDoc.numPages; page++){
                    pdfDoc.getPage(page).then(renderPage);
                    page_number.html(pdfDoc.numPages);
                }
            }
            setPDF.then(pageNumber);
        }
        var loadingTask = pdfjs.getDocument( {data: pdfData} );
        var parrent_width = $('#documentRender').width();
        var fileId = document.getElementsByClassName('document_preview')[0].getAttribute('data-fileId');
        var current = -1;
        var totalFile = {!! json_encode(count($file)) !!};
        renderPDF(loadingTask, $('#documentRender'), parrent_width,1);
        renderPDF(loadingTask, $('#file_preview'), $('#file_preview').width(),1);
        var pdf = new jsPDF('p', 'pt', 'letter');
        function clientSign() {
            $('#spinner').modal('toggle');
            $('#spinner').modal('show');
            let scale = $('#documentRender #customCanvas0').attr('scale');
            let width = $('#documentRender').width();
            let height = $('#documentRender').height();
            let totalPage = $('.page__number').html();
            const ownSignature = $('[data-toggle = modal][data-fileId = '+fileId+']');
            console.log(ownSignature);
            let signatureInf = [];
            let contractId = $('#contract_id').val();
            let signature_id = [];
            let totalSignature = {!! $area !!};
            for(let s = 0; s< totalSignature.length; s++) {
                signature_id.push(totalSignature[s].id);
            }
            console.log(signature_id);
            ownSignature.each(function (index) {
                // let srcImg = $(this).find('.ownSignature--image').get()[0];
                let srcImg = $(this).find('#eSignature').get()[0];
                srcImg = $(srcImg).attr('src');
                let x = $(this).css('left');
                let y = $(this).css('top');
                // let imageX = $(this).width();
                let imageX = $(this).css('width');
                let imageY = $(this).css('height');
                console.log($(this));
                if(x.includes('px')){
                    x= x.replace('px','');
                    y= y.replace('px','');
                    imageX = imageX.replace('px', '');
                    imageY = imageY.replace('px', '');
                }
                else {
                    x = x.replace('%', '');
                    y = y.replace('%', '');
                    imageX = imageX.replace('%', '');
                    imageY = imageY.replace('%', '');
                    x = parseFloat( x * width / 100 );
                    y = parseFloat( y * width / 100 );
                    imageX = parseFloat( imageX * width / 100 );
                    imageY = parseFloat( imageY * height / 100 );

                }
                let pageNum = $(this).attr('data-page');
                let arr =  [x,y,imageX,imageY,pageNum,srcImg];
                console.log(arr);
                signatureInf.push(arr);
                $(this).addClass('d-none');
            });
            $.ajax({
                url: "{{route('web.contracts.testFPDI')}}",
                data: {'width': width, 'height' :height,'signatureInf': signatureInf,'contractId': contractId,'totalPage' :totalPage, signature_id : signature_id},
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    window.location.href = "{{ route('web.commons.signatureComplete') }}";
                },
            })
        }

    </script>
@endsection

