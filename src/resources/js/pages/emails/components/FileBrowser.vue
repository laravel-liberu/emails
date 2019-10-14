<template>
    <div class="file has-name is-info has-margin-top-medium">
        <label class="file-label">
            <input class="file-input"
                type="file"
                multiple="multiple"
                ref="browser"
                @change="$emit('input', $refs.browser.files); email.files = $refs.browser.files"
                v-if="email.status !== parseInt(enums.emailStatuses.Sent, 10)">
            <span class="file-cta">
                <span class="file-icon">
                    <i class="fas fa-paperclip"/>
                </span>
                <span class="file-label">
                    {{ 'Attach some files...' }}
                </span>
            </span>
            <span class="file-name has-background-white"
                v-for="file in email.files"
                :key="file.name">
                {{ file.name }}
            </span>
        </label>
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'FileBrowser',

    props: {
        email: {
            type: Object,
            required: true,
        },
    },

    computed: {
        ...mapState(['enums']),
    },
};
</script>
