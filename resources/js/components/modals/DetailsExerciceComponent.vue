<template>
    <div class="details-exercice-modal">
        <button type="button" class="btn btn-soccer-coach" data-toggle="modal" :data-target="'#modalDetailsExe' +index" @click="openModal()">Détails</button>
        <div :id="'modalDetailsExe'+index" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" v-if="exerciceDTO">
                    <div class="modal-header">
                        <h4 class="modal-title">{{exerciceDTO.principe}}</h4>
                        <button type="button" class= "close btn-close" :id="'closeModalDetailExe'+index" data-dismiss="modal" @click="closeModal()">&times;</button>              
                    </div>
                    <div class="modal-body">
                        <span><span class="label">Description:</span> {{exerciceDTO.description}}</span><br>
                        <span v-if="exerciceDTO.time"><span class="label">Durée:</span> {{exerciceDTO.time}}</span><br>
                        <span v-if="exerciceDTO.nbJoueurs"><span class="label">Nombre de joueurs:</span> {{exerciceDTO.nbJoueurs}}</span><br>
                        <span v-if="exerciceDTO.type_exercice && exerciceDTO.type_exercice.nom"><span class="label">Type:</span> {{exerciceDTO.type_exercice.nom}}</span>                  
                        <span v-if="exerciceDTO.observations"><br><span class="label">Observations:</span> {{exerciceDTO.observations}}</span>
                        <span v-if="exerciceDTO.physique"><br><span class="label">Objectifs physiques:</span> {{exerciceDTO.physique}}</span>
                        <span v-if="exerciceDTO.objectifs && exerciceDTO.objectifs.length !== 0">
                            <br><span class="label">Objectifs:</span>
                            <span v-for="(objectif, index) in exerciceDTO.objectifs" :key="objectif.id">
                                <span v-if="index === nbObjectifs">
                                    {{objectif.nom}}
                                </span>
                                <span v-else>
                                    {{objectif.nom}} ,
                                </span>
                            </span>
                        </span>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['exercice', 'index'],
    data() {
        return {
            exerciceDTO:this.exercice,
            nbObjectifs: this.exercice.objectifs ? this.exercice.objectifs.length - 1 : 0
        }
    },  
    computed:{
    },
    methods:{
        closeModal(){
        },
        openModal(){
        }
    },
    mounted(){
        console.log('details exercice modal' + this.exercice.objectifs)
    }

}
</script>

<style lang="scss" scoped>
    @import '../../../../public/css/modals/details-exercice-modal';
</style>