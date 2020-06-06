<template>
    <div class="mes-favoris">
        <div class="item-exe" v-for="(exercice, index) in favoris" :key="index">
            {{index}}
        </div> 
    </div>
</template>
<script>
    export default {
        data(){
            return{
                favoris:[],
                isLoading:true
            }
        },
        mounted(){
            this.isLoading = true;
            axios.get('/favoris/get-favoris-by-user').then(reponse =>{
                this.favoris = reponse.data.favoris;
                this.isLoading = false;
            }).catch(error =>{
                console.log(error);
                this.isLoading = false;
            });
        }
    }
</script>
<style lang="scss" scoped>
</style>