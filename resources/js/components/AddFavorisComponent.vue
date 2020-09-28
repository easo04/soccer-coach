<template>
    <div class="add-favoris">
        <a class="btn" @click="addFavoris"  v-if="!isAddedToFavoris">
            <i class="ti-heart"></i>
        </a>
        <span class="favoris-added" v-else>
            <i class="fa fa-heart"></i>
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
.add-favoris{
    .favoris-added{
            background-color: #193045;
            color: white!important; 
            border-radius: 10px;
            font-size: 20px;
            text-align: center;
            line-height: 2.3;
            display: block;
            width: 48px;
            height: 48px;
            font-weight: 400;
    }
    .btn{
        border: 2px solid #193045;
        color: #193045!important;
        border-radius: 10px;
        font-size: 20px;   

        &:hover{
            background-color: #193045;
            color: white!important; 
        }
    }
}
</style>