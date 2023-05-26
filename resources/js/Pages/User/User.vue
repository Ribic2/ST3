<template>
    <v-main>
        <v-btn
            @click="addAFriend"
            :disabled="isFriend"
            v-if="!isSameUser"
        >
            {{ addButtonText }}
        </v-btn>
        {{ user }}
    </v-main>
</template>

<script>
import {Factory} from "../../Api/Factory.js";

const user = Factory.get('User')

export default {
    name: "User",
    data() {
        return {
            user: {},
            addButtonText: "Add a friend",
            isFriend: false,
        }
    },
    mounted() {
        user.getSelectedUser(this.$route.params.id).then((res) => {
            this.user = res.data.user;
            this.isFriend = res.data.isFriend

            if (this.isFriend) {
                this.addButtonText = "Request already sent!"
            }
        });
    },
    methods: {
        addAFriend() {
            user.addAFriend({id: this.user.id, user_id: this.user.user_id}).then((res) => {
                this.addButtonText = "Request sent!"
            })
        }
    },
    computed:{
        isSameUser(){
            return this.user.id === this.$store.state.user.id
        }
    }
}
</script>

<style scoped>

</style>
