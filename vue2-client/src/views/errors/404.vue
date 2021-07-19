<template>
    <div class="container">
        <v-card elevation="4" loading color="" class="my-12">
            <div class="py-12 text-center">
                <h3 style="color: red;">Oops! 404 page not found!</h3>
                <p class="my-2">The page you are looking for does not exist.</p>

                <div>
                    Take me
                    <strong> <router-link to="/"> Home </router-link> </strong>
                </div>
            </div>
        </v-card>
    </div>
</template>

<script>
export default {
    name: "page_not_found",
};
</script>
