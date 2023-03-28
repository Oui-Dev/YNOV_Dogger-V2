<script setup>
import DefaultLayout from '@/Layouts/Default.vue';
import StatsCard from '@/Components/StatsCard.vue';
import { RectangleStackIcon, ExclamationTriangleIcon, ChartBarIcon } from '@heroicons/vue/24/outline';
import { ref, watch } from 'vue';
import { Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Tooltip,
} from 'chart.js';

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

console.log('props', props.cardsData);

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Tooltip,
);

const selectedProject = ref('All');
const chartRef = ref(null);

watch(selectedProject, (project) => {
    chartRef.value.chart.clear();
    if(project === 'All') {
        data.value.datasets[0].data = props.chartData.allErrors;
    } else {
        data.value.datasets[0].data = project.errors
    }
    chartRef.value.chart.update();
    console.log('kevin', chartRef.value)
    console.log('data.value', data.value.datasets[0].data);
});


const data = ref({
    datasets: [
        {
            label: 'Error Count',
            borderColor: '#ff8437',
            cubicInterpolationMode: 'monotone',
            data: props.chartData.allErrors,
        },
    ],
});



const options = {
    scales: {
        y: {
            type: 'linear',
            grace: '5%',
        },
        x: {
            type: 'category',
        },
    },
};

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
        <Line ref="chartRef" :data="data" :options="options"  class="py-6 sm:px-6 px-2" />
    </DefaultLayout>
</template>