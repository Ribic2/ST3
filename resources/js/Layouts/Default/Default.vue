<template>
    <v-navigation-drawer :rail="!isMobile" app clipped v-model="drawer">
        <v-list-item prepend-icon="mdi-account" title="My Account" value="account"></v-list-item>
    </v-navigation-drawer>

    <v-app-bar clipped-left app class="flex align-center">
        <v-app-bar-nav-icon class="mr-2" @click="drawer = !drawer"/>
        <v-autocomplete variant="outlined" dense hide-details :class="[isMobile ? 'mr-2': '']"/>
        <v-spacer v-if="!isMobile"/>
        <v-avatar color="surface-variant" class="mr-2"/>
    </v-app-bar>

    <v-main>
        <v-container>
            <h1>{{ isMobile.toString() }}</h1>
        </v-container>
    </v-main>

</template>

<script>

import {useDisplay} from "vuetify";

export default {
    name: "Default",
    data() {
        return {
            isMobile: useDisplay().mobile,
            drawer: false
        }
    }
}
</script>

<style scoped>

</style>
