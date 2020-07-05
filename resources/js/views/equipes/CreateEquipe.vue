<template>
    <div class="create-equipe">
        <form class="form-horizontal panel" @submit.prevent="addEquipe(equipeDTO)">
            <div class="actions-exercice-detail">
                <div class="btns">
                    <a class="btn btn-soccer-coach-action" @click="annuler"><i class="ti-close"></i> Annuler</a>
                </div>
                <span class="msg-required">* indique que le champ est obligatoire</span>
            </div>
            
            <div class="details-equipe">        
                <div class="details-equipe-info">
                    <div class="form-group">
                        <label for="nomEquipe"><span v-if="equipeDTO.nom.validations.require"> * </span> Nom:</label>
                        <input-text placeholder="Ex: Stars U15" v-model="equipeDTO.nom.value" name="nomEquipe"
                                :model="equipeDTO.nom" @validation="equipeDTO.nom.validate = $event"/>
                    </div>
                    <div class="show-saison">
                        <a @click="showSaisonAction()">Ajouter saison <span v-if="!showSaison">+</span><span v-else>-</span></a>
                    </div> 
                    <div class="saison" v-if="showSaison">
                        <div class="form-group">
                            <label for="nomSaison"> Nom:</label>
                            <div class="nom-saison">
                                <input-text placeholder="Ex: Saison hiver" v-model="equipeDTO.saison.nom.value" name="nomSaison"
                                    :model="equipeDTO.nom" @validation="equipeDTO.saison.nom.validate = $event"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dateDebut"> Début:</label>
                            <VueCtkDateTimePicker v-model="equipeDTO.saison.dateDebut.value" locale="fr" format="YYYY-MM-DD" formatted="ll"
                                color="#03aca4" label="Sélectionner une date de début" button-color="#03aca4"
                                button-now-translation="Aujourd'hui" :right="true" :auto-close="true" :only-date="true" id="dateDebut"/>
                        </div>
                        <div class="form-group">
                            <label for="dateFin"> Fin:</label>
                            <VueCtkDateTimePicker v-model="equipeDTO.saison.dateFin.value" locale="fr" format="YYYY-MM-DD" formatted="ll"
                                color="#03aca4" label="Sélectionner une date de fin" button-color="#03aca4"
                                button-now-translation="Aujourd'hui" :right="true" :auto-close="true" :only-date="true" id="dateFin"/>
                        </div>
                    </div> 
                    <div class="entraineurs">
                        <label for="entraineurs"><i class="fa fa-users color-soccer-coach"></i> Entraîneurs</label>
                        <br><span class="error" v-if="error.isError">{{error.message}}</span>  
                        <div class="btn-action-joueurs">
                            <div class="btns">
                                <create-entraineur-modal />
                            </div>
                        </div>
                        <div class="lst-entraineurs" :class="{'lst-vide':lstEntraineurs.length === 0}">
                            <div class="aucun-exercice" v-if="lstEntraineurs.length === 0">Aucun entraîneur</div>
                            <div class="joueur-item" v-for="(entraineur, index) in lstEntraineurs" :key="index">
                                <div class="nom d-joueur">
                                    <span>{{entraineur.nom}}</span>
                                </div> 
                                <div class="positions d-joueur">
                                    <span class="position">{{entraineur.role}}</span>
                                </div> 
                                <div class="d-joueur">
                                    <div class="btn-actions-joueur ">
                                        <button class="btn btn-soccer-coach-action-list" @click="deleteEntraineur(index)"><i class="ti-trash"></i></button>
                                    </div>    
                                </div> 
                            </div>
                        </div>
                    </div> 
                    <div class="joueurs">
                        <label for="joueurs"><i class="fa fa-users color-soccer-coach"></i> Joueurs</label>
                        <br><span class="error" v-if="error.isError">{{error.message}}</span>  
                        <div class="btn-action-joueurs">
                            <div class="btns">
                                <create-joueur-modal />
                            </div>
                        </div>
                        <div class="lst-joueurs" :class="{'lst-vide':lstJoueurs.length === 0}">
                            <div class="aucun-exercice" v-if="lstJoueurs.length === 0">Aucun joueur</div>
                            <div class="joueur-item" v-for="(joueur, index) in lstJoueurs" :key="index">
                                <div class="nom d-joueur">
                                    <span>{{joueur.nom}}</span>
                                </div> 
                                <div class="positions d-joueur">
                                    <span class="position">{{joueur.position1}}</span>
                                    <span class="position" v-if="joueur.position2">/ {{joueur.position2}}</span>
                                    <span class="position" v-if="joueur.position3">/ {{joueur.position3}}</span>
                                </div> 
                                <div class="d-joueur">
                                    <div class="btn-actions-joueur ">
                                        <button class="btn btn-soccer-coach-action-list" @click="deleteJoueur(index)"><i class="ti-trash"></i></button>
                                    </div>    
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-action-sauvegarder">
                <button type="submit" class="btn btn-soccer-coach-action btn-sauvegarder"><i class="ti-save"></i> Sauvegarder l'équipe</button>
            </div>
        </form>
    </div>
</template>
<script>
import { mapState, mapMutations } from 'vuex' 
export default {
    data(){
        return{
            equipeDTO:{},
            error:{isError:false, message:''},
            showSaison:false
        }
    },
    computed:{
        ...mapState(['equipeStoreDTO', 'positions', 'lstJoueurs', 'lstEntraineurs']),
    },
    methods:{
        addEquipe(equipe){

            if(!this.formValid()){
                return;
            }

            let param = {
                nom:equipe.nom.value,
                saison:{
                    nom:equipe.saison.nom.value,
                    dateDebut:equipe.saison.dateDebut.value,
                    dateFin:equipe.saison.dateFin.value
                },
                joueurs:this.lstJoueurs,
                entraineurs:this.lstEntraineurs
            };
            axios.post('/equipes/create', param).then(response =>{
                console.log('creation equipe resultat');
                console.log(response.data);
                this.initFormInputs();
                this.$router.push({name: 'DetailsEquipe', params:{'equipe' : response.data.equipe}}); //go to détail équipe
            });
        },
        formValid(){
            return true;
        },
        annuler(){
                this.setUpdateForm(false); //set the updateForm variable to false
                this.initFormInputs();
                this.$router.push({name: 'MesEquipes'}); //go to mes équipes
        },
        showSaisonAction(){
            this.showSaison = this.showSaison ? false : true;
        },
        deleteEntraineur(index){
            this.deleteEntraineur(index);
        },
        deleteJoueur(index){
            this.deleteJoueur(index);
        },
        initFormInputs(){
            this.clearJoueurList();
            this.clearEntraineurList();
        },
        ...mapMutations(['setUpdateForm', 'deleteJoueur', 'clearJoueurList', 'deleteEntraineur', 'clearEntraineurList'])
    },
    created(){
        this.equipeDTO = this.equipeStoreDTO;
    },
    mounted(){
        this.setUpdateForm(true);

        this.$root.$on('discardFormChanges', () =>{
            this.initFormInputs();
            this.setUpdateForm(false);
            this.$root.$emit('goToLink');
        });
    }
}
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/forms';
    @import '../../../../public/css/equipes/create-equipe';
</style>