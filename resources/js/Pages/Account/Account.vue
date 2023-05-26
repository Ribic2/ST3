<template>
    <loader-component v-if="loading"/>
    <v-container fluid>
        <h1 class="text-h2 font-weight-bold">{{ user.name }} {{ user.surname }}</h1>
    </v-container>
</template>

<script>
import {Factory} from "../../Api/Factory.js";
import LoaderComponent from "../../Components/LoaderComponent.vue";

const user = Factory.get('User')

export default {
    name: "Account",
    components: {LoaderComponent},
    data(){
        return{
            user: {},
            loading: true,
        }
    },
    mounted() {
        user.getUser().then((res)=>{
            this.user = res.data.user
            this.loading = false
        })
    }
}
</script>
