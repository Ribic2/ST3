<template>
    <loader-component v-if="loading"/>
    <v-container>
        <h1 v-if="friends.length ==0">Your friend list is empty</h1>
        <FriendCard v-for="friend in friends" :friend="friend"/>
    </v-container>
</template>

<script>
import {Factory} from "../../Api/Factory.js";
import FriendCard from "../../Components/FriendCard.vue";
import LoaderComponent from "../../Components/LoaderComponent.vue";

const userFactory = Factory.get('User')
export default {
    components: {LoaderComponent, FriendCard},
    data(){
        return{
            friends: [],
            loading: true
        }
    },
    name: "Friends",
    mounted() {
        userFactory.getFriends().then((res)=>{
            this.friends = res.data.friends
            this.loading = false
        })
    }
}
</script>

<style scoped>

</style>
