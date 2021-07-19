<template>
    <div class="text-center">
        <v-dialog
            v-model="dialog"
            width="500"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="primary lighten-2"
                    dark
                    v-bind="attrs"
                    v-on="on"
                >
                    Open Dialogue
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                    Add New Product
                </v-card-title>

                <v-card-text>
                    {{ msg }}
                </v-card-text>


                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        tile
                        @click="submit()"
                    >
                        Submit
                    </v-btn>

                    <v-btn
                        color="error"
                        tile
                        @click="dialog =false"
                    >
                        Cancel
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>


<script>
export default {
    name: "SweetAlert",
    props: {
        msg: {
            type: String,
            default: "Popup message"
        },
        dialog: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        submit() {
            this.$emit('confirm', true);
        }
    }
};
</script>
