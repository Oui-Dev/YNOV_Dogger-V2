<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
        
const authNavigation = [
    {name: "Dashboard", routeName: "dashboard.index"},
    {name: "Projects", routeName: "dashboard.projects.list"},
    {name: "Errors", routeName: "dashboard.errors.list"},
    {name: "Profile", routeName: "dashboard.profil.show"}
];

const isReduced = ref(true);
const isAuth = computed(() => usePage().props.auth.user !== null);

const openSideBar = () => isReduced.value = !isReduced.value;
</script>

<template>
    <header>
        <!-- Laptop -->
        <nav class="hidden lg:flex">
            <div class="logo-side">
                <img alt="Dogger logo" src="/images/logo.png" width="45" height="45" />
            </div>

            <div class="menu-side">
                <template v-if="isAuth">
                    <Link v-for="item in authNavigation" :key="item.name"
                        :href="route(item.routeName)"
                        :class="{'active-link': route().current() === item.routeName}"
                    >
                        {{ item.name }}
                    </Link>
                </template>
            </div>

            <div class="button-side relative">
                <Link v-if="isAuth" :href="route('logout')" class="menu-button">
                    Logout
                </Link>
                <Link v-else :href="route('login')" class="menu-button orange">
                    Login
                </Link>
            </div>
        </nav>

        <!-- Tablet and mobile -->
        <nav class="flex lg:hidden">
            <div class="logo-side">
                <img alt="Dogger logo" src="/images/logo.png" width="35" height="35" />
            </div>

            <div class="button-side">
                <Bars3Icon v-if="isReduced" class="w-6 h-6" @click="openSideBar" />
                <XMarkIcon v-else class="w-6 h-6" @click="openSideBar" />
            </div>

            <div id="sidebar" :class="{'reduced' : isReduced}">
                <div class="overflow-hidden shadow-lg rounded-b-lg border-t border-gray-300">
                    <div class="relative grid gap-2 px-5 py-5 text-sm md:text-base">
                        <template v-if="isAuth">
                            <Link v-for="item in authNavigation" :key="item.name"
                                :href="route(item.routeName)"
                                :class="{'active-link': route().current() === item.routeName}"
                            >
                                {{ item.name }}
                            </Link>
                        </template>
                        <div class="border-solid border-t border-gray-300 flex gap-3 mt-3 pt-4">
                            <Link v-if="isAuth" :href="route('logout')" class="menu-button">
                                Logout
                            </Link>
                            <Link v-else :href="route('login')" class="menu-button orange">
                                Login
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

<style lang="scss" scoped>
header {
    @apply sticky top-0 w-full z-10 bg-white text-black;

    nav {
        @apply justify-between items-center max-w-7xl h-16 mx-auto px-4 md:px-10;

        a {
            @apply text-gray-600 capitalize;

            &.router-link-exact-active {
                @apply text-green-600;
            }
        }
    
        .logo-side {
            @screen lg {
                width: 50px;
            }
        }
    
        .menu-side {
            @apply flex items-center gap-6 justify-center;
        }

        .active-link {
            @apply text-dogger-orange-400;
        }
    
        .button-side {
            @apply flex items-center gap-3 md:gap-6 justify-end;
            @screen lg {
                width: 50px;
            }
        }
    
        .button-side .menu-button, #sidebar .menu-button {
            @apply inline-flex items-center justify-center rounded border border-transparent bg-black text-white px-3 md:px-6 py-1 text-xs md:text-base font-medium shadow-sm hover:bg-dogger-orange-400;
            &.orange {
                @apply bg-dogger-orange-400 hover:bg-dogger-orange-500;
            }
        }

        #sidebar {
            @apply bg-white opacity-100 z-10 absolute top-16 -mt-px right-0 w-screen max-w-lg;
            pointer-events: all;
            transition: opacity 400ms ease 0ms;

            &.reduced {
                @apply opacity-0 pointer-events-none z-0;
                transition: opacity 400ms ease 0ms;
            }
        }
    }
}
</style>