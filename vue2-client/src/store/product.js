import axios from "axios";
import {HTTP} from "@/plugins/http";

export default {
    state: {
        products: [],
    },
    getters: {
        products(state) {
            return state.products;
        },
    },
    mutations: {
        setProducts(state, value) {
            state.products = value;
        },
        updateProducts(state, value) {
            state.products.map(to => {
                if (to.id == value.id) {
                    for (let key in value) {
                        to[key] = value[key];
                    }
                }
            });
        },
        addNewProduct(state, value) {
            state.products.push(value);
        },
        removeProducts(state, value) {
            state.products = state.products.filter((obj) => {
                return obj.id != value.id;
            });
        },
    },
    actions: {
        // eslint-disable-next-line no-unused-vars
        async setProducts({commit, dispatch}) {
            await HTTP
                .get("/api/product")
                .then((response) => {
                    commit("setProducts", response.data.data);
                    dispatch("clearErrors", []);
                })
                .catch((error) => {
                    dispatch("setErrors", error);
                });
        },
        async addProduct({commit, dispatch}, data, config) {
            await HTTP
                .post("/api/product", data, config)
                .then((response) => {
                    commit("addNewProduct", response.data.data);
                    dispatch("clearErrors", []);
                })
                .catch((error) => {
                    dispatch("setErrors", error);
                });
        },
        async updateProduct({commit, dispatch}, combinedData) {
            await HTTP
                .post(`/api/product/${combinedData.id}`, combinedData.formData, combinedData.config)
                .then((response) => {
                    commit("updateProducts", response.data.data);
                    dispatch("clearErrors", []);
                })
                .catch((error) => {
                    dispatch("setErrors", error);
                });
        },
        async deleteProduct({commit, dispatch}, value) {
            await HTTP
                .delete(`/api/product/${value.id}`, value)
                .then((response) => {
                    commit("removeProducts", response.data.data);
                    dispatch("clearErrors", []);
                })
                .catch((error) => {
                    dispatch("setErrors", error);
                });
        }
    },
};
