<template>
    <div class="update-exercice">
        <update-exercice-form :exercice="exercice"
        :variantes="exercice.variantes" :objectifs-exercice="exercice.objectifs"/>     
    </div>
</template>
<script>
export default {
    props:['exercice']
}
</script>