<template>
    <div class="form-group type-exerice-group">

        <div class="type-item" v-for="type in lstAllTypes" :key="type.id">
            <input type="radio" v-bind:id="'control_'+type.id" name="typeExercice" :value="type.id" v-on:change="$emit('change', type.id)" checked v-if="idTypeSelected == type.id">
            <input type="radio" v-bind:id="'control_'+type.id" name="typeExercice" :value="type.id" v-on:change="$emit('change', type.id)" v-else>
            <label :for="'control_'+type.id">
                <div class="details-type">
                    <p class="value">{{type.nom}}</p>                
                </div>
                <div class="icon-exercice"><i :class="type.icon + ' color-soccer-coach'"></i></div>
            </label>
        </div>    
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex';
    export default {
        model:{
            prop: 'typeExercice',
            event: 'change'
        },
        props: ['idTypeSelected', 'typeExercice'],
        computed:{     
            ...mapState(['lstAllTypes']),                         
        },
        methods: {
            updateType: function (id){
                this.$emit('typeSelectd', id);
            },
            ...mapActions(['loadAllTypes'])
        },
        mounted() {
            this.loadAllTypes();
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../public/css/types-exercices-select';
</style>

