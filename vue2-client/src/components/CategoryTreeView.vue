<template>
    <ul class="category-ul">
        <li v-for="category in categories" :key="'category' + category.id">
            <v-row align="center" justify="space-between" class="py-2">
                <v-col cols="12">
                    <v-row align="center" justify="space-between" class="py-2">
                        <div>{{ category.name }}
                            <span class="small-text" v-if="category.products_count > 0"> - ({{ category.products_count }}) Products</span>
                            <span class="small-text" v-if="category.products_count_total > 0"> - Total: ({{ category.products_count_total }})</span>
                        </div>
                        <div v-if="$isLoggedIn">
                            <v-btn primary x-small color="primary" @click="showSubcategoryFormFor=category.id">Add</v-btn>
                            <!--<v-btn primary x-small color="warning ml-1">Edit</v-btn>-->
                            <v-btn primary x-small color="error ml-1" @click="deleteRequest(category)">Delete</v-btn>
                        </div>
                    </v-row>
                </v-col>

                <!-- Add or edit category -->
                <SubcategoryForm
                    :showSubcategoryFormFor="showSubcategoryFormFor"
                    :parent_category_id="category.id"
                />

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
import SubcategoryForm from "@/components/SubcategoryForm";

export default {
    name: "CategoryTreeView",
    components: {SubcategoryForm},
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
    padding: 0 0 0 6px !important;
}

.small-text {
    font-size: 12px;
    color: #ff3636;
}
</style>
