/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//import JwPagination from 'jw-vue-pagination';



require('./bootstrap');


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
Vue.component('action_table_dbox', require('./components/action_table_dbox.vue').default);
Vue.component('action_confirm_dbox', require('./components/action_confirm_dbox.vue').default);
Vue.component('case_create_dbox', require('./components/case_create_dbox.vue').default);
//web pages
Vue.component('iren_header', require('./components/header.vue').default);
Vue.component('iren_footer', require('./components/footer.vue').default);
Vue.component('iren_help', require('./components/help.vue').default);
Vue.component('iren_about', require('./components/about.vue').default);
Vue.component('iren_group', require('./components/group.vue').default);
Vue.component('iren_user_groups', require('./components/user_groups.vue').default);
Vue.component('iren_user_cases', require('./components/user_cases.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});