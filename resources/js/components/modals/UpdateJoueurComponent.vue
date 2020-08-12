<template>
    <div class="add-joueur modal-btn">
        <button class="btn btn-soccer-coach-action-list"  data-toggle="modal" :data-target="'#modalUpdatePlayer' + joueur.id" @click="openModal()"><i class="ti-pencil"></i></button>
        <div :id="'modalUpdatePlayer' + joueur.id" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier un joueur</h4>
                        <button type="button" class= "close btn-close" :id="'closeModalUpdatePlayer' + joueur.id" @click="closeModal()">&times;</button>              
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
                                    <a class="btn btn-soccer-coach-action" @click="addJoueur()"><i class="ti-pencil"></i> Modifier joueur</a>
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
        props:['joueur', 'indexJoueur'],
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
                let params = {
                    id: this.joueur.id,
                    nom:this.joueurDTO.nom.value,
                    email:this.joueurDTO.email.value,
                    position1:this.joueurDTO.position1.value,
                    position2:this.joueurDTO.position2.value,
                    position3:this.joueurDTO.position3.value,
                };

                axios.post("/equipes/updateJoueur", params).then(response =>{
                    params.equipe_id = this.joueur.equipe_id;
                    params.prenom = this.joueur.prenom;
                    params.users_id = this.joueur.users_id;

                    //supprimer le joueur dans la liste de joueurs avant de le mettre à jour
                    this.deleteJoueur(this.indexJoueur);

                    //ajouter le joueur mis à jour
                    this.addJoueurToList(params);

                    //mettre à jour la liste de joueurs dans le locale storage
                    this.$root.$emit('setJoueurLocalStorage');

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
                $("#modalUpdatePlayer" + this.joueur.id).modal("hide");
            },
            ...mapMutations(['addJoueurToList', 'deleteJoueur']),
        },
        created(){
            //initialiser les valeurs du joueurDTO
            this.joueurDTO.nom.value = this.joueur.nom;
            this.joueurDTO.email.value = this.joueur.email;
            this.joueurDTO.position1.value = this.joueur.position1;
            this.joueurDTO.position2.value = this.joueur.position2;
            this.joueurDTO.position3.value = this.joueur.position3;
        },
        mounted(){
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/forms';
    @import '../../../../public/css/modals/addJoueur';
</style>