<template>
    <div class="add-activite modal-btn seances-modal">
        <button class="btn btn-soccer-coach-action-list"  data-toggle="modal" :data-target="'#modalAddSeance' + activite.id" @click="getSenacesByUser()"><i class="fa fa-futbol-o"></i></button>
        <div :id="'modalAddSeance' + activite.id" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter une séance</h4>
                        <button type="button" class= "close btn-close" :id="'closemodalAddSeance' + activite.id" @click="closeModal()">&times;</button>              
                    </div>
                    <div class="modal-body">   
                        <bounce color="17b87d" v-show="isLoading"></bounce> 
                        <div class="row">
                            <div class="col-sm-4 image-exericie" v-for="(seance, index) in displayedSeances" :key="index">
                                <div class="exe-select">
                                    <div class="infos-exercice">
                                        <div class="principe">
                                            <h5 class="card-title">{{seance.theme}}</h5>
                                        </div>
                                        <h6 v-if="seance.temps"><i class="ti-timer color-soccer-coach"></i> {{seance.temps}}</h6>   
                                    </div>
                                    <span class="date-creation">{{ seance.created_at | moment('YYYY/MM/DD') }}</span>
                                </div>
                                <div :class="'file-upload-infos-modal file-upload-infos-modal'+index" @mouseover="showInfos(index)" @mouseout="hideInfos(index)"
                                    @click="selectSeance(seance)">
                                    <div class="file-upload-infos-inner">                             
                                        <p class="file-upload-infos-message"> Cliquer pour choisir la seance</p>                               
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
import { mapState, mapMutations, mapActions } from 'vuex'
export default {
    props:['activite', 'indexAct'],
    data(){
        return{
            lstSeances:[],
            page: 1,
            perPage: 9,
            pages: [],
            isLoading:true,
        }
    },
    computed:{
        displayedSeances () {
            return this.paginate(this.lstMesSeances);
        },
        ...mapState(['lstMesSeances'])                     
    },
    watch: {
        lstMesSeances () {
            this.setPages();
        }
    },
    filters: {
        trimWords(value){
            return value.split(" ").splice(0,20).join(" ") + '...';
        }
    },
    methods:{
        getSenacesByUser(){
            if(this.lstMesSeances.length === 0){
                this.isLoading = true;
                axios.get('/user/get-seances-by-user').then(reponse =>{
                    this.setMesSeancesList(reponse.data.seances);
                    this.isLoading = false;             
                }).catch(error =>{
                    console.log(error);
                    this.isLoading = false;    
                }); 
            }else{
                this.isLoading = false;  
            }        
        },
        selectSeance(seance){
            //ajouter la séance à la pratique
            let param = {
                idSeance : seance.id,
                idActivite : this.activite.id
            };
            axios.post('/seance/add-seance-to-activite', param).then(response =>{
                this.deletePratique(this.indexAct);
                this.activite.seance_id = seance.id;
                this.activite.theme = seance.theme;
                this.activite.seance = seance;
                this.addPratiqueToList(this.activite);
                this.$root.$emit('setPratiqueLocalStorage'); 
            });

            //ferme la modale
            this.closeModal();
        },
        showInfos(index){     
            $('.file-upload-infos-modal'+index)[0].style.opacity = 1;       
        },
        hideInfos(index){
            $('.file-upload-infos-modal'+index)[0].style.opacity = 0;  
        },
        closeModal(){
            $("#modalAddSeance" + this.activite.id).modal("hide");
        },
        initPages(){
            this.page = 1;
            this.perPage = 9;
            this.pages = [];
        },
        setPages () {
            let numberOfPages = Math.ceil(this.lstMesSeances.length / this.perPage);
            if(numberOfPages > 1){
                for (let index = 1; index <= numberOfPages; index++) {
                    this.pages.push(index);
                }
            }
        },
        paginate (seance) {
            let page = this.page;
            let perPage = this.perPage;
            let from = (page * perPage) - perPage;
            let to = (page * perPage);
            return  seance.slice(from, to);
        },
        ...mapMutations(['setMesSeancesList', 'addPratiqueToList', 'deletePratique']),
    },
    created(){

    },
    mounted(){
        this.setPages();
    }
}
</script>
<style lang="scss" scoped>
    @import '../../../../../public/css/forms';
    @import '../../../../../public/css/modals/addActivite';
    @import '../../../../../public/css/modals/seancesModal';
</style>
