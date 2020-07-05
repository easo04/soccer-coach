export default {

	state: {

		lstVariantes: [], //garde la liste des variantes ajoutées
		lstObjectifs: [], //garde la liste des objectifs sélectionnés
		lstExercices:[], //garde la liste d'exercices ajoutés
		exerciceStore:{},
		errors:[], //garde la liste d'erreurs
		imgSelect:undefined,  //garde l'image sélectionnée dans le modal
		lstAllObjectifs:[], //tous les types d'objectifs
		lstAllTypes:[], //tous les types d'exercice
		exerciceAdd:{},
		lstJoueurs:[], //garde la liste des joueurs ajoutés
		lstEntraineurs:[], //garde la liste des entraineurs ajoutés
		lstMatchs:[], //garde la liste des matchs ajoutés
		lstPratiques:[], //garde la liste des pratiques ajoutés
		imgBase64:undefined, //garde l'image en base64
		lstIconsByType: [['principe-offensif', 'ti-target'], ['principe-defensif', 'ti-hummer'], ['rondos', 'ti-cup'], ['physique', 'ti-heart']],          
		lstIconsByCategorie:[{ name:'Offensive', icon:'ti-target', id:'off'}, { name:'Défensive', icon:'ti-hummer', id:'def'}, { name:'Tactique', icon:'fa fa-puzzle-piece', id:'tact'}, { name:'Technique', icon:'fa fa-rocket', id:'tec'},
		{ name:'Organisation du jeu', icon:'fa fa-users', id:'org-jeu'}, { name:'Gardien de but', icon:'fa fa-sign-language', id:'gar'}],
		updateForm:false,
		varianteDTO: {
            time:{
                value:undefined,
                validations:{
                    require:true
                },
                validate:false
            },
            description:{
                value:undefined,
                validations:{
                    require:true
                },
                validate:false
            },
            image:{
				value:'',
				validations:{
                    require:false
                },
                validate:true
			}
        },
        exerciceStoreDTO:{
			principe:{
				value:undefined,
                validations:{
					require:true,
					max:60,
                },
                validate:false
			},
			sousPrincipe:{
				value:undefined,
                validations:{
					require:false,
					max:60,
                },
                validate:true
			},
			description:{
				value:undefined,
                validations:{
					require:true,
					max:900,
                },
                validate:false
			},
			time:{
				value:undefined,
                validations:{
					require:true,				
					max:10
                },
                validate:false
			},
			physique:{
				value:undefined,
                validations:{
					require:false,
					max:60
                },
                validate:true
			},
			private:{
				value:undefined,
                validations:{
					require:false,
                },
                validate:true
			},
			typesexcercice_id:{
				value:undefined,
                validations:{
					require:true,
                },
                validate:false
			},
			nbJoueurs:{
				value:undefined,
                validations:{
					require:true,
                },
                validate:false
			},
			observations:{
				value:undefined,
                validations:{
					require:false,
					max:900,
                },
                validate:true
			},
			url:{
				value:undefined,
                validations:{
					require:false,
                },
                validate:true
			},
			image:{
				value:undefined,
                validations:{
					require:true,
                },
                validate:false
			}
		},
		seanceStoreDTO:{
			theme:{
				value:undefined,
				validations:{
					require:true,
					max:400
				},
				validate:false
			},
            endroit:{
				value:undefined,
				validations:{
					require:false,
				},
				validate:true
			},
            time:{
				value:undefined,
				validations:{
					require:false,
				},
				validate:false
			},
            context:{
				value:undefined,
				validations:{
					require:false,
					max:900
				},
				validate:true
			},
			effectif:{
				value:undefined,
				validations:{
					require:true,
				},
				validate:false
			},
			temps:{
				value:undefined,
				validations:{
					require:true,
					max:400
				},
				validate:false
			},
			categorie:{
				value:undefined,
				validations:{
					require:true,
				},
				validate:false
			},
		},
		equipeStoreDTO:{
			nom:{
                value:undefined,
                validations:{
                    require:true
                },
                validate:false
			},
			logo:{
				value:undefined,
                validations:{
                    require:false
                },
                validate:true
			},
			saison:{
				nom:{
					value:undefined,
					validations:{
						require:true
					},
					validate:false
				},
				dateDebut:{
					value:undefined,
					validations:{
						require:true
					},
					validate:false
				},
				dateFin:{
					value:undefined,
					validations:{
						require:true
					},
					validate:false
				}
			}
		},
		positions:['G', 'DFC', 'DFD', 'DFG', 'MC', 'MOC', 'MD', 'MG', 'ATT', 'AG', 'AD', 'AC'],
		roles:['E','EA','EG','G','A','PP'],
	},
	getters: {
		getNameTypeById: (state) => (id) =>{
			return state.lstAllTypes.find(type => type.id === id).nom;
		},
		getIconByCategorie: (state) => (categorie) =>{
            return state.lstIconsByCategorie.find(c => c.name === categorie).icon;
		},
	},

	actions: {
		loadAll({state}){
			state.loadAllObjectifs();
			state.loadAllTypes();
		},
		loadAllObjectifs ({ commit, state }) {
			if(state.lstAllObjectifs.length === 0){
				//vérifier si la liste est déjà dans le local storage
				if(localStorage.getItem('lstAllObjetifsLocal')){				
					let lstObjLocal = JSON.parse(localStorage.getItem('lstAllObjetifsLocal'));
					commit('setAllObjectifs', lstObjLocal);		
				}else{
					axios.get('/objectifs').then(reponse =>{
						let lstObjResponse = reponse.data.objectifs;
						commit('setAllObjectifs', lstObjResponse);
						//add to local storage
						const parsed = JSON.stringify(lstObjResponse);
						localStorage.setItem('lstAllObjetifsLocal', parsed);
					}).catch(error =>{
						console.log(error);
					}); 
				}
			}
		},
		loadAllTypes({ commit, state }) {
			if(state.lstAllTypes.length === 0){	
				//vérifier si la liste est déjà dans le local storage
				if(localStorage.getItem('lstAllTypesLocal')){				
					let lstTypesLocal = JSON.parse(localStorage.getItem('lstAllTypesLocal'));
					commit('setAllTypes', lstTypesLocal);	
				}else{		
					let mapTypes = new Map(state.lstIconsByType);
					axios.get('/types-exercices').then(reponse =>{	
						reponse.data.types.forEach(type => {
							type.icon = mapTypes.get(type.urlNom);
							commit('addTypeToAllTypesList', type);					
						});
						//add to local storage
						const parsed = JSON.stringify(state.lstAllTypes);
						localStorage.setItem('lstAllTypesLocal', parsed);
					}).catch(error =>{
						console.log(error);
					});
				}  
			}
		},
		loadAllTypesWithTypes({ commit, state }, types){
			//vérifier si la liste est déjà dans le local storage
			if(localStorage.getItem('lstAllTypesLocal')){				
				let lstTypesLocal = JSON.parse(localStorage.getItem('lstAllTypesLocal'));
				commit('setAllTypes', lstTypesLocal);
			}else{
				let mapTypes = new Map(state.lstIconsByType);
				types.forEach(type => {
					type.icon = mapTypes.get(type.urlNom);
					commit('addTypeToAllTypesList', type);
				});
				//add to local storage
				const parsed = JSON.stringify(state.lstAllTypes);
				localStorage.setItem('lstAllTypesLocal', parsed);
			}
			
		}
	},
	mutations: {
		setUpdateForm(state, value){
			state.updateForm = value;
		},
		addVariableToList(state, variante){
			state.lstVariantes.push(variante);
		},
		deleteVarianteToList(state, index){
			state.lstVariantes.splice(index, 1);
		},
		clearListVariantes(state){
			state.lstVariantes = [];
		},
		addObjectifToList(state, objectif){
			state.lstObjectifs.push(objectif);
		},
		deleteObjectifToList(state, index){
			state.lstObjectifs.splice(index, 1);
		},
		clearListObjectifs(state){
			state.lstObjectifs = [];
		},
		initListObjectifs(state, objectifs){
			state.lstObjectifs = objectifs;
		},
		addError(state, error){
			state.errors.push(error);
		},
		deleteError(state, index){
			state.errors.splice(index, 1);
		},
		clearErrors(state){
			state.errors = [];
		},
		addExercice(state, exe){
			state.lstExercices.push(exe);
		},
		deleteExercice(state, index){
			state.lstExercices.splice(index, 1);
		},
		clearExercices(state){
			state.lstExercices = [];
		},
		setExercice(state, exercice){
			state.exerciceStore = exercice;
		},
		addObjectifToAllObjectifsList(state, objectif){
			state.lstAllObjectifs.push(objectif);
		},
		addTypeToAllTypesList(state, type){
			state.lstAllTypes.push(type);
		},
		setAllObjectifs(state, lstObjectifs){
			state.lstAllObjectifs = lstObjectifs;
		},
		setAllTypes(state, lstTypes){
			state.lstAllTypes = lstTypes;
		},
		setExerciceAdd(state, exercice){
			state.exerciceAdd = exercice;
		},
		initSeanceStoreDTO(state){
			state.seanceStoreDTO = {
				theme:{
					value:undefined,
					validations:{
						require:true,
						max:400
					},
					validate:false
				},
				endroit:{
					value:undefined,
					validations:{
						require:false,
						max:200
					},
					validate:false
				},
				time:{
					value:undefined,
					validations:{
						require:false,
					},
					validate:false
				},
				context:{
					value:undefined,
					validations:{
						require:false,
						max:900
					},
					validate:true
				},
				effectif:{
					value:undefined,
					validations:{
						require:true,
						max:400
					},
					validate:false
				},
				temps:{
					value:undefined,
					validations:{
						require:true,
						max:400
					},
					validate:false
				},
				categorie:{
					value:undefined,
					validations:{
						require:true,
						max:400
					},
					validate:false
				},
			}
		},
		initExerciceStoreDTO(state){
			state.exerciceStoreDTO = {
				principe:{
					value:undefined,
					validations:{
						require:true,
						max:60,
					},
					validate:false
				},
				sousPrincipe:{
					value:undefined,
					validations:{
						require:false,
						max:60,
					},
					validate:true
				},
				description:{
					value:undefined,
					validations:{
						require:true,
						max:900,
					},
					validate:false
				},
				time:{
					value:undefined,
					validations:{
						require:true,				
						max:10
					},
					validate:false
				},
				physique:{
					value:undefined,
					validations:{
						require:false,
						max:60
					},
					validate:true
				},
				private:{
					value:undefined,
					validations:{
						require:false,
					},
					validate:true
				},
				typesexcercice_id:{
					value:undefined,
					validations:{
						require:true,
					},
					validate:false
				},
				nbJoueurs:{
					value:undefined,
					validations:{
						require:true,
					},
					validate:false
				},
				observations:{
					value:undefined,
					validations:{
						require:false,
						max:900,
					},
					validate:true
				},
				url:{
					value:undefined,
					validations:{
						require:false,
					},
					validate:true
				},
				image:{
					value:undefined,
					validations:{
						require:true,
					},
					validate:false
				}
			};
		},
		setImgBase64(state, img){
			state.imgBase64 = img;
		},
		addJoueurToList(state, joueur){
			state.lstJoueurs.push(joueur);
		},
		deleteJoueur(state, index){
			state.lstJoueurs.splice(index, 1);
		},
		clearJoueurList(state){
			state.lstJoueurs = [];
		},
		addEntraineurToList(state, entraineur){
			state.lstEntraineurs.push(entraineur);
		},
		deleteEntraineur(state, index){
			state.lstEntraineurs.splice(index, 1);
		},
		clearEntraineurList(state){
			state.lstEntraineurs = [];
		},
		addPratiqueToList(state, pratique){
			state.lstPratiques.push(pratique);
		},
		deletePratique(state, index){
			state.lstPratiques.splice(index, 1);
		},
		clearPratiqueList(state){
			state.lstPratiques = [];
		},
		addMatchToList(state, match){
			state.lstMatchs.push(match);
		},
		deleteMatch(state, index){
			state.lstMatchs.splice(index, 1);
		},
		clearMatchList(state){
			state.lstMatchs = [];
		},
		setJoueurList(state, list){
			state.lstJoueurs = list;
		},
		setEntraineurList(state, list){
			state.lstEntraineurs = list;
		},
		setPratiquesList(state, list){
			state.lstPratiques = list;
		},
		setMatchsList(state, list){
			state.lstMatchs = list;
		}
	}
}