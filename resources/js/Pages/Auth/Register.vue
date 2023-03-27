<script setup>
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    firstname: '',
    lastname: '',
    email: '',
    password: '',
    password_confirmation: '',
    organization_name: '',
});

const submitForm = () => {
    form.post(route('register.post'), { onStart: ()=> form.clearErrors() });
};
</script>

<template>
    <div class="flex justify-center items-center h-screen p-4">
        <div class="max-w-md w-full mb-14 flex flex-col gap-6 md:gap-12">
            <div>
                <Link :href="route('homepage')">
                <img class="mx-auto w-24" src="/images/logo.png" alt="Logo Dogger" />
                </Link>
                <h2 class="mt-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-gray-900">
                    Create your account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Or
                    <Link :href="route('login')" class="font-medium text-dogger-orange-400 hover:text-dogger-orange-500">
                        login
                    </Link>
                </p>
            </div>

            <form @submit.prevent="submitForm">
                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-5">
                    <div :class="{ 'form-error-div': form.errors.firstname }">
                        <label for="first_name">First Name</label>
                        <input v-model="form.firstname" id="first_name" />
                        <div v-if="form.errors.firstname" class="form-error-field">{{ form.errors.firstname }}</div>
                    </div>
                    <div :class="{ 'form-error-div': form.errors.lastname }">
                        <label for="last_name">Last Name</label>
                        <input v-model="form.lastname" id="last_name" />
                        <div v-if="form.errors.lastname" class="form-error-field">{{ form.errors.lastname }}</div>
                    </div>
                </div>
                <div :class="['md:pt-2', { 'form-error-div': form.errors.email }]">
                    <label for="email">Email</label>
                    <input v-model="form.email" id="email" type="email" />
                    <div v-if="form.errors.email" class="form-error-field">{{ form.errors.email }}</div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-5">
                    <div :class="['md:pt-2', { 'form-error-div': form.errors.password }]">
                        <label for="password">Password</label>
                        <input v-model="form.password" id="password" type="password" />
                        <div v-if="form.errors.password" class="form-error-field">{{ form.errors.password }}</div>
                    </div>
                    <div :class="['md:pt-2', { 'form-error-div': form.errors.password_confirmation }]">
                        <label for="password_confirmation">Confirm Password</label>
                        <input v-model="form.password_confirmation" id="password_confirmation" type="password" />
                        <div v-if="form.errors.password_confirmation" class="form-error-field">{{
                            form.errors.password_confirmation }}</div>
                    </div>
                </div>
                <div :class="['md:pt-2', { 'form-error-div': form.errors.organization_name }]">
                    <label for="organization_name">Organization name</label>
                    <input v-model="form.organization_name" id="organization_name" type="organization_name" />
                    <div v-if="form.errors.organization_name" class="form-error-field">{{ form.errors.organization_name }}</div>
                </div>
                <button class="btn primary mt-6 w-full" type="submit">Register</button>
            </form>
        </div>
    </div>
</template>