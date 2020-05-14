export default {

	state: {
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
            image:''
        },
        exerciceDTO:{

        }
	},

	getters: {
	},

	actions: {

	},
	mutations: {
		/*addVariableToList(state, variante){
			state.lstVariantes.push(variante);
		}*/
	}
}