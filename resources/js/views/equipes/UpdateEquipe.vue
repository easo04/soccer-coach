<template>
    <div class="update-equipe">
        <form class="form-horizontal panel" @submit.prevent="updateEquipe(equipeDTO)">
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
                                    :model="equipeDTO.saison.nom" @validation="equipeDTO.saison.nom.validate = $event"/>
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
    props:['equipe'],
    data(){
        return{
            equipeDTO:{},
            error:{isError:false, message:''},
            showSaison:false
        }
    },
    computed:{
        ...mapState(['equipeStoreDTO']),
    },
    methods:{
        updateEquipe(equipeDTO){

            if(!this.formValid()){
                return;
            }

            let param = {
                id:this.equipe.id,
                nom:equipeDTO.nom.value,
                saison:{
                    id:equipeDTO.saison.id,
                    nom:equipeDTO.saison.nom.value,
                    dateDebut:equipeDTO.saison.dateDebut.value,
                    dateFin:equipeDTO.saison.dateFin.value
                },
            };
            axios.post('/equipes/update', param).then(response =>{
                console.log('update equipe resultat');
                this.initFormInputs();
                this.equipe.nom = param.nom;
                if(param.saison.nom){          
                    this.equipe.saison = {
                        nom : param.saison.nom,
                        date_debut : param.saison.dateDebut,
                        date_fin : param.saison.dateFin,
                    }
                }
                this.$router.push({name: 'DetailsEquipe', params:{'equipe' : this.equipe}}); //go to détail équipe
            });
        },
        formValid(){
            return true;
        },
        annuler(){
            this.setUpdateForm(false); //set the updateForm variable to false
            this.initFormInputs();
            this.$router.push({name: 'DetailsEquipe', params: {'equipe':this.equipe}}); //go to détail équipe
        },
        showSaisonAction(){
            this.showSaison = this.showSaison ? false : true;
        },
        initFormInputs(){
        },
        ...mapMutations(['setUpdateForm'])
    },
    created(){
        this.equipeDTO = this.equipeStoreDTO;
        
        this.equipeDTO.nom.value = this.equipe.nom;

        //set saison
        if(this.equipe.saison){
            this.equipeDTO.saison.nom.value = this.equipe.saison.nom;
            this.equipeDTO.saison.dateDebut.value = this.equipe.saison.date_debut;
            this.equipeDTO.saison.dateFin.value = this.equipe.saison.date_fin;
            this.equipeDTO.saison.id = this.equipe.saison.id;
            this.showSaison = true;     
        }
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