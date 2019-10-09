<template>
    <dropdown class="status-selector">
        <template v-slot:label>
            <priority :priority="value"/>
        </template>
        <template v-slot:options>
            <a v-for="priority in enums.emailPriorities._keys()"
                :key="priority"
                class="dropdown-item"
                :class="{ 'is-active': priority == value }"
                @click="$emit('input', parseInt(priority,10))">
                <priority :priority="priority"/>
            </a>
        </template>
    </dropdown>
</template>

<script>
import { mapState } from 'vuex';
import Dropdown from '@enso-ui/dropdown/bulma';
import Priority from './Priority.vue';

export default {
    name: 'PrioritySelect',

    components: { Dropdown, Priority },

    props: {
        value: {
            type: [Number, String],
            required: true,
        },
    },

    computed: {
        ...mapState(['enums']),
    },
};
</script>

<style lang="scss">
    .dropdown.status-selector {
        .dropdown-trigger {
            width: 7em;
        }
        .dropdown-content {
            width: 7em;
            .options {
                width: 7em;
                a.dropdown-item {
                    padding-right: unset;
                }
            }
        }
    }
</style>
