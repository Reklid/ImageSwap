import Vue from "vue";
import Toast from "vue-toastification"
import "vue-toastification/dist/index.css"

require('./bootstrap');

Vue.component('image-list', require('./components/images/List.vue').default);
Vue.component('image-form', require('./components/images/Form.vue').default);
Vue.component('image-show', require('./components/images/Show.vue').default);

import axios from "axios";
Vue.prototype.$http = axios

Vue.use(Toast)

const app = new Vue({
    el: '#app',
});
