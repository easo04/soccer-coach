<template>
    <div class="menu-left">
        <nav id="sidebar" class="sidebar" :class="{'active':showNav}">
            <div class="custom-menu" v-show="showCustomMenu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary" @click="showMenu()">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <h4>Bonjour {{user}}!</h4>
            <ul class="list-unstyled components mb-5">
                <li :class="{'selected-link' : link.selected}" v-for="(link, index) in lstLinks" :key="index">
                    <a :href="link.url" target="_blank" v-if="link.name === 'designer'"><span :class="link.icon" class="mr-3"></span> {{link.nomFr}}</a>
                    <a @click="goToLink(link.url, index)" v-else><span :class="link.icon" class="mr-3"></span> {{link.nomFr}}</a>
                </li>
            </ul>
        </nav>
        <update-form-modal />
    </div>
</template>
<script>
import { mapState, mapMutations } from 'vuex';
export default {
    props:['user'],
    data(){
        return{
            showCustomMenu : true,
            showNav:false,
            lastIndexSelected:undefined,
            lstLinks:[],
            indexSelectedBeforeShowModal:undefined
        }
    },
    computed:{
        ...mapState(['updateForm'])
    },
    methods:{
        goToLink(url, index){
            if(!this.updateForm){
                this.selectLink(index)
                this.$router.push({path: url});
            }else{
                this.indexSelectedBeforeShowModal = index;
                $("#modalUpdateForm").modal();
            }
        },
        showMenu(){
            if(!this.showNav){
                this.showNav = true;
            }else{
                this.showNav = false;
            }
        },
        selectLink(index){  

            //deselectionner le dernier link sélectionné
            if(this.lastIndexSelected !== undefined){
                this.lstLinks[this.lastIndexSelected].selected = false;
            }

            //selectionner le nouveau link
            this.lstLinks[index].selected = true;

            this.lastIndexSelected = index;
        }
    },
    mounted(){
        //init links
        this.lstLinks = [
            {
                name:'designer',
                selected:false,
                nomFr:'Designer',
                icon:'fa fa-paint-brush',
                url:'/create-exercice'
            },
            {
                name:'mes_favoris',
                selected:false,
                nomFr:'Mes favoris',
                icon:'fa fa-star',
                url:'mes-favoris'
            },
            {
                name:'mes_activites',
                selected:false,
                nomFr:'Mes activités',
                icon:'fa fa-calendar',
                url:''
            },
            {
                name:'mes_exercices',
                selected:false,
                nomFr:'Mes exercices',
                icon:'ti-list',
                url:'mes-exercices'
            },
            {
                name:'mes_seances',
                selected:false,
                nomFr:'Mes séances',
                icon:'fa fa-futbol-o',
                url:'mes-seances'
            },
            {
                name:'mes_equipes',
                selected:false,
                nomFr:'Mes équipes',
                icon:'fa fa-cubes',
                url:'mes-equipes'
            },
            {
                name:'mon_club',
                selected:false,
                nomFr:'Mon club',
                icon:'fa fa-cube',
                url:''
            },
            {
                name:'mon_profil',
                selected:false,
                nomFr:'Mon profil',
                icon:'fa fa-user',
                url:''
            }
        ];

        this.$root.$on('goToLink', () =>{
            let lastLinkSelected = this.lstLinks[this.indexSelectedBeforeShowModal];
            this.goToLink(lastLinkSelected.url, this.indexSelectedBeforeShowModal);
        });

    }
    
}
</script>
<style lang="scss" scoped>
    @import 'css/menu-left';
</style>