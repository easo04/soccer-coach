require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);
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

const app = new Vue({
    el: '#app',
    store
});
