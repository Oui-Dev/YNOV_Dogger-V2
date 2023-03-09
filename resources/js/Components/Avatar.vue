<script setup>
import { UserCircleIcon } from '@heroicons/vue/24/outline';

defineProps({
    initials: {
        type: String,
        required: false,
    },
});
</script>

<template>
    <div class="inline-block h-[4.5rem] w-[4.5rem] sm:h-12 sm:w-12 overflow-hidden rounded-full bg-gray-100">
        <div v-if="initials" class="flex items-center justify-center bg-dogger-orange-300 text-white rounded-full w-full h-full font-medium text-3xl sm:text-base uppercase">
            {{ initials }}
        </div>
        <UserCircleIcon v-else class="h-full w-full text-gray-300"/>
    </div>
</template>