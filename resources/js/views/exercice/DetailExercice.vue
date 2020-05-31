<template>
    <div class="detail-exercice">
        <div class="contenu-exercices">
            <div class="actions-exercice-detail">
                <div class="btn-mes-exercices">
                    <a class="btn btn-soccer-coach-action" @click="back"> <i class="ti-list"></i> Mes exercices</a>
                </div>
                <div class="btns">                
                    <a class="btn btn-soccer-coach-action" href="#"><i class="fa fa-file-pdf-o"></i> Télecharger</a>
                    <router-link :to="{ name: 'UpdateExercice', params: { exercice } }" class="btn btn-soccer-coach-action"><i class="ti-pencil"></i> Modifier</router-link>
                    <a class="btn btn-soccer-coach-action" data-toggle="modal" data-target="#modalDeleteExercice"><i class="ti-trash"></i> Supprimer</a>                      
                </div>
            </div>
            <div class="row details-exercice">
                <div class="col-sm-6 details-exercice-image">
                    <div class="image-exercice">
                        <img class="img-responsive" :src="'../images/uploaded/'+exercice.image">
                    </div>                              
                </div>
                <div class="col-sm-6 details-exercice-info">
                    <div class="detail bloc-info">
                        <h3>{{ exercice.principe }}</h3>
                        <p class="description-exercice">{{ exercice.description }}</p>
                        <div class="d-flex justify-content-center details-items-info">
                            <div class="p-flex">
                                <p class="text">DURÉE:</p>
                                <p class="value"><i class="ti-timer color-soccer-coach"></i> {{ exercice.time }}</p>
                            </div>
                            <div class="p-flex">
                                <p class="text">NOMBRE DE JOUEURS:</p>
                                <p class="value">{{ exercice.nbJoueurs }}</p>
                            </div>
                            <div class="p-flex">
                                <p class="text">TYPE:</p>
                                <p class="value"><i :class="exercice.type_exercice.icon" class="color-soccer-coach"></i> {{ exercice.type_exercice.nom }}</p>
                            </div>
                        </div>
                    </div>     
                </div>
            </div>
            <div class="row mt-3">
                <div class="variantes col-sm-6" v-if="exercice.variantes.length > 0">
                    <div class="variante" v-for="(variante, index) in exercice.variantes" :key="variante.id">
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
                    <div class="observations-exercice bloc-sm bloc-info" v-show="exercice.observations">
                        <h5><i class="ti-eye color-soccer-coach"></i> Observations</h5>
                        <p>{{ exercice.observations }}</p>
                    </div>
                    <div class="bloc-sm bloc-info" v-show="exercice.sousPrincipe">
                        <h5><i class="ti-flag color-soccer-coach"></i> Sous-principes</h5>
                        <p>{{ exercice.sousPrincipe }}</p>
                    </div>
                    <div class="bloc-sm bloc-info" v-show="exercice.physique">
                        <h5><i class="ti-heart color-soccer-coach"></i> Objectifs physiques</h5>
                        <p>{{ exercice.physique }}</p>
                    </div>
                    <div class="video" v-if="exercice.idVideo">
                        <iframe width="560" height="315" :src="'https://www.youtube-nocookie.com/embed/'+exercice.idVideo" 
                        frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>     
                    </div>
                    <div class="url" v-else-if="exercice.url && exercice.url !== ''">
                        <i class="ti-link color-soccer-coach"></i><a :href="exercice.url" target = "_blank"> {{exercice.url}}</a>    
                    </div>    
                </div>
            </div>  
            <div class="mt-3" v-show="exercice.objectifs.length > 0">
                <h5><i class="ti-tag color-soccer-coach"></i> Objectifs</h5>   
                <objectifs-by-exercice :objectifs="exercice.objectifs"/>
            </div>  
            <div class="modal" id="modalDeleteExercice">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Supprimer exercice</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            Voulez-vous supprimer l'exercice <span>{{ exercice.principe }}</span>?
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-soccer-coach-action" @click="deleteExercice()"><i class="ti-trash"></i> Supprimer</a>
                        </div>
                    </div>               
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['exercice'],
    methods:{
        back(){
            this.$router.push('mes-exercices');
        },
        deleteExercice(){
            axios.delete('/exercice/'+  this.exercice.id).then(reponse =>{
                $("#modalDeleteExercice").modal("hide");
                this.$router.push('mes-exercices');
            });
        }
    },
    mounted(){
        console.log(this.exercice);
    }
}
</script>