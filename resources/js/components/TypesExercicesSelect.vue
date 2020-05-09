<template>
    <div class="form-group type-exerice-group">

        <div class="type-item" v-for="type in lstTypes" :key="type.id">
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
    export default {
        model:{
            prop: 'typeExercice',
            event: 'change'
        },
        props: ['types', 'idTypeSelected', 'typeExercice'],
        data() {
            return {
                lstTypes: [],
                lstIconsByType: [['principe-offensif', 'ti-target'], ['principe-defensif', 'ti-hummer'], ['rondos', 'ti-cup'], ['physique', 'ti-heart']]
            }
        },
        methods: {
            updateType: function (id){
                this.$emit('typeSelectd', id);
            }
        },
        mounted() {
            //ajouter icon à chaque type de la liste
            let mapTypes = new Map(this.lstIconsByType);
            this.types.forEach(type => {
                let icon = mapTypes.get(type.urlNom);
                type.icon = icon;
                this.lstTypes.push(type);
            });
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../public/css/types-exercices-select';
</style>

