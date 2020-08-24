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
                                <input-autocomplete :lst-items="lstNomsEntraineurs" @select="entraineurSelected = $event" placeholder="Ex: Pep Guardiola"/>
                            </div>
                            <div class="form-group">
                                <label for="role"><span v-if="entraineurDTO.role.validations.require"> * </span> Rôle 1:</label>
                                <select class="select-form" name="role" id="role" v-model="entraineurDTO.role.value">
                                    <option :value="role.key" v-for="(role, index) in roles" :key="index">{{role.description}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="role2"><span v-if="entraineurDTO.role2.validations.require"> * </span> Rôle 2:</label>
                                <select class="select-form" name="role2" id="role2" v-model="entraineurDTO.role2.value">
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
                    role2:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    },
                },
                lstEntraineurs:[],
                lstNomsEntraineurs:[],
                entraineurSelected:'',
                idUserEntraineurSelected:undefined
            }
        },
        computed:{
            ...mapState(['roles']),
        },
        watch:{
            entraineurSelected(){
                let entraineur = this.lstEntraineurs.find(e => e.nom === this.entraineurSelected);
                if(entraineur){
                    this.entraineurDTO.nom.value= entraineur.nom;
                    this.idUserEntraineurSelected = entraineur.users_id;
                }else{
                    this.entraineurDTO.nom.value = this.entraineurSelected;
                }
            }
        },
        methods:{
            addEntraineur(){
                if(!this.formValid()){
                    return;
                }

                let entraineur = {
                    nom:this.entraineurDTO.nom.value,
                    role:this.entraineurDTO.role.value,
                    role2:this.entraineurDTO.role2.value,
                    users_id: this.idUserEntraineurSelected,
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
                    role2:{
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
        },
        created(){
            //récupérer la liste d'entraîneurs disponibles
            if(localStorage.getItem('entraineursClub')){
                this.lstEntraineurs = JSON.parse(localStorage.getItem('entraineursClub'));
                this.lstNomsEntraineurs = this.lstEntraineurs.map((entraineur) =>{ return entraineur.nom});
            }else{
                axios.get('/user/get-entraineurs-by-my-club').then(response =>{
                    this.lstEntraineurs = response.data.entraineurs;
                    this.lstNomsEntraineurs = this.lstEntraineurs.map((entraineur) =>{ return entraineur.nom});

                    //add terrains to local storage
                    const entraineursPrsed = JSON.stringify(this.lstEntraineurs);
                    localStorage.setItem('entraineursClub', entraineursPrsed);
                }).catch(error =>{
                    let errorCode = error.data.errorCode;
                    console.log(errorCode);
                });
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/forms';
    @import '../../../../public/css/modals/addJoueur';
</style>