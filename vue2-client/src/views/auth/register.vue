<template>
    <v-form>
        <v-container>
            <form @submit.stop.prevent="register()">
                <h3 style="text-align: center; margin: 10px;">Register</h3>

                <v-row>
                    <v-col cols="12" sm="6">
                        <InputComponent
                            v-model="registerFormData.name"
                            type="text"
                            label="Name:"
                            id="name"
                            placeholder="Name"
                            :error="errors.name && Array.isArray(errors.name) ? errors.name[0] : errors.name"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <InputComponent
                            v-model="registerFormData.username"
                            type="text"
                            label="Username:"
                            id="username"
                            placeholder="Username"
                            :error="errors.username && Array.isArray(errors.username) ? errors.username[0] : errors.username"
                        />
                    </v-col>
                    <v-col cols="12" sm="12">
                        <InputComponent
                            v-model="registerFormData.email"
                            type="email"
                            label="Email:"
                            id="email"
                            placeholder="Email Address"
                            :error="errors.email && Array.isArray(errors.email) ? errors.email[0] : errors.email"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <InputComponent
                            v-model="registerFormData.password"
                            type="password"
                            label="Password:"
                            id="password"
                            :error="errors.password && Array.isArray(errors.password) ? errors.password[0] : errors.password"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <InputComponent
                            v-model="registerFormData.password_confirmation"
                            type="password"
                            label="Retype Password:"
                            id="password_confirmation"
                            :error="
                        errors.password_confirmation &&
                        Array.isArray(errors.password_confirmation)
                            ? errors.password_confirmation[0]
                            : errors.password_confirmation
                    "
                        />
                    </v-col>
                </v-row>
                <div class="my-2">
                    <v-btn color="primary" class="mr-4" @click="register()">Register</v-btn>
                    <v-btn @click="clear">clear</v-btn>
                </div>
            </form>
        </v-container>
    </v-form>
</template>

<script type="application/javascript">
import InputComponent from "@/components/Form/InputComponent";
import {mapGetters} from "vuex";

export default {
    data: () => ({
        registerFormData: {
            name: '',
            username: '',
            email: '',
            password: '',
            password_confirmation: '',
        },
        errors: [],
    }),
    components: {InputComponent},
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
            getError: 'auth/error',
        })
    },

    methods: {
        validateData() {
            if (!this.registerFormData.name)
                this.errors.name = "Name is required";
            else if (this.registerFormData.name.length < 3)
                this.errors.name = "Name is must be at-least 3 letters";

            if (!this.registerFormData.username)
                this.errors.username = "Username is required";
            else if (this.registerFormData.username.length < 3)
                this.errors.username = "Username is must be at-least 3 letters";

            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!this.registerFormData.email)
                this.errors.email = "Email is required";
            else if (!pattern.test(this.registerFormData.email))
                this.errors.email = "Invalid Email!";

            if (!this.registerFormData.password)
                this.errors.password = "Password is required";
            else if (this.registerFormData.password.length < 8)
                this.errors.password = "Password should be at-least 8 characters";
            else if (this.registerFormData.password_confirmation !== this.registerFormData.password)
                this.errors.password = "Password and confirm password did not match!";
        },
        async register() {
            this.errors = [];
            this.validateData();
            if (Object.keys(this.errors).length) {
                return;
            }
            await this.$store.dispatch('auth/register', this.registerFormData)
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
            this.registerFormData = {
                name: '',
                email: '',
                username: '',
                password: '',
                password_confirmation: '',
            }
            this.errors = []
        },
    },
}
</script>
