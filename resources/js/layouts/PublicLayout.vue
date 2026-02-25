<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    Phone,
    Mail,
    MapPin,
    Facebook,
    Youtube,
    Twitter,
    Instagram,
    Menu,
    X,
    Linkedin,
    MessageCircle,
} from 'lucide-vue-next';
import { ref, computed } from 'vue';
import type { SiteSettings } from '@/types';
import Footer from '@/components/public/Footer.vue';

const page = usePage();
const settings = computed(() => page.props.siteSettings as SiteSettings);
const mobileOpen = ref(false);
const aboutDropdownOpen = ref(false);
const currentUrl = computed(() => page.url);

const navLinks = [
    { label: 'Home', href: '/' },
    { label: 'About Us', href: '/about', hasDropdown: true },
    { label: 'Downloads', href: '/downloads' },
    { label: 'Gallery', href: '/gallery' },
    { label: 'News & Updates', href: '/news-update' },
    { label: 'Admission Form', href: '/admission' },
];

const aboutSubLinks = [
    { label: 'Overview', href: '/about#overview' },
    { label: "Principal's Message", href: '/about#message' },
];

function isActive(href: string) {
    if (href === '/') return currentUrl.value === '/';
    if (href.includes('#')) {
        const basePath = href.split('#')[0];
        return currentUrl.value.startsWith(basePath);
    }
    return currentUrl.value.startsWith(href);
}

const toggleMobileMenu = () => {
    mobileOpen.value = !mobileOpen.value;
    if (mobileOpen.value) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
};

const closeMobileMenu = () => {
    mobileOpen.value = false;
    document.body.style.overflow = '';
};
</script>

<template>
    <!-- Top Bar with Contact Info & Social Icons (Next.js style) -->
    <div class="border-b border-slate-700 bg-slate-800 text-white">
        <div
            class="mx-auto flex max-w-7xl flex-wrap items-center justify-between px-4 py-2"
        >
            <!-- Contact Info -->
            <div class="flex flex-wrap items-center gap-4 text-xs">
                <Link
                    v-if="settings?.phone_1"
                    :href="`tel:${settings.phone_1}`"
                    class="flex items-center gap-1 text-slate-300 transition hover:text-white"
                >
                    <Phone class="h-3 w-3" />
                    {{ settings.phone_1 }}
                </Link>
                <Link
                    v-if="settings?.email_1"
                    :href="`mailto:${settings.email_1}`"
                    class="flex items-center gap-1 text-slate-300 transition hover:text-white"
                >
                    <Mail class="h-3 w-3" />
                    {{ settings.email_1 }}
                </Link>
                <span
                    v-if="settings?.address"
                    class="hidden items-center gap-1 text-slate-300 md:flex"
                >
                    <MapPin class="h-3 w-3" />
                    {{ settings.address }}
                </span>
            </div>

            <!-- Social Icons -->
            <div class="flex items-center gap-2">
                <Link
                    v-if="settings?.facebook_url"
                    :href="settings.facebook_url"
                    target="_blank"
                    class="rounded p-1 transition hover:bg-slate-700"
                >
                    <Facebook class="h-4 w-4 text-blue-400" />
                </Link>
                <Link
                    v-if="settings?.twitter_url"
                    :href="settings.twitter_url"
                    target="_blank"
                    class="rounded p-1 transition hover:bg-slate-700"
                >
                    <Twitter class="h-4 w-4 text-blue-400" />
                </Link>
                <Link
                    v-if="settings?.youtube_url"
                    :href="settings.youtube_url"
                    target="_blank"
                    class="rounded p-1 transition hover:bg-slate-700"
                >
                    <Youtube class="h-4 w-4 text-red-500" />
                </Link>
                <Link
                    v-if="settings?.instagram_url"
                    :href="settings.instagram_url"
                    target="_blank"
                    class="rounded p-1 transition hover:bg-slate-700"
                >
                    <Instagram class="h-4 w-4 text-pink-500" />
                </Link>
                <!-- Additional social icons from Next.js design -->
                <Link
                    href="#"
                    target="_blank"
                    class="rounded p-1 transition hover:bg-slate-700"
                >
                    <MessageCircle class="h-4 w-4 text-green-500" />
                </Link>
                <Link
                    href="#"
                    target="_blank"
                    class="rounded p-1 transition hover:bg-slate-700"
                >
                    <Linkedin class="h-4 w-4 text-blue-600" />
                </Link>
            </div>
        </div>
    </div>

    <!-- Navbar (Next.js style) -->
    <header class="sticky top-0 z-50 bg-slate-800 text-white shadow-lg">
        <div class="mx-auto max-w-7xl px-4">
            <div class="flex items-center justify-between py-4">
                <!-- Logo and School Info -->
                <Link href="/" class="flex items-center gap-4">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-white"
                    >
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800"
                        >
                            <img
                                v-if="settings?.logo"
                                :src="`/storage/${settings.logo}`"
                                :alt="settings?.site_name ?? 'School'"
                                class="h-8 w-8 rounded-full object-cover"
                            />
                            <span v-else class="text-sm font-bold text-white"
                                >LOGO</span
                            >
                        </div>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">
                            {{ settings?.site_name ?? 'Utshav SCHOOL' }}
                        </h1>
                        <p
                            v-if="settings?.address"
                            class="text-sm text-slate-300"
                        >
                            {{ settings.address }}
                        </p>
                        <p v-else class="text-sm text-slate-300">Address</p>
                    </div>
                </Link>

                <!-- Desktop Navigation -->
                <nav class="hidden items-center gap-1 lg:flex">
                    <!-- Regular Links -->
                    <template v-for="link in navLinks" :key="link.href">
                        <!-- About Us with Dropdown -->
                        <div
                            v-if="link.hasDropdown"
                            class="relative"
                            @mouseenter="aboutDropdownOpen = true"
                            @mouseleave="aboutDropdownOpen = false"
                        >
                            <button
                                :class="[
                                    'flex items-center gap-1 rounded px-4 py-2 transition-colors',
                                    isActive('/about')
                                        ? 'bg-slate-700'
                                        : 'hover:bg-slate-700',
                                ]"
                            >
                                <span>{{ link.label }}</span>
                                <svg
                                    class="h-4 w-4 transition-transform duration-200"
                                    :class="{ 'rotate-180': aboutDropdownOpen }"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>

                            <!-- Dropdown Content -->
                            <Transition
                                enter-active-class="transition duration-200 ease-out"
                                enter-from-class="opacity-0 translate-y-1"
                                enter-to-class="opacity-100 translate-y-0"
                                leave-active-class="transition duration-150 ease-in"
                                leave-from-class="opacity-100 translate-y-0"
                                leave-to-class="opacity-0 translate-y-1"
                            >
                                <div
                                    v-if="aboutDropdownOpen"
                                    class="absolute top-full left-0 z-50 mt-1 w-48 rounded-md bg-white py-1 shadow-lg"
                                >
                                    <Link
                                        v-for="subLink in aboutSubLinks"
                                        :key="subLink.href"
                                        :href="subLink.href"
                                        class="block px-4 py-2 text-sm text-slate-800 transition hover:bg-slate-100"
                                    >
                                        {{ subLink.label }}
                                    </Link>
                                </div>
                            </Transition>
                        </div>

                        <!-- Regular Link -->
                        <Link
                            v-else
                            :href="link.href"
                            :class="[
                                'rounded px-4 py-2 transition-colors',
                                isActive(link.href)
                                    ? 'bg-slate-700'
                                    : 'hover:bg-slate-700',
                            ]"
                        >
                            {{ link.label }}
                        </Link>
                    </template>

                    <!-- Contact Button -->
                    <Link
                        href="/contact-us"
                        class="ml-2 rounded bg-green-600 px-4 py-2 font-semibold text-white transition hover:bg-green-700"
                    >
                        Contact Us
                    </Link>
                </nav>

                <!-- Mobile Toggle -->
                <button
                    @click="toggleMobileMenu"
                    class="rounded-lg p-2 text-white hover:bg-slate-700 lg:hidden"
                    aria-label="Toggle menu"
                >
                    <X v-if="mobileOpen" class="h-6 w-6" />
                    <Menu v-else class="h-6 w-6" />
                </button>
            </div>
        </div>

        <!-- Mobile Menu (Sheet style) -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="translate-x-full"
            enter-to-class="translate-x-0"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="translate-x-0"
            leave-to-class="translate-x-full"
        >
            <div v-if="mobileOpen" class="fixed inset-0 z-50 lg:hidden">
                <!-- Backdrop -->
                <div
                    class="fixed inset-0  backdrop-blur-md"
                    @click="closeMobileMenu"
                />

                <!-- Sheet Content -->
                <div class="fixed inset-y-0 right-0 w-80 bg-white shadow-xl">
                    <div class="flex justify-end p-4">
                        <button
                            @click="closeMobileMenu"
                            class="rounded p-2 transition hover:bg-slate-100"
                            aria-label="Close menu"
                        >
                            <X class="h-6 w-6 text-slate-600" />
                        </button>
                    </div>

                    <nav class="mt-8 flex flex-col space-y-4 px-6">
                        <Link
                            v-for="link in navLinks"
                            :key="link.href"
                            :href="link.href"
                            class="text-lg font-medium border-b border-slate-200 text-slate-800 transition hover:text-slate-600"
                            @click="closeMobileMenu"
                        >
                            {{ link.label }}
                        </Link>
                        <Link
                            href="/contact-us"
                            class="text-lg font-medium text-slate-800 transition hover:text-slate-600"
                            @click="closeMobileMenu"
                        >
                            Contact Us
                        </Link>
                        <Link
                            href="/admission"
                            class="mt-4 rounded-lg bg-green-600 px-4 py-3 text-center text-lg font-semibold text-white transition hover:bg-green-700"
                            @click="closeMobileMenu"
                        >
                            Apply Now
                        </Link>
                    </nav>
                </div>
            </div>
        </Transition>
    </header>

    <!-- Main Content -->
    <main class="min-h-[60vh]">
        <slot />
    </main>

    <!-- Footer -->
    <Footer />
</template>
