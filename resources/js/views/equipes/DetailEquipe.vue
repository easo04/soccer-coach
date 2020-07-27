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
                                <div class="item-joueur" v-for="(joueur, index) in displayListJoueurs" :key="index">
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
                                                <update-joueur-modal :joueur="joueur" :indexJoueur="index" />
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
                                <div class="item-joueur" v-for="(entraineur, indexE) in displayListEntraineurs" :key="indexE">
                                    <div class="nom d-joueur">
                                        <span>{{entraineur.nom}}</span>
                                    </div> 
                                    <div class="positions d-joueur">
                                        <span class="position">{{entraineur.role}}</span>
                                    </div> 
                                    <div class="d-joueur">
                                        <div class="btn-actions-joueur">
                                            <div class="btns">
                                                <update-entraineur-modal :entraineur="entraineur" :indexEntraineur="indexE" />
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
                                        <create-activite-modal :equipe="equipeDetail" :is-match="false" />
                                    </div>
                                </div> 
                                <div class="item-joueur" :class="{'with-seance' : pratique.seance_id}" v-for="(pratique, indexP) in displayListPratiques" :key="indexP">
                                    <div class="d-joueur-g">                          
                                        <div class="details-activite">                                       
                                            <span class="nom">{{pratique.nom}}</span> 
                                            <a class="nom terrain" :href="pratique.urlTerrain"  target="_blank" v-if="pratique.urlTerrain">@ {{pratique.nomTerrain}}</a>
                                            <span class="nom terrain" v-else> @ {{pratique.nomTerrain}}</span>
                                        </div> 
                                        <div class="date-activite">
                                            <span class="date-debut">{{pratique.date_debut}}</span> à
                                            <span class="heure-debut">{{pratique.heure_debut}}</span>
                                            <span class="time" v-if="pratique.time !== ''">(Durée {{pratique.time}})</span>
                                        </div> 
                                        <div class="seance" v-if="pratique.seance_id">
                                            <span class="nom">Séance: </span>
                                            <a @click="goToSeance(pratique.seance)">
                                                {{pratique.theme}}
                                            </a>
                                        </div> 
                                    </div>     
                                    <div class="d-joueur-s">
                                        <div class="btn-actions-joueur">
                                            <div class="btns">
                                                <button class="btn btn-soccer-coach-action-list" @click="updateJoueur(pratique)"><i class="fa fa-group"></i></button>
                                                <add-seance-modal :activite="pratique" :indexAct="indexP"/>
                                                <update-activite-modal :activite="pratique" :indexAct="indexP" :isMatch="false"/>
                                                <delete-activite-modal :activite="pratique" :indexActivite="indexP" />
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
                                        <create-activite-modal :equipe="equipeDetail" :is-match="true" />
                                    </div>
                                </div> 
                                <div class="item-joueur" v-for="(match, indexM) in lstMatchs" :key="indexM">
                                    <div class="nom d-joueur-g">
                                        <div class="details-activite">                                       
                                            <span class="nom">{{match.nom}}</span> contre 
                                            <span class="nom">{{match.adversaire}}</span>
                                            <a class="nom terrain" :href="match.urlTerrain" target="_blank" v-if="match.urlTerrain">@ {{match.nomTerrain}}</a>
                                            <span class="nom terrain" v-else> @ {{match.nomTerrain}}</span>
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
                                                <update-activite-modal :activite="match" :indexAct="indexM" :isMatch="true"/>
                                                <delete-activite-modal :activite="match" :indexActivite="indexM" />
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
            displayListJoueurs(){
                return this.lstJoueurs.sort((a,b) =>(a.nom > b.nom ? 1 : -1));
            },
            displayListEntraineurs(){
                return this.lstEntraineurs.sort((a,b) =>(a.nom > b.nom ? 1 : -1));
            },
            displayListPratiques(){
                return this.lstPratiques.sort((a,b) =>(new Date(a.date_debut) > new Date(b.date_debut) ? 1 : -1));
            },
            displayListMatchs(){
                return this.lstMatchs.sort((a,b) =>(new Date(a.date_debut) > new Date(b.date_debut) ? 1 : -1));
            },
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
            goToSeance(seance){
                this.$router.push({name: 'DetailSeance', params: {'seance': seance, 'equipe':this.equipeDetail, 'fromEquipe':true}});
            },
            ...mapMutations(['setJoueurList', 'setEntraineurList', 'setMatchsList', 'setPratiquesList',
                'clearJoueurList', 'clearEntraineurList', 'clearMatchList', 'clearPratiqueList', 'clearMesSeances'])
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
                location.reload();
            });

            this.$root.$on('setEntraineurLocalStorage', () =>{
                //add entraineur to local storage
                this.equipeDetail.lstEntraineurs = this.lstEntraineurs;
                const equipeParsed = JSON.stringify(this.equipeDetail);
                localStorage.setItem('equipeLocale', equipeParsed);
                location.reload();
            });

            this.$root.$on('setPratiqueLocalStorage', () =>{
                //add pratique to local storage
                this.equipeDetail.lstPratiques = this.lstPratiques;
                const equipeParsed = JSON.stringify(this.equipeDetail);
                localStorage.setItem('equipeLocale', equipeParsed);
                location.reload();
            });

            this.$root.$on('setMatchLocalStorage', () =>{
                //add match to local storage
                this.equipeDetail.lstMatchs = this.lstMatchs;
                const equipeParsed = JSON.stringify(this.equipeDetail);
                localStorage.setItem('equipeLocale', equipeParsed);
                location.reload();
            });
        },
        beforeDestroy(){
            this.clearJoueurList();
            this.clearEntraineurList();
            this.clearPratiqueList();
            this.clearMatchList();
            this.clearMesSeances();
            localStorage.removeItem('equipeLocale');
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../../public/css/equipes/detail-equipe';
    @import '../../../../public/css/modals/updateFormModal';
</style>
