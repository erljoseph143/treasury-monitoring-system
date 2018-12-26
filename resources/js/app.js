
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

window.UserData = {};

import VueElementLoading from 'vue-element-loading';

Vue.component('loading', VueElementLoading);

import VueContentPlaceholders from 'vue-content-placeholders';

Vue.use(VueContentPlaceholders);

Vue.use(require('vue-moment'));

import {ServerTable, ClientTable, Event} from 'vue-tables-2';

Vue.use(ClientTable,{}, false, 'bootstrap3');

import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);

// import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css';

import VuejsDialog from "vuejs-dialog";
// import VuejsDialogMixin from "vuejs-dialog/vuejs-dialog-mixin.min.js"; // only needed in custom components

// include the default style
import 'vuejs-dialog/dist/vuejs-dialog.min.css'

Vue.use(VuejsDialog);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

/*
* Login Component
* */
    Vue.component('login',require('./auth/login.vue'));

//Header Component
    Vue.component('header-top',require('./layouts/header.vue'));
//Sibar Component
    Vue.component('side-bar-treasury',require('./layouts/treasurySidebar.vue'));
//Content Component
    Vue.component('content-data',require('./layouts/content.vue'));
//Container Component
    Vue.component('container',require('./layouts/container.vue'));
//Data Component
    Vue.component('monthly-cash-dep',require('./data/cashdep/monthly.vue'));

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import {store} from './store';
import VueRouter from 'vue-router';
import App from './App.vue';
Vue.use(VueRouter);


import router from './router.js';

const app = new Vue({
    router:router,
    store:store,
    el: '#app',
    template:'<App></App>',
    components: { App}
});
