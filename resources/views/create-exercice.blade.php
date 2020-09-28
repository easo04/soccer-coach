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
    <div class="conteneur">
      <div class="block-p">Hola</div>
      <div class="content-design">
        <div class="outils">
          <div class="outils-joueurs"> 
            <h5>Joueurs</h5>
            <div class="list-joueur-add">  
              <div class="joueur-add">
                <img id="player1" src="images/joueurs/player1-red.png" onclick="addPlayerByColor('red')">
              </div> 
              <div class="joueur-add">
                <img id="player1" src="images/joueurs/player1-blue-claro.png" onclick="addPlayerByColor('blue-claro')">
              </div> 
              <div class="joueur-add">
                <img id="player1" src="images/joueurs/player1-yellow.png" onclick="addPlayerByColor('yellow')">
              </div>
            </div> 
          </div>
          <div class="outils-terrains">
            <h5>Terrains</h5>
            <div class="list-terrain-add"></div>
          </div> 
        </div> 
        <div class="terrain">
          <div class="terrain-act action">
            <div class="color-icons icons-soccer">
              <div class="color-outil color-red action-outil" id="color-red" onclick="changerCouleurOutil('red');"></div>
              <div class="color-outil color-blue-claro action-outil" id="color-blue-claro" onclick="changerCouleurOutil('blue-claro');"></div>
              <div class="color-outil color-yellow action-outil" id="color-yellow" onclick="changerCouleurOutil('yellow');"></div>
              <div class="color-outil color-white action-outil" id="color-white" onclick="changerCouleurOutil('white');"></div>
              <div class="color-outil color-black action-outil" id="color-black" onclick="changerCouleurOutil('black');"></div>
            </div>
            <div class="actions-icons icons-soccer">
              <i class="fas fa-plus action-outil" id="btnZoomPlus" onclick="zoomPlus()"></i>
              <i class="fas fa-minus action-outil" id="btnZoomMoins" onclick="zoomMoins()"></i>
              <i class="fas fa-fill-drip action-outil" id="btnColor" onclick="setChangeBorderColor(false);selectedAction('btnColor')"></i>
              <i class="fa fa-font action-outil" data-toggle="modal" id="btnAddText" data-target="#modalAddText"></i>
              <i class="fa fa-file-image-o" onclick="savePNG();"></i>
              <i class="fa fa-file-pdf-o" onclick="savePdf();"></i>
              <i class="fa fa-eraser" onclick="deleteObject();" id="supprimerObject"></i>
              <i class="fa fa-trash" data-toggle="modal" data-target="#modalDeleteAll" id="deleteAll"></i>
            </div>
          </div>
          <div class="row terrain-space" id="terrainSoccer"></div>
        </div>
        <div class="outils">
          <div class="outils-onglets-content">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#outilsDiv" onclick="initButtons(false);initButtonsFormes(false);">Outils</a>
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
              <div class="tab-pane active container tab-onglet" id="outilsDiv">
                <div class="list-group list-group-custom" id="liste-outils"></div>
              </div>
              <div class="tab-pane container tab-onglet" id="lignesDiv">
                <div class="list-group" id="liste-lignes"></div>
              </div>
              <div class="tab-pane container tab-onglet" id="formsDiv">
                <div class="list-group list-group-custom" id="liste-formes"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="styles-lignes"></div>
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
  </body>
</html>