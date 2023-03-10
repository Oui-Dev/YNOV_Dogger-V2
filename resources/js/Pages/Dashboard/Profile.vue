<script setup>
import { ref, computed } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import DefaultLayout from '@/Layouts/Default.vue';
import Modal from '@/Components/Modal.vue';
import Avatar from '@/Components/Avatar.vue';
import { ExclamationTriangleIcon, PencilIcon, BuildingOffice2Icon } from '@heroicons/vue/24/outline';

const props = defineProps({
    organization: {
        type: Object,
        required: true,
    },
});

const currentUser = computed(() => usePage().props.auth.user);
const isAdmin = computed(() => usePage().props.auth.user.roles.includes('admin'));
const userInitials = computed(() => currentUser.value.firstname.charAt(0) + currentUser.value.lastname.charAt(0));
const modalState = ref({
    editOrganization: false,
    deleteProfile: false,
});

const userForm = useForm({
    firstname: currentUser.value.firstname,
    lastname: currentUser.value.lastname,
    email: currentUser.value.email,
    old_password: null,
    password: null,
    password_confirmation: null,
});

const organizationForm = useForm({
    name: props.organization.name,
});

const changeModalState = (modal, state = true) => modalState.value[modal] = state;

function editOrganization() {
    organizationForm.put(route('dashboard.profile.organization.edit'), {
        preserveScroll: true,
        onStart: () => organizationForm.clearErrors(),
        onSuccess: () => changeModalState('editOrganization', false),
    });
}
function editProfile() {
    userForm.put(route('dashboard.profile.edit'), {
        preserveScroll: true,
        onStart: () => userForm.clearErrors(),
    });
}
function deleteProfile() {
    router.delete(route('dashboard.profile.delete'));
}
</script>

<template>
    <DefaultLayout>
        <div class="mx-0 mt-0 md:mt-16 ">
            <form @submit.prevent="editProfile">
                <div class="overflow-hidden shadow md:rounded-md">
                    <div class="bg-white px-4 py-5 md:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="inline-grid col-span-6 md:col-span-6 justify-items-center md:justify-items-start">
                                <Avatar :initials="userInitials" />
                            </div>
                            <div class="col-span-6 md:col-span-3" :class="{ 'form-error-div': userForm.errors.firstname }">
                                <label for="firstname">First name</label>
                                <input v-model="userForm.firstname" id="firstname" autocomplete="given-name" />
                                <div v-if="userForm.errors.firstname" class="form-error-field">{{ userForm.errors.firstname}}</div>
                            </div>
                            <div class="col-span-6 md:col-span-3" :class="{ 'form-error-div': userForm.errors.lastname }">
                                <label for="lastname">Last name</label>
                                <input v-model="userForm.lastname" id="lastname" autocomplete="family-name" />
                                <div v-if="userForm.errors.lastname" class="form-error-field">{{ userForm.errors.lastname }}</div>
                            </div>
                            <div class="col-span-6" :class="{ 'form-error-div': userForm.errors.email }">
                                <label for="email">Email address</label>
                                <input v-model="userForm.email" id="email" autocomplete="email" />
                                <div v-if="userForm.errors.email" class="form-error-field">{{ userForm.errors.email }}</div>
                            </div>
                            <div class="col-span-6 md:col-span-6 lg:col-span-2" :class="{ 'form-error-div': userForm.errors.old_password }">
                                <label for="old_password">Current Password</label>
                                <input v-model="userForm.old_password" type="password" id="old_password" autocomplete="current-password" />
                                <div v-if="userForm.errors.old_password" class="form-error-field">{{userForm.errors.old_password }}</div>
                            </div>
                            <div class="col-span-6 md:col-span-3 lg:col-span-2" :class="{ 'form-error-div': userForm.errors.password }">
                                <label for="password">New Password</label>
                                <input v-model="userForm.password" type="password" id="password" autocomplete="new-password" />
                                <div v-if="userForm.errors.password" class="form-error-field">{{ userForm.errors.password }}</div>
                            </div>
                            <div class="col-span-6 md:col-span-3 lg:col-span-2">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input v-model="userForm.password_confirmation" type="password" id="password_confirmation" autocomplete="new-password" />
                            </div>
                            <div class="col-span-6 text-base font-light flex gap-2 items-center">
                               <p>My organization :</p>
                               <span class="font-semibold">{{ organization.name }}</span>
                               <PencilIcon v-if="isAdmin" @click="changeModalState('editOrganization', true)" class="w-4 h-4 cursor-pointer hover:text-dogger-orange-500" />
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 flex justify-between md:px-6">
                        <button class="btn warning" @click.prevent="changeModalState('deleteProfile', true)">Delete</button>
                        <button class="btn primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Edit Organization Modal -->
        <Modal
            v-if="isAdmin" :show="modalState.editOrganization"
            @closeModal="changeModalState('editOrganization', false)"
        >
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start mb-2">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-dogger-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                        <BuildingOffice2Icon class="h-6 w-6 text-dogger-orange-500" aria-hidden="true" />
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Edit Organization</h3>
                        <p class="text-sm text-gray-500">Please enter a name for your organzation.</p>
                    </div>
                </div>
                <form @submit.prevent="editOrganization()" class='flex flex-col items-stretch'>
                    <div :class="{ 'form-error-div': organizationForm.errors.name }">
                        <label for="organizationName" class="block text-sm font-medium text-gray-700">Enter Name:</label>
                        <input v-model="organizationForm.name" type="text" id="organizationName" />
                        <div v-if="organizationForm.errors.name" class="form-error-field">{{ organizationForm.errors.name }}</div>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 px-4 py-3 flex sm:flex-row-reverse gap-5 sm:px-6">
                <button @click="editOrganization()" class="btn primary">
                    Edit
                </button>
                <button @click="changeModalState('editOrganization', false)" class="btn generic">
                    Cancel
                </button>
            </div>
        </Modal>
        <!-- Delete Profile Modal -->
        <Modal :show="modalState.deleteProfile" @closeModal="changeModalState('deleteProfile', false)">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Delete account</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete your account? All of your
                                data will be permanently removed. This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 flex sm:flex-row-reverse gap-5 sm:px-6">
                <button type="button" @click="deleteProfile" class="btn warning">
                    Delete
                </button>
                <button type="button" @click="changeModalState('deleteProfile', false)" class="btn generic">
                    Cancel
                </button>
            </div>
        </Modal>
    </DefaultLayout>
</template>