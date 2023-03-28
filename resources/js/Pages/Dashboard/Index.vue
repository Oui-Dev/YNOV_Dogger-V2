<script setup>
import DefaultLayout from '@/Layouts/Default.vue';
import StatsCard from '@/Components/StatsCard.vue';
import Chart from '@/Components/Chart.vue';
import { RectangleStackIcon, ExclamationTriangleIcon, ChartBarIcon } from '@heroicons/vue/24/outline';
import { ref, watch } from 'vue';

const props = defineProps({
    chartData: {
        type: Object,
        required: true
    },
    cardsData : {
        type: Object,
        required: true
    }
});

const selectedProject = ref('All');
const chartDataFormated = ref(props.chartData.allErrors);

watch(selectedProject, (project) => {
    chartDataFormated.value = project === 'All'
        ? props.chartData.allErrors
        : project.errors;
});

const statsCardsData = ref([
    { title: "Total projects", value: ""+props.cardsData.projectCount, icon: RectangleStackIcon, iconBg: "bg-blue-500", clickable: true, path: "dashboard/projects" },
    { title: "Total errors", value: ""+props.cardsData.errorCount, icon: ExclamationTriangleIcon, iconBg: "bg-red-500", clickable: true, path: "dashboard/errors" },
    { title: "24h Error count", value: ""+props.cardsData.error24.count, percentage: props.cardsData.error24.percentage+"%", icon: ChartBarIcon, clickable: true, path: "dashboard/errors" },
]);
</script>

<template>
    <DefaultLayout>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <StatsCard v-for="(card, index) in statsCardsData" :key="index" v-bind="card" />
        </div>
        <div id="select" class="mt-8">
            <select v-model="selectedProject" class="border rounded-md">
                <option value="All">All</option>
                <option v-for="chartData in props.chartData.projectErrors" :key="chartData" :value="chartData">{{ chartData.project }}</option>
            </select>
        </div>
        <Chart :chartData="chartDataFormated" />
    </DefaultLayout>
</template>