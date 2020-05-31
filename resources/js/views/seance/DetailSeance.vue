<template>
    <div class="detail-seance">
        <div class="contenu-seance">
            <div class="actions-seance-detail">
                <div class="btn-mes-seances">
                    <a class="btn btn-soccer-coach-action" @click="back"> <i class="fa fa-futbol-o"></i> Mes séances</a>
                </div>
                <div class="btns">                
                    <a class="btn btn-soccer-coach-action" href="#"><i class="fa fa-file-pdf-o"></i> Télecharger</a>
                    <router-link :to="{ name: 'UpdateSeance', params: { seance } }" class="btn btn-soccer-coach-action"><i class="ti-pencil"></i> Modifier</router-link>
                    <a class="btn btn-soccer-coach-action" data-toggle="modal" data-target="#modalDeleteSeance"><i class="ti-trash"></i> Supprimer</a>                      
                </div>
            </div>
        </div>
        <div class="details-seance">  
            <span class="date-creation">{{ seance.created_at | moment('YYYY/MM/DD') }}</span><br>
            <div class="infos-seance">
                <h4>{{seance.theme}}</h4>
                <span class="titre"><i class="ti-timer color-soccer-coach"></i> {{seance.temps}}</span>  
                <span class="separateur">|</span>
                <span class="titre"> Effectif:</span>
                <span>{{seance.effectif}}</span> 
                <div class="info" v-show="seance.endroit && seance.endroit !== ''"><i class="ti-map-alt color-soccer-coach"></i> <span class="titre">Endroit:</span> {{seance.endroit}}</div>
                <div class="info" v-show="seance.time && seance.time !== ''"><i class="fa fa-calendar-o color-soccer-coach"></i> <span class="titre">Date:</span> {{seance.time}}</div>
                <p class="info" v-show="seance.context && seance.context !== ''"><i class="ti-direction color-soccer-coach"></i> <span class="titre">Context:</span> {{seance.context}}</p>
                <span class="bought" v-show="seance.categorie !== 'None'">
                    <i :class="getIconByCategorie(seance.categorie)"></i>
                    {{seance.categorie}}
                </span>
            </div> 
            <h5><i class="ti-star color-soccer-coach"></i> Exercices</h5>
            <div class="lst-exercices">
                <div class="item-exercice" v-for="(exercice, index) in seance.exercices" :key="index">
                    <div class="row" v-if="exercice.isMatch === 0">
                        <div class="col-sm-8 details-exe">
                            <div class="principe-titre">
                                <h6>Exercice #{{index+1}} - {{exercice.principe}}</h6>
                            </div>
                            <div class="items-modifiables">
                                <div class="form-group">
                                    <span class="titre"><i class="ti-timer color-soccer-coach"></i> {{exercice.time}}</span>
                                </div>
                                <span class="separateur">|</span>
                                <div class="form-group">
                                    <span class="titre"> Nombre de joueurs:</span>
                                    <span>{{exercice.nbJoueurs}}</span>
                                </div>
                                <span class="separateur">|</span>
                                <div class="form-group">
                                    <span class="titre"> Type:</span>
                                    <span v-if="exercice.typeExerciceNom">{{exercice.typeExerciceNom}}</span>
                                    <span v-else-if="exercice.type_exercice">{{exercice.type_exercice.nom}}</span>
                                </div>
                            </div>
                            <p>{{exercice.description}}</p>                            
                            <div class="form-group" v-show="exercice.observations && exercice.observations !== ''">
                                <span class="titre">Observations: </span>
                                <span>{{exercice.observations}}</span>
                            </div>
                        </div>
                        <div class="col-sm-4 image-exe">
                            <img :src="'../../../images/uploaded/' + exercice.image" :alt="exercice.image"/>
                        </div>
                    </div>
                    <div class="exercice-match" v-else>                           
                        <div class="details-exe">
                            <div class="principe-titre">                              
                                <h6>Match</h6>
                            </div>
                            <div class="items-modifiables">
                                <div class="form-group">
                                    <span class="titre"><i class="ti-timer color-soccer-coach"></i> {{exercice.time}}</span>
                                </div>
                                <span class="separateur">|</span>
                                <div class="form-group">
                                    <span class="titre"> Nombre de joueurs:</span>
                                    <span>{{exercice.nbJoueurs}}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <span>{{exercice.description}}</span>
                            </div>
                            <div class="form-group" v-show="exercice.observations && exercice.observations !== ''">
                                <span class="titre">Observations: </span>
                                <span>{{exercice.observations}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="variantes" v-if="exercice.variantes && exercice.variantes.length !== 0">
                        <div class="item-variante" v-for="(variante, index) in exercice.variantes" :key="index"> 
                            <div class="variante-titre">                              
                                <h6>Variante #{{index+1}}</h6>
                            </div>
                            <div class="items-modifiables">
                                <div class="form-group">
                                    <span class="titre"><i class="ti-timer color-soccer-coach"></i> {{variante.time}}</span>
                                </div>
                            </div>
                            <p>
                                {{variante.description}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="modalDeleteSeance">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Supprimer séance</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous supprimer la séance?
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-soccer-coach-action" @click="deleteSeance()"><i class="ti-trash"></i> Supprimer</a>
                    </div>
                </div>               
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
export default {
    props:['seance'],
    data(){
        return{
        }
    },
    computed:{
        ...mapGetters(['getIconByCategorie']),
    },
    methods:{
        back(){
            this.$router.push('mes-seances');
        },
        deleteSeance(){
            axios.delete('/seance/'+  this.seance.id).then(reponse =>{
                $("#modalDeleteSeance").modal("hide");
                this.$router.push('mes-seances');
            });
        }
    },
    mounted(){
        console.log('détails seance:');
        console.log(this.seance);
    }
}
</script>
<style lang="scss" scoped>
        @import '../../../../public/css/pratiques/detail-pratique';
</style>