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
                    :class="{'is-danger': email.errors.has('to')}"
                    multiple
                    placeholder="Select recipients"
                    source="administration.users.options"
                    label="person.name"
                    v-model="email.to"
                    @input="email.errors.clear('to')"/>
                <error :message="email.errors.get('to')"
                    v-if="email.errors.has('to')"/>
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
                    :class="{'is-danger': email.errors.has('cc')}"
                    multiple
                    placeholder="Select recipients"
                    source="administration.users.options"
                    label="person.name"
                    v-model="email.cc"
                    @input="email.errors.clear('cc')"/>
                <error :message="email.errors.get('cc')"
                    v-if="email.errors.has('cc')"/>
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
                    :class="{'is-danger': email.errors.has('bcc')}"
                    multiple
                    placeholder="Select recipients"
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
import { EnsoSelect } from '@enso-ui/bulma';
import Error from './Error.vue';

export default {
    name: 'Recipients',

    inject: ['i18n'],

    components: {
        EnsoSelect, Error,
    },

    props: {
        email: {
            type: Object,
            required: true,
        },
    },
};

</script>
