<template>
    <div class="add-activite">
        <button type="button" class="btn btn-soccer-coach-action btn-sauvegarder" data-toggle="modal" :data-target="'#modalAddActivite' + type" @click="openModal()"><i class="ti-plus"></i> Ajouter</button>
        <div :id="'modalAddActivite' + type" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-if="!isMatch">Créer un entraînement</h4>
                        <h4 class="modal-title" v-else>Créer un match</h4>
                        <button type="button" class= "close btn-close" :id="'closemodalAddActivite' + type" @click="closeModal()">&times;</button>              
                    </div>
                    <div class="modal-body">                     
                        <div class="form-add-activite">
                            <div class="form-group" v-if="!isMatch">
                                <label for="periode">Période:</label>
                                <div class="temps-input">
                                    <div class="temps-chexbox">
                                        <div class="type-item">
                                            <input type="radio" id="control_une_fois" name="periodeAct" value="une" v-model="activiteDTO.periode.value" selected="selected">
                                            <label for="control_une_fois">
                                                <div class="details-type">
                                                    <p class="value">Une seule fois</p>                
                                                </div>
                                            </label>
                                        </div>
                                        <div class="type-item">
                                            <input type="radio" id="control_hebdo" name="periodeAct" value="hebdo" v-model="activiteDTO.periode.value">
                                            <label for="control_hebdo">
                                                <div class="details-type">
                                                    <p class="value">Hebdomadaire</p>                
                                                </div>
                                            </label>
                                        </div>
                                        <div class="type-item">
                                            <input type="radio" id="control_deux" name="periodeAct" value="deux" v-model="activiteDTO.periode.value">
                                            <label for="control_deux">
                                                <div class="details-type">
                                                    <p class="value">Aux deux semaines</p>                
                                                </div>
                                            </label>
                                        </div>
                                        <div class="type-item">
                                            <input type="radio" id="control_mensuel" name="periodeAct" value="mensuel" v-model="activiteDTO.periode.value">
                                            <label for="control_mensuel">
                                                <div class="details-type">
                                                    <p class="value">Mensuel</p>                
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                            <div class="form-group">
                                <label for="nomAct"><span v-if="activiteDTO.nom.validations.require"> * </span> Nom:</label>
                                <input-text placeholder="Ex: Pratique/Match" v-model="activiteDTO.nom.value" name="nomAct"
                                        :model="activiteDTO.nom" @validation="activiteDTO.nom.validate = $event"/>
                            </div>
                            <div class="form-group">
                                <label for="time" v-if="showDateFin"><span> * </span> Date de début:</label>
                                <label for="time" v-else><span> * </span> Date:</label>
                                <VueCtkDateTimePicker v-model="activiteDTO.dateDebut.value" locale="fr" format="YYYY-MM-DD" formatted="ll"
                                    color="#03aca4" label="Sélectionner une date" button-color="#03aca4"
                                    button-now-translation="Aujourd'hui" :right="true" :auto-close="true" :only-date="true" id="dateDebutAct"/>
                            </div>
                            <div class="form-group" v-if="showDateFin">
                                <label for="timeFin"><span> * </span> Date de fin:</label>
                                <VueCtkDateTimePicker v-model="activiteDTO.dateFin.value" locale="fr" format="YYYY-MM-DD" formatted="ll"
                                    color="#03aca4" label="Sélectionner une date" button-color="#03aca4"
                                    button-now-translation="Aujourd'hui" :right="true" :auto-close="true" :only-date="true" id="dateDebutFin"/>
                            </div>                    
                            <div class="form-group">
                                <label for="time"><span> * </span> Heure:</label>
                                <VueCtkDateTimePicker v-model="activiteDTO.heureDebut.value" locale="fr" format="hh:mm a" formatted="hh:mm a"
                                    color="#03aca4" label="Sélectionner l'heure" button-color="#03aca4" minute-interval="10"
                                    :only-time="true" :right="true" :auto-close="true" id="heureDebutAct"/>
                            </div>
                            <div class="form-group" v-if="isMatch">
                                <label for="adversaire"><span> * </span> Adversaire:</label>
                                <input-autocomplete :lst-items="lstEquipes" @select="activiteDTO.adversaire.value = $event" placeholder="Ex: Équipe A"/>
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
                                    <input-autocomplete :lst-items="lstNomsTerrains" @select="nomTerrain = $event" placeholder="Ex: Terrain A"/>
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
                                    <a class="btn btn-soccer-coach-action" @click="addActivite()" v-if="!isMatch"><i class="ti-plus"></i> Ajouter entraînement</a>
                                    <a class="btn btn-soccer-coach-action" @click="addActivite()" v-else><i class="ti-plus"></i> Ajouter match</a>
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
        props:['equipe', 'isMatch'],
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
                    dateFin:{
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
                    periode:{
                        value:undefined,
                        validate:true
                    }
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
            showDateFin(){
                return this.activiteDTO.periode.value !== 'une';
            },
        },
        methods:{
            addActivite(){
                if(!this.formValid()){
                    return;
                }

                let activite = {
                    nom:this.activiteDTO.nom.value,
                    type:this.type,
                    dateDebut:this.activiteDTO.dateDebut.value,
                    heureDebut:this.activiteDTO.heureDebut.value,
                    time:this.activiteDTO.temps.value,
                    arrival:this.activiteDTO.arrival.value,
                    adversaire:this.activiteDTO.adversaire.value,
                    dateFin:this.activiteDTO.dateFin.value,
                    equipe:this.equipe.id,
                    saisonId:this.equipe.saison ? this.equipe.saison.id : undefined,
                    periode:this.activiteDTO.periode.value,
                    terrain:{
                        id: this.idTerrainSelected ? this.idTerrainSelected : undefined,
                        nom:this.activiteDTO.terrain.nom.value,
                        adresseLigne1:this.activiteDTO.terrain.adresseLigne1.value,
                        adresseLigne2:this.activiteDTO.terrain.adresseLigne2.value,
                        codePostal:this.activiteDTO.terrain.codePostal.value,
                        urlTerrain:this.activiteDTO.terrain.url.value,
                    }
                };

                axios.post("/equipes/createActivite", activite).then(response =>{
                    let lstActivites = response.data.activites;

                    //vérifier si c'est un match ou une pratique
                    if(this.isMatch){
                        let activiteAdded = {
                            id:lstActivites[0],
                            date_debut:activite.dateDebut,
                            nom:activite.nom,
                            heure_debut:activite.heureDebut,
                            nomTerrain:activite.terrain.nom,
                            time:activite.time,
                            adversaire:activite.adversaire,
                            urlTerrain:activite.terrain.urlTerrain,                          
                            equipe_id:this.equipe.id,

                        };
                        this.addMatchToList(activiteAdded);
                        this.$root.$emit('setMatchLocalStorage');
                    }else{      
                        //ajouter chaque pratique dans la liste de pratiques qui est dans le store
                        lstActivites.forEach(idActivite => {
                            let activiteAdded = {
                                id:idActivite,
                                date_debut:activite.dateDebut,
                                nom:activite.nom,
                                heure_debut:activite.heureDebut,
                                nomTerrain:activite.terrain.nom,
                                time:activite.time,
                                urlTerrain:activite.terrain.urlTerrain,                          
                                equipe_id:this.equipe.id,
                            };
                            this.addPratiqueToList(activiteAdded);
                        });
                        this.$root.$emit('setPratiqueLocalStorage');  
                    }
                    
                    this.closeModal();
                });
            },
            formValid(){
                return true;
            },
            initActiviteDTO(){
                this.activiteDTO = {
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
                    dateFin:{
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
                    periode:{
                        value:undefined,
                        validate:true
                    }
                };
            },
            openModal(){
                //this.$root.$emit('setExerciceDTO');
            },
            closeModal(){
                this.initActiviteDTO();
                $("#modalAddActivite" + this.type).modal("hide");
            },
            ...mapMutations(['addPratiqueToList', 'addMatchToList']),
        },
        created(){
            this.activiteDTO.periode = {
                value : 'une',
                validate:true,
            };

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
        },
        mounted(){
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/forms';
    @import '../../../../public/css/modals/addActivite';
</style>