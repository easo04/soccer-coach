<template>
    <div class="mes-equipes">
        <div class="loading">
            <bounce  color="17b87d" v-show="isLoading"></bounce>
        </div>
        <div v-if="!isLoading">
            <div class="actions">
                <div class="btn-create-equipe">
                    <router-link to="create-equipe" class="btn btn-soccer-coach-action"><i class="ti-plus"></i> Créer une équipe</router-link>
                </div>
            </div>
            <h3>MES ÉQUIPES</h3>
            <h6>Nombre d'équipes: {{lstEquipes.length}}</h6>
            <div class="lst-equipes" :class="{'lst-vide' : lstEquipes.length === 0}">
                <span class="aucun-equipe" v-if="lstEquipes.length === 0">Aucun équipe</span>
                <div class="card-equipe" v-for="(equipe, index) in lstEquipes" :key="index">
                    <div class="info-equipe">
                        <h5>{{equipe.nom}}</h5>
                    </div>
                    <div class="voir-equipe">
                        <router-link :to="{ name: 'DetailsEquipe', params: { equipe, 'searchInfo':true} }" class="btn btn-block btn-soccer-coach">Voir</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState } from 'vuex';
export default {
    data(){
        return{
            isLoading:true,
            lstEquipes:[]
        }
    },
    mounted(){
        this.isLoading = true;
        axios.get('/equipes/get-equipes-by-user').then(response =>{
            this.isLoading = false;
            this.lstEquipes = response.data.equipes;
        });
    }
}
</script>
<style lang="scss" scoped>
        @import '../../../../public/css/equipes/mes-equipes';
</style>