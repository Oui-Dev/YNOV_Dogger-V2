<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import Table from '@/Components/Table/Table.vue';
import DefaultLayout from '@/Layouts/Default.vue';
import { PencilSquareIcon, TrashIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/outline';

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
        <div className="flex justify-end mb-4">
            <button class="btn primary" @click="changeModalState('create', true)">Create Project</button>
        </div>
        <Table
            :tableTitles="['Project', 'Created At', 'Project Key']"
            :tableKeys="['name', 'created_at', 'key']"
            :data="projects"
            :actions="[
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
                <form @submit.prevent="modalState.create ? addProject() : editProject()" class='flex flex-col items-stretch'>
                    <label htmlFor="projectName" class="block text-sm font-medium text-gray-700">Enter Name:</label>
                    <input type="text" v-model="projectForm.name" id="projectName" />
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
                                Are you sure you want to deactivate your account? All of your
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