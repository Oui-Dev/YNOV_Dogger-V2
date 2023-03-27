<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import DefaultLayout from '@/Layouts/Default.vue';
import Table from '@/Components/Table/Table.vue';
import ErrorDetailsSlideOver from '../../Components/ErrorDetailsSlideOver.vue';
import { DocumentMagnifyingGlassIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    errors: {
        type: Object,
        required: true,
    },
    projects: {
        type: Array,
        required: false,
        default: [],
    },
    users: {
        type: Array,
        required: false,
        default: [],
    },
});

const selectedProject = ref(new URLSearchParams(new URL(window.location.href).search).get('project') ?? 'All');
const slideOver = ref({ error: null, show: false });

watch(selectedProject, (id) => {
    router.get(route('dashboard.errors.list', { project: id }));
});

const getProjectName = (error) => error.project.name;
const getErrorAssignedUser = (error) => {
    if(!error.assigned_to) return 'Not assigned';
    return error.assigned_to.full_name;
};
const getErrorDate = (error) => {
    let date = error.timestamp;
    date = !isNaN(Date.parse(date + " GMT")) ? new Date(date + " GMT") : new Date(date);
    return date.toLocaleDateString() + " " + date.toLocaleTimeString();
}
const getErrorStatus = (error) => {
    switch(error.status) {
        case 0:
            return 'New';
        case 1:
            return 'In progress';
        case 2:
            return 'Resolved';
        default:
            return 'Unknown';
    }
}

function showDetails(error, show = true) {
    slideOver.value = { error, show };
}
</script>

<template>
    <DefaultLayout>
        <div id="select">
            <select v-model="selectedProject">
                <option value="All">All</option>
                <option v-for="project in projects" :key="project.id" :value="project.id">{{ project.name }}</option>
            </select>
        </div>
        <Table
            :tableTitles="['Project', 'Assign to', 'Date', 'Status']"
            :tableKeys="[{function: getProjectName}, {function: getErrorAssignedUser}, {function: getErrorDate}, {function: getErrorStatus}]"
            :data="errors"
            :actions="[
                { type: 'function', function: showDetails, icon: DocumentMagnifyingGlassIcon, iconText: 'Show error details' },
            ]"
            :pagination=true
        />
        <ErrorDetailsSlideOver :error="slideOver.error" :show="slideOver.show" :users="users" @close="showDetails(null, false)" />
    </DefaultLayout>
</template>

<style lang="scss" scoped>
div#select {
    @apply capitalize py-1 px-2 border border-gray-300 rounded-lg shadow-sm w-fit bg-gray-50 mx-auto;

    @screen md {
        @apply mx-0;
    }

    select {
        @apply bg-transparent;
        max-width: 300px;
    }
}
</style>