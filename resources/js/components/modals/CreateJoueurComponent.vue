<template>
    <div class="add-joueur">
        <button type="button" class="btn btn-soccer-coach-action btn-sauvegarder" data-toggle="modal" data-target="#modalAddPlayer" @click="openModal()" v-if="!fromDetail"><i class="ti-plus"></i> Ajouter joueur </button>
        <button type="button" class="btn btn-soccer-coach-action btn-sauvegarder" data-toggle="modal" data-target="#modalAddPlayer" @click="openModal()" v-else><i class="ti-plus"></i> Ajouter</button>
        <div id="modalAddPlayer" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Créer un joueur</h4>
                        <button type="button" class= "close btn-close" id="closeModalAddPlayer" @click="closeModal()">&times;</button>              
                    </div>
                    <div class="modal-body">                     
                        <div class="form-add-joueur">
                            <div class="form-group">
                                <label for="nomJoueur"><span v-if="joueurDTO.nom.validations.require"> * </span> Nom:</label>
                                <input-text placeholder="Ex: Lionel Messi" v-model="joueurDTO.nom.value" name="nomJoueur"
                                        :model="joueurDTO.nom" @validation="joueurDTO.nom.validate = $event"/>
                            </div>
                            <div class="form-group">
                                <label for="emailJoueur"><span v-if="joueurDTO.email.validations.require"> * </span> Email:</label>
                                <input-text placeholder="Ex: lionel.messi@gmail.com" v-model="joueurDTO.email.value" name="emailJoueur"
                                        :model="joueurDTO.email" @validation="joueurDTO.email.validate = $event"/>
                            </div>
                            <div class="form-group">
                                <label for="position2"><span v-if="joueurDTO.position1.validations.require"> * </span> Position 1:</label>
                                <select class="select-form" name="position1" id="position2" v-model="joueurDTO.position1.value">
                                    <option :value="position.key" v-for="(position, index) in positions" :key="index">{{position.description}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="position2"><span v-if="joueurDTO.position2.validations.require"> * </span> Position 2:</label>
                                <select class="select-form" name="position2" id="position2" v-model="joueurDTO.position2.value">
                                    <option :value="position.key" v-for="(position, index) in positions" :key="index">{{position.description}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="position3"><span v-if="joueurDTO.position3.validations.require"> * </span> Position 3:</label>
                                <select class="select-form" name="position3" id="position3" v-model="joueurDTO.position3.value">
                                    <option :value="position.key" v-for="(position, index) in positions" :key="index">{{position.description}}</option>
                                </select>
                            </div>
                            <div class="btn-action-exercices">
                                <div class="btns">
                                    <a class="btn btn-soccer-coach-action" @click="addJoueur()"><i class="ti-plus"></i> Ajouter joueur</a>
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
        props:['fromDetail', 'equipe'],
        data(){
            return{
                joueurDTO:{
                    nom:{
                        value:undefined,
                        validations:{
                            require:true
                        },
                        validate:false
                    },
                    email:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    },
                    position1:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    },
                    position2:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    },
                    position3:{
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
            ...mapState(['positions']),
        },
        methods:{
            addJoueur(){
                /*if(!this.formValid()){
                    return;
                }*/
                let joueur = {
                    nom:this.joueurDTO.nom.value,
                    email:this.joueurDTO.email.value,
                    position1:this.joueurDTO.position1.value,
                    position2:this.joueurDTO.position2.value,
                    position3:this.joueurDTO.position3.value,
                };

                if(this.fromDetail){
                    joueur.equipe = this.equipe;
                    axios.post("/equipes/createJoueur", joueur).then(response =>{
                        joueur.id = response.data.joueur;
                        this.addJoueurToList(joueur);
                        this.$root.$emit('setJoueurLocalStorage');
                    });
                }else{
                    this.addJoueurToList(joueur);
                }
                        
                this.closeModal();
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
            initJoueurDTO(){
                this.joueurDTO ={
                    nom:{
                        value:undefined,
                        validations:{
                            require:true
                        },
                        validate:false
                    },
                    email:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    },
                    position1:{
                        value:undefined,
                        validations:{
                            require:true
                        },
                        validate:false
                    },
                    position2:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    },
                    position3:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    },
                }
            },
            openModal(){
                //this.$root.$emit('setExerciceDTO');
            },
            closeModal(){
                this.initJoueurDTO();
                $("#modalAddPlayer").modal("hide");
            },
            ...mapMutations(['addJoueurToList']),
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/forms';
    @import '../../../../public/css/modals/addJoueur';
</style>