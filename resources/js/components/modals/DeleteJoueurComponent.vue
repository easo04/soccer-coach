<template>
    <div class="modal-delete-joueur modal-btn">
        <button class="btn btn-soccer-coach-action-list" data-toggle="modal" :data-target="'#modalDeletePlayer'+joueur"><i class="ti-trash"></i></button>
        <div :id="'modalDeletePlayer'+joueur" class="modal fade modalUpdateForm" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Attention</h4>          
                    </div>
                    <div class="modal-body">
                        Voulez-vous supprimer le joueur <span>{{nom}}</span>?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-soccer-coach-action btn-non" @click="closeModal()">Non</button>
                        <button class="btn btn-soccer-coach-action btn-oui" @click="deleteJoueurToList()">Oui</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState, mapMutations } from 'vuex' 
export default {
    props:['joueur', 'indexJoueur', 'nom'],
    methods:{
        closeModal(){
            console.log('#modalDeletePlayer'+this.joueur);
            $("#modalDeletePlayer"+this.joueur).modal("hide");
        },
        deleteJoueurToList(){
            let parm = {
                idJoueur:this.joueur
            };
            axios.post('/equipes/deleteJoueur', parm).then(response =>{  
                this.deleteJoueur(this.indexJoueur);
                this.closeModal();
                this.$root.$emit('setJoueurLocalStorage');
            });
        },
        ...mapMutations(['deleteJoueur'])
    }
}
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/modals/updateFormModal';
</style>