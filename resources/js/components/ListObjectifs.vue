<template>
    <div class="dropdown-menu dropdown-custom" :aria-labelledby="idArea">
        <a class="dropdown-item" :href="'/exercice/objectifs/'+objectif.nom_url" v-for="objectif in lstObjectifsExercice" :key="objectif.id">
            {{objectif.nom}}
        </a>
    </div>
    
</template>

<script>
    export default {
        props:['idArea'],
        data(){
            return{
                lstObjectifsExercice:[],
            }
        },
        mounted() {
            axios.get('/objectifs').then(reponse =>{
                reponse.data.objectifs.forEach(objectif => {
                    this.lstObjectifsExercice.push(objectif);
                });
            }).catch(error =>{
                console.log(error);
            });   
        }
    }
</script>
