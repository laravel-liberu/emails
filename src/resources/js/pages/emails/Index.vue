<template>
    <div>
        <enso-table class="box is-paddingless raises-on-hover"
            id="emails"
            v-if="!compose"
            @compose="compose = true">
            <template v-slot:priority="{ row }">
                <span class="tag is-table-tag has-margin-right-small"
                    :class="enums.emailPriorityLabels._get(row.priority)">
                    {{ enums.emailPriorities._get(row.priority) }}
                </span>
            </template>
        </enso-table>
        <div class="columns is-centered">
            <email-form
                class="column is-three-quarters-desktop is-full-touch"
                v-if="compose"
                @sent="compose = !compose"
                @cancel="compose = !compose"/>
        </div>
    </div>
</template>

<script>

import { mapState } from 'vuex';
import { EnsoTable } from '@enso-ui/bulma';
import EmailForm from './components/EmailForm.vue';

export default {
    name: 'Index',

    inject: ['errorHandler', 'i18n'],

    components: {
        EnsoTable,
        EmailForm,
    },

    data: () => ({
        compose: null,
    }),

    computed: {
        ...mapState(['enums']),
    },
};
</script>

<style lang="scss">

</style>
