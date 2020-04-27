<template>
    <div class="dropdown-menu dropdown-custom" :aria-labelledby="idArea">     
        <a class="dropdown-item link-custom-2" :href="'exercice/type/'+type.id" v-for="type in lstTypesExercices" :key="type.id">
            <i :class="type.icon"></i> {{type.nom}}
        </a>
    </div>
</template>

<script>
    export default {
        props:['idArea'],
        data(){
            return{
                lstTypesExercices:[],
                lstIconsByType: [['principe-offensif', 'ti-target'], ['principe-defensif', 'ti-hummer'], ['rondos', 'ti-cup'], ['physique', 'ti-heart']]          
            }
        },
        mounted() {
            let mapTypes = new Map(this.lstIconsByType);
            axios.get('/types-exercices').then(reponse =>{
                reponse.data.types.forEach(type => {
                    type.icon = mapTypes.get(type.urlNom);
                    this.lstTypesExercices.push(type);
                });
            }).catch(error =>{
                console.log(error);
            });   
        }
    }
</script>
