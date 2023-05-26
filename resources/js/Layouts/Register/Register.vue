<template>
    <v-app-bar clipped-left app class="flex align-center">
        <v-toolbar-title>Facebook</v-toolbar-title>
    </v-app-bar>

    <v-main>
        <v-container>
            <v-card>
                <v-card-title>Register</v-card-title>

                <v-card-actions>
                    <v-form class="w-100">
                        <v-text-field variant="outlined" label="E-mail" v-model="email"/>
                        <v-text-field variant="outlined" label="Password"
                                      v-model="password"
                                      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                      :type="showPassword ? 'text' : 'password'"
                                      @click:append="showPassword = !showPassword"/>


                        <v-text-field variant="outlined" label="Password confirmation"
                                      v-model="password_confirmation"
                                      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                      :type="showPassword ? 'text' : 'password'"
                                      @click:append="showPassword = !showPassword"/>

                        <v-text-field variant="outlined" label="Name" v-model="name"/>
                        <v-text-field variant="outlined" label="Surname" v-model="surname"/>

                        <v-btn @click="register">Register now</v-btn>
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

const UserFactory = Factory.get('User')

export default {
    name: "Register",
    data() {
        return {
            showPassword: false,
            email: '',
            password: '',
            isError: false,
            name: '',
            surname: '',
            errorText: '<ul>',
            password_confirmation: ''
        }
    },
    methods: {
        async register() {
            await UserFactory.register(
                {
                    email: this.email,
                    password: this.password,
                    name: this.name,
                    surname: this.surname,
                    password_confirmation: this.password_confirmation,
                    dateOfBirth: '2.2.2022'
                }
            ).then((res) => {
                    axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`;
                    localStorage.setItem('token', res.data.token)
                }
            ).then(() => {
                window.location.href = "/webapp"
            })
        }
    }
}
</script>

<style scoped>

</style>
