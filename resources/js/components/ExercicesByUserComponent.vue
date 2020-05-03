<template>
    <div class="exercices-by-user">
        <div class="actions">
            <div class="btn-group">
                <button type="button" class="btn btn-g btn-soccer-coach-action" id="btn-tous" :class="{'btn-g-selected' : lastTypeSelected === 'btn-tous'}" @click="filtrerParType(null)">
                    <i class="ti-star"></i> Tous
                </button>
                <button type="button" class="btn btn-g btn-soccer-coach-action" :class="{'btn-g-selected' : lastTypeSelected === type.id}" @click="filtrerParType(type.id)" v-for="type in types" :key="type.id" :id="'type-'+type.id">
                    <i :class="type.icon"></i> {{type.nom}}
                </button>
                <button type="button" class="btn btn-g btn-soccer-coach-action" :class="{'btn-g-selected' : lastTypeSelected === 'btn-private'}" @click="filtrerParPrivate()">
                    <i class="ti-key"></i> Privées
                </button>
            </div>
            <div class="btn-create-exercice">
                <a class="btn btn-soccer-coach-action" href="/exercice/create">
                    <i class="ti-plus"></i> Créer un exercice
                </a>
            </div>
        </div>
        <h3>MES EXERCICES</h3>
        <h6>Nombre d'exercices: {{lstExercices.length}}</h6>
        <div class="row lst-exercices" :class="{'lst-vide' : lstExercices.length === 0}">
            <span class="aucun-exercice" v-if="lstExercices.length === 0">Aucun exercice</span>
            <div class="col-md-4 card card-exercice" v-for="exercice in displayedExercices" :key="exercice.id">
                <div class="card-exercice-image">
                    <img class="card-img-top img-liste" :src="'../../images/uploaded/' + exercice.image">               
                    <span class="bought"><i :class="exercice.type_exercice.icon"></i> {{exercice.type_exercice.nom}}</span>                    
                    <span class="bought-private" v-if="exercice.private === 1"><i class="ti-key"></i></span>                      
                </div>
                <div class="card-body body-exercice">      
                    <div class="card-title-principe">
                        <h4 class="card-title">{{exercice.principe}}</h4>
                        <h6><i class="ti-timer color-soccer-coach"></i> {{exercice.time}}</h6>                     
                    </div>
                    <span class="date-creation">{{ exercice.created_at | moment('YYYY/MM/DD') }}</span>
                    <p>{{exercice.description}}</p>
                </div>
                <div class="card-footer footer-exercice">
                    <a :href="'/exercice/'+exercice.id" class="btn btn-block btn-soccer-coach">Voir</a>
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
</template>

<script>
    export default {
        props:['exercices', 'types'],
        data(){
            return{
                typeSelected:'tous',
                lstExercices:this.exercices,
                lastTypeSelected: 'btn-tous',
                page: 1,
                perPage: 9,
                pages: []
            }
        },
        methods:{
            filtrerParType(type){
                if(type){
                    this.lastTypeSelected = type;
                    let lstExercicesByType = [];
                    this.exercices.forEach(exe => {
                        if(exe.typesexcercice_id === type){
                            lstExercicesByType.push(exe);
                        }
                    });
                    this.initPages();
                    this.lstExercices = lstExercicesByType; 
                }else{
                    this.lastTypeSelected = 'btn-tous';
                    this.lstExercices =  this.exercices;
                }       
            },
            filtrerParPrivate(){
                let lstExercicesPrivates = []; 
                this.lastTypeSelected = 'btn-private';
                this.exercices.forEach(exe => {
                    if(exe.private === 1){
                        lstExercicesPrivates.push(exe);
                    }
                });
                this.initPages();
                this.lstExercices = lstExercicesPrivates;  
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
            }
        },
        computed: {
            displayedExercices () {
                return this.paginate(this.lstExercices);
            }
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
        mounted() {
            console.log(this.exercices);
            this.setPages();
            /*let mapTypes = new Map(this.lstIconsByType);
            axios.get('/exercices/get-exercices-by-user').then(reponse =>{
                console.log(reponse);
          
            }).catch(error =>{
                console.log(error);
            });*/

            //this.exercices.typesexcercice_id
        }
    }
</script>
