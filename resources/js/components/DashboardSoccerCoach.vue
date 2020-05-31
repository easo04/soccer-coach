<template>
    <div class="dashboard-soccer-coach">
        <div class="wrapper-exercices">
            <menu-left :user="user"/>
            <div class="contenu-dashboard">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['user']
}
</script>
<style lang="scss" scoped>
    @import '../../sass/dashboard';
</style>