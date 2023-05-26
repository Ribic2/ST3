<template>
    <v-container fluid>
        <v-row align="center" justify="center"
               style="height:100vh" dense>
            <v-col cols="12" lg="6" md="6" class="fill-height d-flex flex-column justify-center align-center">
                <v-card flat tile>
                    <v-progress-circular indeterminate size="70"></v-progress-circular>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "LoaderComponent"
}
</script>

<style scoped>

</style>
