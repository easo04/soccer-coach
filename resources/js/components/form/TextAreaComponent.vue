<template>
    <div class="input-text">
        <textarea :placeholder="placeholder" :name="name" class="form-control" :class="{customClass, 'input-error' : error.isError}"
            :value="modelInput" v-on="inputListeners" cols="50" rows="10"></textarea> 
        <span class="error">{{error.message}}</span>                 
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {
        model:{
            prop: 'modelInput',
            event: 'input'
        },
        props: ['modelInput', 'placeholder', 'customClass', 'name', 'model'],
        data() {
            return {
                error : {
                    isError:false,
                    message:''
                }
            }
        },
        computed:{  
            inputListeners(){
                let vm = this;
                return Object.assign({},
                    this.$listeners,
                    {
                        input: function (event) {
                            vm.$emit('input', event.target.value)
                        },
                        blur : function (event) {
                            let require = vm.model.validations.require;
                            let valide =  true;
                            if(require){
                                if(event.target.value.trim() === ''){
                                    vm.error.isError = true;
                                    vm.error.message = '* Ce champ est obligatoire';
                                    valide = false;
                                }else{
                                    if(vm.error.isError){
                                        vm.error.isError = false;
                                        vm.error.message = '';
                                        valide = true;
                                    }
                                }
                            }

                            let max = vm.model.validations.max;
                            if(max){
                                if(event.target.value && event.target.value.length > max){
                                    vm.error.isError = true;
                                    vm.error.message = '* La valeur de ce champ ne doit pas dépasser ' + max + ' caractères';
                                    valide = false;
                                }else{
                                    if(event.target.value.length > 0 && vm.error.isError){
                                        vm.error.isError = false;
                                        vm.error.message = '';
                                        valide = true;
                                    }
                                }
                            }
                            vm.$emit('validation', valide);
                        }
                    }
                );
            },
            ...mapState(['errors'])              
        },
        methods: {
            ...mapMutations(['addError', 'deleteerror', 'clearErrors'])
        },       
        mounted() { 
            this.$root.$on('formInvalid', () => {
                let require = this.model.validations.require;
                if(require && (!this.modelInput || this.modelInput.trim() === '')){
                    this.error.isError = true;
                    this.error.message = '* Ce champ est obligatoire';
                    this.$emit('validation', false);
                }     
                let max = this.model.validations.max;
                if(max && (this.modelInput && this.modelInput.length > max)){
                    this.error.isError = true;
                    this.error.message = '* La valeur de ce champ ne doit pas dépasser ' + max + ' caractères';
                    this.$emit('validation', false);
                }          
            });     
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../public/css/forms';
</style>

