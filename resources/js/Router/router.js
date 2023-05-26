import {createRouter, createWebHistory} from 'vue-router'
import Default from "../Layouts/Default/Default.vue";
import Login from "../Layouts/Login/Login.vue";
import Home from "../Pages/Home/Home.vue";
import account from "../Pages/Account/Account.vue";
import user from "../Pages/User/User.vue";
import friendRequests from "../Pages/Requests/friend-requests.vue";
import friends from "../Pages/Friends/Friends.vue";
import {Factory} from "../Api/Factory.js";
import register from "../Layouts/Register/Register.vue";
import notFound from "../Pages/404/notFound.vue";

const UserFactory = Factory.get('User')

const routes = [
    {path: '/', component: Login, name: 'login'},
    {path: '/register', component: register, name: 'register'},
    {
        path: '/webapp',
        name: 'webapp',
        component: Default,
        beforeEnter: async (to, from) => {
            if (!localStorage.getItem('token')) {
                return {name: 'login'}
            }

            await UserFactory.getUser().catch((err) => {
                window.location.href = "/"
            })

        },
        children: [
            {
                path: '',
                component: Home
            },
            {
                path: 'account',
                component: account
            },
            {
                path: 'user/:id',
                component: user,
                name: 'user',
            },
            {
                path: 'friend-request',
                name: 'friend-request',
                component: friendRequests
            },
            {
                path: 'friends',
                name: 'friends',
                component: friends
            }
        ]
    },
    {
        path: "/:pathMatch(.*)*",
        name: "404",
        component: notFound
    }
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
