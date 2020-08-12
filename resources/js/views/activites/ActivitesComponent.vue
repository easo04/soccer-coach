<template>
    <div class="mes-activites">
        <div class="loading">
            <bounce  color="17b87d" v-show="isLoading"></bounce>
        </div>
        <div v-if="!isLoading">
            <h3>MES ACTIVITÉS À VENIR</h3>
            <div class="lst-activites" :class="{'lst-vide' : lstActivites.length === 0}">
                <span class="aucune-activite" v-if="lstActivites.length === 0">Aucune activité</span>
                <div class="activite-item" v-for="(activite, indexActi) in displayedActivites" :key="indexActi">
                    <div v-if="activite.type === 'pratique'">
                        <div class="details-activite">                                       
                            <span class="nom">{{activite.nom}}</span> 
                            <a class="nom terrain" :href="activite.urlTerrain"  target="_blank" v-if="activite.urlTerrain">@ {{activite.nomTerrain}}</a>
                            <span class="nom terrain" v-else> @ {{activite.nomTerrain}}</span>
                        </div> 
                        <div class="date-activite">
                            <span class="date-debut">{{activite.date_debut}}</span> à
                            <span class="heure-debut">{{activite.heure_debut}}</span>
                            <span class="time" v-if="activite.time !== ''">(Durée {{activite.time}})</span>
                        </div> 
                    </div>
                    <div v-else>
                        <div class="details-activite">                                       
                            <span class="nom">{{activite.nom}}</span> contre 
                            <span class="nom">{{activite.adversaire}}</span>
                            <a class="nom terrain" :href="activite.urlTerrain" target="_blank" v-if="activite.urlTerrain">@ {{activite.nomTerrain}}</a>
                            <span class="nom terrain" v-else> @ {{activite.nomTerrain}}</span>
                        </div> 
                        <div class="date-activite">
                            <span class="date-debut">{{activite.date_debut}}</span> à
                            <span class="heure-debut">{{activite.heure_debut}}</span>
                            <span class="time" v-if="activite.time !== ''">(Durée {{activite.time}})</span>
                        </div> 
                    </div>
                </div>
            </div>
            <nav>
                <ul class="pagination">
                    <li class="page-item">
                        <button type="button" class="page-link" v-if="page != 1" @click="page--"><i class="ti-angle-double-left"></i></button>
                    </li>
                    <li class="page-item">
                        <button type="button" class="page-link" v-for="pageNumber in pages.slice(page-1, page+5)" :key="pageNumber" @click="page = pageNumber"> {{pageNumber}} </button>
                    </li>
                    <li class="page-item">
                        <button type="button" @click="page++" v-if="page < pages.length" class="page-link"><i class="ti-angle-double-right"></i></button>
                    </li>
                </ul>
            </nav>  
        </div>
    </div>
</template>
<script>
    import {mapState, mapActions} from 'vuex'
    export default {
        data(){
            return{
                lstActivites:[],
                page: 1,
                perPage: 9,
                pages: [],
                isLoading:true
            }
        },
        methods:{
            initPages(){
                this.page = 1;
                this.perPage = 9;
                this.pages = [];
            },
            setPages () {
                let numberOfPages = Math.ceil(this.lstActivites.length / this.perPage);
                if(numberOfPages > 1){
                    for (let index = 1; index <= numberOfPages; index++) {
                        this.pages.push(index);
                    }
                }
            },
            paginate (activites) {
                let page = this.page;
                let perPage = this.perPage;
                let from = (page * perPage) - perPage;
                let to = (page * perPage);
                return  activites.slice(from, to);
            },
        },
        computed: {
            displayedActivites () {
                return this.paginate(this.lstActivites);
            },
        },
        watch: {
            lstActivites () {
                this.setPages();
            }
        },
        filters: {
            trimWords(value){
                return value.split(" ").splice(0,20).join(" ") + '...';
            }
        },
        mounted(){
            this.isLoading = true;
            //récupérer la liste de favoris
            axios.get('/user/get-activites-by-user').then(reponse =>{
                this.lstActivites = reponse.data.activites;
                this.isLoading = false;
            }).catch(error =>{
                console.log(error);
                this.isLoading = false;
            });
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/activites/mes-activites';
</style>