import { HTTP } from "@/plugins/http";

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
        updateCategories(state, value) {
            state.categories = value;
        },
        addNewCategory(state, value) {
            state.categories.push(value);
        }
    },
    actions: {
        // eslint-disable-next-line no-unused-vars
        async setCategories({ commit, dispatch }) {
            return await HTTP
                .get("api/category")
                .then((response) => {
                    commit("updateCategories", response.data.data);
                })
                .catch((errors) => {
                    dispatch("setErrors", errors);
                });
        },
        async addCategory({ commit, dispatch }, data) {
            return await HTTP
                .post("api/category", data)
                .then((response) => {
                    if (response) {
                        commit("addNewCategory", response.data.data);
                    }
                })
                .catch((errors) => {
                    dispatch("setErrors", errors);
                });
        }
    }
};
