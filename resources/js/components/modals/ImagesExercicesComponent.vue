<template>
    <div class="images-modal">
        <button type="button" class="btn btn-soccer-coach-action" data-toggle="modal" data-target="#myModal" @click="getImagesExercices()" v-show="!isModal">Choisir dans mes images</button>
        <a class="btn btn-soccer-coach-action create-exe-designer"  href="/create-exercice" target = "_blank">SoccerCoach S3 Designer</a>
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Mes images</h4>
                        <button type="button" class= "close btn-close" id="closeModalImg" @click="closeModal()">&times;</button>              
                    </div>
                    <div class="modal-body">
                        <p>Vous pouvez choisir une image que vous avez déjà enregistré!</p>
                        <div class="row">
                            <bounce  color="17b87d" v-show="isLoading"></bounce>
                            <div class="col-sm-4 image-exericie" v-for="(image, index) in displayedImages" :key="index">
                                <div class="img-select">
                                    <img :id="'img-exercice-modal'+index" :src="'../../../images/uploaded/'+image" :alt="image"/>
                                </div>
                                <div :class="'file-upload-infos-modal file-upload-infos-modal'+index" @mouseover="showInfos(index)" @mouseout="hideInfos(index)"
                                    @click="selectImg(image)">
                                    <div class="file-upload-infos-inner">
                                        <p class="file-upload-filename">
                                            <span class="file-upload-filename-inner">{{ image }}</span>
                                        </p>                              
                                        <p class="file-upload-infos-message"> Cliquer pour choisir l'image</p>                               
                                    </div>
                                </div>
                            </div>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item">
                                    <button type="button" class="page-link" v-if="page != 1" @click="page--"><i class="ti-angle-double-left"></i></button>
                                </li>
                                <li class="page-item">
                                    <button type="button" class="page-link" v-for="pageNumber in pages.slice(page-1, page+5)" :key="pageNumber" @click="page = pageNumber"> {{pageNumber}} </button>
                                </li>
                                <li class="page-item">
                                    <button type="button" @click="page++" v-if="page < pages.length" class="page-link"><i class="ti-angle-double-right"></i></button>
                                </li>
                            </ul>
                        </nav>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'
    
    export default {
        props: ['isModal'],
        data() {
            return {
                lstImages: [],
                page: 1,
                perPage: 9,
                pages: [],
                isLoading:true
            }
        },       
        computed:{
            displayedImages () {
                return this.paginate(this.lstImages);
            },
            ...mapState(['imgSelect'])                     
        },
        watch: {
            lstImages () {
                this.setPages();
            }
        },
        filters: {
            trimWords(value){
                return value.split(" ").splice(0,20).join(" ") + '...';
            }
        },
        methods: {
            closeModal(){
                $("#myModal").modal("hide")
            },
            getImagesExercices(){
                if(this.lstImages.length === 0){
                    this.isLoading = true;
                    axios.get('/exercice/images').then(reponse =>{
                        reponse.data.images.forEach(img => {
                            this.lstImages.push(img.image);
                            this.isLoading = false;
                        });                
                    }).catch(error =>{
                        console.log(error);
                    }); 
                }          
            },
            selectImg(img){
                this.$root.$emit('imgSelected', img); 
                document.getElementById('closeModalImg').click();
            },
            showInfos(index){     
                $('.file-upload-infos-modal'+index)[0].style.opacity = 1;       
            },
            hideInfos(index){
                $('.file-upload-infos-modal'+index)[0].style.opacity = 0;  
            },
            initPages(){
                this.page = 1;
                this.perPage = 9;
                this.pages = [];
            },
            setPages () {
                let numberOfPages = Math.ceil(this.lstImages.length / this.perPage);
                if(numberOfPages > 1){
                    for (let index = 1; index <= numberOfPages; index++) {
                        this.pages.push(index);
                    }
                }
            },
            paginate (images) {
                let page = this.page;
                let perPage = this.perPage;
                let from = (page * perPage) - perPage;
                let to = (page * perPage);
                return  images.slice(from, to);
            },
            ...mapMutations(['setImgSelect'])
        },
        
        mounted() {
            this.setPages();
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../public/css/modals/imagesModal';
</style>

