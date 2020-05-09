export default {

	state: {

		lstVariantes: [],
		lstObjectifs: []

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
		}
	}
}