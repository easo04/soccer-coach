<template>
    <div class="input-text">
        <input type="number" class="form-control" :class="{customClass, 'input-error' : error.isError}" :placeholder="placeholder" 
            :value="modelInput" :name="name" v-on="inputListeners"/>
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
                            let require = vm.model.validations ? vm.model.validations.require : false;
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
                let require = this.model.validations ? this.model.validations.require : false;
                if(require && (!this.modelInput || this.modelInput.trim() === '')){
                    this.error.isError = true;
                    this.error.message = '* Ce champ est obligatoire';
                    this.$emit('validation', false);
                }              
            });    
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../public/css/forms';
</style>

