<template>
    <div class="update-exercice-form">
        <form class="form-horizontal panel" @submit.prevent="updateExercice(exerciceDTO)">
            <div class="actions-exercice-detail">
                <div class="btns">
                    <a @click="annuler" class="btn btn-soccer-coach-action"><i class="ti-close"></i> Annuler</a>
                </div>
                <span>* indique que le champ est obligatoire</span>
            </div>
            <div class="row details-exercice">
                <div class="col-sm-6 details-exercice-info">
                    <div class="form-group">
                        <label for="principe"><i class="ti-flag-alt color-soccer-coach"></i><span v-if="exerciceDTO.principe.validations.require"> * </span> Principe:</label>
                        <input-text placeholder="Ex: Conservation 4vs4 plus joker" v-model="exerciceDTO.principe.value" name="principe"
                                :model="exerciceDTO.principe" @validation="exerciceDTO.principe.validate = $event"/>
                    </div>
                    <div class="form-group">
                        <label for="sousPrincipe"> <i class="ti-flag color-soccer-coach"></i> Sous-principes:</label>
                        <label for="sousPrincipe"> <i class="ti-flag color-soccer-coach"></i><span v-if="exerciceDTO.sousPrincipe.validations.require"> * </span> Sous-principes:</label>
                        <input-text placeholder="Ex: Contrôle du ballon, Orientation du corps" v-model="exerciceDTO.sousPrincipe.value" name="sousPrincipe"
                                :model="exerciceDTO.sousPrincipe" @validation="exerciceDTO.sousPrincipe.validate = $event"/>
                    </div>
                    <div class="form-group">
                        <label for="description"> <i class="ti-direction color-soccer-coach"></i><span v-if="exerciceDTO.description.validations.require"> * </span> Description:</label>
                        <text-area placeholder="Description" name="description" v-model="exerciceDTO.description.value" 
                                    :model="exerciceDTO.description" @validation="exerciceDTO.description.validate = $event"/>
                    </div>
                    <div class="form-group">
                        <label for="physique"><i class="ti-heart color-soccer-coach"></i><span v-if="exerciceDTO.physique.validations.require"> * </span> Physique:</label>
                        <input-text placeholder="Ex: Resistance, rapidité, cardio" v-model="exerciceDTO.physique.value" name="physique"
                                :model="exerciceDTO.physique" @validation="exerciceDTO.physique.validate = $event"/>
                    </div> 
                    <div class="form-group form-check">                 
                        <label class="container-label">
                            <i class="ti-key color-soccer-coach"></i><span v-if="exerciceDTO.private.validations.require"> * </span> Privée
                            <input type="checkbox" v-model="exerciceDTO.private.value">  <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="type"><i class="ti-flag-alt-2 color-soccer-coach"></i><span v-if="exerciceDTO.typesexcercice_id.validations.require"> * </span> Type d'exercice</label>
                        <types-exercices-select v-bind:id-type-selected="exerciceDTO.typesexcercice_id.value" v-model="exerciceDTO.typesexcercice_id.value"/>
                    </div>  
                    <div class="form-group">
                        <label for="type"><i class="ti-tag color-soccer-coach"></i> Objectifs</label>
                        <list-objectifs-exercices :objectifsExercice="objectifsExercice" />
                    </div>     
                </div>
                <div class="col-sm-6 details-exercice-image">
                    <div class="form-group input-sm">
                        <label for="time"> <i class="ti-timer color-soccer-coach"></i><span v-if="exerciceDTO.time.validations.require"> * </span> Durée:</label>
                        <div class="temps-input">
                            <input-number placeholder="Ex: 20" v-model="exerciceDTO.time.value" name="time" 
                                :model="exerciceDTO.time" @validation="exerciceDTO.time.validate = $event"/>
                            <div class="temps-chexbox">
                                <div class="type-item">
                                    <input type="radio" id="control_min_em" name="typeTempsEm" value="min" v-model="exerciceDTO.typeTemps.value">
                                    <label for="control_min_em">
                                        <div class="details-type">
                                            <p class="value">min</p>                
                                        </div>
                                    </label>
                                </div>
                                <div class="type-item">
                                    <input type="radio" id="control_h_em" name="typeTempsEm" value="h" v-model="exerciceDTO.typeTemps.value">
                                    <label for="control_h_em">
                                        <div class="details-type">
                                            <p class="value">h</p>                
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="form-group">
                            <label for="nbJoueurs"> <i class="ti-user color-soccer-coach"></i><span v-if="exerciceDTO.nbJoueurs.validations.require"> * </span> Nombre de joueurs:</label>
                            <input-number placeholder="Ex: 15" v-model="exerciceDTO.nbJoueurs.value" name="number"
                                :model="exerciceDTO.nbJoueurs" @validation="exerciceDTO.nbJoueurs.validate = $event"/>
                    </div>  
                    <div class="form-group">
                            <label for="observations"><i class="ti-eye color-soccer-coach"></i><span v-if="exerciceDTO.observations.validations.require"> * </span> Observations:</label>
                            <text-area placeholder="Observations" name="observations" v-model="exerciceDTO.observations.value" 
                                    :model="exerciceDTO.observations" @validation="exerciceDTO.observations.validate = $event"/>
                    </div> 
                    <div class="form-group">
                            <label for="url"><i class="ti-link color-soccer-coach"></i><span v-if="exerciceDTO.url.validations.require"> * </span> URL: <a href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover"><i class="ti-help-alt"></i></a></label>
                            <input-text placeholder="Ex: http:/youtube.com" v-model="exerciceDTO.url.value" name="url"
                                :model="exerciceDTO.url" @validation="exerciceDTO.url.validate = $event"/>
                    </div>
                    <label for="image"><i class="ti-image color-soccer-coach"></i><span v-if="exerciceDTO.image.validations.require"> * </span> Image</label>
                    <br><span class="error" v-if="error.isError">{{error.message}}</span>   
                    <images-exercices-modal/>
                    <image-upload v-bind:image="exerciceDTO.image.value" id-image="1" @imageUploaded="exerciceDTO.image.value = $event"/>    
                </div>
            </div>
        </form>
        <add-variables v-bind:variantes="variantes"/>
        <div class="btn-action-sauvegarder">
            <button type="submit" class="btn btn-soccer-coach-action btn-sauvegarder"><i class="ti-pencil"></i> Sauvegarder l'exercice</button>
        </div> 
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {
        props: ['exercice', 'variantes', 'objectifsExercice'],
        data() {
            return {
                exerciceDTO:{},
                error:{isError:false, message:''},
            }
        },           
        computed:{
            ...mapState(['lstVariantes', 'lstObjectifs', 'exerciceStoreDTO'])                     
        },
        methods: {
            updateExercice(exercice){ 
                if(!this.isFormValide()){
                    return;
                }

                const formData = new FormData();
                formData.append("image", exercice.image.value);
                formData.append("id", exercice.id.value);
                formData.append("principe", exercice.principe.value);
                formData.append("time", exercice.time.value.toLowerCase() + exercice.typeTemps.value);
                formData.append("nbJoueurs", exercice.nbJoueurs.value);
                formData.append("description", exercice.description.value);
                formData.append("typesexcercice_id", exercice.typesexcercice_id.value);
                this.lstVariantes.forEach((item) => {
                    formData.append('lstVariables[]', JSON.stringify(item));
                });
                this.lstObjectifs.forEach((item) => {
                    formData.append('lstObjectifs[]', JSON.stringify(item));
                });
                formData.append("sousPrincipe", exercice.sousPrincipe.value ? exercice.sousPrincipe.value : '');             
                formData.append("physique", exercice.physique.value ? exercice.physique.value : '');
                formData.append("observations", exercice.observations.value ? exercice.observations.value : '');      
                formData.append("url", exercice.url.value ? exercice.url.value : '');
                formData.append("private", exercice.private.value);  
                axios.post('/exercice/update', formData, {headers:{'Content-Type': 'multipart/form-data'}}).then(reponse =>{
                    console.log(reponse);
                    let exercice = reponse.data.exercice;
                    this.$router.push({name: 'DetailExercice', params: { exercice }});
                }).catch(error =>{
                    console.log(error);
                });        
            },
            annuler(){
                this.setUpdateForm(false); //set the updateForm variable to false
                this.initFormInputs();
                let exercice = this.exercice;
                this.$router.push({name: 'DetailExercice', params:{exercice}}); //go to detail exercice
            },
            isFormValide(){
                let isImageValid = this.exerciceDTO.image.value;

                if(!isImageValid){
                    this.error.isError = true;
                    this.error.message = '* Ce champ est obligatoire';
                }else{
                    this.error.isError = false;
                    this.error.message = '';
                    this.exerciceDTO.image.validate = true;
                }

                let values = Object.values(this.exerciceDTO);

                let valueNotValidate = values.find(value => !value.validate);

                if(valueNotValidate || !isImageValid){
                    this.$root.$emit('formInvalid'); 
                    return false;
                }
                return true;
            },
            initFormInputs(){
                this.initExerciceStoreDTO();
                this.clearListObjectifs(); //clear list objectifs 
                this.clearListVariantes(); //clear list variantes 
                this.exerciceDTO = this.exerciceStoreDTO;
            },
            ...mapMutations(['setUpdateForm', 'clearListObjectifs', 'clearListVariantes', 'initExerciceStoreDTO']),
        },
        created() {
            this.exerciceDTO = this.exerciceStoreDTO;
            //init values du DTO
            this.exerciceDTO.principe.value = this.exercice.principe;
            this.exerciceDTO.sousPrincipe.value = this.exercice.sousPrincipe;
            this.exerciceDTO.physique.value = this.exercice.physique;
            this.exerciceDTO.observations.value = this.exercice.observations;
            this.exerciceDTO.typesexcercice_id.value = this.exercice.typesexcercice_id;
            this.exerciceDTO.private.value = this.exercice.private;
            this.exerciceDTO.image.value = this.exercice.image;
            this.exerciceDTO.nbJoueurs.value = this.exercice.nbJoueurs;
            this.exerciceDTO.description.value = this.exercice.description;
            this.exerciceDTO.id = {
                value:this.exercice.id,
                validate:true
            };
            //setter le temps
            let timeNumber = this.exercice.time;
            let timeType = 'min';
            if(this.exercice.time.includes('min')){
                let indexOfMin = this.exercice.time.lastIndexOf('min');
                timeNumber = this.exercice.time.substr(0, indexOfMin);
            }else if(this.exercice.time.includes('h')){
                let indexOfH = this.exercice.time.lastIndexOf('h');
                timeNumber = this.exercice.time.substr(0, indexOfH);
                timeType = 'h';
            }
            this.exerciceDTO.time.value = timeNumber;
            this.exerciceDTO.typeTemps = {
                value : timeType,
                validate:true,
            };
            //init tous les validations à true
            this.exerciceDTO.principe.validate = true;
            this.exerciceDTO.sousPrincipe.validate = true;
            this.exerciceDTO.time.validate = true;
            this.exerciceDTO.physique.validate = true;
            this.exerciceDTO.observations.validate = true;
            this.exerciceDTO.typesexcercice_id.validate = true;
            this.exerciceDTO.private.validate = true;
            this.exerciceDTO.image.validate = true;
            this.exerciceDTO.nbJoueurs.validate = true;
            this.exerciceDTO.description.validate = true;
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
</style>

