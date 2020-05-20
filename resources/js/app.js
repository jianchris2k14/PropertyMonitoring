/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

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

Vue.component('persons', require('./components/accessibility/Persons.vue').default);
Vue.component('users', require('./components/accessibility/Users.vue').default);

Vue.component('equipments', require('./components/motorpol/Equipments.vue').default);
Vue.component('repair_job_orders', require('./components/motorpol/Repair_Job_Orders.vue').default);

Vue.component('inventory', require('./components/inventory/Inventory.vue').default);
Vue.component('inventory_stocks', require('./components/inventory/Inventory_Stocks.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
