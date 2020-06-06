<template>
    <div class="exercices-modal">
        <button type="button" class="btn btn-soccer-coach-action btn-sauvegarder" data-toggle="modal" data-target="#myModalMesExercices"
            @click="getExercicesByUser()"><i class="ti-list"></i> Mes exercices</button>
        <div id="myModalMesExercices" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Mes exercices</h4>
                        <button type="button" class= "close btn-close" id="closeModalMesExercices" data-dismiss="modal">&times;</button>              
                    </div>
                    <div class="modal-body">
                        <bounce  color="17b87d" v-show="isLoading"></bounce>
                        <div class="row">
                            <div class="col-sm-4 image-exericie" v-for="(exercice, index) in displayedExercices" :key="index">
                                <div class="exe-select">
                                    <div class="exe-img">
                                        <img :id="'img-exercice-modal'+index" :src="'../../../images/uploaded/'+exercice.image" :alt="exercice.image"/>
                                        <span class="bought">{{exercice.typeExercice.nom}}</span>                
                                    </div>
                                    <div class="infos-exercice">
                                        <div class="principe">
                                            <h5 class="card-title">{{exercice.principe}}</h5>
                                        </div>
                                        <h6><i class="ti-timer color-soccer-coach"></i> {{exercice.time}}</h6>   
                                    </div>
                                    <span class="date-creation">{{ exercice.created_at | moment('YYYY/MM/DD') }}</span>
                                </div>
                                <div :class="'file-upload-infos-modal file-upload-infos-modal'+index" @mouseover="showInfos(index)" @mouseout="hideInfos(index)"
                                    @click="selectExe(exercice)">
                                    <div class="file-upload-infos-inner">
                                        <p class="file-upload-filename">
                                            <span class="file-upload-filename-inner">{{ exercice.description }}</span>
                                        </p>                              
                                        <p class="file-upload-infos-message"> Cliquer pour choisir l'exercice</p>                               
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
        props: [],
        data() {
            return {
                lstExercices: [],
                page: 1,
                perPage: 9,
                pages: [],
                isLoading:true
            }
        },       
        computed:{
            displayedExercices () {
                return this.paginate(this.lstExercices);
            },
            ...mapState(['exerciceStore'])                     
        },
        watch: {
            lstExercices () {
                this.setPages();
            }
        },
        filters: {
            trimWords(value){
                return value.split(" ").splice(0,20).join(" ") + '...';
            }
        },
        methods: {
            getExercicesByUser(){
                if(this.lstExercices.length === 0){
                    this.isLoading = true;
                    axios.get('/exercice/get-exercices-by-user').then(reponse =>{
                        reponse.data.exercices.forEach(exe => {
                            this.lstExercices.push(exe);
                        });   
                        this.isLoading = false;             
                    }).catch(error =>{
                        console.log(error);
                        this.isLoading = false;    
                    }); 
                }          
            },
            selectExe(exe){
                this.addExercice(exe);
                document.getElementById('closeModalMesExercices').click();
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
                let numberOfPages = Math.ceil(this.lstExercices.length / this.perPage);
                if(numberOfPages > 1){
                    for (let index = 1; index <= numberOfPages; index++) {
                        this.pages.push(index);
                    }
                }
            },
            paginate (exercice) {
                let page = this.page;
                let perPage = this.perPage;
                let from = (page * perPage) - perPage;
                let to = (page * perPage);
                return  exercice.slice(from, to);
            },
            ...mapMutations(['setExercice', 'addExercice'])
        },
        
        mounted() {
            this.setPages();
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../public/css/modals/exerciceModal';
</style>

