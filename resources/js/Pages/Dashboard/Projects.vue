<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import Table from '@/Components/Table/Table.vue';
import DefaultLayout from '@/Layouts/Default.vue';
import { PencilSquareIcon, TrashIcon, KeyIcon, ExclamationTriangleIcon, SquaresPlusIcon } from '@heroicons/vue/24/outline';

defineProps({
    projects: {
        type: Object,
        required: true,
    },
});

const projectForm = useForm({
    name: '',
});
const modalState = ref({
    create: false,
    edit: false,
    delete: false,
});
const modalProjectId = ref(null);

const getProjectDate = (project) => {
    let date = project.created_at;
    date = !isNaN(Date.parse(date + " GMT")) ? new Date(date + " GMT") : new Date(date);
    return date.toLocaleDateString() + " " + date.toLocaleTimeString();
}
const getProjectKey = (project) => {
    const resumeLength = 25;
    return project.key.length > resumeLength
        ? project.key.substring(0, resumeLength) + '...'
        : project.key;
}
const copyProjectKey = (project) => {
    navigator.clipboard.writeText(project.key);
}

function changeModalState(modal, state = true, project = null) {
    modalState.value[modal] = state;
    if(project) {
        modalProjectId.value = project.id;
        projectForm.name = project.name;
    }
}

function addProject() {
    projectForm.post(route('dashboard.projects.add'), {
        preserveScroll: true,
        onStart: () => projectForm.clearErrors(),
        onSuccess: () => changeModalState('create', false),
    });
}
function editProject() {
    projectForm.put(route('dashboard.projects.edit', modalProjectId.value), {
        preserveScroll: true,
        onStart: () => projectForm.clearErrors(),
        onSuccess: () => changeModalState('edit', false),
    });
}
function deleteProject() {
    router.delete(route('dashboard.projects.delete',  modalProjectId.value), {
        preserveScroll: true,
        onStart: () => changeModalState('delete', false),
    });
}
</script>

<template>
    <DefaultLayout>
        <div className="flex justify-end">
            <button class="btn primary" @click="changeModalState('create', true)">Create Project</button>
        </div>
        <Table
            :tableTitles="['Project', 'Created At', 'Project Key']"
            :tableKeys="['name', {function: getProjectDate}, {function: getProjectKey}]"
            :data="projects"
            :actions="[
                { type: 'function', function: copyProjectKey, icon: KeyIcon, iconText: 'Copy to clipboard project key' },
                { type: 'function', function: (e) => changeModalState('edit', true, e), icon: PencilSquareIcon, iconText: 'Edit project' },
                { type: 'function', function: (e) => changeModalState('delete', true, e), icon: TrashIcon, iconText: 'Delete project', hoverColor: 'hover:text-red-600' },
            ]"
            :pagination=true
        />

        <!-- Create/edit Modal -->
        <Modal
            :show="modalState.create || modalState.edit"
            @closeModal="changeModalState(modalState.create ? 'create' : 'edit', false)"
        >
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start mb-2">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-dogger-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                        <SquaresPlusIcon class="h-6 w-6 text-dogger-orange-500" aria-hidden="true" />
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">{{ modalState.create ? 'Create Project' : 'Edit Project' }}</h3>
                        <p class="text-sm text-gray-500">Please enter a name for your project.</p>
                    </div>
                </div>
                <form @submit.prevent="modalState.create ? addProject() : editProject()" class='flex flex-col items-stretch'>
                    <div :class="{ 'form-error-div': projectForm.errors.name }">
                        <label for="projectName" class="block text-sm font-medium text-gray-700">Enter Name:</label>
                        <input v-model="projectForm.name" type="text" id="projectName" />
                        <div v-if="projectForm.errors.name" class="form-error-field">{{ projectForm.errors.name }}</div>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 px-4 py-3 flex sm:flex-row-reverse gap-5 sm:px-6">
                <button @click="modalState.create ? addProject() : editProject()" class="btn primary">
                    {{ modalState.create ? 'Add' : 'Edit' }}
                </button>
                <button @click="changeModalState(modalState.create ? 'create' : 'edit', false)" class="btn generic">
                    Cancel
                </button>
            </div>
        </Modal>
        <!-- Delete Modal -->
        <Modal :show="modalState.delete" @closeModal="changeModalState('delete', false)">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Deactivate account</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete this project ? All of his
                                data will be permanently removed. This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 flex sm:flex-row-reverse gap-5 sm:px-6">
                <button type="button" @click="deleteProject" class="btn warning">
                    Delete
                </button>
                <button type="button" @click="changeModalState('delete', false)" class="btn generic">
                    Cancel
                </button>
            </div>
        </Modal>
    </DefaultLayout>
</template>