<template>
    <v-col cols="12">
        <div class="text-primary">
            <strong>
                <span v-if="form_type">{{ form_type }} category</span>
                <span v-else>add category</span>
            </strong>
        </div>
        <form @submit.stop.prevent="submitSubCategory(form_category.id)" v-if="$isLoggedIn">
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
                    <v-btn small color="primary" @click="submitSubCategory(form_category.id)">
                        <template v-if="this.form_type">{{ this.form_type }}</template>
                        <template v-else>Submit</template>
                    </v-btn>
                    <v-btn small color="error" @click="closeForm(form_category.id)">Close</v-btn>
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
        form_category: {
            type: Object,
            default: () => {
            }
        },
        form_type: {
            type: String,
            default: ""
        }
    },
    data() {
        return {
            errors: [],
            categoryForm: {
                name: '',
                form_category_id: 0
            }
        }
    },
    mounted() {
        this.clearAll();
        if (this.form_type == 'update') {
            this.categoryForm = {
                name: this.form_category.name,
                form_category_id: this.form_category.id
            }
        }
    },
    watch: {
        form_type: function (val, oldVal) {
            if (val == 'update') {
                this.categoryForm = {
                    name: this.form_category.name,
                    form_category_id: this.form_category.id
                }
            } else {
                this.clearAll();
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
            updateCategory: "updateCategory",
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
        submitSubCategory(form_category_id) {
            this.errors = [];
            this.validateData();
            if (Object.keys(this.errors).length) {
                return;
            }
            if (this.form_type == 'update') {
                this.categoryForm.parent_id = 0;
                const combinedData = {
                    "id": form_category_id,
                    "formData": this.categoryForm,
                }
                this.updateCategory(combinedData).finally(() => {
                    if (this.getErrors && Object.keys(this.getErrors).length) {
                        this.errors = this.getErrors;
                    } else {
                        this.closeForm();
                    }
                });
            } else {
                this.categoryForm.parent_id = form_category_id
                this.addCategory(this.categoryForm).finally(() => {
                    if (this.getErrors && Object.keys(this.getErrors).length) {
                        this.errors = this.getErrors;
                    } else {
                        this.closeForm();
                    }
                });
            }
        },
        clearAll() {
            this.errors = [];
            this.clearErrors();
            this.categoryForm = {
                name: "",
                form_category_id: 0
            };
        },
    }
}
</script>

<style scoped>

</style>
