<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    tableTitles: {
        type: Array,
        required: true,
    },
    tableKeys: {
        type: Array,
        required: true,
    },
    data: {
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
    <li v-for="(item, index) in data" :key="index" class="flex items-center bg-white px-4 py-4 hover:bg-gray-50">
        <div class="flex gap-4 justify-between items-center w-full divide-x divide-gray-200">
            <div class="grid gap-3 text-sm text-gray-500 truncate">
                <div v-for="(key, index) in tableKeys" class="flex gap-2">
                    <span class="font-medium text-gray-900 capitalize">{{ tableTitles[index] }} :</span>
                    <div v-if="typeof key === 'object' && key.link !== true" v-html="key.function(item)"></div>
                    <Link v-else-if="typeof key === 'object' && key.link === true" :class="['flex gap-2 hover:text-red-800 ', key.function(item).classes]" :href="key.function(item).path">{{ key.function(item).text }}</Link>
                    <div v-else>{{ item[key] }}</div>
                </div>
            </div>
            <div v-if="hasActions" class="grid gap-4 text-xl pl-4">
                <template v-for="action in actions">
                    <div v-if="!action.condition || action.condition(item)" :title="action.iconText ?? ''" class="action_btn">
                        <Link v-if="action.type === 'Link'" :href="route(action.routeName, item[action.param])" :as="action.as" :method="action.method" :class="actionHover(action)">
                            <component :is="action.icon" class="h-5 w-5 flex-shrink-0 self-center" />
                        </Link>
                        <button v-else @click.prevent="action.function(item)" :class="actionHover(action)">
                            <component :is="action.icon" class="h-5 w-5 flex-shrink-0 self-center" />
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </li>
</template>