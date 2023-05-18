import './bootstrap';
import {createApp} from 'vue';

import App from "./App.vue";
import router from "./Router/router.js";

// Vuetify
import 'vuetify/styles'
import {createVuetify} from 'vuetify'
import 'material-design-icons-iconfont'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'


const vuetify = createVuetify({
    components,
    directives,
    ssr: true,
})

const app = createApp(App).use(vuetify);

app.use(router)
app.mount('#app');
