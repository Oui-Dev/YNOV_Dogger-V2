<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: Number,
        required: true
    },
    percentage: {
        type: String,
        required: false
    },
    path: {
        type: String,
        required: true
    },
    clickable: {
        type: Boolean,
        required: false,
        default: false
    },
    icon: {
        type: Function,
        required: true
    },
    iconBg: {
        type: String,
        required: false,
        default: 'bg-dogger-orange-400'
    }
})

const isNegative = computed(() => props.percentage < 0);
const bgIconClass = computed(() => {
    return `flex justify-center items-center ${props.iconBg ?? 'bg-dogger-orange-500'} p-2 rounded-full w-10 h-10 text-white text-xl`;
});
</script>

<template>
    <Link :href="path" :class="[clickable ? 'hover:bg-gray-50' : 'cursor-default', 'overflow-hidden rounded-lg bg-white shadow']">
        <div class="flex items-center p-5">
            <div class="mr-5 w-0 flex-1">
                <dl>
                    <dt class="truncate text-sm font-medium text-gray-500">{{ title }}</dt>
                    <dd>
                        <div class="text-lg font-medium text-gray-900">
                            {{ value }}
                            <span v-if="percentage" :class="[isNegative ? 'text-red-500' : 'text-green-500', 'ml-2 text-sm']">
                                {{ percentage }}
                            </span>
                        </div>
                    </dd>
                </dl>
            </div>
            <div :class="bgIconClass">
                <component :is="icon" />
            </div>
        </div>
    </Link>
</template>