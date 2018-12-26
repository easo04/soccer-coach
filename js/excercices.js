var objectSelected = null;
var lastColorSelected = null;
var changeBorderColor = false;

$(function() {
    initListeTerrains();
    initListeJoueurs();
    initListeOutils();
    initListeLignes();

    initButtons(false);
});


function initListeTerrains(){
    var contenu = '';

    listeObjects.liste_terrains.forEach(function (item) {
        if(item.color !== ''){
            contenu += '<li class="list-group-item terrain-li"><div class="terrain-li-div terrain-' + item.name + '" onclick="changerTerrain(\'' + item.color + '\');"></div></li>';
        }else if(item.image !== ''){
            contenu += '<li class="list-group-item terrain-li"><div class="terrain-li-div" onclick="changerTerrainImg(\'' + item.image + '\');"><img src="images/terrain/' + item.image + '" width="293px" height="178px"/></div></li>';
        }
    });

    $("#ul-liste-terrains").html(contenu);
}

function changerTerrainImg(img){
    $('.terrain-space').css('background-image', 'url(images/terrain/' + img + ')');
    $('.terrain-space').css('background-repeat', 'no-repeat');
}


function changerTerrain(color){
    /*$('.terrain-space').removeProp("background-image");
    $('.terrain-space').removeProp("background-repeat");*/
    $('.terrain-space').css('background-image', '');
    $('.terrain-space').css('background-repeat', '');
    $('.terrain-space').css('background-color', color);
}

function initListeJoueurs() {
    var contenu = '';

    listeObjects.liste_joueurs.forEach(function (item) {
        contenu += '<li class="list-group-item joueur-li">'
        + '<div class="joueurs-li-div" onclick="ajouterJoueur(\'' + item.name + '\', \'' + item.image  + '\');">';
        if(item.image === ''){
          contenu += '<div class="drag-player-list"></div>';
        }else{
          contenu += '<div class="drag-player-list-img"><img src="images/joueurs/player-list/' + item.image + '"></div>';
        }

        contenu += '</div></li>';
    });

    $('#ul-liste-joueurs').html(contenu);
}

function ajouterJoueur(joueurName, joueurImage) {
    var noJoueurs = $('.terrain-space')[0].children.length + 1;
    var contenu = '';
    var color = lastColorSelected != null ? lastColorSelected : 'color-black';
    if(joueurImage === ''){
      contenu += '<div id="drag-joueur-' + noJoueurs +  '" class="draggable drag color-' + color + '" onclick="selectObject(\'drag-joueur-' + noJoueurs + '\')">' +
                  //'<p>' + noJoueurs + 'J</p>' +
                  '</div>';
    }else{
      contenu += '<div id="drag-joueur-' + noJoueurs +  '" class="draggable drag-joueur" onclick="selectObject(\'drag-joueur-' + noJoueurs + '\')">' +
                 '<img id="' + joueurName + '" src="images/joueurs/' + joueurImage + '">' +
                 '</div>';
    }

    $('#btnBorder').removeClass('action-selected');
    $('#btnColor').addClass('action-selected');
  
    $('.terrain-space').append(contenu);
}

function initListeOutils() {
    var contenu = '';

    listeObjects.liste_outils.forEach(function (item) {
        contenu += '<li class="list-group-item outil-li"><div class="outil-li-div" onclick="ajouterOutil(\'' + item.name + '\', \'' + item.image  + '\');"><img src="images/outils/' + item.image + '"></div></li>';
    });

    $('#ul-liste-outils').html(contenu);
}

function ajouterOutil(outilName, outilImage) {
    var noOutil = $('.terrain-space')[0].children.length + 1;
    var contenu = '<div id="drag-outil-' + noOutil +  '" class="draggable drag-outil" onclick="selectObject(\'drag-outil-' + noOutil + '\')">' +
        '<img src="images/outils/' + outilImage + '">' +
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
    var noLigne = $('.terrain-space')[0].children.length + 1;
    var contenu = '<div id="drag-lgn-' + noLigne +  '" class="draggable drag" onclick="selectObject(\'drag-lgn-' + noLigne + '\')">' +
        '<p>' + noLigne + 'L</p>' +
        '</div>';
    $('.terrain-space').append(contenu);
}

function deleteObject() {
    objectSelected.remove();
    initButtons(false);
}

function deleteAll(){
    $('.terrain-space').empty();
    objectSelected = null;
    initButtons(false);
}

function selectObject(dragId){
    objectSelected = $('#' + dragId);
    initButtons(true);
    var lastObjectSelected = $('.object-selected');
    if(lastObjectSelected !== undefined){
      lastObjectSelected.removeClass('object-selected');
    }else{
      lastObjectSelected = $('.object-selected-img');
      if(lastObjectSelected !== undefined){
        lastObjectSelected.removeClass('object-selected-img');
      }
    }

    if(objectSelected.hasClass('drag-joueur')){
      objectSelected.addClass('object-selected-img');
    }else if(!objectSelected.hasClass('drag-outil')){
      objectSelected.addClass('object-selected');
    }
}

function initButtons(showColors) {
    if(showColors || objectSelected !== null){
       $('.color-icons').show();
       $('#btnAddText').show();
       $('#btnBorder').show();
    }else{
       $('.color-icons').hide();
       $('#btnAddText').hide();
       $('#btnBorder').hide();
    }
}

function changerCouleurOutil(color){

  if(lastColorSelected != null){
    $('#color-' + lastColorSelected).removeClass('color-outil-selected');
  }

  $('#color-' + color).addClass('color-outil-selected');
  lastColorSelected = color;
  
  if(objectSelected !== null && objectSelected[0].id.startsWith('drag-joueur')){
    if(objectSelected.hasClass('drag-joueur')){
      var imgId = objectSelected[0].children[0].id;
      objectSelected[0].innerHTML = '<img id="' + imgId + '" src="images/joueurs/' + imgId + '-' + color + '.png">';
    }else{

      if(changeBorderColor){
        objectSelected[0].style.borderColor = color;
      }else{
        objectSelected[0].className = '';
        objectSelected.addClass('draggable drag ' + 'color-' + color);
        objectSelected.removeClass('object-selected');
    }
    }
  }
}

function changerPlayerName(){
  var nomPlayer = $("#nomJoueur").val();
  if(objectSelected !== null && objectSelected[0].id.startsWith('drag-joueur')){
    if(objectSelected.hasClass('drag-joueur')){
      objectSelected[0].innerHTML += '<p>' + nomPlayer + '</p>';
    }else{
      objectSelected[0].innerHTML = '<p>' + nomPlayer + '</p>';
    }
    $("#nomJoueur").val('');
  }
}

function setChangeBorderColor(changeBorder){
  changeBorderColor = changeBorder;
}

function selectedAction(idAction){
  var actionSelected = $('.action-selected');
  if(actionSelected.length !== 0){
    if(actionSelected[0].id === idAction){
      $('#'+idAction).removeClass('action-selected');
      //NE PAS AFFICHER A SECTION DES COULEURS
      $('.color-icons').hide();
    }else{
      actionSelected.removeClass('action-selected');
      $('#'+idAction).addClass('action-selected');
    }
  }else{
    $('.color-icons').show();
    $('#'+idAction).addClass('action-selected');
  }
}

function savePNG(){
   html2canvas($(".terrain-space"), {
    onrendered: function(canvas) {
        theCanvas = canvas;
        // Convert and download as image 
        Canvas2Image.saveAsPNG(canvas); 
        // Clean up 
        //document.body.removeChild(canvas);
    }
   });
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