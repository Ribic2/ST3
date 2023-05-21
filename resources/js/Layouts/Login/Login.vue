<template>

    <v-app-bar clipped-left app class="flex align-center">
        <v-toolbar-title>Facebook</v-toolbar-title>
    </v-app-bar>

    <v-main>
        <v-container>
            <v-card>
                <v-card-title>Login</v-card-title>

                <v-card-actions>
                    <v-form class="w-100">
                        <v-text-field variant="outlined" label="E-mail"/>
                        <v-text-field variant="outlined" label="Password"
                                      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                      :type="showPassword ? 'text' : 'password'"
                                      @click:append="showPassword = !showPassword"/>

                        <v-checkbox label="Remember me"/>
                        <v-btn>Login</v-btn>
                    </v-form>
                </v-card-actions>
            </v-card>
        </v-container>
    </v-main>
</template>

<script>
export default {
    name: "Login",
    data(){
        return{
            showPassword: false
        }
    }
}
</script>
