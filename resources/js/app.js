require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);
Vue.use(require('vue-moment'));
import storeData from "./store/index"

const store = new Vuex.Store(
   storeData
)

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

const app = new Vue({
    el: '#app',
    store
});
