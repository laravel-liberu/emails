<template>
    <span class="tag is-warning is-bold is-small">
        {{ label }}
    </span>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'SendTo',

    props: {
        sendTo: {
            type: [Number, String],
            required: true,
        },
    },

    computed: {
        ...mapState(['enums']),
        label() {
            return this.enums.emailSendTo._get(this.sendTo);
        },
    },
};
</script>

<style lang="scss">
</style>
