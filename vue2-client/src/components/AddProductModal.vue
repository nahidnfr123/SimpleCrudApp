<template>
    <div class="text-center">
        <v-dialog
            v-model="dialog"
            width="500"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn class="mx-2" fab dark x-small color="warning"
                       v-bind="attrs"
                       v-on="on" v-if="formType=='update'">
                    <v-icon dark>mdi-pencil</v-icon>
                </v-btn>
                <v-btn
                    v-else
                    color="primary lighten-2"
                    dark
                    v-bind="attrs"
                    v-on="on"
                >
                    Add Product
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                    <span v-if="formType=='update'">Update product</span>
                    <span v-else>Add New Product</span>
                </v-card-title>

                <form @submit.stop.prevent class="px-2">
                    <div>
                        <label @click="handleComboBoxClick()" style="font-size: 14px;">Select Category</label>
                        <div class="comboBoxComponent" @click="handleComboBoxClick()" tabindex="-1" @blur="CBOclicked = false">
                            <div class="placeholders">
                                <div v-if="addProductFormData.categoriesId.length">{{ addProductFormData.categoriesId }}</div>
                                <div v-else>Select Category</div>
                            </div>
                            <template v-if="CBOclicked">
                                <div class="dropdownComboBox">
                                    <ComboBox
                                        :options="categories"
                                        displayProperty="name"
                                        valueProperty="id"
                                        placeholder="Select category"
                                        :selectedOptions="addProductFormData.categoriesId"
                                        @nodeClicked="updateSelectedCategoryValue($event)"
                                    />
                                </div>
                            </template>
                        </div>
                        <p class="text-danger" v-if="errors && Object.keys(errors).length">
                            {{ errors.category && Array.isArray(errors.category) ? errors.category[0] : errors.category }}
                        </p>
                    </div>

                    <InputComponent
                        v-model="addProductFormData.name"
                        type="text"
                        label="Name:"
                        id="name"
                        placeholder="Name"
                        :error="errors.name && Array.isArray(errors.name) ? errors.name[0] : errors.name"
                    />

                    <InputComponent
                        v-model="addProductFormData.total_stock"
                        type="number"
                        label="Total Stock:"
                        id="total_stock"
                        placeholder="10"
                        :error="errors.total_stock && Array.isArray(errors.total_stock) ? errors.total_stock[0] : errors.total_stock"
                    />

                    <InputComponent
                        v-model="addProductFormData.price"
                        type="number"
                        label="Price:"
                        id="price"
                        placeholder="1000 Tk"
                        :error="errors.price && Array.isArray(errors.price) ? errors.price[0] : errors.price"
                    />

                    <div class="my-2 custom-text-input">
                        <label for="productImage">Image: </label>
                        <input type="file" id="productImage" @change="onChange">
                        <p v-if="errors && Object.keys(errors).length">
                            {{ errors.file && Array.isArray(errors.file) ? errors.file[0] : errors.file }}
                        </p>
                    </div>

                    <div class="my-2 custom-text-input">
                        <label>Status: </label>
                        <v-radio-group v-model="addProductFormData.status">
                            <v-radio label="Available" :value="1"></v-radio>
                            <v-radio label="Not Available" :value="0"></v-radio>
                        </v-radio-group>
                    </div>

                    <v-textarea
                        solo
                        name="input-7-4"
                        label="Description"
                        v-model="addProductFormData.description"
                    ></v-textarea>
                    <p class="text-danger" v-if="errors && Object.keys(errors).length">
                        {{ errors.description && Array.isArray(errors.description) ? errors.description[0] : errors.description }}
                    </p>

                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" tile @click="postRequest()">
                            <span v-if="formType=='update'">Update</span>
                            <span v-else>Save</span>
                        </v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-dialog>
    </div>
</template>


<script>
import InputComponent from "@/components/Form/InputComponent";
import {HTTP} from "@/plugins/http";
import {mapActions, mapGetters} from "vuex";
import ComboBox from "@/components/Form/ComboBox";

export default {
    name: "AddProductModal",
    components: {ComboBox, InputComponent},
    props: {
        formType: {
            type: String,
            default: ''
        },
        dataToUpdate: {
            type: Object,
            default: () => {
            }
        }
    },
    data() {
        return {
            CBOclicked: false,
            dialog: false,
            addProductFormData: {
                name: "",
                price: "",
                total_stock: "",
                status: 1,
                image: "",
                description: "",
                categoriesId: [],
            },
            errors: {}
        };
    },
    computed: {
        ...mapGetters({
            categories: "categories",
            getErrors: 'errors'
        }),
    },
    mounted() {
        this.updateForm();
    },
    methods: {
        ...mapActions({
            addProduct: 'addProduct',
            updateProduct: 'updateProduct',
        }),
        handleComboBoxClick() {
            this.CBOclicked = true
        },
        updateForm() {
            if (this.formType == 'update' && Object.keys(this.dataToUpdate).length) {
                this.addProductFormData = {
                    name: this.dataToUpdate.name,
                    price: this.dataToUpdate.price.toString(),
                    total_stock: this.dataToUpdate.total_stock.toString(),
                    status: this.dataToUpdate.status,
                    image: this.dataToUpdate.image,
                    description: this.dataToUpdate.description,
                    categoriesId: [],
                }
                this.addProductFormData.categoriesId = this.dataToUpdate.categories.map(obj => {
                    return obj.id
                })
            }
        },
        onChange(e) {
            this.addProductFormData.image = e.target.files[0];
        },
        updateSelectedCategoryValue(data) {
            const index = this.addProductFormData.categoriesId.indexOf(data.id);
            if (index > -1) {
                this.addProductFormData.categoriesId.splice(index, 1);
            } else {
                this.addProductFormData.categoriesId.push(data.id);
            }

        },
        validation() {

        },
        async postRequest() {
            this.errors = {};
            this.validation();

            const config = {
                headers: {
                    "content-type": "multipart/form-data"
                }
            };
            const formData = new FormData();
            formData.append("name", this.addProductFormData.name);
            formData.append("price", this.addProductFormData.price);
            formData.append("total_stock", this.addProductFormData.total_stock);
            formData.append("status", this.addProductFormData.status);
            formData.append("file", this.addProductFormData.image);
            formData.append("description", this.addProductFormData.description);

            if (this.addProductFormData.categoriesId.length > 0) {
                for (let i = 0; i < this.addProductFormData.categoriesId.length; i++) {
                    formData.append('category[]', this.addProductFormData.categoriesId[i]);
                }
            } else formData.append('category', '');

            if (this.formType == 'update') {
                formData.append("_method", "PUT");
                const combinedData = {
                    "id": this.dataToUpdate.id,
                    "formData": formData,
                    "config": config
                }
                await this.updateProduct(combinedData).then(() => {
                    if (this.getErrors && Object.keys(this.getErrors).length) {
                        this.errors = this.getErrors;
                        return;
                    }
                    this.dialog = false;
                });
            } else {
                await this.addProduct(formData, config).then(() => {
                    if (this.getErrors && Object.keys(this.getErrors).length) {
                        this.errors = this.getErrors;
                        return;
                    }
                    this.dialog = false;
                });
            }
        },
    }
};
</script>
<style scoped lang="scss">
.custom-text-input {
    color: #1d2124;

    label {
        font-size: 14px;
    }

    input {
        border: 1px solid #1d2124;
        width: 100%;
        padding: 4px 10px;
        border-radius: 6px;

        &:focus {
            outline: 0;
        }
    }

    p {
        color: #ff3636;
        font-size: 14px;
    }
}

.text-danger {
    font-size: 14px;
    color: #ff3636;
}
</style>
