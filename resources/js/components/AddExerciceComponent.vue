<template>
  <div class="update-exercice-form">
      <form class="form-horizontal panel" @submit.prevent="addExercice(exerciceDTO)">
        <div class="actions-exercice-detail">
            <div class="btns">
                <button class="btn btn-soccer-coach-action" @click="annuler"><i class="ti-close"></i> Annuler</button>
                <button type="submit" class="btn btn-soccer-coach-action"><i class="ti-pencil"></i> Sauvegarder</button>
            </div>
        </div>
        <div class="row details-exercice">
            <div class="col-sm-6 details-exercice-info">
                <div class="form-group">
                    <label for="principe"><i class="ti-flag-alt color-soccer-coach"></i> Principe:</label>
                    <input type="text" class="form-control" placeholder="Ex: Conservation 4vs4 plus joker" v-model="exerciceDTO.principe"/>
                </div>
                <div class="form-group">
                    <label for="sousPrincipe"> <i class="ti-flag color-soccer-coach"></i> Sous-principes:</label>
                    <input type="text" class="form-control" placeholder="Ex: Contrôple du ballon, Orientation du corps" v-model="exerciceDTO.sousPrincipe"/>
                </div>
                <div class="form-group">
                    <label for="description"> <i class="ti-direction color-soccer-coach"></i> Description:</label>
                    <textarea class="form-control" placeholder="Description" v-model="exerciceDTO.description"/>
                </div>
                <div class="form-group">
                    <label for="physique"><i class="ti-heart color-soccer-coach"></i> Physique:</label>
                    <input type="text" class="form-control" placeholder="Ex: Resistance, rapidité, cardio" v-model="exerciceDTO.physique"/>
                </div> 
                <div class="form-group form-check">                 
                    <label class="container-label">
                        <i class="ti-key color-soccer-coach"></i> Privée<input type="checkbox" v-model="exerciceDTO.private">  <span class="checkmark"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label for="type"><i class="ti-flag-alt-2 color-soccer-coach"></i> Type d'exercice</label>
                    <types-exercices-select v-bind:types="types" v-bind:id-type-selected="exerciceDTO.typesexcercice_id" v-model="exerciceDTO.typesexcercice_id"/>
                </div>     
            </div>
            <div class="col-sm-6 details-exercice-image">
                <div class="form-group">
                        <label for="time"> <i class="ti-timer color-soccer-coach"></i> Durée:</label>
                        <input type="text" class="form-control" placeholder="Ex: 20min" v-model="exerciceDTO.time"/>
                </div>    
                <div class="form-group">
                        <label for="nbJoueurs"> <i class="ti-user color-soccer-coach"></i> Nombre de joueurs:</label>
                        <input type="number" class="form-control"  v-model="exerciceDTO.nbJoueurs"/>
                </div>  
                <div class="form-group">
                        <label for="observations"><i class="ti-eye color-soccer-coach"></i> Observations:</label>
                        <textarea class="form-control" placeholder="Observations" v-model="exerciceDTO.observations"/>
                </div> 
                <div class="form-group">
                        <label for="url"><i class="ti-link color-soccer-coach"></i> URL: <a href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover"><i class="ti-help-alt"></i></a></label>
                        <input type="text" class="form-control" placeholder="Ex: http:/youtube.com" v-model="exerciceDTO.url"/>
                </div>
                <label for="image"><i class="ti-image color-soccer-coach"></i> Image</label>
                <image-upload v-bind:image="exerciceDTO.image" id-image="1" @imageUploaded="exerciceDTO.image = $event"/>     
            </div>
        </div>
        </form>
        <add-variables/> 
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        props: ['types'],
        data() {
            return {
                exerciceDTO:{},
            }
        },     
        computed:{
            ...mapState(['lstVariantes'])                     
        },
        methods: {
            addExercice(exercice){
           
                const formData = new FormData();
                formData.append("image", exercice.image);
                formData.append("principe", exercice.principe);              
                formData.append("time", exercice.time);
                formData.append("nbJoueurs", exercice.nbJoueurs);
                formData.append("description", exercice.description);
                formData.append("typesexcercice_id", exercice.typesexcercice_id);
                this.lstVariantes.forEach((item) => {
                    formData.append('lstVariables[]', JSON.stringify(item));
                });
                formData.append("sousPrincipe", exercice.sousPrincipe ? exercice.sousPrincipe : '');             
                formData.append("physique", exercice.physique ? exercice.physique : '');
                formData.append("observations", exercice.observations ? exercice.observations : '');      
                formData.append("url", exercice.url ? exercice.url : '');
                formData.append("private", exercice.private);
                
                   
                axios.post('/exercice/create', formData, {headers:{'Content-Type': 'multipart/form-data'}}).then(reponse =>{
                    console.log(reponse);
                    let exerciceId =  reponse.data.exerciceId;
                    window.location.replace("/exercice/" + exerciceId);
                }).catch(error =>{
                    console.log(error);
                });        
            },
            annuler(){
                window.history.back();
            }
        },
        mounted() {
            //ajouter icon à chaque type de la liste
        }
    }
</script>

<style lang="scss" scoped>
</style>

