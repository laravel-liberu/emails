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
                    :class="{'is-danger': email.errors.has('to')}"
                    placeholder="Select recipients"
                    multiple
                    source="administration.users.options"
                    label="person.name"
                    v-model="email.to"
                    @input="email.errors.clear('to')"/>
                <error :message="email.errors.get('to')"
                    v-if="email.errors.has('to')"/>
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
                    :class="{'is-danger': email.errors.has('cc')}"
                    :v-if="!email.all"
                    placeholder="Select recipients"
                    multiple
                    source="administration.users.options"
                    label="person.name"
                    v-model="email.cc"
                    @input="email.errors.clear('cc')"/>
                <error :message="email.errors.get('cc')"
                    v-if="email.errors.has('cc')"/>
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
                    :class="{'is-danger': email.errors.has('bcc')}"
                    placeholder="Select recipients"
                    multiple
                    source="administration.users.options"
                    label="person.name"
                    v-model="email.bcc"
                    @input="email.errors.clear('bcc')"/>
                <error :message="email.errors.get('bcc')"
                    v-if="email.errors.has('bcc')"/>
            </div>
        </div>
    </div>
</template>

<script>
import { EnsoSelect, VueSwitch } from '@enso-ui/bulma';
import Error from './Error.vue';

export default {
    name: 'Recipients',

    inject: ['i18n'],

    components: {
        EnsoSelect, VueSwitch, Error,
    },

    props: {
        email: {
            type: Object,
            required: true,
        },
    },
};

</script>
