<template>
    <div class="modal-delete-joueur">
        <button class="btn btn-soccer-coach-action-list" data-toggle="modal" :data-target="'#modalDeleteActivite'+activite.id"><i class="ti-trash"></i></button>
        <div :id="'modalDeleteActivite'+activite.id" class="modal fade modalUpdateForm" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Attention</h4>          
                    </div>
                    <div class="modal-body" v-if="activite.type === 'match'">
                        Voulez-vous supprimer le match <span>{{activite.nom}}</span> du {{activite.date_debut}} contre 
                        <span>{{activite.adversaire}}</span>?
                    </div>
                    <div class="modal-body" v-else>
                        Voulez-vous supprimer l'entraînement <span>{{activite.nom}}</span> du {{activite.date_debut}}?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-soccer-coach-action btn-non" @click="closeModal()">Non</button>
                        <button class="btn btn-soccer-coach-action btn-oui" @click="deleteActiviteToList()">Oui</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState, mapMutations } from 'vuex' 
export default {
    props:['activite', 'indexActivite', 'nom'],
    methods:{
        closeModal(){
            console.log('#modalDeleteActivite'+this.activite.id);
            $("#modalDeleteActivite"+this.activite.id).modal("hide");
        },
        deleteActiviteToList(){
            let parm = {
                idActivite:this.activite.id
            };
            axios.post('/equipes/deleteActivite', parm).then(response =>{ 
                if(this.activite.type === 'match'){
                    this.deleteMatch(this.indexActivite);
                    this.$root.$emit('setPratiqueLocalStorage');
                }else{
                    this.deletePratique(this.indexActivite);
                    this.$root.$emit('setMatchLocalStorage');
                }
                this.closeModal();
            });
        },
        ...mapMutations(['deleteMatch', 'deletePratique'])
    }
}
</script>
<style lang="scss" scoped>
    @import '../../../../../public/css/modals/updateFormModal';
</style>