import './bootstrap';

// import {createApp} from "vue"; // doesn't work

import { createApp } from 'vue/dist/vue.esm-bundler';

import AppComponent from './components/App.vue';

const app = createApp({
    components: {
        AppComponent,
    }
})

app.mount('#app');
