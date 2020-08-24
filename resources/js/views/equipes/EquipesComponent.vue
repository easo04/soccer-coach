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
            <list-equipes :lst-equipes="lstEquipes" />
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