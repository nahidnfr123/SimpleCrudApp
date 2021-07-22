<template>
    <div class="px-4 py-4">
        <h3>Categories</h3>

        <v-alert
            border="top"
            color="red lighten-2"
            dark
            v-if="errors && errors.length"
        >
            {{ errors }}
        </v-alert>

        <form @submit.stop.prevent="addNewCategory()" v-if="$isLoggedIn">
            <v-row class="px-4 mt-2 mb-5">
                <v-text-field
                    label="Add Category"
                    hide-details="auto"
                    v-model="categoryForm.name"
                ></v-text-field>
                <v-btn tile color="primary" @click="addNewCategory()">Add Category</v-btn>
            </v-row>
            <p style="color: red; font-size: 12px" v-if="errors.name">
                {{ Array.isArray(errors.name) ? errors.name[0] : errors.name }}
            </p>
        </form>

        <v-card elevation="4" :loading="loadingCategories" class="my-12 px-6">
            <div class="py-4">
                <div v-if="loadingCategories" class="text-center">
                    <v-progress-circular
                        indeterminate
                        color="purple"
                        :width="3"
                    ></v-progress-circular>
                    Loading Categories ...
                </div>
                <CategoryTreeView
                    v-if="categories && categories.length"
                    :categories="categories"
                    @category_error="category_error($event)"
                />
            </div>
        </v-card>
    </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import CategoryTreeView from "@/components/CategoryTreeView";

export default {
    name: "Category",
    components: {CategoryTreeView},
    computed: {
        ...mapGetters({
            categories: "categories",
            getErrors: "errors",
        }),
    },
    data() {
        return {
            loadingCategories: false,
            categoryForm: {
                name: "",
            },
            errors: [],
        };
    },
    mounted() {
        this.loadCategories();
    },
    methods: {
        ...mapActions({
            getCategories: "setCategories",
            addCategory: "addCategory",
            clearErrors: "clearErrors",
        }),
        loadCategories() {
            this.loadingCategories = true;
            this.getCategories().finally(() => {
                this.loadingCategories = false;
            });
        },
        deleteCategory(event) {
            console.log(event);
        },
        validateData() {
            if (!this.categoryForm.name)
                this.errors.name = "You must insert category name.";
            else if (this.categoryForm.name.length < 2)
                this.errors.name = "Category name should be at-least 2 letters.";
        },
        addNewCategory() {
            this.errors = [];
            this.validateData();
            if (Object.keys(this.errors).length) {
                return;
            }
            this.addCategory(this.categoryForm).finally(() => {
                if (this.getErrors && Object.keys(this.getErrors).length) {
                    this.errors = this.getErrors;
                } else {
                    this.clearAll();
                }
            });
        },
        clearAll() {
            this.errors = [];
            this.clearErrors();
            this.categoryForm = {
                name: "",
            };
        },
        category_error(value) {
            this.errors = value;
        }
    },
};
</script>
