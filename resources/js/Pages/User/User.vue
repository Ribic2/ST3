<template>
    <loader-component v-if="loading"/>
    <v-container fluid>
        <v-card class="pa-3">
            <v-card-title
                class="text-h3 font-weight-bold pa-4"
            >{{ user.name }} {{ user.surname }}

            </v-card-title>
            <v-card-text class="mt-3">{{ user.email }}</v-card-text>
            <v-card-actions>
                <v-btn
                    @click="addAFriend"
                    v-if="!isSameUser && !isFriend && !addSent"
                >
                    {{ addButtonText }}
                </v-btn>
                <v-btn
                    @click="removeAFriend"
                    v-else-if="!isSameUser && isFriend"
                >
                    Remove friend
                </v-btn>

                <v-btn
                    v-else-if="!isSameUser && addSent"
                    :disabled="true"
                >
                    Requesta already sent
                </v-btn>
            </v-card-actions>
        </v-card>

        <v-card class="mt-1" v-if="isFriend">
            <PostComponent v-for="post in posts" :post="post"/>
            {{ posts }}
        </v-card>
    </v-container>
</template>

<script>
import {Factory} from "../../Api/Factory.js";
import LoaderComponent from "../../Components/LoaderComponent.vue";
import PostComponent from "../../Components/PostComponent.vue";

const user = Factory.get('User')

export default {
    name: "User",
    components: {PostComponent, LoaderComponent},
    data() {
        return {
            user: {},
            addButtonText: "Add a friend",
            isFriend: false,
            addSent: false,
            posts: []
        }
    },
    mounted() {
        user.getSelectedUser(this.$route.params.id).then((res) => {
            this.user = res.data.user;
            this.isFriend = res.data.isFriend
            this.addSent = res.data.requested_sent
            this.posts = res.data.posts
        });
    },
    methods: {
        addAFriend() {
            user.addAFriend({id: this.user.id, user_id: this.user.user_id}).then((res) => {
                this.addButtonText = "Request sent!"
            })
        },
        removeAFriend() {
            user.removeUser({id: this.user.id}).then((res) => {
                this.isFriend = false
            })
        }
    },
    computed: {
        isSameUser() {
            return this.user.id === this.$store.state.user.id
        }
    }
}
</script>

<style scoped>

</style>
