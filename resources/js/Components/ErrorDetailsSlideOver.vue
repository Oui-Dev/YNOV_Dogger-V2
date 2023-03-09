<script setup>
import { ref, watch } from 'vue';
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';
import { useForm } from '@inertiajs/vue3';
import { XMarkIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/outline';

const emits = defineEmits(['close']);
const props = defineProps({
    error: {
        type: Object,
        required: false,
        default: null,
    },
    show: {
        type: Boolean,
        required: false,
        default: false,
    },
    users: {
        type: Array,
        required: false,
        default: [],
    },
});

const open = ref(props.show);
const openedError = ref([]);
const form = useForm({
    assigned_to: props.error?.assigned_to,
    status: props.error?.status,
});

watch(() => props, (data) => {
    open.value = data.show;

    const tmp = [];
    if(data.error) {
        tmp.push(['Project', data.error.project.name]);
        tmp.push(['Date', formatedDate(data.error.timestamp)]);
        if(data.error.message) tmp.push(['Message', data.error.message]);
        if(data.error.code) tmp.push(['Code', data.error.code]);
        if(data.error.path) tmp.push(['Path', data.error.path]);
        if(data.error.line) tmp.push(['At line', data.error.line]);

        form.assigned_to = data.error.assigned_to;
        form.status = data.error.status;
    }
    openedError.value = tmp;
}, { deep: true });

const close = () => emits('close');

const formatedDate = (date) => {
    date = !isNaN(Date.parse(date + " GMT")) ? new Date(date + " GMT") : new Date(date);
    return date.toLocaleDateString() + " " + date.toLocaleTimeString();
}

function submitForm() {

}
</script>

<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="close">
            <div class="fixed inset-0" />

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full sm:pl-16">
                        <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700"
                            enter-from="translate-x-full" enter-to="translate-x-0"
                            leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0"
                            leave-to="translate-x-full">
                            <DialogPanel class="pointer-events-auto w-screen max-w-lg">
                                <div class="flex h-full flex-col bg-white shadow-xl">
                                    <div class="px-4 py-6 sm:px-6">
                                        <div class="flex items-start justify-between">
                                            <div class="flex gap-6">
                                                <div class="flex justify-center items-center p-2 rounded-full bg-red-500">
                                                    <ExclamationTriangleIcon class="h-6 w-6 md:h-8 md:w-8 text-white" />
                                                </div>
                                                <div class="flex items-center">
                                                    <DialogTitle class="text-xl font-bold text-gray-900 md:text-2xl">Error details</DialogTitle>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex h-7 items-center">
                                                <button @click="close" class="rounded-md bg-white text-gray-400 hover:text-gray-700">
                                                    <span class="sr-only">Close panel</span>
                                                    <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Main -->
                                    <div class="px-4 pt-5 pb-5 sm:px-0 border-t border-gray-200">
                                        <dl class="space-y-8 px-4 sm:space-y-6 sm:px-6">
                                            <div v-for="(item, index) in openedError" :key="index">
                                                <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">
                                                    {{ item[0] }}
                                                </dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                                                    {{ item[1] }}
                                                </dd>
                                            </div>
                                            <form @submit.prevent="submitForm" class="pt-2 border-t border-gray-200">
                                                <div class="sm:flex py-3 md:py-5">
                                                    <dt class="text-sm font-medium text-gray-500 sm:w-20 sm:flex-shrink-0">
                                                        Assign to
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 sm:ml-6 w-full">
                                                        <select v-model="form.assigned_to">
                                                            <option :value="null">Not assigned</option>
                                                            <option v-for="user in props.users" :value="user.id">{{ user.firstname + " " + user.lastname }}</option>
                                                        </select>
                                                    </dd>
                                                </div>
                                                <div class="sm:flex py-2 md:py-5">
                                                    <dt class="text-sm font-medium text-gray-500 sm:w-20 sm:flex-shrink-0">
                                                        Status
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 sm:ml-6 w-full">
                                                        <select v-model="form.status">
                                                            <option value="0">New</option>
                                                            <option value="1">In progress</option>
                                                            <option value="2">Resolved</option>
                                                        </select>
                                                    </dd>
                                                </div>
                                                <button class="btn primary mt-3" type="submit">Save</button>
                                            </form>
                                        </dl>
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>