<template>
    <div class="add-seance-form">
        <form class="form-horizontal panel" @submit.prevent="addSeance(seanceDTO)">
            <div class="actions-exercice-detail">
                <div class="btns">
                    <a class="btn btn-soccer-coach-action" @click="annuler"><i class="ti-close"></i> Annuler</a>
                </div>
                <span>* indique que le champ est obligatoire</span>
            </div>
            
            <div class="details-exercice">        
                <div class="form-group">
                    <label for="theme"><i class="ti-flag-alt color-soccer-coach"></i><span v-if="seanceDTO.theme.validations.require"> * </span> Thème:</label>
                    <input-text placeholder="Ex: Conservation 4vs4 plus joker" v-model="seanceDTO.theme.value" name="theme"
                        :model="seanceDTO.theme" @validation="seanceDTO.theme.validate = $event"/>
                </div>
                <div class="form-group input-sm">
                    <label for="temps"><i class="ti-time color-soccer-coach"></i><span v-if="seanceDTO.temps.validations.require"> * </span> Durée:</label>
                    <div class="temps-input">
                        <input-number placeholder="Ex: 20" v-model="seanceDTO.temps.value" name="time" 
                            :model="seanceDTO.temps" @validation="seanceDTO.temps.validate = $event"/>
                        <div class="temps-chexbox">
                            <div class="type-item">
                                <input type="radio" id="control_min_p" name="typeTempsP" value="min" v-model="seanceDTO.typeTemps.value">
                                <label for="control_min_p">
                                    <div class="details-type">
                                        <p class="value">min</p>                
                                    </div>
                                </label>
                            </div>
                            <div class="type-item">
                                <input type="radio" id="control_h_p" name="typeTempsP" value="h" v-model="seanceDTO.typeTemps.value">
                                <label for="control_h_p">
                                    <div class="details-type">
                                        <p class="value">h</p>                
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="form-group input-sm">
                    <label for="effectif"><i class="fa fa-group color-soccer-coach"></i><span v-if="seanceDTO.effectif.validations.require"> * </span> Effectif:</label>
                    <input-number placeholder="Ex: 15" v-model="seanceDTO.effectif.value" name="effectif"
                        :model="seanceDTO.effectif" @validation="seanceDTO.effectif.validate = $event"/>
                </div>
                <div class="form-group">
                    <label for="type"><i class="ti-flag-alt-2 color-soccer-coach"></i><span v-if="seanceDTO.categorie.validations.require"> * </span> Type de séance:</label>
                    <types-seances-select v-model="seanceDTO.categorie.value"/>
                </div>     
                <div class="form-group">
                    <label for="endroit"><i class="ti-map-alt color-soccer-coach"></i><span v-if="seanceDTO.endroit.validations.require"> * </span> Endroit:</label>
                    <input-text placeholder="Ex: Terrain A" v-model="seanceDTO.endroit.value" name="theme"
                        :model="seanceDTO.endroit" @validation="seanceDTO.endroit.validate = $event"/>
                </div>
                <div class="form-group input-sm">
                    <label for="time"><i class="fa fa-calendar-o color-soccer-coach"></i><span v-if="seanceDTO.time.validations.require"> * </span> Date:</label>
                    <VueCtkDateTimePicker v-model="seanceDTO.time.value" locale="fr" format="YYYY-MM-DD" formatted="ll"
                        color="#03aca4" label="Sélectionner une date" button-color="#03aca4"
                        button-now-translation="Aujourd'hui" :right="true" :auto-close="true" :only-date="true" id="dateSeance"/>
                </div>
                <div class="form-group">
                    <label for="context"> <i class="ti-direction color-soccer-coach"></i><span v-if="seanceDTO.context.validations.require"> * </span> Contexte:</label>
                    <text-area placeholder="Ex: Préaparation du match contre équipe X" name="context" v-model="seanceDTO.context.value" 
                                :model="seanceDTO.context" @validation="seanceDTO.context.validate = $event"/>
                </div>
                <div class="exercices">
                    <label for="time"><i class="ti-star color-soccer-coach"></i> * Exercices:</label>
                    <br><span class="error" v-if="error.isError">{{error.message}}</span>   
                    <div class="btn-action-exercices">
                        <div class="btns">
                            <mes-exercices-modal />
                            <mes-favoris-modal />
                            <create-exercice-modal />
                            <a class="btn btn-soccer-coach-action" @click="addMatch()"><i class="ti-plus"></i> Ajouter match</a>
                        </div>
                    </div>
                    <div class="lst-exercices" :class="{'lst-vide' : lstExercices.length === 0}">                    
                        <div class="aucun-exercice" v-if="lstExercices.length === 0">Aucun exercice</div>
                        <div class="exercice-item" v-for="(exercice, index) in lstExercices" :key="index">
                            <div class="row" v-if="!exercice.isGame">
                                <div class="col-sm-8 details-exe">
                                    <h5>Exercice #{{index+1}} - {{exercice.principe}}</h5>
                                    <div class="items-modifiables">
                                        <div class="form-group">
                                            <label for="time"><i class="ti-timer color-soccer-coach"></i> Durée:</label>
                                            <input-text v-model="exercice.time" name="time" :model="exercice.time"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="nbJoueurs">Nombre de joueurs:</label>
                                            <input-number v-model="exercice.nbJoueurs" name="nbJoueurs" :model="exercice.nbJoueurs"/>
                                        </div>
                                    </div>
                                    <p>{{exercice.description}}</p>
                                </div>
                                <div class="col-sm-4 image-exe">
                                    <img :src="exercice.imageBase64" :alt="exercice.image" v-if="exercice.newAdded"/>
                                    <img :src="'../../../images/uploaded/' + exercice.image" :alt="exercice.image" v-else/>
                                </div>
                            </div>
                            <div class="exercice-match" v-else> 
                                <div class="details-match">     
                                    <h5>Match</h5>                     
                                    <div class="items-modifiables">
                                        <div class="form-group">
                                            <label for="time"><i class="ti-timer color-soccer-coach"></i> Durée:</label>
                                            <input-text v-model="exercice.time" name="time" :model="exercice.time"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="nbJoueurs">Nombre de joueurs:</label>
                                            <input-number v-model="exercice.nbJoueurs" name="nbJoueurs" :model="exercice.nbJoueurs"/>
                                        </div>
                                    </div>
                                    <div class="match description-match">
                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <text-area v-model="exercice.description" name="description" :model="exercice.description"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="actions">
                                <button class="btn btn-soccer-coach-action" @click="deleteExerciceDTO(index, exercice)"><i class="ti-trash"></i> Supprimer</button>
                                <details-exercice-modal :exercice="exercice" :index="index" v-if="!exercice.isGame"/>      
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-action-sauvegarder">
                <button type="submit" class="btn btn-soccer-coach-action btn-sauvegarder"><i class="ti-save"></i> Sauvegarder la séance</button>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex';

    export default {
        props: ['types'],
        data() {
            return {
                seanceDTO:{},
                error:{isError:false, message:''},
                nbMatchs:0
            }
        },     
        computed:{
            ...mapState(['seanceStoreDTO', 'exerciceStore', 'lstExercices', 'exerciceAdd', 'updateForm'])                     
        },
        methods: {
            addSeance(seance){
                if(!this.isFormValide()){
                    return;
                }
                
                const formData = new FormData();
                formData.append("theme", seance.theme.value);
                formData.append("endroit", seance.endroit.value ? seance.endroit.value : '');              
                formData.append("time", seance.time.value ? seance.time.value.toLowerCase() : '');
                formData.append("context", seance.context.value ? seance.context.value : '');
                formData.append("temps", seance.temps.value ? seance.temps.value + seance.typeTemps.value : '');  
                formData.append("effectif", seance.effectif.value ? seance.effectif.value : '');  
                formData.append("categorie", seance.categorie.value);  
                this.lstExercices.forEach((item, index) => {
                    formData.append("image_" + index, item.image);
                    item.index = index;
                    formData.append('lstExercices[]', JSON.stringify(item));
                });  
                axios.post('/seance/create', formData, {headers:{'Content-Type': 'multipart/form-data'}}).then(reponse =>{
                    console.log(reponse);
                    this.initFormInputs();
                    let seance =  reponse.data.seance;
                    this.$router.push({name: 'DetailSeance', params: { seance }});
                }).catch(error =>{
                    console.log(error);
                });   
            },
            annuler(){
                this.setUpdateForm(false);
                this.initFormInputs();
                window.history.back();
            },
            isFormValide(){
                if(this.seanceDTO.time.value !== ''){
                    this.seanceDTO.time.validate = true;
                }

                if(this.lstExercices.length === 0){
                    this.error.isError = true;
                    this.error.message = '* Au moins un exercice doit être ajouté';
                }else{
                    this.error.isError = false;
                    this.error.message = '';
                }

                let values = Object.values(this.seanceDTO);

                let valueNotValidate = values.find(value => !value.validate);

                if(valueNotValidate || this.error.isError){
                    this.$root.$emit('formInvalid'); 
                    return false;
                }
                return true;
            },
            deleteExerciceDTO(index, exe){
                if(exe.isGame){
                    this.nbMatchs--;
                }
                this.deleteExercice(index); 
            },
            addMatch(){
                this.nbMatchs++;
                let match = {
                    time:'',
                    nbJoueurs:'',
                    description:'',
                    isGame:true,
                    noMatch:this.nbMatchs,
                    newAdded:true
                };
                this.addExercice(match);
            },
            initFormInputs(){
                this.setUpdateForm(false);
                this.initSeanceStoreDTO();
                this.clearExercices();
                this.seanceDTO = this.seanceStoreDTO;
            },
            ...mapMutations(['deleteExercice', 'addExercice', 'setUpdateForm', 'initSeanceStoreDTO', 'clearExercices'])
        },
        beforeCreate(){
        },
        created() {
            this.seanceDTO = this.seanceStoreDTO;
            //setter le type par defaut
            this.seanceDTO.categorie.value = 'Offensive';
            this.seanceDTO.categorie.validate = true; 
            this.seanceDTO.typeTemps = {
                value : 'min',
                validate:true,
            };
        },
        mounted() {
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
    @import '../../../public/css/forms';
    @import '../../../public/css/pratiques/add-pratiques';
</style>

