<template>
    <v-col cols="12" v-if="showSubcategoryFormFor === parent_category_id ">
        <form @submit.stop.prevent="addSubCategory(parent_category_id)" v-if="$isLoggedIn">
            <v-row class="px-4 mt-2 mb-5">
                <v-text-field
                    small
                    label="Add Category"
                    hide-details="auto"
                    v-model="categoryForm.name"
                ></v-text-field>
                <v-btn small color="primary" @click="addSubCategory(parent_category_id)">Add Category</v-btn>
            </v-row>
            <p style="color: red; font-size: 12px" v-if="errors.name">
                {{ Array.isArray(errors.name) ? errors.name[0] : errors.name }}
            </p>
        </form>
    </v-col>
</template>

<script>
export default {
    name: "SubcategoryForm",
    props: {
        showSubcategoryFormFor: {
            type: Number,
            default: 0
        },
        parent_category_id: {
            type: Number,
            default: 0
        },
    },
    data() {
        return {
            errors: [],
            categoryForm: {
                name: '',
            }
        }
    },
    methods: {
        addSubCategory() {

        },
    }
}
</script>

<style scoped>

</style>
