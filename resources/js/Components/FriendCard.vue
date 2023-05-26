<template>
    <v-card class="mb-3">
        <v-card-title>{{ fullName }}</v-card-title>
        <v-card-text>{{ this.friend.email }}</v-card-text>
    </v-card>
</template>

<script>

export default {
    props: ["friend"],
    name: "FriendCard",
    computed:{
        fullName(){
            return `${this.friend.name} ${this.friend.surname}`
        }
    }
}
</script>

<style scoped>

</style>
