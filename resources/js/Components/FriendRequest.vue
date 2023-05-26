<template>
    <v-card v-if="hide">
        <v-card-title>{{ getFullName }} sent a friend request!</v-card-title>
        <div class="ma-2">
            <v-btn color="success" @click="sendFriendRequestResponse(true)" class="ma-1">Confirm friend request</v-btn>
            <v-btn color="error" @click="sendFriendRequestResponse(false)" class="ma-1">Deny</v-btn>
        </div>
    </v-card>
</template>

<script>
import {Factory} from "./../Api/Factory.js";

const user = Factory.get('User')
export default {
    name: "FriendRequest",
    props: ['request'],
    data(){
        return{
            hide: true
        }
    },
    methods: {
        async sendFriendRequestResponse(status) {
            await user.acceptRequest({id: this.request.id, status: status}).then((
                this.hide = false
            ))
        }
    },
    computed: {
        getFullName() {
            return `${this.request.user.name} ${this.request.user.surname}`
        }
    }
}
</script>
