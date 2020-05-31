<template>
    <div class="create-seance">
        <update-pratique :seance="seance"/>
    </div>
</template>
<script>
export default {
    props:['seance']
}
</script>