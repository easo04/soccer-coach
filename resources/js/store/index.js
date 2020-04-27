export default {

	state: {

        lstVariantes: []

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
		}
	}
}