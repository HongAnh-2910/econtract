// enable draggables to be dropped into this
interact('#documentRender').dropzone({
    // only accept elements matching this CSS selector
    accept: '.drag-element',
    // Require a 100% element overlap for a drop to be possible
    overlap: 1,

    // listen for drop related events:
    ondropactivate: function (event) {
        // add active dropzone feedback
        event.target.classList.add('drop-active');
    },
    ondragenter: function (event) {
        var draggableElement = event.relatedTarget,
            dropzoneElement = event.target;

        // feedback the possibility of a drop
        dropzoneElement.classList.add('drop-target');
        // dropzoneElement.appendChild(draggableElement);
        // draggableElement.classList.remove('dropped-out');
        //draggableElement.textContent = 'Dragged in';
    },
    ondragleave: function (event) {
        // remove the drop feedback style
        event.target.classList.remove('drop-target');
        event.relatedTarget.classList.remove('can-drop');
        // event.relatedTarget.classList.add('dropped-out');
        //event.relatedTarget.textContent = 'Dragged out';
    },
    ondrop: function (event) {
        //event.relatedTarget.textContent = 'Dropped';
    },
    ondropdeactivate: function (event) {
        // remove active dropzone feedback
        var img = document.createElement('img');
        img.src = event.relatedTarget.src;
        img.setAttribute('data-x', event.relatedTarget.getAttribute('data-x'));
        img.setAttribute('data-y', event.relatedTarget.getAttribute('data-y'));
        // event.target.append (event.relatedTarget);
        event.target.classList.remove('drop-active');
        event.target.classList.remove('drop-target');
    }
});

interact('.drag-element')
    .draggable({
        inertia: true,
        restrict: {
            restriction: '#documentRender',
            endOnly: true,
            elementRect: {top: 0, left: 0, bottom: 1, right: 1}
        },
        autoScroll: true,
        // dragMoveListener from the dragging demo above
        onmove: dragMoveListener,
    })
    .on('dragstart', dragStartListener)

function dragStartListener(event) {
    var interaction = event.interaction;
    // console.log('start');

    // if the pointer was moved while being held down
    // and an interaction hasn't started yet
    // console.log(event.dataTransfer);
    // var newSig = $('.digitalSignature--first').clone();
    // if (!event.target.dragOrigin) {
    //     var clone = event.target.cloneNode(true);
    //     clone.dragOrigin = event.target;
    //     event.interaction.element = clone;
    //     event.interaction.dragging = false;
    //     var dragTarget = clone;
    //     document.body.appendChild(clone);
    //     var r = event.target.getBoundingClientRect();
    //     clone.style.position = 'absolute';
    //     clone.style.left =  '55.09375px';
    //     clone.style.top = '359.453125px';
    // } else {
    //     dragTarget = event.target;
    // }
    // newSig.addClass('aaa');
    // $('#parametriContainer').append(newSig);
    // this.mouse = {x: event.clientX,y: event.clientY};
    // this.actual = {x: this.style.left, y: this.style.top};
    // event.dataTransfer.setDragImage(this, 0, 0);
}
// function dragMoveListener(event) {
//
//     const { currentTarget, interaction } = event;
//     let element = currentTarget;
//     if (
//         interaction.pointerIsDown &&
//         currentTarget.style.transform === "" &&
//         currentTarget.getAttribute('clonable') != 'false'
//     ) {
//         console.log(interaction.pointerIsDown);
//         console.log(interaction.interacting())
//         console.log(currentTarget);
//         element = currentTarget.cloneNode(true);
//
//         // Add absolute positioning so that cloned object lives
//         // right on top of the original object
//         element.style.position = "absolute";
//         element.style.left = '0.75%';
//         element.style.top = '359px';
//         var a = element.style.zIndex;
//         var $div = document.getElementById('signature-information').lastChild;
//         console.log($div);
//         // Read the Number from that DIV's ID (i.e: 3 from "klon3")
//         // And increment that number by 1
//         var demo = $div.getAttribute("id").split('digitalSignature--first')[1];
//         console.log(demo);
//         var num = parseInt(demo) -1;
//
//         element.setAttribute('id','digitalSignature--first'+num);
//         console.log(element);
//         // Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
//         // var $klon = $div.clone().prop('id', 'klon'+num );
//
//         // Finally insert $klon wherever you want
//         // $div.after( $klon.text('klon'+num) );
//         element.style.zIndex = num;
//         // var index = element.style.zIndex;
//         // var index = parseInt(element.getAttribute('z-index'))- 1;
//         // element.style.zIndex = index;
//         // element.classList.remove('drag-element');
//         // console.log(index);
//         // Add the cloned object to the document
//         var container = document.getElementById('signature-information');
//         container.appendChild(element);
//         interaction.start({ name: 'drag' }, event.interactable, element);
//         // If we are moving an already existing item, we need to make sure
//         // the position object has the correct values before we start dragging it
//     } else  {
//         var target = event.target,
//             // keep the dragged position in the data-x/data-y attributes
//             x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
//             y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
//         target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
//         target.setAttribute('data-x', x);
//         target.setAttribute('data-y', y);
//         // const regex = /translate\(([\d]+)px, ([\d]+)px\)/i;
//         // const transform = regex.exec(currentTarget.style.transform);
//         //
//         // if (transform && transform.length > 1) {
//         //     position.x = Number(transform[1]);
//         //     position.y = Number(transform[2]);
//         // }
//     }
//     // Start the drag event
//     interaction.start({ name: "drag" }, event.interactable, element);
// }
        function dragMoveListener(event) {
            var target = event.target,
            x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
            y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
            target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
            target.setAttribute('data-x', x);
            target.setAttribute('data-y', y);

        }
// this is used later in the resizing demo
window.dragMoveListener = dragMoveListener;
