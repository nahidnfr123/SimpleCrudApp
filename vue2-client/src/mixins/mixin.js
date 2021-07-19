import Vue from "vue";
import { mapGetters } from "vuex";

const LoggedInUser = {
    computed: {
        ...mapGetters({
            user: "auth/user",
        }),
        $isLoggedIn() {
            return !!this.user;
        },
        $apiURL() {
            return 'http://localhost:8000';
        }
    }
};
Vue.mixin(LoggedInUser);
