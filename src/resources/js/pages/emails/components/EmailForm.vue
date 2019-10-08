<template>
    <div class="notification-form-wrapper box raises-on-hover has-background-light">
        <recipients class="has-margin-bottom-large"
            :email="email"
            v-if="email.sendTo === parseInt(enums.emailSendTo.Users, 10)"/>
        <div class="has-margin-bottom-large"
            v-if="email.sendTo === parseInt(enums.emailSendTo.Teams, 10)">
            <label class="label">
                {{ i18n('Teams') }}
            </label>
            <enso-select source="administration.teams.options"
                multiple
                v-model="email.teams"/>
        </div>
        <div class="columns">
            <div class="column">
                <div>
                    <label class="label">
                        {{ i18n('Subject') }}
                    </label>
                    <input class="input"
                        :class="{'is-danger': email.errors.has('subject')}"
                        v-model="email.subject"
                        @input="email.errors.clear('subject')">
                    <error :message="email.errors.get('subject')"
                        v-if="email.errors.has('subject')"/>
                </div>
            </div>
        </div>
        <div class="columns has-margin-bottom-medium">
            <div class="column is-8 has-text-left">
                <label class="label">
                    {{ i18n('Schedule At') }}
                </label>
                <enso-datepicker :class="{'is-danger': email.errors.has('scheduleAt')}"
                    time
                    v-model="email.scheduleAt"
                    format="d-m-Y H:i"
                    @input="email.errors.clear('scheduleAt')"/>
                <error :message="email.errors.get('scheduleAt')"
                    v-if="email.errors.has('scheduleAt')"/>
            </div>
            <div class="column is-2">
                <label for="" class="label">
                    {{ i18n('Send to') }}
                </label>
                <send-to-select :value="email.sendTo"
                    @input="email.sendTo = $event"/>
            </div>
            <div class="column is-2">
                <div>
                    <label class="label">
                        {{ i18n('Priority') }}
                    </label>
                    <priority-select :value="email.priority"
                        @input="email.priority = $event"/>
                    <error :message="email.errors.get('priority')"
                        v-if="email.errors.has('priority')"/>
                </div>
            </div>
        </div>
        <div class="has-margin-bottom-medium">
            <label class="label">
                {{ i18n('Message') }}
            </label>
            <textarea class="textarea"
                :class="{'is-danger': email.errors.has('body')}"
                v-model="email.body"
                @input="email.errors.clear('body')"/>
            <error :message="email.errors.get('body')"
                v-if="email.errors.has('body')"/>
        </div>
        <file-browser @input="files = $event"/>
        <div class="has-text-right">
            <button class="button has-margin-medium"
                @click="cancel()">
                {{ i18n('Cancel') }}
            </button>
            <button class="button is-primary has-margin-medium"
                v-if="email.status === parseInt(enums.emailStatuses.Draft, 10)"
                @click="submit('emails.store')">
                {{ i18n('Save') }}
            </button>
            <button class="button is-success has-margin-medium"
                @click="submit('emails.send')">
                <span v-if="email.status === parseInt(enums.emailStatuses.Sent, 10)">
                    {{ i18n('Resend') }}
                </span>
                <span v-else>
                    {{ i18n('Send now') }}
                </span>
            </button>
        </div>
    </div>
</template>

<script>

import { mapState } from 'vuex';
import { EnsoDatepicker, EnsoSelect } from '@enso-ui/bulma';
import Errors from '@enso-ui/forms/errors';
import Recipients from './Recipients.vue';
import PrioritySelect from './PrioritySelect.vue';
import SendToSelect from './SendToSelect.vue';
import FileBrowser from './FileBrowser.vue';
import Error from './Error.vue';

export default {
    name: 'EmailForm',

    inject: ['errorHandler', 'i18n', 'route'],

    components: {
        Error,
        EnsoDatepicker,
        FileBrowser,
        PrioritySelect,
        Recipients,
        SendToSelect,
        EnsoSelect,
    },

    props: {
        email: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            formData: new FormData(),
            files: [],
        };
    },

    computed: {
        ...mapState(['enums']),
    },

    created() {
        this.email.errors = new Errors();
    },

    methods: {
        submit(route) {
            this.appendParams();
            axios.post(this.route(route), this.formData)
                .then(({ data }) => {
                    const { params, redirect } = data;
                    this.formData = new FormData();
                    this.files = [];
                    this.$emit('submit');
                    this.$toastr.success(data.message);
                    console.log(this.$route.name);
                    console.log(redirect);
                    if (redirect && this.$route.name !== redirect) {
                        this.$router.push({
                            name: 'emails.edit',
                            params,
                        });
                    }
                }).catch((error) => {
                    const { status, data } = error.response;
                    this.formData = new FormData();
                    if (status === 422) {
                        this.email.errors.set(data.errors);
                        return;
                    }
                    this.$emit('submission-error');
                    this.errorHandler(error);
                });
        },

        appendParams() {
            const skip = ['all', 'errors'];
            Object.keys(this.email).filter(key => !skip.includes(key))
                .forEach((key) => {
                    if (Array.isArray(this.email[key])) {
                        this.appendArray(key, this.email[key]);
                    } else {
                        this.formData.append(key, this.email[key] || '');
                    }
                });
            this.appendFiles();
        },
        appendArray(key, array) {
            array.forEach((id) => {
                this.formData.append(`${key}[]`, id);
            });
        },
        appendFiles() {
            for (let i = 0; i < this.files.length; i++) {
                this.formData.append(`file-${i}`, this.files[i]);
            }
        },
        cancel() {
            this.formData = new FormData();
            this.fiels = [];
            this.$emit('cancel');
            this.$router.push({
                name: 'emails.index',
            });
        },
    },
};
</script>

<style>

.notification-form-wrapper {
    padding: 1em;
}
</style>
