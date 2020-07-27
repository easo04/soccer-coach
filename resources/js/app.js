require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);
Vue.use(require('vue-moment'));

import storeData from "./store/index";
const store = new Vuex.Store(
    storeData
);

import router from "./router";

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);

import VueSpinners from 'vue-spinners';
import 'vue-spinners/dist/vue-spinners.css';
Vue.use(VueSpinners);

import Autocomplete from '@trevoreyre/autocomplete-vue';
import '@trevoreyre/autocomplete-vue/dist/style.css';
Vue.use(Autocomplete);

Vue.component('types-exercices-select', require('./components/TypesExercicesSelect.vue').default);
Vue.component('image-upload', require('./components/ImageUpload.vue').default);
Vue.component('add-variables', require('./components/AddVariables.vue').default);
Vue.component('update-exercice-form', require('./components/UpdateExerciceComponent.vue').default);
Vue.component('list-types-exercices', require('./components/ListTypesExercices.vue').default);
Vue.component('list-objectifs', require('./components/ListObjectifs.vue').default);
Vue.component('add-exercice-form', require('./components/AddExerciceComponent.vue').default);
Vue.component('exercices-by-user', require('./components/ExercicesByUserComponent.vue').default);
Vue.component('list-objectifs-exercices', require('./components/ObjectifsSelectComponent.vue').default);
Vue.component('objectifs-by-exercice', require('./components/ListObjectifsByExercice.vue').default);
Vue.component('filter-by-objectif', require('./components/FilterByObjectif.vue').default);
Vue.component('pratiques-by-user', require('./components/PratiquesByUserComponent.vue').default);
Vue.component('add-pratique', require('./components/AddPratiquesComponent.vue').default);
Vue.component('dashboard-soccer-coach', require('./components/DashboardSoccerCoach.vue').default);
Vue.component('update-pratique', require('./components/UpdatePratiquesComponent.vue').default);
Vue.component('types-seances-select', require('./components/TypesSeancesSelect.vue').default);
Vue.component('add-favoris', require('./components/AddFavorisComponent.vue').default);

//Components forms
Vue.component('input-text', require('./components/form/InputTextComponent.vue').default);
Vue.component('text-area', require('./components/form/TextAreaComponent.vue').default);
Vue.component('input-number', require('./components/form/InputNumberComponent.vue').default);
Vue.component('input-autocomplete', require('./components/form/InputAutocompleteComponent.vue').default);

//Components modal
Vue.component('images-exercices-modal', require('./components/modals/ImagesExercicesComponent.vue').default);
Vue.component('mes-exercices-modal', require('./components/modals/MesExercicesComponent.vue').default);
Vue.component('exercices-publics-modal', require('./components/modals/ExercicesPublicsComponent.vue').default);
Vue.component('create-exercice-modal', require('./components/modals/CreateExerciceComponent.vue').default);
Vue.component('details-exercice-modal', require('./components/modals/DetailsExerciceComponent.vue').default);
Vue.component('update-form-modal', require('./components/modals/UpdateFormComponent.vue').default);
Vue.component('mes-favoris-modal', require('./components/modals/MesFavorisComponent.vue').default);
Vue.component('create-joueur-modal', require('./components/modals/CreateJoueurComponent.vue').default);
Vue.component('create-entraineur-modal', require('./components/modals/CreateEntraineurComponent.vue').default);
Vue.component('delete-joueur-modal', require('./components/modals/DeleteJoueurComponent.vue').default);
Vue.component('delete-entraineur-modal', require('./components/modals/DeleteEntraineurComponent.vue').default);
Vue.component('create-activite-modal', require('./components/modals/activite/CreateActiviteComponent.vue').default);
Vue.component('delete-activite-modal', require('./components/modals/activite/DeleteActiviteComponent.vue').default);
Vue.component('update-joueur-modal', require('./components/modals/UpdateJoueurComponent.vue').default);
Vue.component('update-entraineur-modal', require('./components/modals/UpdateEntraineurComponent.vue').default);
Vue.component('update-activite-modal', require('./components/modals/activite/UpdateActiviteComponent.vue').default);
Vue.component('add-seance-modal', require('./components/modals/activite/AddSeanceComponent.vue').default);


//Components menu
Vue.component('menu-left', require('./components/menu/MenuLeftComponent.vue').default);

const app = new Vue({
    el: '#app',
    store,
    router 
});
