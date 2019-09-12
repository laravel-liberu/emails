<template>
    <div class="notification-form-wrapper box raises-on-hover has-background-light">
        <recipients class="has-margin-bottom-medium"
            :email="email"/>
        <div class="columns">
            <div class="column is-10">
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
            <div class="column is-2 has-text-centered">
                <div>
                    <label class="label">
                        {{ i18n('Priority') }}
                    </label>
                    <priority-selector :value="email.priority"
                        @input="email.priority = $event"/>
                    <error :message="email.errors.get('priority')"
                        v-if="email.errors.has('priority')"/>
                </div>
            </div>
        </div>
        <div class="has-margin-bottom-medium">
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
            <button class="button is-link has-margin-medium"
                @click="submit()">
                {{ i18n('Send') }}
            </button>
        </div>
    </div>
</template>

<script>

import { mapState } from 'vuex';
import { EnsoDatepicker } from '@enso-ui/bulma';
import Errors from '@enso-ui/forms/errors';
import Recipients from './Recipients.vue';
import PrioritySelector from './PrioritySelector.vue';
import FileBrowser from './FileBrowser.vue';
import Error from './Error.vue';

export default {
    name: 'EmailForm',

    inject: ['errorHandler', 'i18n'],

    components: {
        Error, EnsoDatepicker, FileBrowser, PrioritySelector, Recipients,
    },

    data() {
        return {
            email: this.factory(),
            formData: new FormData(),
            files: [],
        };
    },

    computed: {
        ...mapState(['enums']),
    },

    created() {
        this.email.priority = this.enums.emailPriorities.Low;
    },

    methods: {
        submit() {
            this.addParams();
            axios.post(route('emails.send'), this.formData)
                .then(({ data }) => {
                    this.resetForm();
                    this.$emit('submit');
                    this.$toastr.success(data.message);
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

        addParams() {
            const skip = ['all', 'errors'];
            Object.keys(this.email).filter(key => !skip.includes(key))
                .forEach((key) => {
                    if (Array.isArray(this.email[key])) {
                        this.addRecipients(key, this.email[key]);
                    } else {
                        this.formData.append(key, this.email[key] || '');
                    }
                });
            this.formData.append('all', this.email.all);
            for (let i = 0; i < this.files.length; i++) {
                this.formData.append(`file-${i}`, this.files[i]);
            }
        },
        addRecipients(key, recipients) {
            recipients.forEach((id) => {
                this.formData.append(`${key}[]`, id);
            });
        },
        cancel() {
            this.resetForm();
            this.$emit('cancel');
        },
        resetForm() {
            this.files = [];
            this.email = this.factory();
            this.formData = new FormData();
        },
        factory() {
            return {
                to: [],
                cc: [],
                bcc: [],
                all: false,
                subject: null,
                body: null,
                scheduleAt: null,
                priority: null,
                errors: new Errors(),
            };
        },
    },
};
</script>

<style>

.notification-form-wrapper {
    padding: 1em;
}
</style>
