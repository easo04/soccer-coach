<template>
    <div class="pratiques-by-user">
        <div class="loading">
            <bounce  color="#17b87d" v-show="isLoading"></bounce>
        </div>
        <div v-if="!isLoading">
            <div class="actions">
                <h5>Filtrer par type</h5>
                <div class="btn-group">              
                    <button type="button" class="btn btn-g btn-soccer-coach-action" id="btn-tous" :class="{'btn-g-selected' : lastTypeSelected === 'btn-tous'}" @click="filtrerParType(null)">
                        <i class="ti-star"></i> Tous
                    </button>
                    <button type="button" class="btn btn-g btn-soccer-coach-action" :class="{'btn-g-selected' : lastTypeSelected === type}" @click="filtrerParType(type.name)" v-for="(type, index) in lstIconsByCategorie" :key="index" :id="'type-'+type.id">
                        <i :class="type.icon"></i> {{type.name}}
                    </button>
                </div>
                <div class="btn-create-exercice">
                    <router-link :to="{ name: 'CreateSeance'}" class="btn btn-soccer-coach-action"><i class="ti-plus"></i> Créer une séance</router-link>
                </div>
            </div>
            <h3>MES SÉANCES</h3>
            <h6>Nombre de séances: {{lstSeances.length}}</h6>
            <div class="row lst-exercices" :class="{'lst-vide' : lstSeances.length === 0}">
                <span class="aucun-exercice" v-if="lstSeances.length === 0">Aucune séance</span>
                <div class="col-md-4 card card-seance" v-for="seance in displayedSeances" :key="seance.id">                   
                    <div class="card-body card-body-seance">      
                        <div class="card-title-theme">
                            <h4 class="card-title">{{seance.theme}}</h4>
                            <span><i class="ti-timer color-soccer-coach"></i> {{seance.temps}}</span>  
                            <span class="separateur">|</span>
                            <span class="titre"> Effectif:</span>
                            <span>{{seance.effectif}}</span> 
                        </div>
                        <div class="categorie" v-if="seance.categorie !== 'None'">
                            <i :class="getIconByCategorie(seance.categorie)"></i>
                            {{seance.categorie}}
                        </div>
                        <span class="date-creation"> Créé le {{ seance.created_at | moment('YYYY-MM-DD') }}</span>                
                    </div>
                    <div class="card-footer footer-seance">
                        <router-link :to="{ name: 'DetailSeance', params: { seance } }" class="btn btn-block btn-soccer-coach">Voir</router-link>
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
</template>

<script>
    import { mapGetters, mapState } from 'vuex';  
    export default {
        props:['pratiques'],
        data(){
            return{
                lstSeances : this.pratiques ? this.pratiques : [],
                page: 1,
                perPage: 9,
                pages: [],      
                isLoading:true,
                lastTypeSelected:'btn-tous',
                seancesByUser:[],
            }
        },
        methods:{
            filtrerParType(type){
                if(type){
                    this.lastTypeSelected = type;
                    let lstSeancesByType = [];
                    this.seancesByUser.forEach(seance => {
                        if(seance.categorie === type){
                            lstSeancesByType.push(seance);
                        }
                    });
                    this.initPages();
                    this.lstSeances = lstSeancesByType; 
                }else{
                    this.lastTypeSelected = 'btn-tous';
                    this.lstSeances =  this.seancesByUser;
                }   
            },
            initPages(){
                this.page = 1;
                this.perPage = 9;
                this.pages = [];
            },
            setPages () {
                let numberOfPages = Math.ceil(this.lstSeances.length / this.perPage);
                if(numberOfPages > 1){
                    for (let index = 1; index <= numberOfPages; index++) {
                        this.pages.push(index);
                    }
                }
            },
            paginate (seances) {
                let page = this.page;
                let perPage = this.perPage;
                let from = (page * perPage) - perPage;
                let to = (page * perPage);
                return  seances.slice(from, to);
            }
        },
        computed: {
            displayedSeances () {
                return this.paginate(this.lstSeances);
            },
            ...mapGetters(['getIconByCategorie']),
            ...mapState(['lstIconsByCategorie']),
        },
        watch: {
            lstSeances () {
                this.setPages();
            }
        },
        filters: {
            trimWords(value){
                return value.split(" ").splice(0,20).join(" ") + '...';
            }
        },
        created() {
            if(!this.pratiques){
                this.isLoading = true;
                let mapTypes = new Map(this.lstIconsByType);
                axios.get('/user/get-seances-by-user').then(reponse =>{
                    console.log(reponse);
                    this.seancesByUser = reponse.data.seances;
                    this.lstSeances = reponse.data.seances;
                    this.isLoading = false;
                }).catch(error =>{
                    console.log(error);
                    this.isLoading = false;
                });
            }
            console.log(this.lstSeances);
            this.setPages();
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../public/css/pratiques/pratique-by-user';
</style>         