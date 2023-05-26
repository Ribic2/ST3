<template>
    <v-card class="mt-1">
        <v-row align="center"
               justify="center">
            <v-col cols="1">
                <v-card-text>
                    <v-avatar color="brown">
                        <span class="font-weight-bold">{{ initials }}</span>
                    </v-avatar>
                </v-card-text>
            </v-col>
            <v-col>
                <h1>{{ post.post }}</h1>
            </v-col>
        </v-row>

        <!-- Like section -->
        <v-card-actions>
            <v-btn @click="likeAction" icon="mdi-thumb-up"/>
            <p>{{ this.likes }}</p>
        </v-card-actions>

        <!-- Comment section -->

        <CommentComponent v-for="comment in comments" :comment="comment"/>
        <v-card-actions>
            <v-text-field placeholder="add new comment" variant="outlined" v-model="commentModel"/>
            <v-btn @click="addNewComment">Post</v-btn>
        </v-card-actions>
        <v-divider/>
    </v-card>
</template>

<script>
import {Factory} from "../Api/Factory.js";
import CommentComponent from "./CommentComponent.vue";

const PostFactory = Factory.get('Post');

export default {
    components: {CommentComponent},
    props: ['post'],
    name: "PostComponent",
    data() {
        return {
            comments: [],
            commentModel: '',
            likes: 0
        }
    },
    methods: {
        addNewComment() {
            PostFactory.addNewComment({post_id: this.post.id, comment: this.commentModel})
        },
        likeAction() {
            PostFactory.likePost({post_id: this.post.id}).then((res) => {
                if (res.data.response) {
                    this.likes++;
                } else {
                    this.likes--;
                }
            })
        }
    },
    mounted() {
        this.comments = this.post.comments
        this.likes = this.post.likes.length
    },
    computed: {
        initials() {
            return `${this.post.created_by.name[0]}${this.post.created_by.surname[0]}`
        }
    },
    created() {
        window.Echo.private('update-posts-channel')
            .listen('UpdateComments', (e) => {
                if(this.post.id === e.comment.post_id){
                    this.comments.unshift(e.comment)
                }
            })
    },
}
</script>

<style scoped>

</style>
