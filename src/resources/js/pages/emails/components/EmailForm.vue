<template>
    <div class="notification-form-wrapper box raises-on-hover has-background-light">
        <recipients class="has-margin-bottom-medium"
            :to="email.to"
            :cc="email.cc"
            :bcc="email.bcc"/>
        <div class="columns">
            <div class="column is-10">
                <div>
                    <label class="label">
                        {{ i18n('Subject') }}
                    </label>
                    <input class="input"
                        :class="{'is-danger': subjectError}"
                        v-model="email.subject"
                        @input="subjectError = false">
                    <error message="A subject is required!"
                        v-if="subjectError"/>
                </div>
            </div>
            <div class="column is-2 has-text-centered">
                <div>
                    <label class="label">
                        {{ i18n('Priority') }}
                    </label>
                    <priority-selector :value="email.priority"
                        @input="email.priority = $event"/>
                </div>
            </div>
        </div>
        <!-- <div class="columns is-mobile is-centered">
            <div class="column is-10">
                <label class="label">
                    {{ i18n('Subject') }}
                </label>
                <input class="input"
                    :class="{'is-danger': subjectError}"
                    v-model="email.subject"
                    @input="subjectError = false">
                <error message="A subject is required!"
                    v-if="subjectError"/>
                </div>
            <div class="column has-text-right">
                <label class="label has-text-centered">
                    {{ i18n('Priority') }}
                </label>
                <priority-selector :value="email.priority"
                    @input="email.priority = $event"/>
            </div>
        </div> -->
        <div class="has-margin-bottom-medium">
            <label class="label">
                {{ i18n('Schedule At') }}
            </label>
            <enso-datepicker time
                v-model="email.scheduleAt"
                format="d-m-Y H:i"/>
        </div>
        <div class="has-margin-bottom-medium">
            <label class="label">
                {{ i18n('Message') }}
            </label>
            <textarea class="textarea"
                :class="{'is-danger': bodyError}"
                v-model="email.body"
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

import { mapState } from 'vuex';
import { EnsoDatepicker } from '@enso-ui/bulma';
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
            email: {
                to: [],
                cc: [],
                bcc: [],
                subject: null,
                body: null,
                scheduleAt: null,
                priority: null,
            },
            formData: new FormData(),
            bodyError: false, // Todo: astea o sa dispara
            subjectError: false,
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
            Object.keys(this.email).forEach((key) => {
                this.formData.append(key, this.email[key]);
            });

            // this.recipients.forEach(rec => this.formData.append('recipients[]', rec));
            // for (let i = 0; i < this.files.length; i++) {
            //     this.formData.append(`file-${i}`, this.files[i]);
            // }
        },
        cancel() {
            this.email.subject = null;
            this.email.body = null;
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
