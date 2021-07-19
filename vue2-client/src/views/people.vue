<template>
    <div>
        <v-card elevation="4" :loading="loadingUsers" class="my-12 px-6">
            <div class="py-4">
                <div v-if="loadingUsers" class="text-center">
                    <v-progress-circular
                        indeterminate
                        color="purple"
                        :width="3"
                    ></v-progress-circular>
                    Loading Users ...
                </div>
                <div v-if="!loadingUsers && !users">
                    <div style="text-align: center; padding-top: 20px; color: blueviolet; font-weight: bolder;">
                        No Users found ...
                    </div>
                </div>
                <v-card
                    class="mx-auto"
                    max-width="600"
                    tile
                    v-if="users && users.length"
                >
                    <div style="padding: 10px 0; text-align: center;background-color: #fa9512">User List</div>
                    <hr>
                    <v-list-item v-for="user in users" :key="user.id">
                        <v-list-item-content>
                            <v-list-item-title>{{ user.name }}</v-list-item-title>
                            <v-list-item-subtitle>
                                {{ user.username }}
                            </v-list-item-subtitle>
                            <v-list-item-subtitle>
                                {{ user.email }}, <span v-if="user.email_verified_at" style="color: green; margin-left: 20px">Verified</span>
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-card>
            </div>
        </v-card>
    </div>
</template>

<script>
import {HTTP} from "@/plugins/http";

export default {
    name: "people.vue",
    data() {
        return {
            loadingUsers: false,
            users: []
        }
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        async getUsers() {
            this.loadingUsers = true;
            await HTTP.get('/api/users')
                .then((response) => {
                    this.users = response.data;
                }).catch(error => {
                    console.log(error);
                }).finally(() => {
                    this.loadingUsers = false;
                });
        }
    }
}
</script>

<style scoped>

</style>
