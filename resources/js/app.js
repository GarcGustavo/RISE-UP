/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//import JwPagination from 'jw-vue-pagination';

<<<<<<< HEAD
=======

>>>>>>> 34140abe639af7d6b49c39f387b701dd525ddd1d
require('./bootstrap');
import 'bootstrap-vue/dist/bootstrap-vue.css'


window.Vue = require('vue');

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
<<<<<<< HEAD
Vue.component('iren_header', require('./components/header.vue').default);
Vue.component('iren_footer', require('./components/footer.vue').default);
Vue.component('iren_help', require('./components/help.vue').default);
Vue.component('iren_about', require('./components/about.vue').default);
Vue.component('iren_group', require('./components/group.vue').default);
Vue.component('iren_user_groups', require('./components/user_groups.vue').default);
Vue.component('iren_user_cases', require('./components/user_cases.vue').default);
Vue.component('iren_login', require('./components/login.vue').default);
Vue.component('iren_home', require('./components/home.vue').default);
Vue.component('iren_profile', require('./components/profile.vue').default);
=======
Vue.component('iren-header', require('./components/header.vue').default);
Vue.component('iren-footer', require('./components/footer.vue').default);
Vue.component('iren-help', require('./components/help.vue').default);
Vue.component('iren-about', require('./components/about.vue').default);
Vue.component('iren-group', require('./components/group.vue').default);
Vue.component('iren-user-groups', require('./components/user-groups.vue').default);
Vue.component('iren-user-cases', require('./components/user-cases.vue').default);
Vue.component('iren-404', require('./components/errors/404-error.vue').default);
Vue.component('case_study', require('./components/case_study.vue').default);
Vue.component('home', require('./components/home.vue').default);
Vue.component('items', require('./components/items.vue').default);
>>>>>>> 34140abe639af7d6b49c39f387b701dd525ddd1d
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
})