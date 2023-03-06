<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    data: {
        type: Array,
        required: true,
    },
    tableKeys: {
        type: Array,
        required: true,
    },
    hasActions: {
        type: Boolean,
        default: false,
        required: false,
    },
    actions: {
        type: Array,
        required: false,
    },
});

const actionHover = (action) => {
    return action.hoverColor ?? 'hover:text-dogger-orange-400';
}
</script>

<template>
    <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-for="(item, i) in data" :key="i">
            <td v-for="(key, j) in tableKeys" :key="j" class="custom_td">
                <div v-if="typeof key === 'object' && key.link !== true" v-html="key.function(item)"></div>
                <Link v-else-if="typeof key === 'object' && key.link === true" :class="['flex gap-2 hover:text-red-800 ', key.function(item).classes]" :href="key.function(item).path">{{ key.function(item).text }}</Link>
                <div v-else>{{ item[key] }}</div>
            </td>
            <td v-if="hasActions" class="custom_actions">
                <template v-for="(action, index) in actions" :key="index">
                    <div v-if="!action.condition || action.condition(item)" :title="action.iconText ?? ''" class="action_btn">
                        <Link v-if="action.type === 'Link'" :href="route(action.routeName, item[action.param])" :as="action.as" :method="action.method" :class="actionHover(action)">
                            <component :is="action.icon" class="h-5 w-5 flex-shrink-0 self-center" />
                        </Link>
                        <button v-else @click.prevent="action.function(item)" :class="actionHover(action)">
                            <component :is="action.icon" class="h-5 w-5 flex-shrink-0 self-center" />
                        </button>
                    </div>
                </template>
            </td>
        </tr>
    </tbody>
</template>

<style lang="scss" scoped>
.custom_td {
    @apply whitespace-nowrap px-3 py-4 text-sm text-gray-500;
}
.custom_actions {
    @apply relative whitespace-nowrap py-4 pl-3 pr-4 sm:pr-6 flex justify-end gap-3;
    
    .action_btn {
        @apply p-2 bg-gray-100 rounded-md flex items-center justify-center;
    }
}
</style>