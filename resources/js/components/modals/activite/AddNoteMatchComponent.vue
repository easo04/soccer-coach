<template>
    <div class="add-activite modal-btn update-assistance-modal">
        <button class="btn btn-soccer-coach-action-list"  data-toggle="modal" :data-target="'#modalUpdateAssistance' + activite.id" @click="getAssistancesByActivite()"><i class="fa fa-group"></i></button>
        <div :id="'modalUpdateAssistance' + activite.id" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{activite.nom}} {{activite.date_debut}}</h4>
                        <button type="button" class= "close btn-close" :id="'closemodalUpdateAssistance' + activite.id" @click="closeModal()">&times;</button>              
                    </div>
                    <div class="modal-body"> 
                        <bounce  color="17b87d" v-show="isLoading"></bounce>
                        <div class="joueurs" v-if="!isLoading">
                            <div class="joueur-item" v-for="(joueur, indexJ) in lstJoueurs" :key="indexJ">
                                <div class="nom">         
                                    {{joueur.nom}} 
                                </div>
                                <div class="actions">
                                    <div class="temps-chexbox">
                                        <form class="form-assistance">
                                            <div class="type-item">
                                                <input type="radio" :id="'control_present_'+joueur.id+'_'+activite.id" :name="'typeTempsP_'+joueur.id+'_'+activite.id" value="present" @click="addToPresent(joueur.id)" :checked="joueur.presence === 'present'">
                                                <label :for="'control_present_'+joueur.id+'_'+activite.id" class="present">
                                                    <div class="details-type">
                                                        <p class="value">Présent(e)</p>                
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="type-item">
                                                <input type="radio" :id="'control_absent_'+joueur.id+'_'+activite.id" :name="'typeTempsP_'+joueur.id+'_'+activite.id" value="absent" @click="addToAbsent(joueur.id)" :checked="joueur.presence === 'absent'">
                                                <label :for="'control_absent_'+joueur.id+'_'+activite.id" class="absent">
                                                    <div class="details-type">
                                                        <p class="value">Absent(e)</p>                
                                                    </div>
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="updated-by" v-if="joueur.userUpdated && joueur.dateUpdated">
                                        Modifié le
                                        <span class="date-updated">{{joueur.dateUpdated}}</span> par 
                                        <span class="user-updated">{{joueur.userUpdated}}</span>
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                        <div class="btn-action-exercices">
                            <div class="btns">
                                <a class="btn btn-soccer-coach-action" @click="savePresences()"><i class="fa fa-save"></i> Sauvegarder</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState, mapMutations, mapGetters } from 'vuex' 
export default {
    props:['activite', 'indexAct'],
    data(){
        return {
            lstAssistance:[],
            presences:[],
            isLoading : true,
        }
    },
    computed:{
        displayListJoueurs(){     
            return this.lstAssistance.sort((a,b) =>(a.nom > b.nom ? 1 : -1));
        },
        ...mapState(['lstJoueurs', 'mapPresencesActivites']),
        ...mapGetters(['getPresencesByActivite'])
    },
    methods:{
        closeModal(){
            this.presences = []; //init la liste de présences    
            this.lstAssistance = []; //init la liste de joueurs avec leurs présences  

            //mettre à jour la liste de joueurs
            this.lstJoueurs.forEach(joueur => {
                joueur.presence = undefined 
                joueur.dateUpdated = undefined;
                joueur.userUpdated = undefined;  
            });
            $("#modalUpdateAssistance" + this.activite.id).modal("hide");
        },
        getAssistancesByActivite(){

            //vérifier s'il y a déjà des présences dans la liste de présences du store pour l'activité
            let presencesActivite = this.getPresencesByActivite(this.activite.id); 
            if(presencesActivite){   
                let joueurs = this.lstJoueurs;
                joueurs.forEach(joueur => {
                    let assistance =  presencesActivite.find(a => a.idJoueur === joueur.id); 
                    joueur.presence = assistance ? assistance.presence : undefined;   
                    joueur.dateUpdated = assistance ? assistance.date : undefined;
                    joueur.userUpdated =  assistance ? assistance.nameUser : undefined;         
                    this.lstAssistance.push(joueur); 
                });
                this.isLoading = false;
            }else{			
                axios.get('/equipes/get-assistances-by-activite/'+this.activite.id).then(response =>{
                    let assistances = response.data.lstAssistance;
                    let lstPresences = [];
                    if(assistances.length > 0){
                        let joueurs = this.lstJoueurs;
                        joueurs.forEach(joueur => {
                            let assistance =  assistances.find(a => a.joueur_id === joueur.id);                   
                            joueur.presence = assistance ? assistance.presence : undefined;     
                            joueur.dateUpdated = assistance ? assistance.date_last_update : undefined;
                            joueur.userUpdated =  assistance ? assistance.nameUser : undefined;         
                            this.lstAssistance.push(joueur);  

                            //ajouter la présence dans la liste de présence
                            if(assistance){
                                let joueur = {
                                    idJoueur : assistance.joueur_id,
                                    presence : assistance.presence,
                                    date: assistance.date_last_update,
                                    userUpdate: assistance.user_updated_id,
                                    nameUser : assistance.nameUser
                                };
                                lstPresences.push(joueur);
                            }

                        });

                        //ajouter les présences de l'activité dans la liste du store
                        let param = {
                            idActivite: this.activite.id,
                            presences:lstPresences
                        };
                        this.addPresenceToActivite(param);
                    }else{
                        this.lstAssistance = this.lstJoueurs;  
                    }
                    this.isLoading = false;
                });
            }
        },
        addToPresent(idJoueur){

            //vérifier si le joueur a déjà une présence
            let presenceJoueur = this.presences.find(presence => presence.idJoueur === idJoueur);
            if(!presenceJoueur){
                let presence = {
                    idJoueur : idJoueur,
                    isPresent : true,
                    date: new Date()
                }
                this.presences.push(presence);
            }else{
                presenceJoueur.isPresent = true;
            }
        },
        addToAbsent(idJoueur){

             //vérifier si le joueur a déjà une présence
            let presenceJoueur = this.presences.find(presence => presence.idJoueur === idJoueur);
            if(!presenceJoueur){
                let presence = {
                    idJoueur : idJoueur,
                    isPresent : false,
                    date: new Date()
                }
                this.presences.push(presence);
            }else{
                presenceJoueur.isPresent = false;
            }
        },
        savePresences(){
            if(this.presences.length > 0){
                let params = {
                    idActivite : this.activite.id,
                    presences : this.presences
                };
                axios.post('/equipes/save-presences', params).then(response => {
                    let param = {
                        idActivite: this.activite.id,
                        presences:this.presences
                    };

                    let lstPresences = [];

                    //vérifier si le map contien déjà des présences
                    if(this.mapPresencesActivites.has(this.activite.id)){
                        lstPresences = this.getPresencesByActivite(this.activite.id);
                        this.deletePresencesByActivite(this.activite.id);   
                    }

                    //ajouter la nouvelle liste de présences
                    params.presences.push(lstPresences);
                    this.addPresenceToActivite(param); 
                    
                    //fermer la modale
                    this.closeModal();
                });
            }else{
                //fermer la modale
                this.closeModal();
            }
        },
        ...mapMutations(['setMapPresencesActivites', 'clearMapPresencesActivites', 'addPresenceToActivite', 'deletePresencesByActivite'])
    },
    mounted() {}
}
</script>
<style lang="scss" scoped>
    @import '../../../../../public/css/forms';
    @import '../../../../../public/css/modals/addActivite';
    @import '../../../../../public/css/modals/updateAssistance';
</style>
