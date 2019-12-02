/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//import JwPagination from 'jw-vue-pagination';

require('./bootstrap');
import 'bootstrap-vue/dist/bootstrap-vue.css'
import BootstrapVue, { BTable, BLink, BTooltip } from "bootstrap-vue";
import Datepicker from 'vuejs-datepicker';

window.Vue = require('vue');

window.bootbox = require('bootbox');

Vue.use(BootstrapVue);
Vue.use(Datepicker);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//web pages components
Vue.component('paginator', require('./components/paginator.vue').default);
Vue.component('action-table-dbox', require('./components/dialogue-boxes/action-table-dbox.vue').default);
Vue.component('case-create-dbox', require('./components/dialogue-boxes/case-create-dbox.vue').default);
//web pages
Vue.component('iren-header', require('./components/header.vue').default);
Vue.component('iren-footer', require('./components/footer.vue').default);
Vue.component('iren-help', require('./components/help.vue').default);
Vue.component('iren-about', require('./components/about.vue').default);
Vue.component('iren-group', require('./components/group.vue').default);
Vue.component('iren-user-groups', require('./components/user-groups.vue').default);
Vue.component('iren-user-cases', require('./components/user-cases.vue').default);
Vue.component('iren-404', require('./components/errors/404-error.vue').default);
Vue.component('case_study', require('./components/case_study.vue').default);
Vue.component('iren-search', require('./components/search.vue').default);
Vue.component('home', require('./components/home.vue').default);
Vue.component('items', require('./components/items.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
})