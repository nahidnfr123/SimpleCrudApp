<template>
    <v-col cols="12">
        <form @submit.stop.prevent="addSubCategory(parent_category_id)" v-if="$isLoggedIn">
            <v-card class="d-flex justify-space-between align-center mt-2 mb-5" flat>
                <InputComponent
                    v-model="categoryForm.name"
                    type="text"
                    label=""
                    id="category-name"
                    placeholder="Category name"
                    :error="errors.name && Array.isArray(errors.name) ? errors.name[0] : errors.name"
                />
                <div>
                    <v-btn small color="primary" @click="addSubCategory(parent_category_id)">Submit</v-btn>
                    <v-btn small color="error" @click="closeForm(parent_category_id)">Close</v-btn>
                </div>
            </v-card>
        </form>
    </v-col>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import InputComponent from "@/components/Form/InputComponent";

export default {
    name: "SubcategoryForm",
    components: {InputComponent},
    props: {
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
                parent_category_id: 0
            }
        }
    },
    computed: {
        ...mapGetters({
            getErrors: "errors",
        }),
    },
    methods: {
        ...mapActions({
            addCategory: "addCategory",
            clearErrors: "clearErrors",
        }),
        closeForm() {
            this.clearAll();
            this.$emit('closeForm')
        },
        validateData() {
            if (!this.categoryForm.name)
                this.errors.name = "You must insert category name.";
            else if (this.categoryForm.name.length < 2)
                this.errors.name = "Category name should be at-least 2 letters.";
        },
        addSubCategory(parent_category_id) {
            this.categoryForm.parent_id = parent_category_id
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
    }
}
</script>

<style scoped>

</style>
