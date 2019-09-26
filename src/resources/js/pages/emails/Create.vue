<template>
    <div class="columns is-centered">
        <email-form class="column is-three-quarters-desktop is-full-touch"
            :email="email"
            v-if="email"/>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import EmailForm from './components/EmailForm.vue';

export default {
    name: 'Create',

    components: { EmailForm },

    props: {},

    data: () => ({
        email: null,
    }),

    computed: {
        ...mapState(['enums']),
    },

    created() {
        this.email = this.factory();
    },

    methods: {
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

<style>
</style>
