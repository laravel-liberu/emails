<template>
    <enso-table class="box is-paddingless raises-on-hover"
        id="emails"
        @edit="edit($event.id)">
        <template v-slot:priority="{ row }">
            <span class="tag is-table-tag has-margin-right-small"
                :class="enums.emailPriorityLabels._get(row.priority)">
                {{ enums.emailPriorities._get(row.priority) }}
            </span>
        </template>
        <template v-slot:status="{ row }">
            <span class="tag is-table-tag has-margin-right-small"
                :class="enums.emailStatusLabels._get(row.status)">
                {{ enums.emailStatuses._get(row.status) }}
            </span>
        </template>
    </enso-table>
</template>

<script>

import { mapState } from 'vuex';
import { EnsoTable } from '@enso-ui/tables/bulma';

export default {
    name: 'Index',

    inject: ['errorHandler', 'i18n', 'route'],

    components: {
        EnsoTable,
    },

    data: () => ({
        email: null,
    }),

    computed: {
        ...mapState(['enums']),
    },

    methods: {
        edit(id) {
            this.$router.push({
                name: 'emails.edit',
                params: { email: id },
            });
        },
    },
};
</script>

<style lang="scss">

</style>
