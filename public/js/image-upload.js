var base64Img = '';

$(function() {
    document.getElementById("input-file").addEventListener("change", readFile);

    $('.file-upload').hover(function(){
        $('.file-upload-infos')[0].style.opacity = 1;
    }, function(){
        $('.file-upload-infos')[0].style.opacity = 0;
    });
});

/** Permet de mettre à jour L'image sélectionné dans un div */
function readFile() {

    if (this.files && this.files[0]) {
        
        var fileName = this.files[0].name;

        var FR= new FileReader();

        FR.addEventListener("load", function(e) {
            base64Img = e.target.result;
            $('#img-exercice')[0].src = base64Img;
            $('.file-upload-filename-inner').text(fileName);
        });

        FR.readAsDataURL( this.files[0] );
    }

}