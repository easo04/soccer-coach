<template>
    <div id="modalUpdateForm" class="modal fade modalUpdateForm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Attention</h4>          
                </div>
                <div class="modal-body">
                    Voulez-vous abandonner les modifications?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-soccer-coach-action btn-non" @click="closeModal()">Non</button>
                    <button class="btn btn-soccer-coach-action btn-oui" @click="discardChanges()">Oui</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:[],
    methods:{
        closeModal(){
            $("#modalUpdateForm").modal("hide");
        },
        discardChanges(){
            //send message to discard changes
            this.$root.$emit('discardFormChanges');
            this.closeModal();
        }
    }
}
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/modals/updateFormModal';
</style>