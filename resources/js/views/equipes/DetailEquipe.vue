<template>
    <div class="detail-equipe">
        <div class="loading">
            <bounce  color="17b87d" v-show="isLoading"></bounce>
        </div>
        <div v-if="!isLoading">
            <div class="contenu-exercices">
                <div class="actions-exercice-detail">
                    <div class="btn-mes-exercices">
                        <a class="btn btn-soccer-coach-action" @click="back"> <i class="fa fa-cubes"></i> Mes équipes</a>
                    </div>
                    <div class="btns">                
                        <router-link :to="{ name: 'UpdateEquipe', params: { 'equipe': this.equipeDetail } }" class="btn btn-soccer-coach-action"><i class="ti-pencil"></i> Modifier</router-link>
                        <a class="btn btn-soccer-coach-action" data-toggle="modal" data-target="#modalDeleteEquipe"><i class="ti-trash"></i> Supprimer</a>                      
                    </div>
                </div>
                <div class="info-equipe">
                    <h4>{{equipeDetail.nom}}</h4>
                    <div class="saison-equipe" v-if="equipeDetail.saison">
                        <div>
                            <span class="nom-saison">{{equipeDetail.saison.nom}}</span>
                        </div>
                        <span class="debut-saison" v-if="equipeDetail.saison.date_debut"><span class="label">Début: </span>{{equipeDetail.saison.date_debut}}</span>
                        <span class="fin-saison" v-if="equipeDetail.saison.date_fin"><span class="label">Fin: </span>{{equipeDetail.saison.date_fin}}</span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#joueurs">Joueurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#entraineurs">Entraîneurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#entrainements">Entraînements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#matchs">Matchs</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane container active" id="joueurs">
                            <div class="lst-joueurs">
                                <div class="btn-ajouter">
                                    <div class="btn-rigth">                                    
                                        <create-joueur-modal :from-detail="true" :equipe="equipeDetail.id"/>
                                    </div> 
                                </div> 
                                <div class="item-joueur" v-if="lstJoueurs.length > 0">
                                    <div class="d-joueur">
                                        <span class="position">Nom</span>
                                    </div> 
                                    <div class="d-joueur">
                                        <span class="position">Positions</span>
                                    </div> 
                                    <div class="d-joueur">
                                        <span class="position actions">Actions</span>   
                                    </div> 
                                </div> 
                                <div class="item-joueur" v-for="(joueur, index) in lstJoueurs" :key="index">
                                    <div class="nom d-joueur">
                                        <span>{{joueur.nom}}</span>
                                    </div> 
                                    <div class="positions d-joueur">
                                        <span class="position">{{joueur.position1}}</span>
                                        <span class="position" v-if="joueur.position2">/ {{joueur.position2}}</span>
                                        <span class="position" v-if="joueur.position3">/ {{joueur.position3}}</span>
                                    </div> 
                                    <div class="d-joueur">
                                        <div class="btn-actions-joueur">
                                            <div class="btns">
                                                <button class="btn btn-soccer-coach-action-list" @click="updateJoueur(joueur)"><i class="ti-pencil"></i></button>
                                                <delete-joueur-modal :joueur="joueur.id" :indexJoueur="index" :nom="joueur.nom" />
                                            </div> 
                                        </div>    
                                    </div> 
                                </div> 
                            </div> 
                        </div>
                        <div class="tab-pane container fade" id="entraineurs">
                            <div class="lst-joueurs">
                                <div class="btn-ajouter">
                                    <div class="btn-rigth">                                    
                                        <create-entraineur-modal :from-detail="true" :equipe="equipeDetail.id"/>
                                    </div> 
                                </div> 
                                <div class="item-joueur" v-if="lstEntraineurs.length > 0">
                                    <div class="d-joueur">
                                        <span class="position">Nom</span>
                                    </div> 
                                    <div class="d-joueur">
                                        <span class="position">Rôle</span>
                                    </div> 
                                    <div class="d-joueur">
                                        <span class="position actions">Actions</span>   
                                    </div> 
                                </div> 
                                <div class="item-joueur" v-for="(entraineur, indexE) in lstEntraineurs" :key="indexE">
                                    <div class="nom d-joueur">
                                        <span>{{entraineur.nom}}</span>
                                    </div> 
                                    <div class="positions d-joueur">
                                        <span class="position">{{entraineur.role}}</span>
                                    </div> 
                                    <div class="d-joueur">
                                        <div class="btn-actions-joueur">
                                            <div class="btns">
                                                <button class="btn btn-soccer-coach-action-list" @click="updateJoueur(entraineur)"><i class="ti-pencil"></i></button>
                                                <delete-entraineur-modal :entraineur="entraineur.id" :indexEntraineur="indexE" :nom="entraineur.nom" />
                                            </div>
                                        </div>    
                                    </div> 
                                </div> 
                            </div> 
                        </div>
                        <div class="tab-pane container fade" id="entrainements">
                            <div class="lst-joueurs">
                                <div class="btn-ajouter">
                                    <div class="btn-rigth">     
                                        <button class="btn btn-soccer-coach-action" @click="ajouterJoueur()"><i class="ti-plus"></i> Ajouter</button>
                                    </div>
                                </div> 
                                <div class="item-joueur" :class="{'with-seance' : pratique.seance_id}" v-for="(pratique, indexP) in lstPratiques" :key="indexP">
                                    <div class="d-joueur-g">                          
                                        <div class="details-activite">                                       
                                            <span class="nom">{{pratique.nom}}</span> 
                                            <span class="nom terrain"> @ {{pratique.nomTerrain}}</span>
                                        </div> 
                                        <div class="date-activite">
                                            <span class="date-debut">{{pratique.date_debut}}</span> à
                                            <span class="heure-debut">{{pratique.heure_debut}}</span>
                                            <span class="time" v-if="pratique.time !== ''">(Durée {{pratique.time}})</span>
                                        </div> 
                                        <div class="seance" v-if="pratique.seance_id">
                                            <a @click="goToSeance(pratique.seance_id)">
                                                {{pratique.theme}}
                                            </a>
                                        </div> 
                                    </div>     
                                    <div class="d-joueur-s">
                                        <div class="btn-actions-joueur">
                                            <div class="btns">
                                                <button class="btn btn-soccer-coach-action-list" @click="updateJoueur(match)"><i class="fa fa-group"></i></button>
                                                <button class="btn btn-soccer-coach-action-list" @click="updateJoueur(match)"><i class="ti-pencil"></i></button>
                                                <button class="btn btn-soccer-coach-action-list" @click="deletePratique(pratique)"><i class="ti-trash"></i></button>
                                            </div>
                                        </div>    
                                    </div> 
                                </div> 
                            </div> 
                        </div>
                        <div class="tab-pane container fade" id="matchs">
                            <div class="lst-joueurs">
                                <div class="btn-ajouter">
                                    <div class="btn-rigth">     
                                        <button class="btn btn-soccer-coach-action" @click="ajouterJoueur()"><i class="ti-plus"></i> Ajouter</button>
                                    </div>
                                </div> 
                                <div class="item-joueur" v-for="(match, indexM) in lstMatchs" :key="indexM">
                                    <div class="nom d-joueur-g">
                                        <div class="details-activite">                                       
                                            <span class="nom">{{match.nom}}</span> contre 
                                            <span class="nom">{{match.adversaire}}</span>
                                            <span class="nom terrain"> @ {{match.nomTerrain}}</span>
                                        </div> 
                                        <div class="date-activite">
                                            <span class="date-debut">{{match.date_debut}}</span> à
                                            <span class="heure-debut">{{match.heure_debut}}</span>
                                            <span class="time" v-if="match.time !== ''">(Durée {{match.time}})</span>
                                        </div> 
                                    </div> 
                                    <div class="d-joueur-s">
                                        <div class="btn-actions-joueur">
                                            <div class="btns">
                                                <button class="btn btn-soccer-coach-action-list" @click="updateJoueur(match)"><i class="fa fa-group"></i></button>
                                                <button class="btn btn-soccer-coach-action-list" @click="updateJoueur(match)"><i class="fa fa-comment"></i></button>
                                                <button class="btn btn-soccer-coach-action-list" @click="updateJoueur(match)"><i class="ti-pencil"></i></button>
                                                <button class="btn btn-soccer-coach-action-list" @click="deleteJoueur(match)"><i class="ti-trash"></i></button>
                                            </div>
                                        </div>    
                                    </div> 
                                </div> 
                            </div> 
                        </div>
                    </div>         
                </div> 
            </div>
            <div class="modal fade modalUpdateForm" role="dialog" id="modalDeleteEquipe">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Supprimer équipe</h4>
                        </div>
                        <div class="modal-body">
                            Voulez-vous supprimer l'équipe <span>{{ equipeDetail.nom }}</span>?
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-soccer-coach-action btn-non" @click="closeModalDelete()">Non</button>
                            <button class="btn btn-soccer-coach-action btn-oui" @click="deleteEquipe()">Oui</button>
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
        props:['equipe', 'searchInfo'],
        data(){
            return{
                equipeDetail: this.equipe ? this.equipe : {},
                isLoading: this.searchInfo ? true : false,
            }
        },
        computed:{
            ...mapState(['lstJoueurs', 'lstEntraineurs', 'lstMatchs', 'lstPratiques']),
        },
        methods:{
            back(){
                this.$router.push('mes-equipes');
            },
            closeModalDelete(){
                $("#modalDeleteEquipe").modal("hide");
            },
            deleteEquipe(){
                axios.delete('/equipes/delete-equipe/' + this.equipeDetail.id).then(response =>{
                    this.closeModalDelete();
                    this.back();
                });
            },
            goToSeance(idSeance){

            },
            detailPratique(pratique){

            },
            deletePratique(pra){

            },
            deleteMatch(match){

            },
            ...mapMutations(['setJoueurList', 'setEntraineurList', 'setMatchsList', 'setPratiquesList',
                'clearJoueurList', 'clearEntraineurList', 'clearMatchList', 'clearPratiqueList'])
        },
        created(){
            //vérifier s'il y a déjà une équipe dans le locale storage
            if(localStorage.getItem('equipeLocale')){				
                this.equipeDetail = JSON.parse(localStorage.getItem('equipeLocale'));

                //set list to index store
                this.setJoueurList(this.equipeDetail.lstJoueurs);
                this.setEntraineurList(this.equipeDetail.lstEntraineurs);
                this.setMatchsList(this.equipeDetail.lstMatchs);
                this.setPratiquesList(this.equipeDetail.lstPratiques);

                this.isLoading = false;
            }else{
                if(this.searchInfo){
                    this.equipeDetail.lstJoueurs = [];
                    this.equipeDetail.lstEntraineurs = [];
                    this.equipeDetail.saison = {};
                    axios.get('/equipes/get-joueurs-and-saison-by-equipe/' + this.equipe.id).then(response =>{
                        this.equipeDetail.lstJoueurs = response.data.joueurs;
                        this.equipeDetail.lstEntraineurs = response.data.entraineurs;
                        this.equipeDetail.lstMatchs = response.data.matchs;
                        this.equipeDetail.lstPratiques = response.data.pratiques;
                        this.equipeDetail.saison = response.data.saison;
                        this.isLoading = false;

                        //set list to index store
                        this.setJoueurList(this.equipeDetail.lstJoueurs);
                        this.setEntraineurList(this.equipeDetail.lstEntraineurs);
                        this.setMatchsList(this.equipeDetail.lstMatchs);
                        this.setPratiquesList(this.equipeDetail.lstPratiques);

                        //add exercice to local storage
                        const equipeParsed = JSON.stringify(this.equipeDetail);
                        localStorage.setItem('equipeLocale', equipeParsed);
                    });
                }else{
                    this.isLoading = false;

                    //set list to index store
                    this.setJoueurList(this.equipeDetail.lstJoueurs);
                    this.setEntraineurList(this.equipeDetail.lstEntraineurs);               
                    this.setMatchsList(this.equipeDetail.lstMatchs);
                    this.setPratiquesList(this.equipeDetail.lstPratiques);

                    //add equipe to local storage
                    const equipeParsed = JSON.stringify(this.equipeDetail);
                    localStorage.setItem('equipeLocale', equipeParsed);
                }
            }
        },
        mounted(){
            this.$root.$on('setJoueurLocalStorage', () =>{
                //add joueur to local storage
                this.equipeDetail.lstJoueurs = this.lstJoueurs;
                const equipeParsed = JSON.stringify(this.equipeDetail);
                localStorage.setItem('equipeLocale', equipeParsed);
            });

            this.$root.$on('setEntraineurLocalStorage', () =>{
                //add entraineur to local storage
                this.equipeDetail.lstEntraineurs = this.lstEntraineurs;
                const equipeParsed = JSON.stringify(this.equipeDetail);
                localStorage.setItem('equipeLocale', equipeParsed);
            });

            this.$root.$on('setPratiqueLocalStorage', () =>{
                //add pratique to local storage
                this.equipeDetail.lstPratiques = this.lstPratiques;
                const equipeParsed = JSON.stringify(this.equipeDetail);
                localStorage.setItem('equipeLocale', equipeParsed);
            });

            this.$root.$on('setMatchLocalStorage', () =>{
                //add match to local storage
                this.equipeDetail.lstMatchs = this.lstMatchs;
                const equipeParsed = JSON.stringify(this.equipeDetail);
                localStorage.setItem('equipeLocale', equipeParsed);
            });
        },
        beforeDestroy(){
            this.clearJoueurList();
            this.clearEntraineurList();
            this.clearPratiqueList();
            this.clearMatchList();
            localStorage.removeItem('equipeLocale');
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/equipes/detail-equipe';
    @import '../../../../public/css/modals/updateFormModal';
</style>
