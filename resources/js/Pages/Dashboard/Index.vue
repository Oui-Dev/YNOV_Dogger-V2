<script setup>
import DefaultLayout from '@/Layouts/Default.vue';
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

</script>

<template>
    <DefaultLayout>
        <div class="flex flex-col items-center min-h-screen py-12">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="h-12 w-48 bg-green-500"></div>
                <div class="h-12 w-48 bg-green-500"></div>
                <div class="h-12 w-48 bg-green-500"></div>
                <div class="h-12 w-48 bg-green-500"></div>
            </div>
            <Line :data="data" :options="options" />
        </div>
    </DefaultLayout>
</template>