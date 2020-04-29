<template>
    <div class="add-variables">
        <div class="form-add-variable" v-if="showAddVariable">
            <form @submit.prevent="addVariable" class="form-horizontal panel">
                <div class="actions-exercice-detail">                  
                    <div class="btns">
                        <button class="btn btn-soccer-coach-action btn-annuler" @click="toutAnnuler" v-if="showAnnulerBtn"><i class="ti-close"></i> Annuler</button>
                        <button class="btn btn-soccer-coach-action" type="submit"><i class="ti-plus"></i> Ajouter variante</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 details-exercice-info">
                        <div class="form-group">
                            <label for="time"> <i class="ti-timer color-soccer-coach"></i> Durée:</label>
                            <input type="text" class="form-control" placeholder="Ex: 20min" v-model="variable.time"/>
                        </div>    
                        <div class="form-group"> 
                            <label for="description"><i class="ti-pin-alt color-soccer-coach"></i> Description de la variante</label>
                            <textarea placeholder="Description de la variante ..." name="description" class="form-control textarea-variante" v-model="variable.description" cols="50" rows="10"></textarea>                        
                        </div>
                    </div>
                    <div class="col-sm-6 details-exercice-info">
                        <label for="image"><i class="ti-image color-soccer-coach"></i> Image</label>
                        <image-upload id-image="2" class-image="sm-image" @imageUploaded="variable.image = $event"/>
                    </div>
                </div>
            </form>

            <div class="lst-variables">     
                <h5 v-if="lstVariantes.length > 0">Variantes</h5>
                <div class="variante-item" v-for="(variante, index) in lstVariantes" :key="index">
                        <div class="item-header">                   
                            Variante #{{index+1}} - 
                            <span><i class="ti-timer color-soccer-coach"></i> Durée: {{variante.time}}</span>      
                            <button class="btn-soccer-coach-action btn-delete" @click="deleteVariante(index)"><i class="ti-trash"></i></button>                  
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
                variable:{description:'', image:'', time:''},
                showAddVariable:false,
                showAnnulerBtn:true,
                nbVariantes:0,
            }
        },
        computed:{
            ...mapState(['lstVariantes'])                     
        },
        methods: {
            addVariable(){
                if(!this.isFormValide()){
                    return;
                }

                this.nbVariantes++;
                const varianteItem = {
                    description:this.variable.description,
                    image:this.variable.image,
                    time:this.variable.time
                };

                this.variable.description = '';
                this.variable.time = '';

                this.lstAddNewVariantes.push(varianteItem);
                this.addVariableToList(varianteItem);

                if(varianteItem.image != ''){
                    this.uploadImg(varianteItem.image, this.nbVariantes-1);
                }

            },
            showFormAddVariable(){
                this.showAddVariable = true;
            },
            toutAnnuler(){
               this.showAddVariable = false; 
               this.lstAddNewVariantes = [];
               this.variable.description = '';
               this.variable.time = '';
               this.variable.image = undefined;
               this.clearListVariantes();
            },
            deleteVariante(index){
                this.deleteVarianteToList(index);
                this.nbVariantes--;
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
                if(this.variable.description.trim() === '' && this.variable.description.trim() === ''){
                    return false;
                }
                return true;
            },
            ...mapMutations(['addVariableToList', 'deleteVarianteToList', 'clearListVariantes'])
        },
        mounted() {
            if(this.variantes && this.variantes.length > 0){
                this.showAddVariable = true;
                this.showAnnulerBtn = false;
                this.variantes.forEach(variante => {
                    this.addVariableToList(variante);
                });
            }   
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../public/css/add-variables';
</style>

