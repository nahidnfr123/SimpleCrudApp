<template>
    <v-col cols="3">
        <v-sheet rounded="lg">
            <v-list color="transparent">
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title>
                            <router-link to="/categories">
                                <v-btn text>Category</v-btn>
                            </router-link>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title>
                            <router-link to="/products">
                                <v-btn text>Products</v-btn>
                            </router-link>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider class="my-2"></v-divider>


<!--                <v-list-item
                    link
                    color="grey lighten-4">
                    <v-list-item-content>
                        <v-list-item-title>
                            Refresh
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>-->
            </v-list>
        </v-sheet>
    </v-col>
</template>

<script>
export default {
    name: "SideBar"
}
</script>

<style scoped>

</style>
