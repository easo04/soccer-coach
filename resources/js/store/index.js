export default {

	state: {

		lstVariantes: [],
		lstObjectifs: [],
		errors:[],     
		imgSelect:undefined,  
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
        }
	},

	getters: {
	},

	actions: {

	},
	mutations: {
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
		}
	}
}