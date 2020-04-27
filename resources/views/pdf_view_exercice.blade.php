<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>{{ $principe }}</title>
 <link rel="stylesheet" href="css/pdf-view.css">
</head>
<body>
 <div class="details-exercice">
    <div class="detail-col-1">
        <h3>{{ $principe }}</h3>
        <div class="details-items-info">
            <div class="p-flex">
                <span class="text">Durée:</span>
                <span class="value">{{ $time }}</span>
                <span class="text">Nombre de joueurs:</span>
                <span class="value">{{ $nbJoueurs }}</span>
                <span class="text">Type:</span>
                <span class="value">{{ $typeExercice->nom }}</span>
            </div>
        </div>
        <p class="description-exercice">{{ $description }}</p>
        <div class="details-exercice-info">
            @if($observations != '')
            <div class="bloc-info">
                <h5>Observations</h5>
                <p>{{ $observations }}</p>
            </div>
            @endif   
            @if($sousPrincipe != '')
                <div class="bloc-info">
                    <h5>Sous-principes</h5>
                    <p>{{ $sousPrincipe }}</p>
                </div>
            @endif
            @if($physique != '')
                <div class="bloc-info">
                    <h5>Objectifs physiques</h5>
                    <p>{{ $physique }}</p>
                </div>
            @endif        
        </div>
    </div>
    <div class=" detail-col-1 details-exercice-image">
        <div class="image-exercice">
            <img class="img-responsive" src="images/uploaded/{{ $image }}">
        </div>                        
    </div>
  </div>
  <div class="by">By Soccer-Coach</div>
  </body>
</html>
