<template>
    <loader-component v-if="loading"/>
    <v-container v-else>
        <v-card class="pb-3">
            <v-card-title>What are you thinking about?</v-card-title>
            <v-form class="pr-3 pl-3">
                <v-textarea
                    variant="outlined"
                    label="Write a post"
                    v-model="post"
                    no-resize/>

                <v-btn @click="createPost">Make a post</v-btn>
            </v-form>
        </v-card>

        <v-main class="pt-3 pa-0">
            <PostComponent v-for="postProp in posts" :post.sync="postProp"/>
        </v-main>
    </v-container>
</template>

<script>
import {Factory} from "../../Api/Factory.js";
import PostComponent from "../../Components/PostComponent.vue";
import LoaderComponent from "../../Components/LoaderComponent.vue";

const postFactory = Factory.get('Post')

export default {
    name: "Home",
    components: {LoaderComponent, PostComponent},
    data() {
        return {
            post: '',
            posts: [],
            loading: true
        }
    },
    mounted() {
        postFactory.getPost().then((res) => {
            this.posts = res.data.posts
            this.loading = false;
        })
    },

    created() {
        window.Echo.private('update-posts-channel')
            .listen('UpdatePosts', (e) => {
                console.log(e)
                this.posts.unshift(e.post)
            })
    },
    methods: {
        createPost() {
            let post = this.post;
            postFactory.createPost({post})
        }
    }
}
</script>

<style scoped>

</style>
