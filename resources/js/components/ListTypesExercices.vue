<template>
    <div class="lst-types">
        <div class="dropdown-menu dropdown-custom" :aria-labelledby="idArea" v-if="isMenuTop">     
            <a class="dropdown-item link-custom-2" :href="'/exercice/type/'+type.id" v-for="type in lstAllTypes" :key="type.id">
                <i :class="type.icon"></i> {{type.nom}}
            </a>
        </div>
        <div class="search-types" v-else>
            <div class="type-item" v-for="type in lstAllTypes" :key="type.id">
                <a :href="'/exercice/type/'+type.id+'/'+type.urlNom">
                    <i :class="type.icon"></i> {{type.nom}}
                </a>    
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations, mapActions } from 'vuex';
    export default {
        props:['idArea', 'isMenuTop', 'types'],
        data(){
            return{
                lstTypesExercices:[],
            }
        },
        computed:{
            ...mapState(['lstAllTypes'])                     
        },
        methods:{
            ...mapActions(['loadAllTypes', 'loadAllTypesWithTypes'])
        },
        mounted() {
            if(this.types){
                let lstTypes = this.types;
                this.loadAllTypesWithTypes(lstTypes);
            }else{
                this.loadAllTypes();
            }
        }
    }
</script>
