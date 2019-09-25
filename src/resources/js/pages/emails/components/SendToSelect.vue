<template>
    <dropdown class="status-selector">
        <template v-slot:label>
            <send-to :send-to="value"/>
        </template>
        <template v-slot:options>
            <a v-for="sendTo in enums.emailSendTo._keys()"
                :key="sendTo"
                class="dropdown-item"
                :class="{ 'is-active': parseInt(sendTo, 10) === value }"
                @click="$emit('input', parseInt(sendTo, 10))">
                <send-to :send-to="sendTo"/>
            </a>
        </template>
    </dropdown>
</template>

<script>
import { mapState } from 'vuex';
import { Dropdown } from '@enso-ui/bulma';
import SendTo from './SendTo.vue';

export default {
    name: 'SendToSelect',

    components: { Dropdown, SendTo },

    inject: ['i18n'],

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
</style>
