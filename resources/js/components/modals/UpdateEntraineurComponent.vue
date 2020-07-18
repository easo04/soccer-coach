<template>
    <div class="add-joueur modal-btn">
        <button class="btn btn-soccer-coach-action-list"  data-toggle="modal" :data-target="'#modalUpdateCoach' + +entraineur.id" @click="openModal()"><i class="ti-pencil"></i></button>
        <div :id="'modalUpdateCoach'+entraineur.id" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier un entrâineur</h4>
                        <button type="button" class= "close btn-close" :id="'closemodalUpdateCoach'+entraineur.id" @click="closeModal()">&times;</button>              
                    </div>
                    <div class="modal-body">                     
                        <div class="form-add-joueur">
                            <div class="form-group">
                                <label for="nomEnt"><span v-if="entraineurDTO.nom.validations.require"> * </span> Nom:</label>
                                <input-text placeholder="Ex: Pep Guardiola" v-model="entraineurDTO.nom.value" name="nomEnt"
                                        :model="entraineurDTO.nom" @validation="entraineurDTO.nom.validate = $event"/>
                            </div>
                            <div class="form-group">
                                <label for="role"><span v-if="entraineurDTO.role.validations.require"> * </span> Rôle:</label>
                                <select class="select-form" name="role" id="role" v-model="entraineurDTO.role.value">
                                    <option :value="role" v-for="(role, index) in roles" :key="index">{{role}}</option>
                                </select>
                            </div>
                            <div class="btn-action-exercices">
                                <div class="btns">
                                    <a class="btn btn-soccer-coach-action" @click="updateCoach()"><i class="ti-plus"></i> Modifier entraîneur</a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState, mapMutations } from 'vuex' 
    export default {
        props:['entraineur', 'indexEntraineur'],
        data(){
            return{
                entraineurDTO:{
                    nom:{
                        value:undefined,
                        validations:{
                            require:true
                        },
                        validate:false
                    },
                    role:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    },
                },
            }
        },
        computed:{
            ...mapState(['roles']),
        },
        methods:{
            updateCoach(){
                let params = {
                    id: this.entraineur.id,
                    nom:this.entraineurDTO.nom.value,
                    role:this.entraineurDTO.role.value,
                };

                axios.post("/equipes/updateEntraineur", params).then(response =>{
                    params.equipe_id = this.entraineur.equipe_id;
                    params.prenom = this.entraineur.prenom;
                    params.users_id = this.entraineur.users_id;

                    //supprimer le joueur dans la liste de joueurs avant de le mettre à jour
                    this.deleteEntraineur(this.indexEntraineur);

                    //ajouter le joueur mis à jour
                    this.addEntraineurToList(params);

                    //mettre à jour la liste de joueurs dans le locale storage
                    this.$root.$emit('setEntraineurLocalStorage');

                    this.closeModal();
                });
                        
            },
            formValid(){
                let values = Object.values(this.joueurDTO);

                let valueNotValidate = values.find(value => !value.validate);

                if(valueNotValidate){
                    this.$root.$emit('formInvalid'); 
                    return false;
                }
                return true;
            },
            openModal(){
            },
            closeModal(){
                $("#modalUpdateCoach" + this.entraineur.id).modal("hide");
            },
            ...mapMutations(['addEntraineurToList', 'deleteEntraineur']),
        },
        created(){
            //initialiser les valeurs du joueurDTO
            this.entraineurDTO.nom.value = this.entraineur.nom;
            this.entraineurDTO.role.value = this.entraineur.role;
        },
        mounted(){
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/forms';
    @import '../../../../public/css/modals/addJoueur';
</style>