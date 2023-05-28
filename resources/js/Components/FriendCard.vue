<template>
    <v-card class="mb-3" @click="goToUsersPage">
        <v-card-title>{{ fullName }}</v-card-title>
        <v-card-text>{{ this.friend.email }}</v-card-text>
    </v-card>
</template>

<script>

export default {
    props: ["friend"],
    name: "FriendCard",
    computed: {
        fullName() {
            return `${this.friend.name} ${this.friend.surname}`
        }
    },
    methods: {
        goToUsersPage() {
            this.$router.push({name: 'user', params: {id: this.friend.id}})
        }
    }
}
</script>

<style scoped>

</style>
