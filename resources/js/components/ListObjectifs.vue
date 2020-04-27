<template>
    <div class="dropdown-menu dropdown-custom" :aria-labelledby="idArea">
        <a class="dropdown-item" href="#">Principes aaa</a>
        <a class="dropdown-item" href="#">Principes défensifs</a>
        <a class="dropdown-item" href="#">Rondos</a>
        <a class="dropdown-item" href="#">Physiques</a>
    </div>
</template>

<script>
    export default {
        props:['idArea'],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
