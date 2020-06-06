<template>
    <div class="form-group type-exerice-group">

        <div class="type-item" v-for="(type, index) in lstIconsByCategorie" :key="index">
            <input type="radio" :id="'control_'+type.id" name="typeSeance" :value="type.name" v-on:change="$emit('change', type.name)" checked v-if="isTypeSelect(index, type.name)">
            <input type="radio" :id="'control_'+type.id" name="typeSeance" :value="type.name" v-on:change="$emit('change', type.name)" v-else>
            <label :for="'control_'+type.id">
                <div class="details-type">
                    <p class="value">{{type.name}}</p>                
                </div>
                <div class="icon-exercice"><i :class="type.icon + ' color-soccer-coach'"></i></div>
            </label>
        </div>    
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    export default {
        model:{
            prop: 'typeSeance',
            event: 'change'
        },
        data(){
            return{
            }
        },
        props: ['idTypeSelected', 'typeSeance'],
        computed:{     
            ...mapState(['lstIconsByCategorie']),                         
        },
        methods: {
            isTypeSelect(index, name){
                if(this.idTypeSelected){
                    if(this.idTypeSelected === type.name){
                        return true;
                    }
                }else if(index === 0){
                    return true;
                }

                return false;
            },
        },
        mounted() {
            
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../public/css/types-exercices-select';
</style>

