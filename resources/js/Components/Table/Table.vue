<script setup>
import {onMounted} from "@vue/runtime-core";
import Pagination from "@/Components/Pagination.vue";
import { ref, computed, watch } from "vue";
import Thead from "./Thead.vue";
import Tbody from "./Tbody.vue";

const props = defineProps({
    tableTitles: {
        type: Array,
        required: true,
    },
    tableKeys: {
        type: Array,
        required: true,
    },
    data: {
        type: Object || Array,
        required: true,
    },
    actions: {
        type: Array,
        default: [],
        required: false,
    },
    pagination: {
        type: Boolean,
        default: false,
        required: false,
    },
});

const newData = ref([]);

onMounted(() => {
    if (props.tableTitles.length !== props.tableKeys.length) {
        throw new Error(
            "The number of table titles and table keys must be the same."
        );
    }

    newData.value = props.pagination ? props.data.data : props.data;
});

watch(() => props.data, (newVal) => {
    newData.value = props.pagination ? newVal.data : newVal;
}, { deep: true });

const hasData = computed(() => {
    return newData.value.length > 0;
});
const hasActions = computed(() => {
    return props.actions.length > 0;
});
</script>

<template>
    <section>
        <div class="inline-block min-w-full mt-8">
            <div v-if="hasData" class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <Thead :tableTitles="tableTitles" :hasActions="hasActions" />
                    <Tbody :data="newData" :tableKeys="tableKeys" :hasActions="hasActions" :actions="actions" />
                </table>
            </div>
            <div v-else class="text-center">
                No values to display
            </div>
        </div>
        <Pagination v-if="pagination" class="pt-2" :paginator="data" />
    </section>
</template>
