<template>
    <div class="add-activite modal-btn">
        <button class="btn btn-soccer-coach-action-list"  data-toggle="modal" :data-target="'#modalUpdateActivite' + activite.id" @click="openModal()"><i class="ti-pencil"></i></button>
        <div :id="'modalUpdateActivite' + activite.id" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-if="!isMatch">Modifier un entraînement</h4>
                        <h4 class="modal-title" v-else>Modifier un match</h4>
                        <button type="button" class= "close btn-close" :id="'closemodalUpdateActivite' + activite.id" @click="closeModal()">&times;</button>              
                    </div>
                    <div class="modal-body">                     
                        <div class="form-add-activite">
                            <div class="form-group">
                                <label for="nomAct"><span v-if="activiteDTO.nom.validations.require"> * </span> Nom:</label>
                                <input-text placeholder="Ex: Pratique/Match" v-model="activiteDTO.nom.value" name="nomAct"
                                        :model="activiteDTO.nom" @validation="activiteDTO.nom.validate = $event"/>
                            </div>
                            <div class="form-group">
                                <label for="time"><span> * </span> Date:</label>
                                <VueCtkDateTimePicker v-model="activiteDTO.dateDebut.value" locale="fr" format="YYYY-MM-DD" formatted="ll"
                                    color="#03aca4" label="Sélectionner une date" button-color="#03aca4"
                                    button-now-translation="Aujourd'hui" :right="true" :auto-close="true" :only-date="true" id="dateDebutAct"/>
                            </div>                 
                            <div class="form-group">
                                <label for="time"><span> * </span> Heure:</label>
                                <VueCtkDateTimePicker v-model="activiteDTO.heureDebut.value" locale="fr" format="hh:mm a" formatted="hh:mm a"
                                    color="#03aca4" label="Sélectionner l'heure" button-color="#03aca4" minute-interval="10"
                                    :only-time="true" :right="true" :auto-close="true" id="heureDebutAct"/>
                            </div>
                            <div class="form-group" v-if="isMatch">
                                <label for="adversaire"><span> * </span> Adversaire:</label>
                                <input-autocomplete :lst-items="lstEquipes" :value-default="activite.adversaire" @select="activiteDTO.adversaire.value = $event" placeholder="Ex: Équipe A"/>
                            </div>
                            <div class="form-group">
                                <label for="tempsAct"><span v-if="activiteDTO.temps.validations.require"> * </span> Durée:</label>
                                <input-text placeholder="Ex: 1h30" v-model="activiteDTO.temps.value" name="tempsAct"
                                        :model="activiteDTO.temps" @validation="activiteDTO.temps.validate = $event"/>
                            </div>
                            <div class="form-group">
                                <label for="arrivalAct"><span v-if="activiteDTO.arrival.validations.require"> * </span> Arriver:</label>
                                <input-text placeholder="Ex: 45min" v-model="activiteDTO.arrival.value" name="arrivalAct"
                                        :model="activiteDTO.arrival" @validation="activiteDTO.arrival.validate = $event"/>
                            </div>
                            <div class="terrain">
                                <label>Terrain</label>
                                <div class="form-group">
                                    <label for="nomTerrain"><span> * </span> Nom:</label>
                                    <input-autocomplete :lst-items="lstNomsTerrains" :value-default="activite.nomTerrain" @select="nomTerrain = $event" placeholder="Ex: Terrain A"/>
                                </div>
                                <div class="form-group">
                                    <label for="nomTerrain">Adresse 1:</label>
                                    <input-text placeholder="Ex: 2020 rue Manchester" v-model="activiteDTO.terrain.adresseLigne1.value" name="nomTerrain"
                                            :model="activiteDTO.terrain.adresseLigne1" @validation="activiteDTO.terrain.adresseLigne1.validate = $event"/>
                                </div>
                                <div class="form-group">
                                    <label for="adrLgn2Ter">Adresse 2:</label>
                                    <input-text placeholder="Ex: App 2" v-model="activiteDTO.terrain.adresseLigne2.value" name="adrLgn2Ter"
                                            :model="activiteDTO.terrain.adresseLigne2" @validation="activiteDTO.terrain.adresseLigne2.validate = $event"/>
                                </div>
                                <div class="form-group">
                                    <label for="codePostalTer"> Code postal:</label>
                                    <input-text placeholder="Ex: G2L 1M9" v-model="activiteDTO.terrain.codePostal.value" name="codePostalTer"
                                            :model="activiteDTO.terrain.codePostal" @validation="activiteDTO.terrain.codePostal.validate = $event"/>
                                </div>
                                <div class="form-group">
                                    <label for="urlTer"> URL:</label>
                                    <input-text placeholder="Ex: https://goo.gl/maps/4j4Sbi1uLbQuKz928" v-model="activiteDTO.terrain.url.value" name="urlTer"
                                            :model="activiteDTO.terrain.url" @validation="activiteDTO.terrain.url.validate = $event"/>
                                </div>
                            </div> 
                            <div class="btn-action-exercices">
                                <div class="btns">
                                    <a class="btn btn-soccer-coach-action" @click="updateActivite()" v-if="!isMatch"><i class="ti-plus"></i> Modifier entraînement</a>
                                    <a class="btn btn-soccer-coach-action" @click="updateActivite()" v-else><i class="ti-plus"></i> Modifier match</a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState, mapMutations } from 'vuex' 
    export default {
        props:['activite', 'indexAct', 'isMatch'],
        data(){
            return{
                activiteDTO:{
                    nom:{
                        value:undefined,
                        validations:{
                            require:true
                        },
                        validate:false
                    },
                    type:{
                        value:undefined,
                        validations:{
                            require:true
                        },
                        validate:true
                    },
                    dateDebut:{
                        value:undefined,
                        validations:{
                            require:true
                        },
                        validate:true
                    },
                    heureDebut:{
                        value:undefined,
                        validations:{
                            require:true
                        },
                        validate:true
                    },
                    arrival:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    },
                    temps:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    },
                    adversaire:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    },
                    terrain:{
                        nom:{
                            value:undefined,
                            validate:true
                        },
                        adresseLigne1:{
                            value:undefined,
                            validate:true
                        },
                        adresseLigne2:{
                            value:undefined,
                            validate:true
                        },
                        codePostal:{
                            value:undefined,
                            validate:true
                        },
                        url:{
                            value:undefined,
                            validate:true
                        }
                    },
                },
                type:this.isMatch ? 'match' : 'pratique',
                lstTerrains:[],
                lstEquipes:[],
                lstNomsTerrains:[],
                nomTerrain:'',
                idTerrainSelected:undefined,
            }
        },
        watch:{
            nomTerrain() {
                let terrainSelected = this.lstTerrains.find(terrain => terrain.nom === this.nomTerrain);
                if(terrainSelected){
                    this.activiteDTO.terrain.nom.value = terrainSelected.nom;
                    this.activiteDTO.terrain.adresseLigne1.value = terrainSelected.adresse_ligne1;
                    this.activiteDTO.terrain.adresseLigne2.value = terrainSelected.adresse_ligne2;
                    this.activiteDTO.terrain.codePostal.value = terrainSelected.code_postal;
                    this.activiteDTO.terrain.url.value = terrainSelected.url_terrain;
                    this.idTerrainSelected = terrainSelected.id;
                }else{
                    this.activiteDTO.terrain.nom.value = this.nomTerrain;
                }
            },
        },
        computed:{
        },
        methods:{
            updateActivite(){

                let params = {
                    id:this.activite.id,
                    nom:this.activiteDTO.nom.value,
                    type:this.type,
                    dateDebut:this.activiteDTO.dateDebut.value,
                    heureDebut:this.activiteDTO.heureDebut.value,
                    time:this.activiteDTO.temps.value,
                    arrival:this.activiteDTO.arrival.value,
                    adversaire:this.activiteDTO.adversaire.value,
                    equipe:this.activite.equipe_id,
                    terrain : {
                        nom:this.activiteDTO.terrain.nom.value,
                        adresseLigne1:this.activiteDTO.terrain.adresseLigne1.value,
                        adresseLigne2:this.activiteDTO.terrain.adresseLigne2.value,
                        codePostal:this.activiteDTO.terrain.codePostal.value,
                        urlTerrain:this.activiteDTO.terrain.url.value,
                    }
                };


                let terrainIdParam = this.activite.terrain_id;

                //vérifier si c'est un nouveau terrain 
                if(this.idTerrainSelected && this.idTerrainSelected !== this.activite.terrain_id){
                    terrainIdParam = this.idTerrainSelected;
                }

                //setter id terrain
                params.terrain.id = terrainIdParam;

                axios.post("/equipes/updateActivite", params).then(response =>{
                    if(this.isMatch){
                        this.deleteMatch(this.indexAct);
                        let activiteAdded = {
                            id:this.activite.id,
                            date_debut:params.dateDebut,
                            nom:params.nom,
                            heure_debut:params.heureDebut,
                            nomTerrain:params.terrain.nom,
                            time:params.time,
                            adversaire:params.adversaire,
                            urlTerrain:params.terrain.urlTerrain,
                            adresseLigne1:params.terrain.adresseLigne1,
                            adresseLigne2:params.terrain.adresseLigne2,
                            codePostalTerrain:params.terrain.codePostal,                         
                            terrain_id:response.data.idTerrain,
                            idTerrain:response.data.idTerrain,
                            equipe_id:this.activite.equipe_id,
                        };
                        this.addMatchToList(activiteAdded);
                        this.$root.$emit('setMatchLocalStorage');
                    }else{
                        this.deletePratique(this.indexAct);
                        let activiteAdded = {
                            id:this.activite.id,
                            date_debut:params.dateDebut,
                            nom:params.nom,
                            heure_debut:params.heureDebut,
                            nomTerrain:params.terrain.nom,
                            time:params.time,
                            urlTerrain:params.terrain.urlTerrain,                      
                            adresseLigne1:params.terrain.adresseLigne1,
                            adresseLigne2:params.terrain.adresseLigne2,
                            codePostalTerrain:params.terrain.codePostal,
                            terrain_id:response.data.idTerrain,
                            idTerrain:response.data.idTerrain,
                            equipe_id:this.activite.equipe_id,
                        };
                        this.addPratiqueToList(activiteAdded);
                        this.$root.$emit('setPratiqueLocalStorage'); 
                    }

                    this.closeModal();
                });
                        
            },
            formValid(){
                let values = Object.values(this.joueurDTO);

                let valueNotValidate = values.find(value => !value.validate);

                if(valueNotValidate){
                    this.$root.$emit('formInvalid'); 
                    return false;
                }
                return true;
            },
            openModal(){
            },
            closeModal(){
                $("#modalUpdateActivite" + this.activite.id).modal("hide");
            },
            ...mapMutations(['addMatchToList', 'deleteMatch', 'addPratiqueToList', 'deletePratique']),
        },
        created(){

            //récupérer la liste de terrains et la liste des équipes disponibles
            if(localStorage.getItem('terrains') && localStorage.getItem('equipesMatchs')){
                this.lstTerrains = JSON.parse(localStorage.getItem('terrains'));
                this.lstEquipes = JSON.parse(localStorage.getItem('equipesMatchs'));
                this.lstNomsTerrains = this.lstTerrains.map((terrain) =>{ return terrain.nom});
            }else{
                axios.get('/equipes/get-terrains-and-equipes').then(response =>{
                    this.lstTerrains = response.data.terrains;
                    this.lstEquipes = response.data.equipes;
                    this.lstNomsTerrains = this.lstTerrains.map((terrain) =>{ return terrain.nom});

                    //add terrains to local storage
                    const terrainsParsed = JSON.stringify(this.lstTerrains);
                    localStorage.setItem('terrains', terrainsParsed);

                    //add equipes to local storage
                    const equipesMatchsParsed = JSON.stringify(this.lstEquipes);
                    localStorage.setItem('equipesMatchs', equipesMatchsParsed);
                });
            }

            //initialiser les valeurs du activiteDTO
            this.activiteDTO.nom.value = this.activite.nom;
            this.activiteDTO.dateDebut.value = this.activite.date_debut;
            this.activiteDTO.heureDebut.value = this.activite.heure_debut;
            this.activiteDTO.type.value = this.activite.type;
            this.activiteDTO.temps.value = this.activite.time;
            this.activiteDTO.arrival.value = this.activite.arrival;
            this.activiteDTO.adversaire.value = this.activite.adversaire;
            this.activiteDTO.terrain.nom.value = this.activite.nomTerrain;
            this.activiteDTO.terrain.adresseLigne1.value = this.activite.adresseLigne1;
            this.activiteDTO.terrain.adresseLigne2.value = this.activite.adresseLigne2;
            this.activiteDTO.terrain.codePostal.value = this.activite.codePostalTerrain;          
            this.activiteDTO.terrain.url.value = this.activite.urlTerrain;
        },
        mounted(){
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/forms';
    @import '../../../../public/css/modals/addJoueur';
    @import '../../../../public/css/modals/addActivite';
</style>