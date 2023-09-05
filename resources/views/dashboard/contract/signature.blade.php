@extends('dashboard.contract.signature_layout')
@section('content')
    @foreach($file as $fi)
        <div class="file_base64_encode" data-fileBaseId="{{$fi['fileId']}}">{{$fi['fileContent']}}</div>
    @endforeach
    @include('dashboard.spinner')
    @include('dashboard.contract.modal_file_signature_create')
    @include('dashboard.contract.modal_remote_signature_create')
    <div class="modal  modal-signature" id="exampleModal" style="z-index: 10000" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <h5 class="d-inline-block">Ký tên</h5>
                    <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="">
                        <button class="btn btn-primary" id="">Draw</button>
                        <button class="btn btn-default border " data-dismiss="modal" data-toggle="modal" data-target="#fileSignature" id="">Từ file</button>
{{--                        <button class="btn btn-default border " data-dismiss="modal" data-toggle="modal" data-target="#myModal" id="">Ký số</button>--}}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12=" id="modal-canvas">
                            <canvas data-id="" class="drawArea" id="sig-canvas" width="480"
                                    height="160">
                                Get a better browser, bro.
                            </canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" id="sig-submitBtn">Xác nhận</button>
                            <button class="btn btn-default border" id="sig-clearBtn">Xóa</button>
                            @if($ownSignature != '' && isset($ownSignature))
                                <img style="display: none" id="sig-sampleImg" type="hidden" src="{{$ownSignature->signature}}">
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
    <nav class="navbar-contract container-fluid d-flex flex-row py-3 align-items-center">
        <img class="navbar-contract__image ml-2" src="{{ asset('images/Vector (3).png') }}">
        <div class="navbar-contract__text">
            Ký tài liệu
        </div>
    </nav>
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
        <div class="container-content__signature overflow-auto {{($ownSignature != '' && isset($ownSignature)) ? 'sample__signature--exist' : ''}}">
            <div class="signature-information" id="signature-information">
                @if($isUpdate != 2)
                <div class="company__selection mx-3 mt-3 py-2 px-2" style="height: 56px">
                    <select class="form-select " aria-label="Default select example" id="listSignaturesInit">
                        <option value="" selected>Chọn người nhận</option>
                    </select>
                    <select class="form-select d-none" aria-label="Default select example" id="listSignatures">
                        <option value="default" selected>Chọn người nhận</option>
                        @if($isUpdate == 0 )
                            @foreach($signatures as $signatureItem)
                                <option value="{{ $signatureItem->id }}">{{ $signatureItem->name }} ({{ $signatureItem->email }})</option>
                            @endforeach
                        @else
                            @foreach($signatureName as $key => $signatureItem)
                                <option value="{{ $signatureItem[0]->id }}">{{ $signatureItem[0]->name }} ({{$key }})</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                @endif
                <div class="company__title--text text-center mt-4 px-2">TRƯỜNG THÔNG TIN</div>
                <div class="company__title--text-small px-2 text-center mt-2 mb-5">Kéo thả các trường thông tin dưới đây để thêm ô ký vào bản hợp đồng.Click đúp chuột vào ô chữ ký dưới đây để hiển thị tùy chọn ký</div>
                <div class="signature--block d-flex justify-content-center " id="signature--block">
                    <div style="box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);" class="digitalSignature--first d-flex justify-content-center align-items-center" id="digitalSignature--first1" draggable="true" onclick="onClickSignature(this)" ondragstart="dragStart()">
                        <img class="signature--image" id="signatureFirst--image" src="{{ asset('images/Signature_block.png') }}">
                        <img id="eSignature" src="" class="img-fluid signature-item">
                    </div>
                    <div class="digitalSignature--second d-flex justify-content-center align-items-center" id="digitalSignature--second" draggable="true" onclick="onClickSignature(this)" ondragstart="dragSecondStart()">
                        <img  class="signature--image" src="{{asset('images/Signature_block_2.png')}}">
                    </div>
                </div>
                    @if($isUpdate == 2)
                        @if(!isset($ownSignature))
                        <div class=" border company__title--text-small px-2 text-center mt-2 mb-5 text-danger">
                            <div>Bạn chưa có chữ ký cá nhân</div>
                            <div>Chọn: Quản lý cài đặt >> Danh sách chữ ký để tạo chữ kí</div>
                        </div>
                        @else
                        <div class="ownSignature d-flex justify-content-center">
                            <h3 class="ownSignature--text">Chữ ký của tôi</h3>
                            <div class="ownDigitalSignature d-flex justify-content-center" id="ownDigitalSignature" ondragstart="dragOwnStart()"
                                 onclick="onClickSignature(this)" draggable="true">
                                <img class="ownSignature--image" src=" {{$ownSignature->signature}}">
                            </div>
                        </div>
                        @endif
                    @endif
{{--                    @if($ownSignature != '' && isset($ownSignature))--}}
{{--                            <div class="ownSignature">--}}
{{--                                <h3 class="ownSignature--text">Chữ ký của tôi</h3>--}}
{{--                                <div class="ownDigitalSignature d-flex" id="ownDigitalSignature" ondragstart="dragOwnStart()"--}}
{{--                                     onclick="onClickSignature(this)" draggable="true">--}}
{{--                                    <img class="ownSignature--image" src=" {{$ownSignature->signature}}">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                    @endif--}}
            </div>

        </div>
        <div class="container-content__contract">
            <div class="documentRender" id="documentRender"> </div>
        </div>
        <div class="container-content__list d-flex flex-column align-items-center">
            @foreach($file as $key => $fi)
                <div class="document_preview d-none d-md-flex {{! $key ? 'active__file--contract' : ''}}" data-key="{{$key}}" data-fileId="{{$fi['fileId']}}" id="document_preview">
                    <img class="document_preview--icon" src="{{asset('/images/svg/pdf.svg')}}">
                    <div class="document_preview--name">{{$fi['fileName']}}</div>
                </div>
            @endforeach
            <div class="file_preview mt-2" id="file_preview">
            </div>
                @if($isUpdate != 2)
                <form action="{{route('web.contracts.sendMail')}}" id="sendMailForm" method="post" >
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    {{csrf_field()}}
                    <input type="hidden" id="contract_id" name="contract_id" value="{{ $contract_id }}"/>
                    <button class="btn btn-list--complete mt-3 mb-3" type="button"  id="complete" disabled>
                        Hoàn thành
                    </button>
                </form>
                @else
                    <input type="hidden" id="contract_id" name="contract_id" value="{{ $contract_id }}"/>
                    <button class="btn btn-list--complete mt-3 mb-3" id="sign" type="btn">
                        Hoàn thành
                    </button>
                @endif
{{--                <form action="{{route('contract.testFPDI')}}" id="testFPDI" method="post" >--}}
{{--                    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--                    {{csrf_field()}}--}}
{{--                    <input type="hidden" id="contract_id" name="contract_id" value="{{ $contract_id }}"/>--}}
{{--                </form>--}}
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{asset('vendor/pdf/signature.config.js')}}"></script>
    <script src="{{asset('vendor/pdf/signature-pad-create.config.js')}}"></script>
    <script>
        $(document).ready(function () {
            var current = -1;
            var totalFile = {!! json_encode(count($file)) !!};
            var isUpdate = {!! json_encode($isUpdate) !!};
            if( isUpdate == 2 ) {
                $('.signature--block').addClass('d-none');
            }
            // clone updated signature
            if(typeof {!! json_encode($signatures) !!} !== 'undefined'){
                const countAreaArray = {!! json_encode($signatures) !!};
                countAreaArray.map((item, index) => {
                    if(countAreaArray[index].dataX){
                        let ele = $('#digitalSignature--first1').clone();
                        if(item.type != 3) {
                            $(ele).css('width', item.width + '%');
                            $(ele).css('height', item.height + '%');
                            $(ele).attr('data-target', '#' + parseInt(item.id));
                            $(ele).attr('id', 'digitalSignature--first' + item.id);
                            $(ele).attr('data-id', item.id);
                            $(ele).attr('data-page', item.dataPage);
                            $(ele).attr('data-fileId', item.file_id);
                            if($(ele).attr('data-fileId') != fileId) {
                               $(ele).addClass('d-none');
                            }
                            if(isUpdate != 2) {
                                $(ele).append('<div class="d-flex justify-content-center align-items-center remove__sign--button" onclick="onClickRemoveSignature(this)" style="position: absolute; top: -10px; right: -10px; width: 20px; height: 20px; background: gray; border-radius: 10px; color: white;">X</div>');
                            }
                            $(ele).removeAttr('ondragstart');
                            $(ele).addClass('clone-element');
                            $(ele).attr('type',item.type);
                            $(ele).attr('data-file',0);
                            $(ele).attr('del-status',0);
                            if(item.type == 2) {
                                $(ele).attr('type',2);
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
                    }
                })
            }
            let dragEle = $('.clone-element');
            if(dragEle.length >0 ) {
                $('#complete').removeAttr('disabled');
            }
            //  sign on mobile
            $('.digitalSignature--second').on('touchstart', function(e) {
                dragSecondStart();
            })

            $('.digitalSignature--first').on('touchstart', function(e) {
                dragStart();
            })

            $('.ownDigitalSignature').on('touchstart', function(e) {
                dragOwnStart();
            })

            // change file
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

            // complete button
            $('#complete').on('click', function () {
                let dragElement = $('.drag-element.d-flex');
                var check = 0 ;
                dragElement.each( function (index) {
                    if($(this).attr('data-signature-id') == 'default'){
                        alert('Vui lòng chọn người nhận cho từng chữ kí');
                        check = 1 ;
                        return false;
                    }
                });
                let checkOwn = $('.ownDigitalSignature.drag-element.d-flex').attr('id');
                if(checkOwn){
                    if( check == 0 ) {
                        drawSignature();
                    }
                }
                else {
                    if(check == 0) {
                        $('#spinner').modal('toggle');
                        $('#spinner').modal('show');
                        $('#sendMailForm').submit();
                    }
                }
            })

            $('#sign').on('click',function (){
                draw();
            })
            function draw() {
                $('#spinner').modal('toggle');
                $('#spinner').modal('show');
                let scale = $('#documentRender #customCanvas0').attr('scale');
                let width = $('#documentRender').width();
                let height = $('#documentRender').height();
                let ownSignatureX = $('#documentRender').offset().left-$('#ownDigitalSignature').offset().left;
                let ownSignatureY = $('#documentRender').offset().top-$('#ownDigitalSignature').offset().top;
                let totalPage = $('.page__number').html();
                const ownSignature = $('[id = ownDigitalSignature1][data-fileId = '+fileId+']');
                let signatureInf = [];
                let contractId = $('#contract_id').val();
                ownSignature.each(function (index) {
                    let srcImg = $(this).find('.ownSignature--image').get()[0];
                    srcImg = $(srcImg).attr('src');
                    let x = parseFloat($(this).attr('data-x') - ownSignatureX);
                    let y = parseFloat($(this).attr('data-y') - ownSignatureY);
                    let imageX = $(this).width();
                    let imageY = $(this).height();
                    let pageNum = $(this).attr('data-page');
                    let arr =  [x,y,imageX,imageY,pageNum,srcImg];
                    signatureInf.push(arr);
                    $(this).addClass('d-none');
                });
                $.ajax({
                    url: "{{route('web.contracts.testFPDI')}}",
                    data: {'width': width, 'height' :height,'signatureInf': signatureInf,'contractId': contractId,'totalPage' :totalPage},
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        window.location.href = "{{route('web.contracts.index')}}";
                    },
                })
            }
            // draw signature and update to file
            function drawSignature () {
                $('#spinner').modal('toggle');
                $('#spinner').modal('show');
                $('#sendMailForm').trigger('submit');
            }
            // check signature
            function checkSignature(datapage,datafileId) {
                $('.drag-element').addClass('d-none').removeClass('d-flex');
                $('.clone-element').addClass('d-none').removeClass('d-flex');
                $('div[data-page= '+datapage+' ][data-fileId = '+datafileId+'][del-status = 0]').addClass('d-flex').removeClass('d-none');
            }
            var value = parseInt($('.page__box').val());
            window.saveArray = new Array();

            // change page
            $('#left-angle').on('click',function (){
                if(value > 1){
                    value--;
                    checkSignature(value,fileId);
                    $('.page__box').val(value);
                    renderPDF(loadingTask, $('#documentRender'), parrent_width,value);
                    renderPDF(loadingTask, $('#file_preview'), $('#file_preview').width(),value);
                }
            });

            // change page
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
            // send coordinate
            $('#sendMailForm').submit(function (){
                interact('.digitalSignature--first').unset();
                const allDragElements = $('.drag-element ');
                let coordinates = []
                let width = $('#documentRender').width();
                let height = $('#documentRender').height();
                const self = this;
                let oldSignature = [];
                const cloneElements = $('.clone-element');
                allDragElements.each(function (index) {
                    const divId = $(this).attr('id');
                    let sigDiv = document.getElementById(divId.toString()).cloneNode(true);
                    let type = sigDiv.getAttribute('type');
                    let dataFileId = sigDiv.getAttribute('data-fileId');
                    let offsetX = 0;
                    let offsetY = 0;
                    if(type != 3) {
                        let canvasHeight = $('[file-id = '+dataFileId+']').attr('height');
                        let canvasWidth = $('[file-id = '+dataFileId+']').attr('width');
                        let eleWidth  = $(this).width() / parseFloat(canvasWidth) * 100;
                        let eleHeight = $(this).height() / (parseFloat(canvasHeight) + 6) * 100; // 6 :box shadow
                        if(type == 1 ) {
                            offsetX = $('#documentRender').offset().left-$('#digitalSignature--first1').offset().left;
                            offsetY = $('#documentRender').offset().top- $('#digitalSignature--first1').offset().top;
                        }
                        else if(type == 2 ) {
                            offsetX = $('#documentRender').offset().left - $('#digitalSignature--second').offset().left;
                            offsetY = $('#documentRender').offset().top - $('#digitalSignature--second').offset().top;
                        }
                        sigDiv.classList.remove('drag-element');
                        let pageData = sigDiv.getAttribute('data-page');
                        document.getElementById('signature--block').appendChild(sigDiv);
                        let x = parseFloat((sigDiv.getAttribute('data-x')  - offsetX)/width * 100);
                        let y = parseFloat((sigDiv.getAttribute('data-y') - offsetY)/height * 100);
                        const sigId = parseInt(sigDiv.getAttribute('data-signature-id'));
                        const arr = [x,y];
                        coordinates.push(arr);
                        $(self).append(`<input type="hidden" name="coordinates[${sigId}][${index}][0]" value="${x}"/>`);
                        $(self).append(`<input type="hidden" name="coordinates[${sigId}][${index}][1]" value="${y}"/>`);
                        $(self).append(`<input type="hidden" name="coordinates[${sigId}][${index}][2]" value="${pageData}"/>`);
                        $(self).append(`<input type="hidden" name="coordinates[${sigId}][${index}][3]" value="${type}"/>`);
                        $(self).append(`<input type="hidden" name="coordinates[${sigId}][${index}][4]" value="${dataFileId}"/>`);
                        $(self).append(`<input type="hidden" name="coordinates[${sigId}][${index}][5]" value="${eleWidth}"/>`);
                        $(self).append(`<input type="hidden" name="coordinates[${sigId}][${index}][6]" value="${eleHeight}"/>`);
                        $(self).append(`<input type="hidden" name="isUpdate" value="${isUpdate}"/>`);
                    }
                })
                // update signature
                cloneElements.each (function(index){
                    const cloneId = $(this).attr('data-id');
                    let status = $(this).attr('del-status');
                    $(self).append(`<input type="hidden" name="oldSignature[${cloneId}]" value="${status}"/>`);
                })
                return true;
            });

            $('#listSignatures').on('change', (function () {
                const signatureElement = $('.signature__press--active');
                const signatureId = $(this).val();
                signatureElement.attr('data-signature-id', signatureId)
            }))
            R.Init();
        });
    </script>
    <script>
        'use strict';
        var pdfjs = window['pdfjs-dist/build/pdf'];
        var str = $('.file_base64_encode').eq(0).html();
        var fileId = document.getElementsByClassName('document_preview')[0].getAttribute('data-fileId');
        var pdfData = atob(str);

        // render pdf
        function renderPDF (setPDF, canvasContainer, options,number) {
            var page_number = $('.page__number');
            function renderPage(page) {
                var scale = options/page.getViewport(1).width;
                var viewport = page.getViewport(scale);
                var canvas = document.createElement('canvas');
                if( canvasContainer.hasClass('documentRender')) {
                    canvas.setAttribute('id', 'customCanvas'+page.pageIndex);
                }
                canvas.setAttribute('file-id', fileId);
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
        renderPDF(loadingTask, $('#documentRender'), parrent_width,1);
        renderPDF(loadingTask, $('#file_preview'), $('#file_preview').width(),1);
        var pdf = new jsPDF('p', 'pt', 'letter');

        // choose email signature
        function onClickSignature(element) {
            const selectSignature = $('#listSignatures');
            selectSignature.removeClass('d-none').addClass('d-flex');
            $('#listSignaturesInit').addClass('d-none');
            $('.signature__press--active').removeClass('signature__press--active')
            $(element).addClass('signature__press--active');
            if ($(element).attr('data-signature-id')) {
                selectSignature.val($(element).attr('data-signature-id')).change();
            } else {
                selectSignature.val('default').change();
            }
        }
        // hide signature
        function onClickRemoveSignature(element) {
            $(element).parent().removeClass('d-flex').addClass('d-none');
            $(element).parent().attr('del-status',1);
        }

        $(document).mouseup(function (e) {
            const target = $(e.target);
            if (!target.closest('.digitalSignature--first').length && !target.closest('#listSignatures').length) {
                $('#listSignatures').removeClass('d-flex').addClass('d-none');
                $('.signature__press--active').removeClass('signature__press--active')
            }
        })

        // drag signature 1
        function dragStart(event){
            $('#complete').removeAttr('disabled');
            let $div = $('div[id^="digitalSignature--first"]:last');
            let num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
            let newDiv = document.getElementById('digitalSignature--first1').cloneNode(true);
            newDiv.setAttribute('id','digitalSignature--first'+num);
            newDiv.setAttribute('type',1);
            newDiv.setAttribute('data-fileId',fileId);
            newDiv.setAttribute('del-status',0);
            // add remove element button
            $(newDiv).append('<div class="d-flex justify-content-center align-items-center remove__sign--button" onclick="onClickRemoveSignature(this)" style="position: absolute; top: -10px; right: -10px; width: 20px; height: 20px; background: gray; border-radius: 10px; color: white;">X</div>');

            let dataPage = $('.page__box').val();
            newDiv.setAttribute('data-page',dataPage);
            newDiv.classList.add('drag-element');
            resizalbeElement($(newDiv));
            newDiv.style.zIndex = num+10;
            $('#signature--block').append(newDiv);
        }

        // drag signature 2
        var signature_id = 0;
        function dragSecondStart(event){
            $('#complete').removeAttr('disabled');
            signature_id++;
            let newDiv = $('#digitalSignature--second').clone();
            newDiv.attr('id','digitalSignature--second'+signature_id);
            newDiv.attr('type',2);
            newDiv.attr('data-fileId',fileId);
            newDiv.attr('del-status',0);
            // add remove element button
            $(newDiv).append('<div class="d-flex justify-content-center align-items-center remove__sign--button" onclick="onClickRemoveSignature(this)" style="position: absolute; top: -10px; right: -10px; width: 20px; height: 20px; background: gray; border-radius: 10px; color: white;">X</div>');

            let dataPage = $('.page__box').val();
            newDiv.attr('data-page',dataPage);
            newDiv.addClass('drag-element');
            resizalbeElement($(newDiv));
            $('.signature--block').append(newDiv);
        }

        // drag own signature
        function dragOwnStart(event){
            $('#complete').removeAttr('disabled');
            let newDiv = document.getElementById('ownDigitalSignature').cloneNode(true);
            newDiv.setAttribute('id','ownDigitalSignature1');
            newDiv.setAttribute('type',3);
            newDiv.setAttribute('data-fileId',fileId);
            newDiv.setAttribute('del-status',0);
            // add remove element button
            $(newDiv).append('<div class="d-flex justify-content-center align-items-center remove__sign--button" onclick="onClickRemoveSignature(this)" style="position: absolute; top: -10px; right: -10px; width: 20px; height: 20px; background: gray; border-radius: 10px; color: white;">X</div>');

            let dataPage = $('.page__box').val();
            newDiv.setAttribute('data-page',dataPage);
            newDiv.classList.add('drag-element');
            resizalbeElement($(newDiv));
            $('.ownSignature').append(newDiv);
        }
        function modalStart() {
            $('#exampleModal').modal('show');
        }
        function resizalbeElement (element) {
            element.resizable({
                // aspectRatio: 19 / 7,
                // maxHeight: 70,
                // maxWidth: 190,
                minHeight: 25,
                start : function () {
                    interact('.drag-element').draggable(false);
                },
                stop : function () {
                    interact('.drag-element').draggable(true);
                }
            });
        }
    </script>
@endsection
