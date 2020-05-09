<template>
    <div class="list-objectifs-by-exercice row">
        <div class="categorie col-sm-3" :class="classCustom" v-for="(categorie, index) in mapCategorieObjectis" :key="index">
            <div class="categorie-nom"><h5>{{ categorie.categorie }}</h5></div>
            <div class="objectifs">
                <div v-if="setFilter">
                    <a @click="onMethodFilter(objectif.id);selectObjectif(objectif.id)" v-for="objectif in categorie.lstObjectifs" :key="objectif.id">
                        <div class="tag" :class="{'tag-selected' : objectif.isSelected || lstLastObjectifSelected.includes(objectif.id)}">
                            <span>{{ objectif.nom }}</span>
                        </div>
                    </a>
                </div>
                <div v-else>
                    <div class="tag" :class="{'tag-selected' : objectif.isSelected}" v-for="objectif in categorie.lstObjectifs" :key="objectif.id">
                        <span v-if="setUrl"><a :href="'/exercice/objectifs/' + objectif.nom_url" :alt="objectif.nom_url">{{ objectif.nom }}</a></span>
                        <span v-else-if="!setUrl">{{ objectif.nom }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['objectifs', 'objectifSelected', 'setUrl', 'setFilter', 'classCustom', 'onMethodFilter'],
        data(){
            return{
                lstObjectifs:this.objectifs,
                mapCategorieObjectis: [],
                lstLastObjectifSelected:[],
            }
        },
        methods:{
            selectObjectif(id){
                if(this.lstLastObjectifSelected.includes(id)){
                    let index = this.lstLastObjectifSelected.indexOf(id);
                    this.lstLastObjectifSelected.splice(index, 1);
                }else{
                    this.lstLastObjectifSelected.push(id);
                }               
            }
        },
        created: function () {
            
        },
        mounted() {

            this.$root.$on('filtredByType', () => {
                this.lstLastObjectifSelected = [];
            })

            let lstCategorieObjectifs = [];
            
            //construire liste de categories
            this.lstObjectifs.forEach(objectif => {
                if(!lstCategorieObjectifs.includes(objectif.categorie)){
                    lstCategorieObjectifs.push(objectif.categorie);
                }
            });

            let categorieObject;

            //construire le map de categories et ajouter la liste d'objectifs
            lstCategorieObjectifs.forEach(categorie => {
                let lstObjectifsParCategorie = [];
                this.lstObjectifs.forEach(objectif => {
                    if(categorie === objectif.categorie){
                        objectif.isSelected = objectif.nom_url === this.objectifSelected;
                        lstObjectifsParCategorie.push(objectif);
                    }
                });

                categorieObject = {
                    "categorie" : categorie,
                    "lstObjectifs" : lstObjectifsParCategorie
                }
                this.mapCategorieObjectis.push(categorieObject);        
            });

            console.log(this.mapCategorieObjectis);
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../public/css/list-objectifs-by-exercice';
</style>
