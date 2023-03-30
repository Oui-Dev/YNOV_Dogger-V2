<script setup>
import { computed, onMounted, watch } from 'vue';
import { useToast } from "vue-toastification";
import { usePage } from '@inertiajs/vue3'
import NavBar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const toast = useToast();
const toastProps = computed(() => usePage().props.toast);

watch(toastProps, () => {
    setToast();
});

onMounted(() => {
    setToast();
});

const setToast = () => {
    if (toastProps.value) {
        // Available types: "success", "error", "default", "info" and "warning"
        toast[toastProps.value.type](toastProps.value.message);
    }
}
</script>

<template>
    <div>
        <div class="min-h-screen">
            <NavBar />

            <!-- Page Content -->
            <main class="p-4 md:p-6 lg:p-8 max-w-6xl mx-auto">
                <slot />
            </main>
        </div>
        <Footer />
    </div>
</template>