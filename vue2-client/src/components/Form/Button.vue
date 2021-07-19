<template>
    <v-btn tile :color="buttonColor" :disabled="disabled">
        <v-icon left v-if="buttonIcon"> {{ buttonIcon }}</v-icon>
        {{ buttonName }}
    </v-btn>
</template>

<script>
export default {
    name: "CustomButton",
    props: {
        buttonName: {
            type: String,
            default: "Button",
        },
        buttonIcon: {
            type: String,
            default: "",
        },
        buttonColor: {
            type: String,
            default: "primary",
        },
        disabled: {
            type: Boolean,
            default: false,
        }
    },
};
</script>
