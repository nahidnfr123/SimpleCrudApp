import {HTTP} from "@/plugins/http";
import _ from "lodash";

export default {
    state: {
        categories: []
    },
    getters: {
        categories(state) {
            return state.categories;
        }
    },
    mutations: {
        setCategories(state, value) {
            state.categories = value;
        },
        updateProducts(state, value) {
            state.categories.map(to => {
                if (to.id == value.id) {
                    for (let key in value) {
                        to[key] = value[key];
                    }
                }
            });
        },
        addNewCategory(state, value) {
            state.categories.push(value);
        },
        removeCategory(state, data) {

        },
    },
    actions: {
        async setCategories({commit, dispatch}) {
            return await HTTP
                .get("api/category")
                .then((response) => {
                    commit("setCategories", response.data.data);
                    dispatch("clearErrors", []);
                })
                .catch((errors) => {
                    dispatch("setErrors", errors);
                });
        },
        async addCategory({commit, dispatch}, data) {
            return await HTTP
                .post("api/category", data)
                .then((response) => {
                    if (response) commit("addNewCategory", response.data.data);
                    dispatch("clearErrors", []);
                })
                .catch((errors) => {
                    dispatch("setErrors", errors);
                });
        },
        async deleteCategory({commit, dispatch}, value) {
            await HTTP
                .delete(`/api/category/${value.id}`,)
                .then((response) => {
                    //commit("removeCategory", response.data.data);
                    dispatch("setCategories");
                    dispatch("clearErrors", []);
                })
                .catch((error) => {
                    let customErrorMessage = null;
                    if (error.response && error.response.status === 500) {
                        commit('updateErrors', error.response.data.errorMsg);
                        return;
                    }
                    dispatch("setErrors", error, customErrorMessage);
                });
        }
    }
};
