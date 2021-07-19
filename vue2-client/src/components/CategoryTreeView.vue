<template>
    <ul class="category-ul">
        <li v-for="category in categories" :key="'category' + category.id">
            <v-row align="center" justify="space-between" class="py-2">
                <div>{{ category.name }}</div>
                <div v-if="$isLoggedIn">
<!--                    <v-btn primary tile x-small color="primary"> Add </v-btn>
                    <v-btn primary tile x-small color="warning"> Edit </v-btn>
                    <v-btn primary tile x-small color="error"> Delete </v-btn>-->
                </div>
            </v-row>

            <CategoryTreeView
                v-if="category.children && category.children.length"
                :categories="category.children"
            />
        </li>
    </ul>
</template>

<script>
export default {
    name: "CategoryTreeView",
    props: {
        categories: {
            type: Array,
            default: () => {
            },
        },
    },
};
</script>

<style>
.category-ul li {
    padding: 10px 0 10px 6px !important;
}
</style>
