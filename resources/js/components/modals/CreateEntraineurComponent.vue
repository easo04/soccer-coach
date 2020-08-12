<template>
    <div class="add-joueur">
        <button type="button" class="btn btn-soccer-coach-action btn-sauvegarder" data-toggle="modal" data-target="#modalAddCoach" @click="openModal()" v-if="!fromDetail"><i class="ti-plus"></i> Ajouter entraîneur </button>
        <button type="button" class="btn btn-soccer-coach-action btn-sauvegarder" data-toggle="modal" data-target="#modalAddCoach" @click="openModal()" v-else><i class="ti-plus"></i> Ajouter</button>
        <div id="modalAddCoach" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Créer un entrâineur</h4>
                        <button type="button" class= "close btn-close" id="closemodalAddCoach" @click="closeModal()">&times;</button>              
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
                                    <option :value="role.key" v-for="(role, index) in roles" :key="index">{{role.description}}</option>
                                </select>
                            </div>
                            <div class="btn-action-exercices">
                                <div class="btns">
                                    <a class="btn btn-soccer-coach-action" @click="addEntraineur()"><i class="ti-plus"></i> Ajouter entraîneur</a>
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
    import { mapState, mapMutations, mapGetters } from 'vuex' 
    export default {
        props:['fromDetail', 'equipe'],
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
            addEntraineur(){
                /*if(!this.formValid()){
                    return;
                }*/
                let entraineur = {
                    nom:this.entraineurDTO.nom.value,
                    role:this.entraineurDTO.role.value,
                };

                if(this.fromDetail){
                    entraineur.equipe = this.equipe;
                    axios.post("/equipes/createEntraineur", entraineur).then(response =>{
                        entraineur.id = response.data.entraineur;
                        this.addEntraineurToList(entraineur);
                        this.$root.$emit('setEntraineurLocalStorage');
                    });
                }else{
                    this.addEntraineurToList(entraineur);
                }
                
                this.closeModal();
            },
            formValid(){
                return true;
            },
            initJoueurDTO(){
                this.entraineurDTO = {
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
                };
            },
            openModal(){
                //this.$root.$emit('setExerciceDTO');
            },
            closeModal(){
                this.initJoueurDTO();
                $("#modalAddCoach").modal("hide");
            },
            ...mapMutations(['addEntraineurToList']),
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/forms';
    @import '../../../../public/css/modals/addJoueur';
</style>