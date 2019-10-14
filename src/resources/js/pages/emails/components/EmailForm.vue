<template>
    <div class="notification-form-wrapper box raises-on-hover has-background-light">
        <recipients class="has-margin-bottom-large"
            :email="email"
            v-if="email.sendTo == enums.emailSendTo.Users"/>
        <div class="has-margin-bottom-large"
            v-if="email.sendTo == enums.emailSendTo.Teams">
            <label class="label">
                {{ i18n('Teams') }}
            </label>
            <enso-select source="administration.teams.options"
                multiple
                :readonly="email.status == enums.emailStatuses.Sent"
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
                        :readonly="email.status == enums.emailStatuses.Sent"
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
                    v-model="email.scheduleAt"
                    time
                    format="d-m-Y H:i"
                    :readonly="email.status == enums.emailStatuses.Sent"
                    @input="email.errors.clear('scheduleAt')"/>
                <error :message="email.errors.get('scheduleAt')"
                    v-if="email.errors.has('scheduleAt')"/>
            </div>
            <div class="column is-2">
                <label for="" class="label">
                    {{ i18n('Send to') }}
                </label>
                <send-to-select :value="email.sendTo"
                    :disabled="email.status == enums.emailStatuses.Sent"
                    @input="email.sendTo = $event"/>
            </div>
            <div class="column is-2">
                <div>
                    <label class="label">
                        {{ i18n('Priority') }}
                    </label>
                    <priority-select :value="email.priority"
                        :disabled="email.status == enums.emailStatuses.Sent"
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
                :readonly="email.status == enums.emailStatuses.Sent"
                @input="email.errors.clear('body')"/>
            <error :message="email.errors.get('body')"
                v-if="email.errors.has('body')"/>
        </div>
        <file-browser class="has-margin-bottom-large"
            :email="email"/>
        <div class="level">
            <div class="level-right"/>
            <div class="level-left">
                <action tag="button"
                    :button="{label: 'Back', icon: 'arrow-left'}"
                    @click="back()"/>
                <action tag="button"
                    :button="{label: 'Save', class: 'is-primary', icon: 'check'}"
                    v-if="!email.id && email.status === parseInt(enums.emailStatuses.Draft, 10)"
                    @click="submit('emails.store', 'post')"/>
                <action tag="button"
                    :button="{label: 'Update', class: 'is-primary', icon: 'check'}"
                    v-if="email.id && email.status !== parseInt(enums.emailStatuses.Sent)"
                    @click="submit('emails.update', 'post')"/>
                <action tag="button"
                    :button="{label: 'Send Now', class: 'is-success', icon: 'paper-plane'}"
                    v-if="email.status !== parseInt(enums.emailStatuses.Sent)"
                    @click="submit('emails.send', 'post')"/>
            </div>
        </div>
    </div>
</template>

<script>

import { mapState } from 'vuex';
import { EnsoDatepicker } from '@enso-ui/datepicker/bulma';
import { EnsoSelect } from '@enso-ui/select/bulma';
import { Action } from '@enso-ui/forms/bulma';
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
        Action,
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
        };
    },

    computed: {
        ...mapState(['enums']),
    },

    created() {
        this.email.errors = new Errors();
    },

    methods: {
        submit(route, method) {
            this.appendParams();
            axios[method](
                this.route(route, { email: this.email.id }),
                this.formData,
            ).then(({ data }) => {
                const { params, redirect } = data;
                this.formData = new FormData();
                this.files = [];
                this.$emit('submit');
                this.$toastr.success(data.message);
                if (redirect) {
                    this.$router.push({ name: redirect, params });
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
            const skip = ['errors', 'files'];
            this.cleanFields();
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
        cleanFields() {
            switch (this.email.sendTo) {
            case parseInt(this.enums.emailSendTo.Users, 10):
                this.email.teams = [];
                break;
            case parseInt(this.enums.emailSendTo.Teams, 10):
                this.email.to = [];
                this.email.cc = [];
                this.email.bcc = [];
                break;
            case parseInt(this.enums.emailSendTo.All, 10):
                this.email.to = [];
                this.email.cc = [];
                this.email.bcc = [];
                this.email.teams = [];
                break;
            default:
                break;
            }
        },
        appendArray(key, array) {
            array.forEach((id) => {
                this.formData.append(`${key}[]`, id);
            });
        },
        appendFiles() {
            for (let i = 0; i < this.email.files.length; i++) {
                this.formData.append(`file-${i}`, this.email.files[i]);
            }
        },
        back() {
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
