<template>
    <v-navigation-drawer :rail="!isMobile" app clipped v-model="enableDrawer">
        <v-list>
            <v-list-item prepend-icon="mdi-home" title="Home" value="home" to="/webapp"/>
            <v-list-item prepend-icon="mdi-account" title="Account" value="account" to="/webapp/account"/>
            <v-list-item prepend-icon="mdi-account-multiple" title="Friend list" value="Friend list" to="/webapp/friends"/>
        </v-list>
    </v-navigation-drawer>

    <v-app-bar clipped-left app class="flex align-center">
        <v-app-bar-nav-icon class="mr-2" @click="drawer = !drawer"/>
        <v-autocomplete
            variant="outlined"
            dense
            hide-details
            no-filter
            :items="results"
            :class="[isMobile ? 'mr-2': '']"
            placeholder="Search for user..."
            @input="searchUsers"
            return-object
            multiple
        >
            <template #item="{ item }">
                <v-list-item class="d-flex" @click="goToSelectedAccount(item.value)">
                    <div class="ml-2">{{ item.value.name }} {{ item.value.surname }}</div>
                </v-list-item>
            </template>
        </v-autocomplete>
        <v-spacer v-if="!isMobile"/>

        <v-btn stacked @click="goToFriendRequests" v-if="this.friendRequests.length > 0">
            <v-badge
                     color="error"
                     :content="this.friendRequests.length"
            >
                <v-icon icon="mdi-account"></v-icon>
            </v-badge>

            Friend requests
        </v-btn>

        <v-btn stacked @click="goToFriendRequests" v-else>
            <v-icon icon="mdi-account"></v-icon>
        </v-btn>

        <v-menu>
            <template v-slot:activator="{ props }">
                <v-btn
                    icon
                    v-bind="props"
                >
                    <v-avatar
                        color="brown"
                    >
                        {{ initials }}
                    </v-avatar>
                </v-btn>
            </template>

            <v-card>
                <v-card-text>
                    <div class="mx-auto text-center">
                        <v-avatar
                            color="brown"
                        >
                            <span class="text-h5">{{ initials }}</span>
                        </v-avatar>
                        <h3>{{ user.name }} {{ user.surname }}</h3>
                        <p class="text-caption mt-1">
                            {{ user.email }}
                        </p>
                        <v-divider class="my-3"></v-divider>
                        <v-btn
                            rounded
                            variant="text"
                        >
                            Edit Account
                        </v-btn>
                        <v-divider class="my-3"></v-divider>
                        <v-btn
                            rounded
                            @click="logout"
                            variant="text"
                        >
                            Logout
                        </v-btn>
                    </div>
                </v-card-text>
            </v-card>
        </v-menu>

    </v-app-bar>
    <v-main>
        <router-view/>
    </v-main>

</template>

<script>

import {useDisplay} from "vuetify";
import {Factory} from "../../Api/Factory.js";

const user = Factory.get('User')

export default {
    name: "Default",
    data() {
        return {
            isMobile: useDisplay().mobile,
            drawer: false,
            user: {},
            initials: '',
            results: [],
            friendRequests: ''
        }
    },
    computed: {
        enableDrawer: {
            get() {
                return this.isMobile ? this.drawer : true;
            },
            set(value) {
                this.drawer = value
            }
        },
    },
    async mounted() {
        await user.getUser().then((res) => {
            this.user = res.data.user
            console.log(res.data.user)
            this.friendRequests = res.data.user.friendRequests
            this.initials = `${this.user.name[0]}${this.user.surname[0]}`
            this.$store.commit('addFriendRequest', this.friendRequests)
            this.$store.commit('setUser', this.user)
            this.$store.commit('setPost', res.data.posts)
        })
    },
    methods: {
        async searchUsers(e) {
            let query = e.srcElement.value
            await user.searchUsers({params: {query}}).then((res) => {
                this.results = res.data.users
            })
        },
        async goToSelectedAccount(data) {
            this.$router.push({name: 'user', params: {id: data.id}})
        },
        async goToFriendRequests() {
            this.$router.push({name: 'friend-request'})
        },
        async logout() {
            localStorage.clear()
            this.$router.push({name: 'login'})
        }
    }
}
</script>

<style scoped>

</style>
