<template>
    <div>
        Cucu c'est moi
    </div>
</template>
<script>
import { mapActions } from 'vuex'
export default {
    methods:{
        ...mapActions(['loadAllObjectifs', 'loadAllTypes']),
    },
    created(){
        //loader tous les objectifs et tous les types d'exercice
        this.loadAllObjectifs();
        this.loadAllTypes();
    },
    mounted(){
    }
}
</script>