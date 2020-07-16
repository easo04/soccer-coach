<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Excercie</title>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous'>
    <link rel="stylesheet" href="css/exercices.css">
    <link rel="stylesheet" href="css/drag.css">
    <link rel="stylesheet" href="css/colors.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="js/imports/bootstrap/bootstrap.min.js"></script>
    <script src="js/imports/interact.js"></script> 
    <!-- <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>-->
    <script src="js/imports/jspdf.min.js"></script>
    <script src="js/imports/canvas2image.js"></script>
    <script src="js/imports/html2canvas.js"></script>
    <script src="js/objects/liste-objects.js"></script>
    <script src="js/excercices.js"></script>
    <script src="js/drag.js"></script>
  </head>
  <body>
    <div class="actions">
      <div class="outils-act-2">
      </div>
      <div class="outils-act-1">
        <div class="color-icons icons-soccer">
          <div class="color-outil color-red action-outil" id="color-red" onclick="changerCouleurOutil('red');"></div>
          <div class="color-outil color-blue-claro action-outil" id="color-blue-claro" onclick="changerCouleurOutil('blue-claro');"></div>
          <div class="color-outil color-yellow action-outil" id="color-yellow" onclick="changerCouleurOutil('yellow');"></div>
          <div class="color-outil color-white action-outil" id="color-white" onclick="changerCouleurOutil('white');"></div>
          <div class="color-outil color-black action-outil" id="color-black" onclick="changerCouleurOutil('black');"></div>
        </div>
        <div class="actions-icons icons-soccer">
          <i class="fas fa-fill-drip action-outil" id="btnColor" onclick="setChangeBorderColor(false);selectedAction('btnColor')"></i>
          <i class="fa fa-font action-outil" data-toggle="modal" id="btnAddText" data-target="#modalAddText"></i>
          <i class="fa fa-file-image-o" onclick="savePNG();"></i>
          <i class="fa fa-file-pdf-o" onclick="savePdf();"></i>
          <!--<i class="fa fa-floppy-o"></i>-->
          <i class="fa fa-eraser" onclick="deleteObject();" id="supprimerObject"></i>
          <i class="fa fa-trash" data-toggle="modal" data-target="#modalDeleteAll" id="deleteAll"></i>
        </div>
      </div>
      <div class="outils-act-2">
        <div class="actions-icons icons-soccer">
          <i class="fa fa-rotate-right action-outil" id="btnRotate" onclick="selectedActionForm('btnRotate');rotate();"></i>
          <i class="fa fa-plus-square action-outil" id="btnZoomPlus" onclick="selectedActionForm('btnZoomPlus');zoomPlus();"></i>
          <i class="fa fa-minus-square action-outil" id="btnZoomMoins" onclick="selectedActionForm('btnZoomMoins');zoomMoins();"></i>
          <i class="fa fa-square action-outil" id="btnSquare" onclick="selectedActionForm('btnSquare')"></i>
          <i class="fa fa-circle action-outil action" id="btnCircle" onclick="selectedActionForm('btnCircle')"></i>
          <i class="far fa-clone action-outil action" id="btnMakeCopy" onclick="selectedActionForm('btnMakeCopy');makeCopy();"></i>
          <!--<i class="fa fa-square-o" data-toggle="modal" id="btnBorderForme" data-target="#modalAddText"></i>-->
          <select id="select-transparence">
            <option value="opacite">Opacité</option>
            <option value="100">100%</option>
            <option value="70">70%</option>
            <option value="50">50%</option>
            <option value="20">20%</option>
            <option value="0">0%</option>
          </select>
        </div>
      </div>
    </div>
    <div class="conteneur">
      <div class="outils">
      </div> 
      <div class="terrain">
        <div class="row terrain-space" id="terrainSoccer"></div>
      </div>
      <div class="outils">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#terrainsDiv" onclick="initButtons(false);initButtonsFormes(false);">Terrains</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#joueursDiv" onclick="initButtons(true);initButtonsFormes(false);">Joueurs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#outilsDiv" onclick="initButtons(false);initButtonsFormes(false);">Outils</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#lignesDiv" onclick="initButtons(false);">Lignes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#formsDiv" onclick="initButtons(false);initButtonsFormes(true);">Formes</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active container tab-onglet" id="terrainsDiv">
            <ul class="list-group" id="ul-liste-terrains"></ul>
          </div>
          <div class="tab-pane container tab-onglet" id="joueursDiv">
            <ul class="list-group" id="ul-liste-joueurs"></ul>
          </div>
          <div class="tab-pane container tab-onglet" id="outilsDiv">
            <ul class="list-group" id="ul-liste-outils"></ul>
          </div>
          <div class="tab-pane container tab-onglet" id="lignesDiv">
            <ul class="list-group" id="ul-liste-lignes"></ul>
          </div>
          <div class="tab-pane container tab-onglet" id="formsDiv">
            <ul class="list-group" id="ul-liste-formes"></ul>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="modalAddText" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ajouter le nom du joueur</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <label for="nomJoueur">Nom joueur:</label>
                <input type="text" class="form-control" id="nomJoueur">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" onclick="changerPlayerName()">Ok</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
      </div>

      <div class="modal fade" id="modalDeleteAll" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tout supprimer</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <p>Voulez-vous tout supprimer?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" onclick="deleteAll()">Oui</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    <div class="styles-lignes"></div>
  </body>
</html>