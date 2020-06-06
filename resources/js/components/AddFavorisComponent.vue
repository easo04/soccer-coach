<template>
    <div class="add-favoris">
        <a class="btn btn-soccer-coach-action" @click="addFavoris"  v-if="!isAddedToFavoris">
            <i class="ti-star"></i> Favoris
        </a>
        <a class="btn" v-else>
            <i class="ti-star"></i> Favoris
        </a>
    </div>
</template>
<script>
export default {
    props:['idExercice', 'isAdded'],
    data(){
        return{
            isAddedToFavoris:false
        }
    },
    methods:{
        addFavoris(){
            let params = {'exericeId' : this.idExercice};
            axios.post('/favoris/add-favoris', params).then(response =>{
                this.isAddedToFavoris = true;
            }).catch(error =>{
                console.log(error);
            }); 
        }
    },
    mounted(){
    }
}
</script>
<style lang="scss" scoped>
</style>