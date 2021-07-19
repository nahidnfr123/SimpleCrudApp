import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import category from "@/store/category";
import product from "@/store/product";
import auth from "@/store/auth";

export default new Vuex.Store({
    state: {
        errors: [],
    },
    getters: {
        errors(state) {
            return state.errors;
        },
    },
    mutations: {
        updateErrors(state, value) {
            state.errors = value;
        },
    },
    actions: {
        clearErrors({commit}) {
            commit("updateErrors", []);
        },
        setErrors(context, error) {
            let err = "Some error occurred!";
            if (error.response && error.response.status == 422) {
                err = error.response.data.errors;
            }
            context.commit("updateErrors", err);
            //generateErrors({commit, dispatch}, error, err, "Some error occurred!", true);
        },
    },
    modules: {
        category,
        product,
        auth,
    },
});

/*function generateErrors({commit, dispatch}, error, err, msg = "Error! ", showSnackBar = false) {
    let snakbarType = "Error!";
    if (error.response) {
        if (error.response.status == 401) {
            err = error.message;
            dispatch("snackbar/addSnack", {color: "danger", msg: "Unauthenticated: " + err, snakbarType: snakbarType,}, {root: true});
        } else if (error.response.status == 422) {
            err = error.response.data.errors;
        } else if (error.response.status == 403) {
            err = error.response.data.message;
        } else if (error.response.status == 500) {
            err = error.response.data.message;
            dispatch("snackbar/addSnack", {color: "danger", msg: "Backend server error!", snakbarType: snakbarType,}, {root: true});
        } else if (error.response.status == 419) {
            err = error.response.data.message;
            dispatch("snackbar/addSnack", {color: "danger", msg: err, snakbarType: snakbarType}, {root: true});
        } else {
            err = msg + error;
        }
        commit("SET_ERROR", err);
        if (showSnackBar === true && error.response.status != 419) {
            dispatch("snackbar/addSnack", {color: "danger", msg: err, snakbarType: snakbarType}, {root: true});
        }
    } else {
        dispatch("snackbar/addSnack", {color: "danger", msg: error, snakbarType: snakbarType}, {root: true});
    }
}*/
