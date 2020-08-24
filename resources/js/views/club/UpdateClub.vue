<template>
<div class="update-club">
    <form class="form-horizontal panel" @submit.prevent="updateClub(clubDTO)">
        <div class="actions-exercice-detail">
            <div class="btns">
                <a class="btn btn-soccer-coach-action" @click="annuler"><i class="ti-close"></i> Annuler</a>
            </div>
            <span class="msg-required">* indique que le champ est obligatoire</span>
        </div>
        
        <div class="details-club">        
            <div class="details-club-info">
                <div class="form-group">
                    <label for="nomClub"><span v-if="clubDTO.nom.validations.require"> * </span> Nom:</label>
                    <input-text placeholder="Ex: Club soccer les étoiles" v-model="clubDTO.nom.value" name="nomClub"
                            :model="clubDTO.nom" @validation="clubDTO.nom.validate = $event"/>
                </div>
                <div class="form-group">
                    <label for="adrLigne1Club"><span v-if="clubDTO.adresse.adrLigne1.validations.require"> * </span> Adresse ligne 1:</label>
                    <input-text placeholder="Ex: 2020 rue de Manchester" v-model="clubDTO.adresse.adrLigne1.value" name="adrLigne1Club"
                            :model="clubDTO.adresse.adrLigne1" @validation="clubDTO.adresse.adrLigne1.validate = $event"/>
                </div>
                <div class="form-group">
                    <label for="adrLigne2Club"><span v-if="clubDTO.adresse.adrLigne2.validations.require"> * </span> Adresse ligne 2:</label>
                    <input-text placeholder="Ex: App7" v-model="clubDTO.adresse.adrLigne2.value" name="adrLigne2Club"
                            :model="clubDTO.adresse.adrLigne2" @validation="clubDTO.adresse.adrLigne2.validate = $event"/>
                </div>
                <div class="form-group">
                    <label for="codePostalClub"><span v-if="clubDTO.adresse.codePostal.validations.require"> * </span> Code postal:</label>
                    <input-text placeholder="Ex: G2L 1K2" v-model="clubDTO.adresse.codePostal.value" name="codePostalClub"
                            :model="clubDTO.adresse.codePostal" @validation="clubDTO.adresse.codePostal.validate = $event"/>
                </div>
                <div class="form-group">
                    <label for="villeClub"><span v-if="clubDTO.adresse.ville.validations.require"> * </span> Ville:</label>
                    <input-text placeholder="Ex: Québec" v-model="clubDTO.adresse.ville.value" name="villeClub"
                            :model="clubDTO.adresse.ville" @validation="clubDTO.adresse.ville.validate = $event"/>
                </div>
                <div class="form-group">
                    <label for="provinceClub"><span v-if="clubDTO.adresse.province.validations.require"> * </span> Province:</label>
                    <input-text placeholder="Ex: Québec" v-model="clubDTO.adresse.province.value" name="provinceClub"
                            :model="clubDTO.adresse.province" @validation="clubDTO.adresse.province.validate = $event"/>
                </div>
                <div class="form-group">
                    <label for="telClub"><span v-if="clubDTO.telephone.validations.require"> * </span> Téléphone:</label>
                    <input-text placeholder="Ex: 418 806-2904" v-model="clubDTO.telephone.value" name="telClub"
                            :model="clubDTO.telephone" @validation="clubDTO.telephone.validate = $event"/>
                </div>
            </div>
        </div>
        <div class="btn-action-sauvegarder">
            <button type="submit" class="btn btn-soccer-coach-action btn-sauvegarder"><i class="ti-save"></i> Sauvegarder le club</button>
        </div>
    </form>
</div>
</template>
<script>
    import { mapState, mapMutations } from 'vuex' 
    export default {
        props:['club'],
        data(){
            return{               
                clubDTO:{
                    nom:{
                        value:undefined,
                        validations:{
                            require:true
                        },
                        validate:false
                    },
                    adresse:{
                        codePostal:{
                            value:undefined,
                            validations:{
                                require:false
                            },
                            validate:true
                        },
                        adrLigne1:{
                            value:undefined,
                            validations:{
                                require:false
                            },
                            validate:true
                        },
                        adrLigne2:{
                            value:undefined,
                            validations:{
                                require:false
                            },
                            validate:true
                        },
                        ville:{
                            value:undefined,
                            validations:{
                                require:false
                            },
                            validate:true
                        },
                        province:{
                            value:undefined,
                            validations:{
                                require:false
                            },
                            validate:true
                        },
                    },
                    telephone:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    }
                }
            }
        },
        methods:{
            annuler(){
                this.initFormInputs();
                this.$router.push({name: 'MonClub', params: {'club':this.club}}); //go to détail équipe
            },
            updateClub(clubDTO){
                if(this.isFormValid()){
                    return;
                }

                let params = {
                    id:clubDTO.id,
                    nom:clubDTO.nom.value,
                    adresseLigne1:clubDTO.adresse.adrLigne1.value,
                    adresseLigne2:clubDTO.adresse.adrLigne2.value,
                    codePostal:clubDTO.adresse.codePostal.value,
                    ville:clubDTO.adresse.ville.value,
                    province:clubDTO.adresse.province.value,
                    telephone:clubDTO.telephone.value,
                };
                axios.post('/club/update-club', params).then(response =>{

                    //mettre à jour e club avec les nouvelles informations
                    let clubUpdated = this.club;
                    clubUpdated.nom = params.nom;
                    clubUpdated.adresse_ligne1 = params.adresseLigne1;
                    clubUpdated.adresse_ligne2 = params.adresseLigne2;
                    clubUpdated.code_postal = params.codePostal;
                    clubUpdated.ville = params.ville;
                    clubUpdated.province = params.province;
                    clubUpdated.no_telephone = params.telephone;
                    this.$router.push({name: 'MonClub', params: {'club': clubUpdated}}); //go to détail équipe
                }).catch(error=>{
                    console.log(error);
                });
            },
            initFormInputs(){
                this.clubDTO = {
                    nom:{
                        value:undefined,
                        validations:{
                            require:true
                        },
                        validate:false
                    },
                    adresse:{
                        codePostal:{
                            value:undefined,
                            validations:{
                                require:false
                            },
                            validate:true
                        },
                        adrLigne1:{
                            value:undefined,
                            validations:{
                                require:false
                            },
                            validate:true
                        },
                        adrLigne2:{
                            value:undefined,
                            validations:{
                                require:false
                            },
                            validate:true
                        },
                        ville:{
                            value:undefined,
                            validations:{
                                require:false
                            },
                            validate:true
                        },
                        province:{
                            value:undefined,
                            validations:{
                                require:false
                            },
                            validate:true
                        },
                    },
                    telephone:{
                        value:undefined,
                        validations:{
                            require:false
                        },
                        validate:true
                    }
                }
            },
            isFormValid(){
                return true;
            },
            ...mapMutations(['setUpdateForm'])
        },
        created(){

            //vérifier s'il y a déjà un club dans le locale storage
            if(localStorage.getItem('detailsClub')){				
                this.clubDTO = JSON.parse(localStorage.getItem('detailsClub'));
            }else if(this.club){
                this.clubDTO.nom.value = this.club.nom;
                this.clubDTO.adresse.adrLigne1.value = this.club.adresse_ligne1;
                this.clubDTO.adresse.adrLigne2.value = this.club.adresse_ligne2;
                this.clubDTO.adresse.codePostal.value = this.club.code_postal;
                this.clubDTO.adresse.ville.value = this.club.ville;
                this.clubDTO.adresse.province.value = this.club.province;
                this.clubDTO.telephone.value = this.club.no_telephone;
                this.clubDTO.id = this.club.id;

                //add infos club to local storage
                const clubParsed = JSON.stringify(this.clubDTO);
                localStorage.setItem('detailsClub', clubParsed);
            }
        },
        mounted(){
            this.setUpdateForm(true);

            this.$root.$on('discardFormChanges', () =>{
                this.initFormInputs();
                this.setUpdateForm(false);
                this.$root.$emit('goToLink');
            });
        },
        beforeDestroy(){
            localStorage.removeItem('detailsClub');
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/forms';
    @import '../../../../public/css/clubs/update-club';
</style>                                    