<template>
    <div class="mes-favoris">
        <div class="loading">
            <bounce  color="17b87d" v-show="isLoading"></bounce>
        </div>
        <div v-if="!isLoading">
            <div class="actions">
                <h5>Filtrer par type</h5>
                <div class="btn-group">              
                    <button type="button" class="btn btn-g btn-soccer-coach-action" id="btn-tous" :class="{'btn-g-selected' : lastTypeSelected === 'btn-tous'}" @click="filtrerParType(null)">
                        <i class="ti-star"></i> Tous
                    </button>
                    <button type="button" class="btn btn-g btn-soccer-coach-action" :class="{'btn-g-selected' : lastTypeSelected === type.id}" @click="filtrerParType(type.id)" v-for="type in lstAllTypes" :key="type.id" :id="'type-'+type.id">
                        <i :class="type.icon"></i> {{type.nom}}
                    </button>
                    <button type="button" class="btn btn-g btn-soccer-coach-action" :class="{'btn-g-selected' : lastTypeSelected === 'btn-private'}" @click="filtrerParPrivate()">
                        <i class="ti-key"></i> Privées
                    </button>
                </div>
                <div class="mt-3">
                        <filter-by-objectif :objectifs="lstAllObjectifs"
                        :set-filter="true" :show-btn-filter="true" class-custom="filter-action"
                        :on-method-filter="filtrerParObjectifs"/>
                </div>
            </div>
            <h3>MES FAVORIS</h3>
            <h6>Nombre d'exercices: {{lstExercices.length}}</h6>
            <div class="row lst-exercices" :class="{'lst-vide' : lstExercices.length === 0}">
                <span class="aucun-exercice" v-if="lstExercices.length === 0">Aucun exercice</span>
                <div class="col-md-4 card card-exercice" v-for="(exercice, index) in displayedExercices" :key="exercice.id">
                    <div class="card-exercice-image">
                        <img class="card-img-top img-liste" :src="'../../images/uploaded/' + exercice.image">               
                        <span class="bought"><i :class="exercice.typeExercice.icon"></i> {{exercice.typeExercice.nom}}</span>                    
                        <a class="btn-delete-favoris" @click="deleteExerciceFavoris(exercice.id, index)" alt="Enlever cet exercice des favoris"><i class="fa fa-heart"></i></a>           
                    </div>
                    <div class="card-body body-exercice">      
                        <div class="card-title-principe">
                            <h4 class="card-title">{{exercice.principe}}</h4>
                            <h6><i class="ti-timer color-soccer-coach"></i> {{exercice.time}}</h6>                     
                        </div>
                        <p>{{exercice.description}}</p>
                    </div>
                    <div class="card-footer footer-exercice">
                        <router-link :to="{ name: 'DetailExercice', params: { exercice, route:'mes-favoris' } }" class="btn btn-block btn-soccer-coach">Voir</router-link>
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
    import {mapState, mapActions} from 'vuex'
    export default {
        data(){
            return{
                typeSelected:'tous',
                lstExercices:[],
                page: 1,
                perPage: 9,
                pages: [],
                lastTypeSelected: 'btn-tous',
                lstObjectifsSelected:[],
                exercicesByUser:[],
                isLoading:true
            }
        },
        methods:{
            deleteExerciceFavoris(id, index){
                axios.delete('/favoris/delete-exercice/' + id).then(response =>{
                    this.lstExercices.splice(index, 1);
                });
            },
            filtrerParType(type){
                if(type){
                    this.lastTypeSelected = type;
                    let lstExercicesByType = [];
                    this.exercicesByUser.forEach(exe => {
                        if(exe.typesexcercice_id === type){
                            lstExercicesByType.push(exe);
                        }
                    });
                    this.initPages();
                    this.lstExercices = lstExercicesByType; 
                }else{
                    this.lastTypeSelected = 'btn-tous';
                    this.lstExercices =  this.exercicesByUser;
                }   
                this.$root.$emit('filtredByType');
            },
            filtrerParPrivate(){
                let lstExercicesPrivates = []; 
                this.lastTypeSelected = 'btn-private';
                this.exercicesByUser.forEach(exe => {
                    if(exe.private === 1){
                        lstExercicesPrivates.push(exe);
                    }
                });
                this.initPages();
                this.lstExercices = lstExercicesPrivates; 
                this.$root.$emit('filtredByType'); 
            },
            filtrerParObjectifs(objectif){
                let lstExercicesByObjectif = []; 


                //vérifier si l'objectif est déjà dans la liste, si c'est le cas il faut le supprimer, l'ajouter sinon
                if(this.lstObjectifsSelected.includes(objectif)){
                    let index = this.lstObjectifsSelected.indexOf(objectif);
                    this.lstObjectifsSelected.splice(index, 1);
                }else{
                    this.lstObjectifsSelected.push(objectif);
                }

                //il faut filtrer la liste d'exercices seuelement s'il y a des objestifs sélectionnés
                if(this.lstObjectifsSelected.length > 0){ 
                    let lstExercicesFiltred = this.getLstExercicesFiltredByType();                       
                    lstExercicesFiltred.forEach(exe => {
                        exe.objectifs.forEach(obj => {
                            if(this.lstObjectifsSelected.includes(obj.id)){
                                let isExeAdded = lstExercicesByObjectif.find(exercice => exercice.id === exe.id);
                                if(!isExeAdded){
                                    lstExercicesByObjectif.push(exe)
                                }                          
                            }
                        });
                    });

                    this.initPages();               
                    this.lstExercices = lstExercicesByObjectif; 
                }else{
                    if(this.lastTypeSelected === 'btn-private'){
                        this.filtrerParPrivate();
                    }else if(this.lastTypeSelected === 'btn-tous'){
                        this.filtrerParType(null);
                    }else{
                        this.filtrerParType(this.lastTypeSelected);
                    }
                }
            },
            getLstExercicesFiltredByType(){
                let retval = [];
                if(this.lastTypeSelected === 'btn-private'){
                    retval = this.exercicesByUser.filter(e => e.private === 1);       
                }else if(this.lastTypeSelected === 'btn-tous'){
                    retval = this.exercicesByUser;
                }else{
                    retval = this.exercicesByUser.filter(e => e.typesexcercice_id === this.lastTypeSelected);  
                }
                return retval;
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
            paginate (exercices) {
                let page = this.page;
                let perPage = this.perPage;
                let from = (page * perPage) - perPage;
                let to = (page * perPage);
                return  exercices.slice(from, to);
            },
            ...mapActions(['loadAllObjectifs', 'loadAllTypes'])
        },
        computed: {
            displayedExercices () {
                return this.paginate(this.lstExercices);
            },
            ...mapState(['lstAllTypes', 'lstAllObjectifs']),
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
        mounted(){
            this.isLoading = true;
            //récupérer la liste de favoris
            axios.get('/favoris/get-favoris-by-user').then(reponse =>{
                this.exercicesByUser = reponse.data.favoris;
                this.lstExercices = reponse.data.favoris;
                this.isLoading = false;
            }).catch(error =>{
                console.log(error);
                this.isLoading = false;
            });

            //load le type d'exercice et les objectifs
            this.loadAllTypes();
            this.loadAllObjectifs();
        }
    }
</script>
<style lang="scss" scoped>
</style>