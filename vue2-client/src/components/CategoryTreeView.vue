<template>
    <ul class="category-ul">
        <li v-for="category in categories" :key="'category' + category.id">
            <v-row align="center" justify="space-between" class="py-2">
                <v-col cols="12">
                    <v-row align="center" justify="space-between" class="py-2">
                        <div>{{ category.name }}
                            <span class="small-text" v-if="category.product_count > 0"> - ({{ category.product_count }}) Products</span>
                            <span class="small-text" v-if="category.product_counter > 0"> > ({{ category.product_counter }}) Total</span>
                        </div>
                        <div v-if="$isLoggedIn">
                            <v-btn primary x-small color="primary" @click="showSubcategoryFormFor=category.id"> Add</v-btn>
                            <!--                    <v-btn primary x-small color="warning"> Edit</v-btn>-->
                            <v-btn primary x-small color="error" @click="deleteRequest(category)"> Delete</v-btn>
                        </div>
                    </v-row>
                </v-col>
                <v-col cols="12" v-if="showSubcategoryFormFor === category.id ">
                    <form @submit.stop.prevent="addSubCategory(category.id)" v-if="$isLoggedIn">
                        <v-row class="px-4 mt-2 mb-5">
                            <v-text-field
                                small
                                label="Add Category"
                                hide-details="auto"
                                v-model="categoryForm.name"
                            ></v-text-field>
                            <v-btn small color="primary" @click="addSubCategory(category.id)">Add Category</v-btn>
                        </v-row>
                        <p style="color: red; font-size: 12px" v-if="errors.name">
                            {{ Array.isArray(errors.name) ? errors.name[0] : errors.name }}
                        </p>
                    </form>
                </v-col>
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
            showSubcategoryFormFor: 0,
            categoryForm: {
                name: '',
            }
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
            // Remove previous errors..
            this.errors = {};
            this.$emit('category_error', this.errors);

            this.deleteCategory(category).then(() => {
                if (this.getErrors) {
                    // Add errors ..
                    this.errors = this.getErrors;
                    this.$emit('category_error', this.errors);
                }
            });
        },
        addSubCategory() {

        }
    }
};
</script>

<style>
.category-ul li {
    padding: 10px 0 10px 6px !important;
}

.small-text {
    font-size: 12px;
}
</style>
