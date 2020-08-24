<template>
    <div class="lst-equipes-component">
        <h6>Nombre d'équipes: {{lstEquipes.length}}</h6>
        <div class="lst-equipes" :class="{'lst-vide' : lstEquipes.length === 0}">
            <span class="aucun-equipe" v-if="lstEquipes.length === 0 && !byClub">Aucune équipe</span>
            <div class="card-equipe" v-for="(equipe, index) in lstEquipes" :key="index">
                <div class="info-equipe">               
                    <div class="saison-equipe" v-if="equipe.nomSaison">
                        <h5>{{equipe.nom}}</h5>
                        <div>
                        <span class="nom-saison"> {{equipe.nomSaison}} - </span>
                        <span class="debut-saison" v-if="equipe.dateDebutSaison"><span class="label">Début: </span>{{equipe.dateDebutSaison}}</span>
                        <span class="fin-saison" v-if="equipe.dateFinSaison"><span class="label">Fin: </span>{{equipe.dateFinSaison}}</span>
                        </div>
                    </div>
                    <div v-else>
                        <h5>{{equipe.nom}}</h5>
                    </div> 
                </div>
                <div class="voir-equipe">
                    <router-link :to="{ name: 'DetailsEquipe', params: { equipe, 'searchInfo':true, 'from': byClub ? 'club':undefined} }" class="btn btn-block btn-soccer-coach">Voir</router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        props:['lstEquipes', 'byClub']
    }
</script>
<style lang="scss" scoped>
    @import '../../../public/css/equipes/list-equipes';
</style>                                      