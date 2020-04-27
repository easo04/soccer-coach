<template>
    <div class="file-upload-wrapper">
        <div :class="'card card-body view file-upload has-preview '+classImage">
            <div class="card-text file-upload-message">
                <i class="ti-cloud-down"></i>
                <p>Cliquer ici pour ajouter une image</p>
            </div>
            <div class="mask rgba-stylish-slight" style="display: none;"></div>
            <input type="file" name="image" id="input-file" :class="'file-upload file-upload'+idImage" @change="readFile" accept=".png, .jpg"/>
            <div :id="'file-upload-preview'+idImage" class="file-upload-preview" style="display: block;">
                <span class="file-upload-render">
                    <img class="file-upload-preview-img img-upload" :id="'img-exercice'+idImage" :src="srcFile"/>
                </span>
                <div :class="'file-upload-infos file-upload-infos'+idImage">
                    <div class="file-upload-infos-inner">
                        <p class="file-upload-filename">
                            <span class="file-upload-filename-inner">{{ fileName }}</span>
                        </p>                              
                        <p class="file-upload-infos-message"> Cliquer pour remplacer</p> 
                        <i class="ti-cloud-up color-soccer-coach"></i>                                  
                    </div>
                </div>
            </div>
        </div>
    </div>  
</template>

<script>
    export default {
        props: ['image', 'idImage', 'classImage'],
        data() {
            return {
                fileName:this.image,
                srcFile:this.image !== undefined ?'../../images/uploaded/' + this.image : '',
                file:''
            }
        },
        methods: {
            readFile: function(event) {
                let files = event.target.files;
                if (files && files[0]) {             
                    let FR = new FileReader();

                    this.file = files[0];

                    this.fileName = files[0].name;
                    let idImage = this.idImage;

                    this.$emit('imageUploaded', files[0]);

                    FR.addEventListener("load", function(e) {
                        let srcFile = e.target.result;         
                        $('#img-exercice'+idImage)[0].src = srcFile;
                        $('#file-upload-preview'+idImage)[0].style.zIndex = 1;
                    });
                    FR.readAsDataURL(files[0]);
                }
            },
        },
        mounted() {
            const id = this.idImage;
            $('.file-upload'+id).hover(function(){
                $('.file-upload-infos'+id)[0].style.opacity = 1;
            }, function(){
                $('.file-upload-infos'+id)[0].style.opacity = 0;
            });

            if(this.image === undefined){
                $('#file-upload-preview'+id)[0].style.zIndex = -1;
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../public/css/image-upload';
</style>

