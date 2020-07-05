<template>
    <div class="modal-delete-joueur">
        <button class="btn btn-soccer-coach-action-list" data-toggle="modal" :data-target="'#modalDeleteCoach'+entraineur"><i class="ti-trash"></i></button>
        <div :id="'modalDeleteCoach'+entraineur" class="modal fade modalUpdateForm" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Attention</h4>          
                    </div>
                    <div class="modal-body">
                        Voulez-vous supprimer l'entraîneur <span>{{nom}}</span>?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-soccer-coach-action btn-non" @click="closeModal()">Non</button>
                        <button class="btn btn-soccer-coach-action btn-oui" @click="deleteEntraineurToList()">Oui</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState, mapMutations } from 'vuex' 
export default {
    props:['entraineur', 'indexEntraineur', 'nom'],
    methods:{
        closeModal(){
            console.log('#modalDeleteCoach'+this.entraineur);
            $("#modalDeleteCoach"+this.entraineur).modal("hide");
        },
        deleteEntraineurToList(){
            let parm = {
                idEntraineur:this.entraineur
            };
            axios.post('/equipes/deleteEntraineur', parm).then(response =>{  
                this.deleteEntraineur(this.indexEntraineur);
                this.closeModal();
                this.$root.$emit('setEntraineurLocalStorage');
            });
        },
        ...mapMutations(['deleteEntraineur'])
    }
}
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/modals/updateFormModal';
</style>