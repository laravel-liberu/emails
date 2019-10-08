<template>
    <div class="columns is-centered">
        <email-form class="column is-three-quarters-desktop is-full-touch"
            :email="email"
            v-if="email"/>
    </div>
</template>

<script>
import EmailForm from './components/EmailForm.vue';

export default {
    name: 'Edit',

    components: { EmailForm },

    inject: ['route'],

    data: () => ({
        email: null,
    }),

    created() {
        this.fetch();
    },

    methods: {
        fetch() {
            axios.get(
                this.route('emails.edit', this.$route.params),
            ).then(({ data }) => {
                this.email = data;
            }).catch(this.handleError);
        },
    },
};

</script>

<style>
</style>
