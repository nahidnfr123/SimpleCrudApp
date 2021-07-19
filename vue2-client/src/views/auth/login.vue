<template>
    <v-form>
        <v-container>
            <form @submit.stop.prevent="login()">
                <h3 style="text-align: center; margin: 10px;">Login</h3>
                <v-row>
                    <v-col cols="12" sm="6">
                        <InputComponent
                            v-model="loginFormData.username"
                            type="text"
                            label="Email / Username:"
                            id="email-username"
                            placeholder="Email or Username"
                            :error="errors.username && Array.isArray(errors.username) ? errors.username[0] : errors.username"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <InputComponent
                            v-model="loginFormData.password"
                            type="password"
                            label="Password:"
                            id="password"
                            :error="errors.password && Array.isArray(errors.password) ? errors.password[0] : errors.password"
                        />
                    </v-col>
                </v-row>
                <div class="my-2">
                    <v-btn color="primary" class="mr-4" @click="login()">Login</v-btn>
                    <v-btn @click="clear">clear</v-btn>
                </div>
            </form>
        </v-container>
    </v-form>
</template>

<script type="application/javascript">
import {mapGetters} from "vuex";
import InputComponent from "@/components/Form/InputComponent";

export default {
    components: {InputComponent},
    data: () => ({
        loginFormData: {
            username: '',
            password: '',
        },
        errors: [],
    }),

    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
            getError: 'auth/error',
        })
    },

    methods: {
        validateData() {
            if (!this.loginFormData.username)
                this.errors.username = "Email or username is required";

            if (!this.loginFormData.password)
                this.errors.password = "Password is required";
            else if (this.loginFormData.password.length < 8)
                this.errors.password = "Password should de at-least 8 characters";
        },
        async login() {
            this.errors = [];
            //this.validateData();
            if (Object.keys(this.errors).length) {
                return;
            }
            await this.$store.dispatch('auth/login', this.loginFormData)
                .then(() => {
                    if (this.getError && Object.keys(this.getError).length) {
                        this.errors = this.getError
                        return;
                    } else if (this.authenticated && this.user) {
                        this.$router.push({
                            name: 'People'
                        })
                    }
                });
        },
        clear() {
            this.loginFormData = {
                username: '',
                password: '',
            };
            this.errors = []
        },
    },
}
</script>
