var objectSelected = null;

$(function() {
    initListeTerrains();
    initListeJoueurs();
    initListeOutils();
    initListeLignes();

    initButtons();
});


function initListeTerrains(){
    var contenu = '';

    listeObjects.liste_terrains.forEach(function (item) {
        if(item.color !== ''){
            contenu += '<li class="list-group-item terrain-li"><div class="terrain-li-div terrain-' + item.name + '" onclick="changerTerrain(\'' + item.color + '\');"></div></li>';
        }else if(item.image !== ''){
            contenu += '<li class="list-group-item">item</li>';
        }
    });

    $("#ul-liste-terrains").html(contenu);
}

function changerTerrain(color){
    $('.terrain-space').css('background-color', color);
}

function initListeJoueurs() {
    var contenu = '';

    listeObjects.liste_joueurs.forEach(function (item) {
        contenu += '<li class="list-group-item joueur-li"><div class="joueurs-li-div" onclick="ajouterJoueur(\'' + item.name + '\', \'' + item.image  + '\');">' + item.name + '</div></li>';
    });

    $('#ul-liste-joueurs').html(contenu);
}

function ajouterJoueur(joueurName, joueurImage) {
    var noJoueurs = $('.terrain-space')[0].children.length + 1;
    var contenu = '<div id="drag-joueur-' + noJoueurs +  '" class="draggable drag" onclick="selectObject(\'drag-joueur-' + noJoueurs + '\')">' +
                  '<p>' + noJoueurs + '</p>' +
                  '</div>';
    $('.terrain-space').append(contenu);
}

function initListeOutils() {
    var contenu = '';

    listeObjects.liste_outils.forEach(function (item) {
        contenu += '<li class="list-group-item outil-li"><div class="outil-li-div" onclick="ajouterOutil(\'' + item.name + '\', \'' + item.image  + '\');">' + item.name + '</div></li>';
    });

    $('#ul-liste-outils').html(contenu);
}

function ajouterOutil(outilName, outilImage) {
    var noJoueurs = $('.terrain-space')[0].children.length + 1;
    var contenu = '<div id="drag-outil-' + noJoueurs +  '" class="draggable drag">' +
        '<p>' + noJoueurs + '</p>' +
        '</div>';
    $('.terrain-space').append(contenu);
}

function initListeLignes() {
    var contenu = '';

    listeObjects.liste_lignes.forEach(function (item) {
        contenu += '<li class="list-group-item ligne-li"><div class="ligne-li-div" onclick="ajouterLigne(\'' + item.name + '\', \'' + item.image  + '\');">' + item.name + '</div></li>';
    });

    $('#ul-liste-lignes').html(contenu);
}

function ajouterLigne(ligneName, ligneImage) {
    var noJoueurs = $('.terrain-space')[0].children.length + 1;
    var contenu = '<div id="drag-lgn-' + noJoueurs +  '" class="draggable drag">' +
        '<p>' + noJoueurs + '</p>' +
        '</div>';
    $('.terrain-space').append(contenu);
}

function deleteObject() {
    objectSelected.remove()
}

function selectObject(dragId){
    objectSelected = $('#' + dragId);
}

function initButtons() {
    //$('#delete').prop('disabled', true);
}

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