/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
require('datatables.net-bs4');
require('nestable2');
window.Swal = require('sweetalert2');
window.toastr = require('toastr');

/**
 * Import Vue 3 and necessary components.
 */
import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import MenuHeader from './components/layouts/Header.vue';
import MenuLeftSidebar from './components/layouts/LeftSidebar.vue';
import DraggableMenu from './components/MenuBuilder.vue';
import NestMenu from './components/NestMenu.vue';

/**
 * Create a new Vue application instance.
 */
const app = createApp({});

/**
 * Register Vue components.
 */
app.component('example-component', ExampleComponent);
app.component('menu-header', MenuHeader);
app.component('menu-left-sidebar', MenuLeftSidebar);
app.component('draggable-menu', DraggableMenu);
app.component('nest-menu', NestMenu);

/**
 * Mount the Vue application to the DOM.
 */
app.mount('#app');