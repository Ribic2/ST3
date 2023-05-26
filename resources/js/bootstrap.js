import 'bootstrap';
import axios from 'axios';
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.axios = axios;

const token = localStorage.getItem('token')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if(token){
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

// Set Laravel-pusher
window.pusher = Pusher
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'b9092bebd94598073700',
    cluster: 'eu',
    authEndpoint: "/api/broadcasting/auth",
    forceTLS: true,
    auth: {
        headers: {
            Authorization: `Bearer ${token}`
        }
    }
})
