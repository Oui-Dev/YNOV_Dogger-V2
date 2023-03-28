<script setup>
import { ref, computed } from 'vue';
import { Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Tooltip,
} from 'chart.js';

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Tooltip,
);

const props = defineProps({
    chartData: {
        type: Object,
        required: true
    },
});

const chartRef = ref(null);
const data = computed(() => ({
    datasets: [{
        label: 'Error Count',
        borderColor: '#ff8437',
        cubicInterpolationMode: 'monotone',
        data: props.chartData,
    }],
}));

const options = {
    scales: {
        y: { type: 'linear', grace: '5%', beginAtZero: true },
        x: { type: 'category' },
    },
};

</script>

<template>
    <Line
        ref="chartRef"
        :data="data"
        :options="options"
        class="py-3"
    />
</template>