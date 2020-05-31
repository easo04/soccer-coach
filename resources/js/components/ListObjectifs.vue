<template>
    <div class="lst-objectifs">
        <div class="dropdown-menu dropdown-custom" :aria-labelledby="idArea" v-if="isMenuTop">
            <a class="dropdown-item" :href="'/exercice/objectifs/'+objectif.nom_url" v-for="objectif in lstAllObjectifs" :key="objectif.id">
                {{objectif.nom}}
            </a>
        </div>
        <div class="search-objectifs" v-else>
            <div class="objectif-item" v-for="objectif in lstAllObjectifs" :key="objectif.id">
                <a :href="'/exercice/objectifs/'+objectif.nom_url">
                    {{objectif.nom}}
                </a>    
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations,  mapActions} from 'vuex';
    export default {
        props:['idArea', 'isMenuTop', 'objectifs'],
        data(){
            return{
            }
        },
        computed:{
            ...mapState(['lstAllObjectifs'])               
        },
        methods:{
            ...mapMutations(['setAllObjectifs']),
            ...mapActions(['loadAllObjectifs'])
        },
        mounted() {
            if(this.objectifs){
                this.setAllObjectifs(this.objectifs);
            }else{
                this.loadAllObjectifs();
            }
            
        }
    }
</script>
