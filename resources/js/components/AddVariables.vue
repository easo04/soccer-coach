<template>
    <div class="add-variables">
        <div class="form-add-variable" v-if="showAddVariable">
            <div class="actions-exercice-detail">                  
                <div class="btns">
                    <button class="btn btn-soccer-coach-action btn-annuler" @click="toutAnnuler" v-if="showAnnulerBtn"><i class="ti-close"></i> Annuler</button>
                </div>
            </div>  
            <div class="row">           
                <div class="col-sm-6 details-exercice-info">
                    <form @submit.prevent="addVariable" class="form-horizontal panel">
                        <div class="form-group input-sm">
                            <label for="time"> <i class="ti-timer color-soccer-coach"></i><span v-if="variable.time.validations.require"> * </span> Durée:</label>
                            <div class="temps-input">
                                <input-number placeholder="Ex: 20" v-model="variable.time.value" name="time" 
                                    :model="variable.time" @validation="variable.time.validate = $event"/>
                                <div class="temps-chexbox">
                                    <div class="type-item">
                                        <input type="radio" id="control_min_v" name="typeTempsV" value="min" v-model="variable.typeTemps.value">
                                        <label for="control_min_v">
                                            <div class="details-type">
                                                <p class="value">min</p>                
                                            </div>
                                        </label>
                                    </div>
                                    <div class="type-item">
                                        <input type="radio" id="control_h_v" name="typeTempsV" value="h" v-model="variable.typeTemps.value">
                                        <label for="control_h_v">
                                            <div class="details-type">
                                                <p class="value">h</p>                
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="form-group"> 
                            <label for="description"><i class="ti-pin-alt color-soccer-coach"></i><span v-if="variable.description.validations.require"> * </span> Description de la variante</label>                  
                            <text-area placeholder="Description de la variante ..." name="description" custom-class="textarea-variante" v-model="variable.description.value" 
                                :model="variable.description" @validation="variable.description.validate = $event"/>
                        </div>
                        <button class="btn btn-soccer-coach-action" type="submit"><i class="ti-plus"></i> Ajouter variante</button>
                    </form>
                </div>                  
                <div class="col-sm-6">
                    <span class="titre-variantes"><i class="ti-pin-alt color-soccer-coach"></i> Variantes</span><br>
                    <div class="lst-variables">     
                        <div class="aucune-variante" v-if="lstVariantes.length === 0">Aucune variante</div>
                        <div class="variante-item" v-for="(variante, index) in lstVariantes" :key="index">
                            <div class="item-header">                   
                                Variante #{{index+1}} - 
                                <span><i class="ti-timer color-soccer-coach"></i> {{variante.time}}</span>      
                                <button class="btn-soccer-coach btn-delete" @click="deleteVariante(index)"><i class="ti-trash"></i></button>                  
                            </div>
                            <div class="item-body row" v-if="variante.image">
                                <div class="col-sm-6">{{variante.description}}</div>
                                <div class="col-sm-6 img-variante"><img :id="'image-variante' + index" src=""/></div>                                                       
                            </div>
                            <div class="item-body" v-else>
                                {{variante.description}}
                            </div>
                        </div>
                    </div>
                </div>                
            </div>        
        </div>
        <div class="btn-show-form-variable" v-else>
            <button class="btn btn-soccer-coach-action" @click="showFormAddVariable"><i class="ti-pin-alt"></i> Ajouter variante</button>
        </div>      
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {
        props: ['variantes'],
        data() {
            return {
                lstAddNewVariantes:[],
                variable:{},
                showAddVariable:false,
                showAnnulerBtn:true,
                nbVariantes:0,
            }
        },
        computed:{
            ...mapState(['lstVariantes', 'varianteDTO'])                     
        },
        methods: {
            addVariable(){
                if(!this.isFormValide()){
                    return;
                }

                this.nbVariantes++;
                let varianteItem = {
                    description:this.variable.description.value,
                    image:this.variable.image.value,
                    time:this.variable.time.value + this.variable.typeTemps.value, 
                };

                this.initVariableDTO();

                this.lstAddNewVariantes.push(varianteItem);
                this.addVariableToList(varianteItem);
            },
            showFormAddVariable(){
                this.showAddVariable = true;
            },
            toutAnnuler(){
                this.showAddVariable = false; 
                this.lstAddNewVariantes = [];
                this.initVariableDTO();
                this.clearListVariantes();
            },
            deleteVariante(index){
                this.deleteVarianteToList(index);
                this.nbVariantes--;
            },
            initVariableDTO(){
                this.variable.description.value = undefined;
                this.variable.time.value = undefined;
                this.variable.image.value = undefined;
                this.variable.description.validate = false;
                this.variable.time.validate = false;
                this.variable.image.validate = true;
            },
            uploadImg(image, index){
                let FR= new FileReader();
                FR.addEventListener("load", function(e) {
                    let srcFile = e.target.result;             
                    $('#image-variante'+index)[0].src = srcFile;
                });
                FR.readAsDataURL(image);
            },
            isFormValide(){
                let isValid = true;
                let values = Object.values(this.variable);

                let valueNotValidate = values.find(value => !value.validate);
                if(valueNotValidate){
                    this.$root.$emit('formInvalid'); 
                    return false;
                }
                return true;
            },
            ...mapMutations(['addVariableToList', 'deleteVarianteToList', 'clearListVariantes'])
        },
        mounted() {
            this.variable = this.varianteDTO;
            this.variable.typeTemps = {
                value : 'min',
                validate:true,
            };
            if(this.variantes && this.variantes.length > 0){
                this.showAddVariable = true;
                this.showAnnulerBtn = false;
                this.variantes.forEach(variante => {
                    this.addVariableToList(variante);
                });
            }   
            console.log('lst variantes');
            console.log(this.variantes);
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../public/css/forms';
    @import '../../../public/css/add-variables';
</style>

