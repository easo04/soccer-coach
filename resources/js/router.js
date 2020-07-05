import Vue from 'vue'
import VueRouter  from 'vue-router'


Vue.use(VueRouter)

export default new VueRouter ({
    routes:[
        {
            path:'/', 
            component:() => import('./views/MonDashboard.vue'),
            children: []
        },
        {
            path:'/mes-exercices',
            component:() => import('./views/exercice/MesExercices.vue'),
            children: []
        },
        {
            path:'/create-exercice',
            name:'createExercice',
            component:() => import('./views/exercice/CreateExercice.vue')
        },
        {
            path:'/update-exercice',
            name:'UpdateExercice',
            component:() => import('./views/exercice/UpdateExercice.vue'),
            props: true
        },
        {
            path: '/detail-exercice',
            name:'DetailExercice',
            component:() => import('./views/exercice/DetailExercice.vue'),
            props: true
        },
        {
            path:'/mes-seances',
            component:() => import('./views/seance/MesSeances.vue'),
            children: []
        },
        {
            path:'/detail-seance',
            name:'DetailSeance',
            component:() => import('./views/seance/DetailSeance.vue'),
            props: true
        },
        {
            path:'/create-seance',
            name:'CreateSeance',
            component:() => import('./views/seance/CreateSeance.vue')
        },
        {
            path:'/update-seance',
            name:'UpdateSeance',
            component:() => import('./views/seance/UpdateSeance.vue'),
            props: true
        },
        {
            path:'/mes-favoris',
            name:'MesFavoris',
            component:() => import('./views/favoris/FavorisComponent.vue'),
        },
        {
            path:'/mes-equipes',
            name:'MesEquipes',
            component:() => import('./views/equipes/EquipesComponent.vue'),
        },
        {
            path:'/create-equipe',
            name:'CreateEquipe',
            component:() => import('./views/equipes/CreateEquipe.vue'),
        },
        {
            path:'/update-equipe',
            name:'UpdateEquipe',
            component:() => import('./views/equipes/UpdateEquipe.vue'),
            props: true
        },
        {
            path:'/details-equipe',
            name:'DetailsEquipe',
            component:() => import('./views/equipes/DetailEquipe.vue'),
            props: true
        },
    ]
})