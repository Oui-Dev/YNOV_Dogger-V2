<script setup>
import { ref, watch } from 'vue';

const visible = ref(false);
const timeout = ref(null);

const props = defineProps({
    toast: Object,
    popstate: Boolean,
});

watch(props, () => {
    visible.value = true;

    if (timeout.value) {
        clearTimeout(timeout.value);
    }

    timeout.value = setTimeout(() => {
        visible.value = false;
    }, 2500);
}, { deep: true, immediate: true });
</script>

<template>
    <transition name="slide-fade">
        <div
            class="absolute flex max-w-xs w-full mt-4 top-0 right-0 bg-white rounded shadow p-4 z-10"
            v-if="toast && visible && !popstate"
        >
            <div class="mr-2 items-center flex">
                <svg
                    :class="['w-6 h-6', {'text-green-600': toast.type === 'success', 'text-red-500': toast.type === 'error'}]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                </svg>
            </div>
            <div class="flex-1 text-gray-800">{{ toast.message }}</div>
            <div class="ml-2">
                <button
                    class="align-top text-gray-500 hover:text-gray-700 focus:outline-none focus:text-dogger-orange-400"
                    @click="visible = false"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>
                </button>
            </div>
        </div>
    </transition>
</template>

<style scoped>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.4s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(150px);
    opacity: 0;
}
</style>
