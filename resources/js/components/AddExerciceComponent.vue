<template>
    <div class="update-exercice-form">
        <form class="form-horizontal panel" @submit.prevent="addExerciceToList(exerciceDTO)">
        <div class="actions-exercice-detail">
            <div class="btns" v-if="!isModal">
                <a class="btn btn-soccer-coach-action" @click="annuler"><i class="ti-close"></i> Annuler</a>
            </div>
            <span class="msg-required">* indique que le champ est obligatoire</span>
        </div>
        
        <div class="row details-exercice">        
            <div class="col-sm-6 details-exercice-info">
                <div class="form-group">
                    <label for="principe"><i class="ti-flag-alt color-soccer-coach"></i><span v-if="exerciceDTO.principe.validations.require"> * </span> Principe:</label>
                    <input-text placeholder="Ex: Conservation 4vs4 plus joker" v-model="exerciceDTO.principe.value" name="principe"
                            :model="exerciceDTO.principe" @validation="exerciceDTO.principe.validate = $event"/>
                </div>
                <div class="form-group">
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
                    <list-objectifs-exercices />
                </div>  
            </div>
            <div class="col-sm-6 details-exercice-image">
                <div class="form-group">
                        <label for="time"> <i class="ti-timer color-soccer-coach"></i><span v-if="exerciceDTO.time.validations.require"> * </span> Durée:</label>
                        <input-text placeholder="Ex: 20min" v-model="exerciceDTO.time.value" name="time"
                            :model="exerciceDTO.time" @validation="exerciceDTO.time.validate = $event"/>
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
                <images-exercices-modal isModal="isModal"/>
                <image-upload v-bind:image="exerciceDTO.image.value" id-image="1" @imageUploaded="exerciceDTO.image.value = $event"/>     
            </div>
        </div>
        <add-variables/> 
        <div class="btn-action-sauvegarder">
            <button type="submit" class="btn btn-soccer-coach-action btn-sauvegarder"><i class="ti-save"></i> Sauvegarder l'exercice</button>
        </div>
        </form>
    </div>
</template>

<script>
    import { mapState, mapMutations, mapGetters } from 'vuex';

    export default {
        props: ['isModal'],
        data() {
            return {
                exerciceDTO:{},
                error:{isError:false, message:''}
            }
        },     
        computed:{
            ...mapState(['lstVariantes', 'lstObjectifs', 'exerciceStoreDTO', 'imgBase64']),
            ...mapGetters(['getNameTypeById'])                  
        },
        methods: {
            addExerciceToList(exercice){
                if(!this.isFormValide()){
                    return;
                }

                if(!this.isModal){
                    const formData = new FormData();
                    formData.append("image", exercice.image.value);
                    formData.append("principe", exercice.principe.value);              
                    formData.append("time", exercice.time.value.toLowerCase());
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
                    
                    
                    axios.post('/exercice/create', formData, {headers:{'Content-Type': 'multipart/form-data'}}).then(reponse =>{
                        console.log(reponse);
                        let exercice = reponse.data.exercice;
                        this.$router.push({name: 'DetailExercice', params: { exercice }});
                    }).catch(error =>{
                        console.log(error);
                    }); 
                }else{
                    let exerciceAdd = {
                        image:exercice.image.value,
                        principe:exercice.principe.value,
                        sousPrincipe:exercice.sousPrincipe.value ? exercice.sousPrincipe.value : '',
                        time:exercice.time.value,
                        nbJoueurs:exercice.nbJoueurs.value,
                        description:exercice.description.value,
                        observations:exercice.observations.value ? exercice.observations.value : '',
                        url:exercice.url.value ? exercice.url.value : '',
                        typesexcercice_id:exercice.typesexcercice_id.value,
                        type_exercice : {
                            nom:this.getNameTypeById(exercice.typesexcercice_id.value)
                        },
                        physique:exercice.physique.value ? exercice.physique.value : '',
                        private:exercice.private.value,
                        lstVariantes:this.lstVariantes,
                        lstObjectifs:this.lstObjectifs,
                        newAdded:true,
                        imageBase64:this.imgBase64
                    };
                    this.addExercice(exerciceAdd);
                    this.$root.$emit('closeModalCustom');
                    this.setImgBase64(undefined);
                }                     
            },
            annuler(){
                this.setUpdateForm(false); //set the updateForm variable to false
                this.initExerciceDTO(); 
                window.history.back();
            },
            initExerciceDTO(){
                this.initExerciceStoreDTO();
                this.clearListObjectifs(); //clear list objectifs 
                this.clearListVariantes(); //clear list variantes 
                this.exerciceDTO = this.exerciceStoreDTO;
                this.exerciceDTO.typesexcercice_id.value = 1;
                this.exerciceDTO.typesexcercice_id.validate = true; 
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
            ...mapMutations(['addExercice', 'initExerciceStoreDTO', 'setImgBase64', 'setUpdateForm', 'clearListVariantes', 'clearListObjectifs'])  
        },
        beforeCreate(){
        },
        created() {
            this.exerciceDTO = this.exerciceStoreDTO;
            //setter le type par defaut
            this.exerciceDTO.typesexcercice_id.value = 1;
            this.exerciceDTO.typesexcercice_id.validate = true; 
        },
        mounted() {        
            this.$root.$on('setExerciceDTO', () =>{
                this.initExerciceDTO();
            });

            this.setUpdateForm(true);

            this.$root.$on('discardFormChanges', () =>{
                this.initExerciceDTO();
                this.setUpdateForm(false);
                this.$root.$emit('goToLink');
            });
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../public/css/forms';
</style>

