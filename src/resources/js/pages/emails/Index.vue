<template>
    <div>
        <enso-table class="box is-paddingless raises-on-hover"
            id="emails"
            v-if="!email"
            @compose="email = factory()"
            @show="fetch($event.id)">
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
        <div class="columns is-centered">
            <email-form class="column is-three-quarters-desktop is-full-touch"
                :email="email"
                v-if="email"
                @submit="email=null"
                @cancel="email=null"/>
        </div>
    </div>
</template>

<script>

import { mapState } from 'vuex';
import { EnsoTable } from '@enso-ui/bulma';
import EmailForm from './components/EmailForm.vue';

export default {
    name: 'Index',

    inject: ['errorHandler', 'i18n', 'route'],

    components: {
        EnsoTable, EmailForm,
    },

    data: () => ({
        email: null,
    }),

    computed: {
        ...mapState(['enums']),
    },

    methods: {
        fetch(id) {
            axios.get(
                this.route('emails.show', { email: id }),
            ).then(({ data }) => {
                this.email = data;
            }).catch(this.handleError);
        },
        factory() {
            return {
                id: null,
                to: [],
                cc: [],
                bcc: [],
                teams: [],
                sendTo: parseInt(this.enums.emailSendTo.Users, 10),
                subject: null,
                body: null,
                scheduleAt: null,
                priority: this.enums.emailPriorities.Low,
                errors: null,
            };
        },
    },
};
</script>

<style lang="scss">

</style>
