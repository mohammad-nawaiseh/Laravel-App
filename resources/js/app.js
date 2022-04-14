// app.js

require('./bootstrap');

import { createApp } from 'vue';
import * as VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import App from './App.vue';
import CreateComponent from './components/CreateComponent.vue';

const routes = [
    {
        name: 'home',
        path: '/',
        component: CreateComponent
    },
];

const router = VueRouter.createRouter({ mode: 'history', history: VueRouter.createWebHashHistory(), routes: routes });
createApp(App)
    .use(VueAxios, axios)
    .use(router)
    .mount('#app');
