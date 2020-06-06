/**
 * Created by ceseas1 on 2018-12-27.
 */
// target elements with the "draggable" class
interact('.draggable')
    .draggable({
        // enable inertial throwing
        inertia: true,
        // keep the element within the area of it's parent
        restrict: {
            restriction: "parent",
            endOnly: true,
            elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
        },
        // enable autoScroll
        autoScroll: true,

        // call this function on every dragmove event
        onmove: dragMoveListener,
        // call this function on every dragend event
        onend: function (event) {
            // var textEl = event.target.querySelector('p');
            //
            // textEl && (textEl.textContent =
            //   'moved a distance of '
            //   + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
            //                Math.pow(event.pageY - event.y0, 2) | 0))
            //       .toFixed(2) + 'px');
        }
    });

    /*document.addEventListener('DOMContentLoaded', () => {
        const sns = 'http://www.w3.org/2000/svg'
        const xns = 'http://www.w3.org/1999/xlink'
        const root = document.getElementById('svg-edit-demo')
        const star = document.getElementById('edit-star')
        let rootMatrix
        const originalPoints = []
        let transformedPoints = []
        
        for (let i = 0, len = star.points.numberOfItems; i < len; i++) {
        const handle = document.createElementNS(sns, 'use')
        const point = star.points.getItem(i)
        const newPoint = root.createSVGPoint()
    
        handle.setAttributeNS(xns, 'href', '#point-handle')
        handle.setAttribute('class', 'point-handle')
    
        handle.x.baseVal.value = newPoint.x = point.x
        handle.y.baseVal.value = newPoint.y = point.y
    
        handle.setAttribute('data-index', i)
    
        originalPoints.push(newPoint)
    
        root.appendChild(handle)
        }
    
        function applyTransforms (event) {
        rootMatrix = root.getScreenCTM()
    
        transformedPoints = originalPoints.map((point) => {
            return point.matrixTransform(rootMatrix)
        })
    
        interact('.point-handle').draggable({
            snap: {
            targets: transformedPoints,
            range: 20 * Math.max(rootMatrix.a, rootMatrix.d),
            },
        })
        }
        
    interact(root)
        .on('mousedown', applyTransforms)
        .on('touchstart', applyTransforms)
    
    interact('.point-handle')
    .draggable({
    onstart: function (event) {
        root.setAttribute('class', 'dragging')
    },
    onmove: function (event) {
        const i = event.target.getAttribute('data-index') | 0
        const point = star.points.getItem(i)

        point.x += event.dx / rootMatrix.a
        point.y += event.dy / rootMatrix.d

        event.target.x.baseVal.value = point.x
        event.target.y.baseVal.value = point.y
    },
    onend: function (event) {
        root.setAttribute('class', '')
    },
    snap: {
        targets: originalPoints,
        range: 10,
        relativePoints: [{ x: 0.5, y: 0.5 }],
    },
    restrict: { restriction: document.rootElement },
    })
    .styleCursor(false)
    
    document.addEventListener('dragstart', (event) => {
        event.preventDefault()
    })
}) */

interact('.resize-drag')
    .draggable({
        onmove: window.dragMoveListener,
        restrict: {
            restriction: 'parent',
            elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
        },
    })
    .resizable({
        // resize from all edges and corners
        edges: { left: true, right: true, bottom: true, top: true },

        listeners: {
            move (event) {
                var target = event.target
                var x = (parseFloat(target.getAttribute('data-x')) || 0)
                var y = (parseFloat(target.getAttribute('data-y')) || 0)

                // update the element's style
                target.style.width = event.rect.width + 'px'
                target.style.height = event.rect.height + 'px'
                
              // translate when resizing from top or left edges
                x += event.deltaRect.left
                y += event.deltaRect.top
                
                target.style.webkitTransform = target.style.transform =
                'translate(' + x + 'px,' + y + 'px)'
                
                target.setAttribute('data-x', x)
                target.setAttribute('data-y', y)
                target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height)
            }
        },

        /*modifiers: [
            // keep the edges inside the parent
            interact.modifiers.restrictEdges({
              outer: 'parent'
            }),
      
            // minimum size
            interact.modifiers.restrictSize({
              min: { width: 100, height: 50 },             
              max: { width:  400, height:  400 },
            })
          ],
      
          inertia: true*/

        // keep the edges inside the parent
        restrictEdges: {
            outer: 'parent',
        },

        // minimum size
        restrictSize: {
            min: { width: 100, height: 100 },
            max: { width:  250, height:  250 },
        },

        inertia: true,
    })
    .on('resizemove', function (event) {
        var target = event.target,
            x = (parseFloat(target.getAttribute('data-x')) || 0),
            y = (parseFloat(target.getAttribute('data-y')) || 0);

        // update the element's style
        target.style.width  = event.rect.width + 'px';
        target.style.height = event.rect.height + 'px';

        // translate when resizing from top or left edges
        x += event.deltaRect.left;
        y += event.deltaRect.top;

        target.style.webkitTransform = target.style.transform =
            'translate(' + x + 'px,' + y + 'px)';

        target.setAttribute('data-x', x);
        target.setAttribute('data-y', y);
        //target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height);
    });


function dragMoveListener (event) {
    var target = event.target,
        // keep the dragged position in the data-x/data-y attributes
        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

    // translate the element
    target.style.webkitTransform =
        target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

    // update the posiion attributes
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
}

// this is used later in the resizing and gesture demos
window.dragMoveListener = dragMoveListener;