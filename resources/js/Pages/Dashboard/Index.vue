<script setup>
import { ref } from 'vue';
import DefaultLayout from '@/Layouts/Default.vue';
import StatsCard from '@/Components/StatsCard.vue';
import { RectangleStackIcon, ExclamationTriangleIcon, ChartBarIcon } from '@heroicons/vue/24/outline';
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
    }
});

const errorCount = Object.values(props.chartData.allErrors);

ChartJS.register(
        CategoryScale,
        LinearScale,
        PointElement,
        LineElement,
        Tooltip,
);

const data = {
    datasets: [
        {
            label: 'Error Count',
            borderColor: '#ff8437',
            cubicInterpolationMode: 'monotone',
            data: props.chartData.allErrors,
        },
    ],
};

const options = {
    scales: {
        y: {
            type: 'linear',
            min: Math.round(Math.min(...errorCount) * 0.9),
            max: Math.round(Math.max(...errorCount) * 1.1),
        },
        x: {
            type: 'category',
        },
    },
};

const statsCardsData = ref([
    { title: "Total projects", value: null, percentage: null, icon: RectangleStackIcon, iconBg: "bg-blue-500", clickable: true, path: "dashboard.projects.list" },
    { title: "Total errors", value: null, percentage: null, icon: ExclamationTriangleIcon, iconBg: "bg-red-500", clickable: true, path: "dashboard.errors.list" },
    { title: "24h Error count", value: null, percentage: null, icon: ChartBarIcon, clickable: true, path: "dashboard.errors.list" },
]);
</script>

<template>
    <DefaultLayout>
        <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <StatsCard v-for="(card, index) in statsCardsData" :key="index" v-bind="card" />
        </div>
        <Line :data="data" :options="options" />
    </DefaultLayout>
</template>