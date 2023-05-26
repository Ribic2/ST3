<template>
    <v-container fluid v-if="friendRequests.length === 0" style="height: 100%">
        <v-row align="center" justify="center"
               style="height:100%" dense>
            <v-col cols="12" lg="6" md="6" class="fill-height d-flex flex-column justify-center align-center">
                <v-card flat tile>
                    <v-card-title>You have no friend requests!</v-card-title>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    <friend-request v-else v-for="request in friendRequests" :request="request"/>
</template>

<script>
import FriendRequest from "../../Components/FriendRequest.vue";

export default {
    name: "friend-requests",
    components: {FriendRequest},
    data() {
        return {}
    },
    computed: {
        friendRequests() {
            return this.$store.state.friendRequests
        }
    }
}
</script>
