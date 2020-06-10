<template>
    <div class="add-favoris">
        <a class="btn btn-soccer-coach-action" @click="addFavoris"  v-if="!isAddedToFavoris">
            <i class="ti-heart"></i> Favoris
        </a>
        <span class="favoris-added" v-else>
            <i class="fa fa-heart"></i> Favoris
        </span>
    </div>
</template>
<script>
export default {
    props:['idExercice', 'isAdded'],
    data(){
        return{
            isAddedToFavoris:this.isAdded && this.isAdded === 1 ? true : false,
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