<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    paginator: {
        type: Object,
        required: true,
    },
});

const isDisplayed = (key, link) => {
    return key > 0 && key < props.paginator.links.length - 1 && !link.active;
};

const isDisabled = (key) => {
    return (props.paginator.current_page - 1 === 0 && key === 0)
        || (props.paginator.current_page === props.paginator.last_page
        && key === props.paginator.links.length - 1);
};
</script>

<template>
    <div v-if="paginator.links.length > 3">
        <div class="flex flex-wrap gap-1 p-1 justify-end">
            <template v-for="(link, key) in paginator.links" :key="`link-${key}`">
                <Link
                class="px-4 py-3 text-sm leading-4 border rounded" :href="link.url ?? ''" v-html="link.label"
                :class="{
                    'bg-dogger-orange-400 text-white': link.active,
                    'hover:text-dogger-orange-400 bg-gray-50': !link.active,
                    'hidden md:block' : isDisplayed(key, link),
                    'disabled': isDisabled(key)
                }" />
            </template>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .disabled {
        @apply cursor-not-allowed pointer-events-none bg-gray-200 text-gray-500;
    }
</style>