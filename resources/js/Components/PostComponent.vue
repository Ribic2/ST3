<template>
    <v-card class="mt-1" v-if="!isDeleted">
        <v-row align="center"
               justify="center">
            <v-col cols="1">
                <v-card-text>
                    <v-avatar color="brown">
                        <span class="font-weight-bold">{{ initials }}</span>
                    </v-avatar>
                </v-card-text>
            </v-col>
            <v-col cols="9" v-if="!edit">
                <h1>{{ postText }}</h1>
            </v-col>

            <v-col cols="9" v-else>
                <v-text-field label="Edit post.." v-model="postText"/>
                <v-btn @click="updatePost">Update post</v-btn>
                <v-btn @click="cancelAction">Cancel</v-btn>
            </v-col>

            <v-col v-if="post.created_by.id === this.$store.state.user.id">
                <v-menu
                    v-model="menu"
                    :close-on-content-click="false"
                    location="end"
                >
                    <template v-slot:activator="{props}">
                        <v-btn icon="mdi-dots-vertical" v-bind="props"/>
                    </template>


                    <v-list>
                        <v-list-item>
                            <v-btn @click="deletePost">Delete post</v-btn>
                        </v-list-item>
                        <v-list-item>
                            <v-btn @click="editPost">Edit post</v-btn>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-col>

            <v-col v-else></v-col>
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
            likes: 0,
            menu: false,
            edit: false,
            postText: '',
            isDeleted: false
        }
    },
    methods: {
        cancelAction(){
          this.edit = false;
          this.postText = this.post.post
        },
        updatePost() {
            PostFactory.editPost({post_id: this.post.id, post: this.postText})
                .then((res) => {
                    this.$emit('update:post', res.data.response)
                    this.edit = false
                })
        },
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
        },
        deletePost() {
            PostFactory.deletePost({post_id: this.post.id})
                .then((res) => {
                    this.isDeleted = true
                })
        },
        editPost() {
            this.edit = true
        }
    },
    mounted() {
        this.comments = this.post.comments
        this.likes = this.post.likes.length
        this.postText = this.post.post
    },
    computed: {
        initials() {
            return `${this.post.created_by.name[0]}${this.post.created_by.surname[0]}`
        }
    },
    created() {
        window.Echo.private('update-posts-channel')
            .listen('UpdateComments', (e) => {
                if (this.post.id === e.comment.post_id) {
                    this.comments.unshift(e.comment)
                }
            })
    },
}
</script>

<style scoped>

</style>
