<template>
    <div class="mon-club">
        <div class="loading">
            <bounce  color="17b87d" v-show="isLoading"></bounce>
        </div>
        <div v-if="!isLoading && clubData">
            <div class="club">
                <div class="actions-club-detail">
                    <div class="btns">                
                        <router-link :to="{ name: 'UpdateClub', params: { 'club': clubData } }" class="btn btn-soccer-coach-action"><i class="ti-pencil"></i> Modifier</router-link>                    
                    </div>
                </div>
                <div class="info-club">
                    <h4>{{clubData.nom}}</h4>
                    <div class="data-club">
                        <div class="adresse-club" v-if="showAddress()">
                            <span class="block label">Adresse:</span>
                            <span class="block">{{clubData.adresse_ligne1}}</span>
                            <span class="block" v-if="clubData.adresse_ligne2">{{clubData.adresse_ligne2}}</span>
                            <span class="block">{{clubData.code_postal}}</span>
                            <span class="block">{{clubData.ville}}, {{clubData.province}}</span>
                        </div> 
                        <span class="no-tel" v-if="clubData.no_telephone">
                            <span class="label">Téléphone:</span> {{clubData.no_telephone}}
                        </span>
                    </div>
                    <div class="lst-equipes">
                        <div class="actions">
                            <div class="btn-create-equipe">
                                <router-link :to="{ name: 'CreateEquipe', params: { 'from': 'club', 'clubId': clubData.id } }" class="btn btn-soccer-coach-action"><i class="ti-plus"></i> Ajouter une équipe</router-link>
                            </div>
                        </div> 
                        <h5><i class="fa fa-cubes color-soccer-coach"></i> Équipes du club</h5>
                        <list-equipes :lst-equipes="lstEquipes" :by-club="true" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState, mapMutations, mapGetters } from 'vuex'  
    export default {
        props:['club'],
        data(){
            return{
                isLoading: true,
                clubData: undefined,
                lstEquipes: []
            }
        },
        computed:{
        },
        methods:{
            showAddress(){
                return this.clubData.adresse_ligne1 && this.clubData.code_postal && this.clubData.ville 
                    && this.clubData.province;
            },
        },
        mounted(){
            if(!this.club){
                axios.get('/user/get-infos-my-club').then(response =>{
                    this.clubData = response.data.club;
                    this.lstEquipes = response.data.equipes;
                    this.clubData.lstEquipes = this.lstEquipes;
                    this.isLoading = false;
                }).catch(error =>{
                    console.log(error);
                    this.isLoading = false;
                });
            }else{
                this.clubData = this.club;
                this.lstEquipes = this.club.lstEquipes;
                this.isLoading = false;
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/clubs/details-club';
</style>                                 