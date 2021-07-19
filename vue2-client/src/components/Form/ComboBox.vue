<template>
    <!--    <div class="selectComponent" @click="handleClick()" tabindex="-1" @blur="clicked = false">
            <div class="comboBoxName">{{ placeholder }}</div>

            <div class="selectedItems">
                <template v-if="options.length">
                    <template v-for="option in options">
                        <span v-if="selectedOptions.includes(option.id)" :key="'selected-item-'+option.id">
                            {{ option[displayProperty] }}
                        </span>
                    </template>
                </template>
            </div>

            <div class="dropdown" v-show="clicked">
                <template v-if="options && options.length">
                    <template v-for="(option, i) in options">
                        <ComboBoxItem
                            :key="i"
                            :option="option"
                            :selectedOptions="selectedOptions"
                            @updateTextValue="updateSelectedOption($event)"
                        />
                        <hr :key="'hr-' + i"/>
                        <br :key="'br-' + i"/>
                    </template>
                </template>
            </div>
        </div>-->


    <ul v-if="options && options.length">
        <li v-for="(option, i) in options">
            <div class="list-item" @click.stop.prevent="nodeClicked(option)" :class="[selectedOptions.indexOf(option[valueProperty])>-1?'active':'']">
                {{ option[displayProperty] }}
            </div>
            <hr>
            <template v-if="option.children && Object.keys(option.children).length">
                <ComboBox
                    :options="option.children"
                    displayProperty="name"
                    valueProperty="id"
                    :selectedOptions="selectedOptions"
                    @nodeClicked="nodeClicked($event)"
                />
            </template>
        </li>
    </ul>
</template>

<script>
export default {
    name: "ComboBox",
    props: {
        options: {
            type: Array,
            default: () => [],
        },
        selectedOptions: {
            type: Array,
            default: () => [],
        },
        displayProperty: {
            type: String,
            default: "name",
        },
        valueProperty: {
            type: String,
            default: "value",
        },
    },
    data() {
        return {
            clicked: false,
        };
    },
    methods: {
        handleClick() {
            this.clicked = true;
        },
        nodeClicked(option) {
            this.handleClick();
            this.$emit('nodeClicked', option)
        }
    },
};
</script>

<style lang="scss">
.comboBoxComponent {
    position: relative;
    min-height: 40px;
    height: 40px;
    background-color: #d2d2d2;
    cursor: pointer;
}

.placeholders {
    width: 100%;
    height: 40px;
    line-height: 40px;
    padding: 0 10px;
    background-color: white;
    border-radius: 6px;
    border: 1px solid #1b1e21;
}

.dropdownComboBox {
    width: 100%;
    position: absolute;
    top: 40px;
    max-height: 250px;
    overflow: auto;
    background-color: #b0b0b0;
    box-shadow: 0 0 10px rgb(black, .5);
    border-radius: 6px;
}

ul {
    margin: 0;
    padding: 0;
    list-style: none;
    background-color: white;

    .list-item {
        background-color: white;
        padding: 2px 6px;
        margin: 2px 0;
        border-radius: 6px;
        transition: all 200ms ease-in-out;
        cursor: pointer;

        &:hover {
            background-color: dodgerblue;

            &.active {
                background-color: yellowgreen;
            }
        }

        &.active {
            background-color: yellowgreen;
        }
    }
}
</style>
