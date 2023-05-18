import Login from "../Layouts/Login/Login.vue";
import {createRouter, createWebHashHistory} from 'vue-router'
import Default from "../Layouts/Default/Default.vue";

const routes = [
    {path: '/', component: Login},
    {path: '/webapp', component: Default},
]

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router
