<template>
    <div>
        <div class="level is-mobile has-margin-bottom-large">
            <div class="level-left">
                <div class="level-item">
                    <div class="label">
                        {{ i18n('Send to all') }}:
                    </div>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <vue-switch class="is-large is-success"
                        v-model="email.all"/>
                </div>
            </div>
        </div>
        <div class="columns is-vcentered" v-if="!email.all">
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
                    v-model="email.to"/>
            </div>
        </div>
        <div class="columns is-vcentered" v-if="!email.all">
            <div class="column is-1">
                <div class="label">
                    {{ i18n('Cc') }}:
                </div>
            </div>
            <div class="column is-11">
                <enso-select class="is-inlineblock"
                    :v-if="!email.all"
                    multiple
                    source="administration.users.options"
                    label="person.name"
                    v-model="email.cc"/>
            </div>
        </div>
        <div class="columns is-vcentered" v-if="!email.all">
            <div class="column is-1">
                <div class="label">
                    {{ i18n('Bcc') }}:
                </div>
            </div>
            <div class="column is-11">
                <enso-select class="is-inlineblock"
                    :v-if="!email.all"
                    multiple
                    source="administration.users.options"
                    label="person.name"
                    v-model="email.bcc"/>
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
        email: {
            type: Object,
            required: true,
        },
    },
};

</script>
