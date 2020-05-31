<template>
    <div class="add-exercice-modal">
        <button type="button" class="btn btn-soccer-coach-action btn-sauvegarder" data-toggle="modal" data-target="#modalAddExe" @click="openModal()"><i class="ti-plus"></i> Nouvel exercice </button>
        <div id="modalAddExe" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Créer un exercice</h4>
                        <button type="button" class= "close btn-close" id="closeModalAddExe" @click="closeModal()">&times;</button>              
                    </div>
                    <div class="modal-body">                     
                        <add-exercice-form :isModal="true"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    methods:{
        openModal(){
            this.$root.$emit('setExerciceDTO');
        },
        closeModal(){
            $("#modalAddExe").modal("hide");
        }
    },
    mounted(){
        this.$root.$on('closeModalCustom', () =>{
            this.closeModal();
        });       
    }
}
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/modals/addExerciceModal';
</style>