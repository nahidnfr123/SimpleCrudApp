<template>
    <div class="container">
        <h3 class="text-center">Products List</h3>

        <div class="my-4" v-if="$isLoggedIn">
            <div class="flex-row al-mid justify-between">
                <AddProductModal/>
                <!--<CustomButton buttonName="Bulk delete" buttonColor="error"/>-->
            </div>
        </div>

        <v-card elevation="4" :loading="loadingProducts" class="my-6 px-4">
            <div class="py-4">
                <div v-if="loadingProducts" class="text-center">
                    <v-progress-circular
                        indeterminate
                        color="purple"
                        :width="3"
                    ></v-progress-circular>
                    Loading Products ...
                </div>
                <v-simple-table v-if="products && products.length">
                    <template v-slot:default>
                        <thead>
                        <tr>
                            <th class="text-left">
                                <!--                                <input type="checkbox" name="select_all"/>-->
                                #
                            </th>
                            <th class="text-left">Product Name</th>
                            <th class="text-left">Category</th>
                            <th class="text-left">Total Stock</th>
                            <th class="text-left">Price</th>
                            <th class="text-left">status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="product in products" :key="product.id">
                            <td>
                                <!--                                <input type="checkbox" name="select_all"/>-->
                                {{ product.id }}
                            </td>
                            <td>
                                <img v-if="product.image" :src="$apiURL+product.image" height="30px" alt=""/>
                                <div>{{ product.name }}</div>
                            </td>
                            <td>
                                <div v-if="product.categories">
                                    <v-chip
                                        x-small
                                        color="primary"
                                        v-for="category in product.categories"
                                        :key="category.id"
                                        class="mr-1"
                                    >
                                        {{ category.name }}
                                    </v-chip>
                                </div>
                            </td>
                            <td>{{ product.total_stock }}</td>
                            <td>{{ product.price }}</td>
                            <td>{{ product.status }}</td>
                            <td>
                                <v-row>
                                    <!--                                    <v-col cols="4">
                                                                            <v-btn class="mx-2" fab dark x-small color="primary">
                                                                                <v-icon dark>mdi-eye</v-icon>
                                                                            </v-btn>
                                                                        </v-col>-->
                                    <template v-if="$isLoggedIn">
                                        <v-col cols="4">
                                            <AddProductModal formType="update" :dataToUpdate="product"/>
                                            <!--                                            <v-btn class="mx-2" fab dark x-small color="warning">
                                                                                            <v-icon dark>mdi-pencil</v-icon>
                                                                                        </v-btn>-->
                                        </v-col>
                                        <v-col cols="4">
                                            <v-btn class="mx-2" fab dark x-small color="error" @click="deleteProductCall(product)">
                                                <v-icon dark>mdi-trash-can-outline</v-icon>
                                            </v-btn>
                                        </v-col>
                                    </template>
                                </v-row>
                            </td>
                        </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <div v-else>
                    <v-alert v-if="!products" border="top" color="red lighten-2" dark>
                        No products available!
                    </v-alert>
                </div>
            </div>
        </v-card>

    </div>
</template>


<script>
import {mapGetters, mapActions} from "vuex";
import ComboBox from "@/components/Form/ComboBox";
import AddProductModal from "@/components/AddProductModal";
import CustomButton from "@/components/Form/Button";

export default {
    name: "Products",
    components: {CustomButton, AddProductModal, ComboBox},
    computed: {
        ...mapGetters({
            categories: "categories",
            products: "products"
        })
    },
    data() {
        return {
            loadingProducts: false,
            searchParameters: {
                query: "",
                selectedCategories: [1]
            }
        };
    },
    mounted() {
        this.loadProducts();
        this.loadCategories();
    },
    methods: {
        ...mapActions({
            getCategories: "setCategories",
            getProducts: "setProducts",
            deleteProduct: "deleteProduct"
        }),
        loadProducts() {
            this.loadingProducts = true;
            this.getProducts().finally(() => {
                this.loadingProducts = false;
            });
        },
        loadCategories() {
            this.getCategories();
        },
        updateTextValue(event) {
            let isChecked = event.target.checked;
            if (isChecked) this.selectedItems.push(event.target.value);
            else this.selectedItems.splice(this.selectedItems.indexOf(event.target.value), 1);

            //console.log(this.selectedItems);
            this.$emit("input", this.selectedItems);
        },
        deleteProductCall(product) {
            this.loadingProducts = true;
            this.deleteProduct(product)
                .finally(() => {
                    this.loadingProducts = false;
                })
        },
    }
};
</script>


<style scoped>
.flex-row {
    display: flex;
    flex-direction: row;
}

.justify-between {
    justify-content: space-between;
}

.al-mid {
    align-items: center;
    align-content: center;
}
</style>
