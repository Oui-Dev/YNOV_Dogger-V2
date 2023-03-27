<script setup>
import { ref } from 'vue';
import DefaultLayout from '@/Layouts/Default.vue';
import StatsCard from '@/Components/StatsCard.vue';
import { RectangleStackIcon, ExclamationTriangleIcon, ChartBarIcon } from '@heroicons/vue/24/outline';

const statsCardsData = ref([
    { title: "Total Projects", value: null, percentage: null, icon: RectangleStackIcon, iconBg: "bg-blue-500", clickable: true, path: "dashboard.projects.list" },
    { title: "Total Errors", value: null, percentage: null, icon: ExclamationTriangleIcon, clickable: true, path: "dashboard.errors.list" },
    { title: "Last 24h errors", value: null, percentage: null, icon: ChartBarIcon, iconBg: "bg-red-500", clickable: true, path: "dashboard.errors.list" },
]);
</script>

<template>
    <DefaultLayout>
        <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <StatsCard v-for="(card, index) in statsCardsData" :key="index" v-bind="card" />
        </div>
    </DefaultLayout>
</template>