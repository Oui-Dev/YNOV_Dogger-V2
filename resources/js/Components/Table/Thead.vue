<script setup>
defineProps({
    tableTitles: {
        type: Array,
        required: true,
    },
    hasActions: {
        type: Boolean,
        default: false,
        required: false,
    },
});
</script>

<template>
    <thead class="bg-dogger-orange-400 text-white">
        <tr>
            <th v-for="(title, index) in tableTitles" :key="index" scope="col" class="custom_th">
                {{title}}
            </th>
            <th v-if="hasActions" scope="col" class="action_th">
                Actions
            </th>
        </tr>
    </thead>
</template>

<style lang="scss" scoped>
.custom_th {
    @apply py-3.5 pl-4 pr-3 text-left text-sm font-semibold;
}
.action_th {
    @apply relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-semibold sm:pr-6;
}
</style>