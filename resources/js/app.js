/***
First we will load all of this project 'sJavaScript dependencies which *
includes Vue and other libraries.It is agreat starting point when *
building robust, powerful web applications using Vue and Laravel.*/
require('./bootstrap');
import Vue from 'vue'
import router from './Vue/router/index'
import store from './Vue/store/index'
import Vuetify from 'vuetify'
import App from './Vue/App.vue'
import 'vuetify/dist/vuetify.min.css'
import Toaster from 'v-toaster'
// You need a specific loader for CSS files
import 'v-toaster/dist/v-toaster.css'
import VueTimeago from 'vue-timeago'
import VueCookies from 'vue-cookies'/**
 * Next, we will create a fresh Vue application
 instance and attach it to* the page. Then, you may begin adding components to this application* or customize the JavaScript scaffolding to fit your unique needs. */

Vue.use(Toaster, {
    timeout: 5000
})

Vue.use(VueTimeago, {
    name: 'Timeago', // Component name, `Timeago` by default
    locale: 'en', // Default locale
})

Vue.use(Vuetify)
Vue.use(VueCookies)

const app = new Vue({
    el: '#app',
    store,
    router,
    components: {
        App
    },
    render: h => h(App),
    methods: {}
});;
