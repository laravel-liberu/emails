<template>
    <div class="notification-form-wrapper box raises-on-hover has-background-light">
        <div class="has-margin-bottom-medium">
            <label class="label">
                {{ i18n('Subject') }}
            </label>
            <input class="input"
                :class="{'is-danger': subjectError}"
                v-model="subject"
                @input="subjectError = false">
            <error message="A subject is required!"
                v-if="subjectError"/>
        </div>
        <div class="has-margin-bottom-medium">
            <label class="label">
                {{ i18n('Schedule At') }}
            </label>
            <enso-datepicker time
                v-model="scheduleAt"
                format="d-m-Y H:i:s"/>
        </div>
        <div class="has-margin-bottom-medium">
            <label class="label">
                {{ i18n('Message') }}
            </label>
            <textarea class="textarea"
                :class="{'is-danger': bodyError}"
                v-model="body"
                @input="bodyError = false"/>
            <error message="A message is required!"
                v-if="bodyError"/>
        </div>
        <file-browser @new-files="files = $event"/>
        <div class="has-text-right">
            <button class="button has-margin-medium"
                @click="cancel()">
                {{ i18n('Cancel') }}
            </button>
            <button class="button is-link has-margin-medium"
                @click="submit(); $emit('sent')">
                {{ i18n('Send') }}
            </button>
        </div>
    </file-browser>
</div>
</template>

<script>

import { EnsoDatepicker } from '@enso-ui/bulma';
import Error from './Error.vue';
import FileBrowser from './FileBrowser.vue';

export default {
    name: 'EmailForm',

    inject: ['errorHandler', 'i18n'],

    components: { Error, EnsoDatepicker, FileBrowser },

    data() {
        return {
            subject: null,
            body: null,
            scheduleAt: null,
            bodyError: false, // Todo: astea o sa dispara
            subjectError: false,
            // recipientError: false,
            files: [],
            formData: new FormData(),
        };
    },

    methods: {
        submit() {
            this.addParams();
            axios.post(
                route('emails.store'),
                this.formData,
            ).then(({ data }) => {
                this.formData = new FormData();
                this.files = [];
                this.$toastr.success(data.message);
                this.$emit('submit');
            }).catch(this.errorHandler);
        },

        addParams() {
            this.formData.append('subject', this.subject);
            this.formData.append('body', this.body);
            this.formData.append('schedule_at', this.scheduleAt);
            // this.recipients.forEach(rec => this.formData.append('recipients[]', rec));
            // for (let i = 0; i < this.files.length; i++) {
            //     this.formData.append(`file-${i}`, this.files[i]);
            // }
        },
        cancel() {
            this.subject = null;
            this.body = null;
            // this.files = [];
            this.$emit('cancel');
        },
    },
};
</script>

<style>

.notification-form-wrapper {
    padding: 1em;
}
</style>
