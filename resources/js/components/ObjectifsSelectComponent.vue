<template>
    <div class="form-group objectifs-list-group">
        <ul>
            <li v-for="objectif in lstObjectifsToShow" :key="objectif.id">
            <label>
                <input type="checkbox" :name="objectif.nom_url" @click="addObjectif(objectif.id)" :checked="objectif.selected">
                <div class="icon-box">
                    {{objectif.nom}}
                </div>
            </label>
            </li>
        </ul> 
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'
    
    export default {
        props: ['objectifs', 'objectifsExercice'],
        data() {
            return {
                lstObjectifsToShow: [],
                mapCategorieObjectis: [],
            }
        },       
        computed:{
            ...mapState(['lstObjectifs'])                     
        },
        methods: {
            addObjectif(name){
                console.log(name);
                if(!this.lstObjectifs.includes(name)){
                    this.addObjectifToList(name);
                }else{
                    let index = this.lstObjectifs.indexOf(name);
                    this.deleteObjectifToList(index);
                }            
            },
            ...mapMutations(['addObjectifToList', 'deleteObjectifToList', 'clearListObjectifs', 'initListObjectifs'])
        },
        mounted() {
            let lstIdObjectifs = [];

            //initiliser la liste des objectifs si on la recoit en parametre
            if(this.objectifsExercice !== undefined && this.objectifsExercice.length > 0){

                //vérifier s'il y a des objectifs qui doivent être sélectionnés
                lstIdObjectifs = this.objectifsExercice.map((obj) => { return obj.id; });

                //initilaiser la liste dans le state
                this.initListObjectifs(lstIdObjectifs);
            }

            this.objectifs.forEach(obj => {            
                obj.selected = lstIdObjectifs.includes(obj.id);
                this.lstObjectifsToShow.push(obj);                 
            });
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../public/css/objectifs-exercices-select';
</style>

