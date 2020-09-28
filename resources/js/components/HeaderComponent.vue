<template>
    <div class="header-page">
        <div class="header-div-1">
            <div class="actions">
                <a @click="canShowMenuLeft()" class="navicon"><i class="fa fa-navicon"></i></a>
                <a href="/"><img class="logo" src="../../../public/images/logo.png"></a>
            </div>
            <div class="actions-header" :title="textTitle" v-if="showModePresentation" :class="{'mode-presentation':modePresentation}" @click="setModePresentation()">
                <i class="fa fa-desktop"></i>
            </div>
        </div>
        <div class="menu-left" :class="{'show-menu':isShowMenuLeft}" id="menu-left">
            <div>
                <div class="imet-menu">
                    <ul>
                        <li>
                            <a href="/" class="home">Accueil</a>
                        </li>
                    </ul>
                </div>
                <div class="imet-menu">
                    <h5>NOS SERVICES</h5>
                    <ul>
                        <li><a @click="gotToExercices()">EXERCICE</a></li>
                        <li><a @click="goToSeances()">SÉANCE</a></li>
                        <li><a @click="goToAlignements()">ALIGNEMENT</a></li>
                    </ul>
                </div>
                <div class="imet-menu informations">
                    <h5>INFORMATIONS</h5>
                    <ul>
                        <li>
                            <a @click="goToHelp()">Aide</a>
                        </li>
                        <li>
                            <a href="/#contactUs">Contactez-nous</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapState, mapMutations} from 'vuex';
export default {
    data(){
        return{
            textTitle:'Activer le mode présentation',
            isShowMenuLeft:false,
        }
    },
    computed:{
        ...mapState(['modePresentation', 'showModePresentation', 'showMenuLeft'])
    },
    watch:{
        showMenuLeft(){
            this.isShowMenuLeft = this.showMenuLeft;
        }
    },
    methods:{
        setModePresentation(){
            if(this.modePresentation){
                
                this.textTitle = 'Activer le mode présentation';
                this.setModePresentationStore(false);
            }else{
                
                this.textTitle = 'Désactiver le mode présentation';
                this.setModePresentationStore(true);
            }
        },
        canShowMenuLeft(){
            this.isShowMenuLeft = this.isShowMenuLeft ? false : true;
            
            //set store object
            this.setShowMenuLeft(this.isShowMenuLeft);
        },
        gotToExercices(){
            this.canShowMenuLeft();
            this.$router.push({path: '/create-exercice'});
        },
        goToSeances(){
            this.canShowMenuLeft();
            this.$router.push({path: '/create-seance'});
        },
        goToAlignements(){
            this.canShowMenuLeft();
            this.$router.push({path: '/create-alignement'});
        },
        goToHelp(){
            this.canShowMenuLeft();
            this.$router.push({path: '/help'});
        },
        ...mapMutations(['setModePresentationStore', 'setShowMenuLeft'])
    },
    mounted(){
            let globalThis = this;
            $('#contenu-page').click(event =>{
                if(event.target.id !== 'menu-left'){
                    globalThis.setShowMenuLeft(false);  
                }
            });
    }
}
</script>
<style lang="scss">
    @import '../../../public/css/header';
</style>
