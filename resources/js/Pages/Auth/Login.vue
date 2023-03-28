<script setup>
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
});

const submitForm = () => {
    form.post(route('login.post'), { onStart: () => form.clearErrors() });
};
</script>

<template>
    <div class="flex justify-center items-center h-screen p-4">
        <div class="max-w-md w-full mb-24 flex flex-col gap-10 md:gap-14">
            <div>
                <Link :href="route('homepage')">
                    <img class="mx-auto w-24" src="/images/logo.png" alt="Logo Dogger" />
                </Link>
                <h2 class="mt-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-gray-900">
                    Sign in to your account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Or
                    <Link :href="route('register')" class="font-medium text-dogger-orange-400 hover:text-dogger-orange-500">
                        create a new account
                    </Link>
                </p>
            </div>

            <form @submit.prevent="submitForm">
                <div :class="{ 'form-error-div': form.errors.email }">
                    <label for="email">Email</label>
                    <input v-model="form.email" id="email" type="email" />
                    <div v-if="form.errors.email" class="form-error-field">{{ form.errors.email }}</div>
                </div>
                <div :class="{ 'form-error-div': form.errors.password }">
                    <label for="password">Password</label>
                    <input v-model="form.password" id="password" type="password" />
                    <div v-if="form.errors.password" class="form-error-field">{{ form.errors.password }}</div>
                </div>
                <button class="btn primary mt-6 w-full" type="submit">Login</button>
            </form>
        </div>
    </div>
</template>