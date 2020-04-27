var base64Img = '';

$(function() {
    $('.div-exercice-infos').hide();

    document.getElementById("inp").addEventListener("change", readFile);

    $('.file-upload').file_upload();
});

function readFile() {

    if (this.files && this.files[0]) {

        var FR= new FileReader();

        FR.addEventListener("load", function(e) {
            base64Img = e.target.result;
        });

        FR.readAsDataURL( this.files[0] );
    }

}

function creerExerrcice(){
    var infosExercice = $('.exercice-infos');
    var principe = $('#principe').val();
    var description = $('#description').val();
    var observations = $('#observations-coach').val();
    var sousPrincipes = $('#sous-principe').val();
    var time = $('#time').val();
    var nbJoueurs = $('#nb-joueurs').val();
    var physique = $('#physique').val();

    $('#td-description')[0].innerText = description;
    $('#td-observations')[0].innerText = observations;
    $('#td-principes')[0].innerText = principe;
    $('#td-sous-principes')[0].innerText = sousPrincipes;
    $('#td-duree')[0].innerText = time;
    $('#td-physique')[0].innerText = physique;
    $('#td-nbJoueurs')[0].innerText = nbJoueurs;
    $('.div-exercice-infos').show();
    $('#ajouter-exercice-form').hide();

}

function modifierExericice() {
    $('#ajouter-exercice-form').show();
    $('.div-exercice-infos').hide();
    $('#btn-creer')[0].innerText = 'Modifier';
}

function creerExercicePdf() {
    html2canvas($(".exercice-infos"), {
        onrendered: function(canvas) {
            var img = canvas.toDataURL('image/png');
            var doc = new jsPDF();
            doc.addImage(img, 'JPEG', 0, 0);
            doc.save('exercice.pdf');
        }
    });

    // var pdf = new jsPDF();
    // var source = $(".exercice-infos")[0];
    // var specialElementHandlers = {
    //     // element with id of "bypass" - jQuery style selector
    //     '#bypassme': function(element, renderer){
    //         // true = "handled elsewhere, bypass text extraction"
    //         return true
    //     },
    //     '.hide': function(element, renderer){
    //         // true = "handled elsewhere, bypass text extraction"
    //         return true
    //     }
    // };
    //
    //
    // var margins = {
    //     top: 80,
    //     bottom: 60,
    //     left: 40,
    //     width: 522
    // };
    //
    // pdf.fromHTML(
    //     $(".exercice-infos").html() // HTML string or DOM elem ref.
    //     , 15// x coord
    //     , 15 // y coord
    //     , {
    //         'width': 170 // max width of content on PDF
    //     }
    // );
    // pdf.save('exercice.pdf');
}