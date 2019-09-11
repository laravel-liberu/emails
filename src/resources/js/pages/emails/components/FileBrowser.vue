<template>
    <div class="file has-name is-info has-margin-top-medium">
        <label class="file-label">
            <input class="file-input"
                type="file"
                multiple="multiple"
                ref="browser"
                @change="$emit('input', $refs.browser.files); files = $refs.browser.files">
            <span class="file-cta">
            <span class="file-icon">
                <i class="fas fa-upload"/>
            </span>
            <span class="file-label">
                {{ 'Attach some files...' }}
            </span>
            </span>
            <span class="file-name has-background-white"
                v-for="file in files"
                :key="file.name">
                {{ file.name }}
            </span>
        </label>
    </div>
</template>

<script>
export default {
    name: 'FileBrowser',

    data: () => ({
        files: null,
    }),
};
</script>
