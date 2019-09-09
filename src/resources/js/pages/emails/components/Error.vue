<template>
    <div class="content has-text-danger has-padding-small">
        <span class="icon is-inline">
            <fa icon="exclamation"/>
        </span>
        <p class="is-inline">
            {{ i18n(message) }}
        </p>
    </div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core';
import { faExclamation } from '@fortawesome/free-solid-svg-icons';

library.add(faExclamation);

export default {
    name: 'Error',

    inject: ['i18n'],

    props: {
        message: {
            validator(value) {
                return typeof value === 'string' || value === null;
            },
            required: true,
        },
    },
};
</script>

<style>

</style>
