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
                        <v-text-field variant="outlined" label="E-mail" v-model="email"/>
                        <v-text-field variant="outlined" label="Password"
                                      v-model="password"
                                      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                      :type="showPassword ? 'text' : 'password'"
                                      @click:append="showPassword = !showPassword"/>
                        <v-btn @click="loginUser()">Login</v-btn>
                    </v-form>
                </v-card-actions>

                <v-card-text>
                    <v-alert type="error" title="Response error" v-if="isError">
                        <v-span v-html="errorText"/>
                    </v-alert>
                </v-card-text>
            </v-card>
        </v-container>
    </v-main>
</template>

<script>
import {Factory} from "../../Api/Factory.js";

const User = Factory.get('User')

export default {
    name: "Login",
    data() {
        return {
            showPassword: false,
            email: '',
            password: '',
            isError: false,
            errorText: '<ul>'
        }
    },
    methods: {
        async loginUser() {
            let password = this.password
            let email = this.email

            await User.login({password: password, email: email})
                .then((res) => {
                    axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`;
                    localStorage.setItem('token', res.data.token)
                }).then(() => {
                    this.$router.push("/webapp")
                })
                .catch((err) => {
                    this.errorText = "<ul>"
                    for (const errElement in err.response.data.error) {
                        this.errorText += `<li>${err.response.data.error[errElement]}</li>`
                    }
                    this.errorText += "</ul>"
                    this.isError = true;
                })
        }
    }
}
</script>
