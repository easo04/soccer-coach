<template>
    <div class="filter-by-objectif">
        <a class="btn-filter" v-if="showBtnFilter" @click="showList()"><h5>Filtrer par objectif</h5></a>
        <h5 v-else>Filtrer par objectif</h5>
        <div v-show="showListObjectifs">
            <objectifs-by-exercice v-bind:objectifs="objectifs" v-bind:objectifSelected="objectifSelected"
                v-bind:setUrl="setUrl" v-bind:classCustom="classCustom" v-bind:setFilter="setFilter" v-bind:onMethodFilter="onMethodFilter"/>
        </div>
    </div>
</template>

<script>
    export default {
        props:['objectifs', 'objectifSelected', 'setUrl', 'setFilter', 'showBtnFilter', 'classCustom', 'onMethodFilter'],
        data(){
            return{
                showListObjectifs:!this.showBtnFilter,
            }
        },
        methods:{
            showList(){
                this.showListObjectifs = this.showListObjectifs ? false : true;
            }
        },
        mounted() {
        }
    }
</script>
<style lang="scss" scoped>
    @import '../../../public/css/list-objectifs-by-exercice';
</style>
