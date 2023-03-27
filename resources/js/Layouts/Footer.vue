<template>
    <div class="mx-auto mt-32 max-w-7xl px-6 lg:px-8">
        <footer aria-labelledby="footer-heading" class="relative border-t border-gray-900/10 py-24 sm:mt-56 sm:py-32">
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <img class="h-7" :src="logo"
                    alt="Company name" />
                <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-gray-900">Solutions</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li v-for="item in footerNavigation.solutions" :key="item.name">
                                    <a :href="item.href" class="text-sm leading-6 text-gray-600 hover:text-dogger-orange-400">{{
                                        item.name }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-gray-900">Support</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li v-for="item in footerNavigation.support" :key="item.name">
                                    <a :href="item.href" class="text-sm leading-6 text-gray-600 hover:text-dogger-orange-400">{{
                                        item.name }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-gray-900">Company</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li v-for="item in footerNavigation.company" :key="item.name">
                                    <a :href="item.href" class="text-sm leading-6 text-gray-600 hover:text-dogger-orange-400">{{
                                        item.name }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-gray-900">Legal</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li v-for="item in footerNavigation.legal" :key="item.name">
                                    <a :href="item.href" class="text-sm leading-6 text-gray-600 hover:text-dogger-orange-400">{{
                                        item.name }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
    </footer>
</div>
</template>

<script setup>
import logo from '../../../public/images/logo.png';

const footerNavigation = {
    solutions: [
      { name: 'Hosting', href: '#' },
      { name: 'Data Services', href: '#' },
      { name: 'Uptime Monitoring', href: '#' },
      { name: 'Enterprise Services', href: '#' },
    ],
    support: [
      { name: 'Pricing', href: '#' },
      { name: 'Documentation', href: '#' },
      { name: 'Guides', href: '#' },
      { name: 'API Reference', href: '#' },
    ],
    company: [
      { name: 'About', href: '#' },
      { name: 'Blog', href: '#' },
      { name: 'Jobs', href: '#' },
      { name: 'Press', href: '#' },
      { name: 'Partners', href: '#' },
    ],
    legal: [
      { name: 'Claim', href: '#' },
      { name: 'Privacy', href: '#' },
      { name: 'Terms', href: '#' },
    ],
  }
</script>