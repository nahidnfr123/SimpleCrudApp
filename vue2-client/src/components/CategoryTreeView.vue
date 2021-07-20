<template>
    <ul class="category-ul">
        <p class="error" v-if="errors && errors.length">{{ errors }}</p>
        <li v-for="category in categories" :key="'category' + category.id">
            <v-row align="center" justify="space-between" class="py-2">
                <div>{{ category.name }}</div>
                <div v-if="$isLoggedIn">
                    <!--                    <v-btn primary x-small color="primary"> Add</v-btn>
                                        <v-btn primary x-small color="warning"> Edit</v-btn>-->
                    <v-btn primary x-small color="error" @click="deleteRequest(category)"> Delete</v-btn>
                </div>
            </v-row>

            <CategoryTreeView
                v-if="category.children && category.children.length"
                :categories="category.children"
            />
        </li>
    </ul>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "CategoryTreeView",
    props: {
        categories: {
            type: Array,
            default: () => {
            },
        },
    },
    data() {
        return {
            errors: [],
        }
    },
    computed: {
        ...mapGetters({
            getErrors: "errors"
        })
    },
    methods: {
        ...mapActions({
            deleteCategory: 'deleteCategory'
        }),
        deleteRequest(category) {
            this.deleteCategory(category).then(() => {
                if (this.getErrors) {
                    this.errors = this.getErrors
                }
            });
        }
    }
};
</script>

<style>
.category-ul li {
    padding: 10px 0 10px 6px !important;
}
</style>
