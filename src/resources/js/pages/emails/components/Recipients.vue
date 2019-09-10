<template>
    <div>
        <div class="columns is-vcentered">
            <div class="column is-1">
                <div class="label">
                    {{ i18n('To') }}:
                </div>
            </div>
            <div class="column is-11">
                <enso-select class="is-inlineblock"
                    multiple
                    source="administration.users.options"
                    label="person.name"
                    v-model="to"/>
            </div>
        </div>
        <div class="columns is-vcentered">
            <div class="column is-1">
                <div class="label">
                    {{ i18n('Cc') }}:
                </div>
            </div>
            <div class="column is-11">
                <enso-select class="is-inlineblock"
                    multiple
                    source="administration.users.options"
                    label="person.name"
                    v-model="cc"/>
            </div>
        </div>
        <div class="columns is-vcentered">
            <div class="column is-1">
                <div class="label">
                    {{ i18n('Bcc') }}:
                </div>
            </div>
            <div class="column is-11">
                <enso-select class="is-inlineblock"
                    multiple
                    source="administration.users.options"
                    label="person.name"
                    v-model="bcc"/>
            </div>
        </div>
    </div>
</template>

<script>
import { EnsoSelect, VueSwitch } from '@enso-ui/bulma';

export default {
    name: 'Recipients',

    inject: ['i18n'],

    components: {
        EnsoSelect, VueSwitch,
    },

    props: {
        to: {
            type: Array,
            required: true,
        },
        cc: {
            type: Array,
            required: true,
        },
        bcc: {
            type: Array,
            required: true,
        },
    },

    data: () => ({

    }),

    computed: {},

    methods: {},
};

</script>
<style>
</style>
