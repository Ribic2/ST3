import './bootstrap';
import {createApp} from 'vue';

import App from "./App.vue";
import router from "./Router/router.js";

// Vuetify
import 'vuetify/styles'
import {createVuetify} from 'vuetify'
import 'material-design-icons-iconfont'
import * as components from 'vuetify/components'
import store from './Store/store.js'
import * as directives from 'vuetify/directives'


const vuetify = createVuetify({
    components,
    directives,
})

const app = createApp(App).use(router).use(vuetify).use(store);

app.mount('#app');
