<template>
    <div class="detail-exercice">
        <div class="loading">
            <bounce  color="17b87d" v-show="isLoading"></bounce>
        </div>
        <div v-if="!isLoading">
            <div class="contenu-exercices">
                <div class="actions-exercice-detail">
                    <div class="btn-mes-exercices">
                        <a class="btn btn-soccer-coach-action" @click="back" v-if="route !== 'mes-favoris'"> <i class="ti-list"></i> Mes exercices</a>
                        <a class="btn btn-soccer-coach-action" @click="backFavoris" v-else> <i class="ti-list"></i> Mes Favoris</a>
                    </div>
                    <div class="btns">                
                        <a class="btn btn-soccer-coach-action" href="#" @click="download"><i class="fa fa-file-pdf-o"></i> Télecharger</a>
                        <router-link :to="{ name: 'UpdateExercice', params: { 'exercice': exerciceDetail } }" class="btn btn-soccer-coach-action"><i class="ti-pencil"></i> Modifier</router-link>
                        <a class="btn btn-soccer-coach-action" data-toggle="modal" data-target="#modalDeleteExercice"><i class="ti-trash"></i> Supprimer</a>                      
                    </div>
                </div>
                <div class="row details-exercice">
                    <div class="col-sm-6 details-exercice-image">
                        <div class="image-exercice">
                            <img class="img-responsive" :src="'../images/uploaded/'+exerciceDetail.image">
                        </div>                              
                    </div>
                    <div class="col-sm-6 details-exercice-info">
                        <div class="detail bloc-info">
                            <h3>{{ exerciceDetail.principe }}</h3>
                            <p class="description-exercice">{{ exerciceDetail.description }}</p>
                            <div class="d-flex justify-content-center details-items-info">
                                <div class="p-flex">
                                    <p class="text">DURÉE:</p>
                                    <p class="value"><i class="ti-timer color-soccer-coach"></i> {{ exerciceDetail.time }}</p>
                                </div>
                                <div class="p-flex">
                                    <p class="text">NOMBRE DE JOUEURS:</p>
                                    <p class="value">{{ exerciceDetail.nbJoueurs }}</p>
                                </div>
                                <div class="p-flex">
                                    <p class="text">TYPE:</p>
                                    <p class="value"><i :class="exerciceDetail.typeExercice.icon" class="color-soccer-coach"></i> {{ exerciceDetail.typeExercice.nom }}</p>
                                </div>
                            </div>
                        </div>     
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="variantes col-sm-6" v-if="exerciceDetail.variantes.length > 0">
                        <div class="variante" v-for="(variante, index) in exerciceDetail.variantes" :key="variante.id">
                            <div class="variante-header clearfix">
                                <h5 class="float-left"><i class="ti-pin-alt color-soccer-coach"></i> Variante #{{index + 1}}</h5>
                                <h5 class="float-right time"><i class="ti-timer color-soccer-coach"></i> {{variante.time}}</h5>
                            </div>
                            <div class="variante-body">                   
                                <p>{{variante.description}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" v-else></div>
                    <div class="col-sm-6">
                        <div class="observations-exercice bloc-sm bloc-info" v-show="exerciceDetail.observations">
                            <h5><i class="ti-eye color-soccer-coach"></i> Observations</h5>
                            <p>{{ exerciceDetail.observations }}</p>
                        </div>
                        <div class="bloc-sm bloc-info" v-show="exerciceDetail.sousPrincipe">
                            <h5><i class="ti-flag color-soccer-coach"></i> Sous-principes</h5>
                            <p>{{ exerciceDetail.sousPrincipe }}</p>
                        </div>
                        <div class="bloc-sm bloc-info" v-show="exerciceDetail.physique">
                            <h5><i class="ti-heart color-soccer-coach"></i> Objectifs physiques</h5>
                            <p>{{ exerciceDetail.physique }}</p>
                        </div>
                        <div class="video" v-if="exerciceDetail.idVideo">
                            <iframe width="560" height="315" :src="'https://www.youtube-nocookie.com/embed/'+exerciceDetail.idVideo" 
                            frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>     
                        </div>
                        <div class="url" v-else-if="exerciceDetail.url && exerciceDetail.url !== ''">
                            <i class="ti-link color-soccer-coach"></i><a :href="exerciceDetail.url" target = "_blank"> {{exerciceDetail.url}}</a>    
                        </div>    
                    </div>
                </div>  
                <div class="mt-3" v-show="exerciceDetail.objectifs.length > 0">
                    <h5><i class="ti-tag color-soccer-coach"></i> Objectifs</h5>   
                    <objectifs-by-exercice :objectifs="exerciceDetail.objectifs"/>
                </div>  
                <div class="modal" id="modalDeleteExercice">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Supprimer exercice</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                Voulez-vous supprimer l'exercice <span>{{ exerciceDetail.principe }}</span>?
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-soccer-coach-action" @click="deleteExercice()"><i class="ti-trash"></i> Supprimer</a>
                            </div>
                        </div>               
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['exercice', 'route'],
    data(){
        return{
            isLoading:true,
            exerciceDetail:this.exercice ? this.exercice: {},
        }
    },
    methods:{
        download(){
            window.location.assign('/customer/print-pdf/'+this.exercice.id);
        },
        back(){
            this.$router.push('mes-exercices');
        },
        backFavoris(){
            this.$router.push('mes-favoris');
        },
        deleteExercice(){
            axios.delete('/exercice/'+  this.exerciceDetail.id).then(reponse =>{
                $("#modalDeleteExercice").modal("hide");
                this.$router.push('mes-exercices');
            });
        }
    },
    created(){
        //vérifier s'il y a déjà un exercice dans le locale storage
        if(localStorage.getItem('exerciceLocale')){				
            this.exerciceDetail = JSON.parse(localStorage.getItem('exerciceLocale'));
            this.isLoading = false;
        }else{
            if(!this.exerciceDetail.variantes && !this.exerciceDetail.objectifs){
                this.exerciceDetail.variantes = [];
                this.exerciceDetail.objectifs = [];
                this.isLoading = true;
                axios.get('/exercice/outil/get-variantes-and-objectifs/' + this.exerciceDetail.id).then(reponse =>{
                    this.exerciceDetail.variantes = reponse.data.variantes;
                    this.exerciceDetail.objectifs = reponse.data.objectifs;    
                    this.isLoading = false;

                    //add exercice to local storage
                    const exerciceParsed = JSON.stringify(this.exerciceDetail);
                    localStorage.setItem('exerciceLocale', exerciceParsed);
                }).catch(error =>{
                    console.log(error);
                    this.isLoading = false;
                });
            }else{
                this.isLoading = false;

                //add exercice to local storage
                const exerciceParsed = JSON.stringify(this.exerciceDetail);
                localStorage.setItem('exerciceLocale', exerciceParsed);
            }
        }
    },
    mounted(){   
    },
    beforeDestroy(){
        localStorage.removeItem('exerciceLocale');
    }
}
</script>