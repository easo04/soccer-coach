<template>
    <div class="form-group objectifs-list-group">
        <ul>
            <li v-for="objectif in displayedLstObjectifs" :key="objectif.id">
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
    import { mapState, mapMutations, mapActions } from 'vuex'
    
    export default {
        props: ['objectifsExercice'],
        data() {
            return {
                mapCategorieObjectis: [],
                lstIdObjectifs:[]
            }
        },       
        computed:{     
            displayedLstObjectifs(){
                let lstObjectifsToShow = [];
                this.lstAllObjectifs.forEach(obj => {            
                    obj.selected = this.lstIdObjectifs.includes(obj.id);
                    lstObjectifsToShow.push(obj);                 
                });
                return lstObjectifsToShow
            },  
            ...mapState(['lstObjectifs', 'lstAllObjectifs']),                         
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
            ...mapMutations(['addObjectifToList', 'deleteObjectifToList', 'clearListObjectifs', 'initListObjectifs']),
            ...mapActions(['loadAllObjectifs'])
        },
        mounted() {
            //initialiser la liste d'objectifs
            this.loadAllObjectifs();

            //initiliser la liste des objectifs si on la recoit en parametre
            if(this.objectifsExercice !== undefined && this.objectifsExercice.length > 0){

                //vérifier s'il y a des objectifs qui doivent être sélectionnés
                this.lstIdObjectifs = this.objectifsExercice.map((obj) => { return obj.id; });

                //initilaiser la liste dans le state
                this.initListObjectifs(this.lstIdObjectifs);
            }
        },
        updated(){
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../public/css/objectifs-exercices-select';
</style>

