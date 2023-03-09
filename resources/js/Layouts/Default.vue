<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import Toast from "@/Components/Toast.vue";
import { usePage } from '@inertiajs/vue3'
import NavBar from '@/Components/NavBar.vue';

const toast = ref(null);
const toastProps = computed(() => usePage().props.toast);
const getToast = computed(() => toast.value);
const popstate = computed(() => usePage().props.popstate);

watch(toastProps, () => {
    setToast();
});

onMounted(() => {
    setToast();
});

const setToast = () => {
    if(toastProps.value) {
        toast.value = toastProps.value;
    }
}
</script>

<template>
    <div>
        <div class="min-h-screen">
            <Toast :toast="getToast" :popstate="popstate" />
            <NavBar />

            <!-- Page Content -->
            <main class="p-4 md:p-6 lg:p-8 max-w-6xl mx-auto">
                <slot />
            </main>
        </div>
    </div>
</template>