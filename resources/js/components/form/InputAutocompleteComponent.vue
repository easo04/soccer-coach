<template>
    <div class="input-text">
        <autocomplete :search="search" @blur="handleBlur" @submit="handleSubmit" base-class="input-autocomplete" :placeholder="placeholder"></autocomplete>
    </div>
</template>
<script>
    export default {
        props:['lstItems', 'model', 'placeholder'],
        data(){
            return{
                lstAutocomplete: this.lstItems ? this.lstItems : []
            }
        },
        methods: {
            search(input) {
                if (input.length < 1) { return [] }
                return this.lstItems.filter(item => {
                    return item.toLowerCase().startsWith(input.toLowerCase())
                });
            },
            handleSubmit(result) {
                this.$emit('select', result);
            },
            handleInput(input) {
                console.log('handle input');
            },
            handleBlur(event){
                this.$emit('select', event.target.value);
            }
        },
    }
</script>
<style lang="scss" scoped>
//@import '../../../../public/css/forms';
</style>
