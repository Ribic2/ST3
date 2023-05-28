<template>
    <loader-component v-if="loading"/>
    <v-container fluid>
        <v-card class="pa-2">
            <v-card-title
                class="text-h2 font-weight-bold"
            >{{ user.name }} {{ user.surname }}</v-card-title>
            <v-card-text>{{ user.email}}</v-card-text>
        </v-card>

        <PostComponent v-for="post in posts" :post="post"/>
    </v-container>
</template>

<script>
import {Factory} from "../../Api/Factory.js";
import LoaderComponent from "../../Components/LoaderComponent.vue";
import PostComponent from "../../Components/PostComponent.vue";

const user = Factory.get('User')

export default {
    name: "Account",
    components: {PostComponent, LoaderComponent},
    data(){
        return{
            user: {},
            loading: true,
            posts: []
        }
    },
    mounted() {
        user.getUser().then((res)=>{
            this.user = res.data.user
            this.loading = false
            this.posts = this.$store.state.posts
        })
    }
}
</script>
