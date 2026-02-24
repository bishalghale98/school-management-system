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
    ChevronDown,
} from 'lucide-vue-next';
import { ref, computed } from 'vue';
import type { SiteSettings } from '@/types';

const page = usePage();
const settings = computed(() => page.props.siteSettings as SiteSettings);
const mobileOpen = ref(false);
const currentUrl = computed(() => page.url);

const navLinks = [
    { label: 'Home', href: '/' },
    { label: 'News & Updates', href: '/news-update' },
    { label: 'Downloads', href: '/downloads' },
    { label: 'Gallery', href: '/gallery' },
    { label: 'Contact', href: '/contact-us' },
];

function isActive(href: string) {
    if (href === '/') return currentUrl.value === '/';
    return currentUrl.value.startsWith(href);
}
</script>

<template>
    <!-- Top Bar -->
    <div class="border-b border-gray-200 bg-gray-900 text-xs text-gray-300">
        <div
            class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-2 px-4 py-2"
        >
            <div class="flex flex-wrap items-center gap-4">
                <a
                    v-if="settings?.phone_1"
                    :href="`tel:${settings.phone_1}`"
                    class="flex items-center gap-1 transition hover:text-white"
                >
                    <Phone class="h-3 w-3" />
                    {{ settings.phone_1 }}
                </a>
                <a
                    v-if="settings?.email_1"
                    :href="`mailto:${settings.email_1}`"
                    class="flex items-center gap-1 transition hover:text-white"
                >
                    <Mail class="h-3 w-3" />
                    {{ settings.email_1 }}
                </a>
                <span
                    v-if="settings?.address"
                    class="hidden items-center gap-1 md:flex"
                >
                    <MapPin class="h-3 w-3" />
                    {{ settings.address }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <a
                    v-if="settings?.facebook_url"
                    :href="settings.facebook_url"
                    target="_blank"
                    class="transition hover:text-white"
                    ><Facebook class="h-3.5 w-3.5"
                /></a>
                <a
                    v-if="settings?.youtube_url"
                    :href="settings.youtube_url"
                    target="_blank"
                    class="transition hover:text-white"
                    ><Youtube class="h-3.5 w-3.5"
                /></a>
                <a
                    v-if="settings?.twitter_url"
                    :href="settings.twitter_url"
                    target="_blank"
                    class="transition hover:text-white"
                    ><Twitter class="h-3.5 w-3.5"
                /></a>
                <a
                    v-if="settings?.instagram_url"
                    :href="settings.instagram_url"
                    target="_blank"
                    class="transition hover:text-white"
                    ><Instagram class="h-3.5 w-3.5"
                /></a>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <header
        class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 shadow-sm backdrop-blur-md"
    >
        <div
            class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3"
        >
            <!-- Logo -->
            <Link href="/" class="flex items-center gap-3">
                <img
                    v-if="settings?.logo"
                    :src="`/storage/${settings.logo}`"
                    :alt="settings?.site_name ?? 'School'"
                    class="h-10 w-auto"
                />
                <div>
                    <span class="text-lg font-bold text-gray-900">
                        {{ settings?.site_name ?? 'School' }}
                    </span>
                    <p
                        v-if="settings?.tagline"
                        class="hidden text-[11px] leading-tight text-gray-500 md:block"
                    >
                        {{ settings.tagline }}
                    </p>
                </div>
            </Link>

            <!-- Desktop Nav -->
            <nav class="hidden items-center gap-1 lg:flex">
                <Link
                    v-for="link in navLinks"
                    :key="link.href"
                    :href="link.href"
                    :class="[
                        'rounded-lg px-3 py-2 text-sm font-medium transition-colors',
                        isActive(link.href)
                            ? 'bg-blue-50 text-blue-700'
                            : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900',
                    ]"
                >
                    {{ link.label }}
                </Link>
                <Link
                    href="/admission"
                    class="ml-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                >
                    Apply Now
                </Link>
            </nav>

            <!-- Mobile Toggle -->
            <button
                @click="mobileOpen = !mobileOpen"
                class="rounded-lg p-2 text-gray-700 hover:bg-gray-100 lg:hidden"
            >
                <X v-if="mobileOpen" class="h-5 w-5" />
                <Menu v-else class="h-5 w-5" />
            </button>
        </div>

        <!-- Mobile Nav -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div
                v-if="mobileOpen"
                class="border-t bg-white px-4 pt-2 pb-4 lg:hidden"
            >
                <Link
                    v-for="link in navLinks"
                    :key="link.href"
                    :href="link.href"
                    @click="mobileOpen = false"
                    :class="[
                        'block rounded-lg px-3 py-2.5 text-sm font-medium transition-colors',
                        isActive(link.href)
                            ? 'bg-blue-50 text-blue-700'
                            : 'text-gray-700 hover:bg-gray-100',
                    ]"
                >
                    {{ link.label }}
                </Link>
                <Link
                    href="/admission"
                    @click="mobileOpen = false"
                    class="mt-2 block rounded-lg bg-blue-600 px-3 py-2.5 text-center text-sm font-semibold text-white hover:bg-blue-700"
                >
                    Apply Now
                </Link>
            </div>
        </Transition>
    </header>

    <!-- Main Content -->
    <main class="min-h-[60vh]">
        <slot />
    </main>

    <!-- Footer -->
    <footer class="border-t bg-gray-900 text-gray-300">
        <div
            class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:grid-cols-2 lg:grid-cols-4"
        >
            <!-- About -->
            <div>
                <h3 class="mb-4 text-lg font-bold text-white">
                    {{ settings?.site_name ?? 'School' }}
                </h3>
                <p
                    v-if="settings?.tagline"
                    class="mb-4 text-sm leading-relaxed"
                >
                    {{ settings.tagline }}
                </p>
                <div class="flex items-center gap-3">
                    <a
                        v-if="settings?.facebook_url"
                        :href="settings.facebook_url"
                        target="_blank"
                        class="rounded-full bg-gray-800 p-2 transition hover:bg-blue-600"
                        ><Facebook class="h-4 w-4"
                    /></a>
                    <a
                        v-if="settings?.youtube_url"
                        :href="settings.youtube_url"
                        target="_blank"
                        class="rounded-full bg-gray-800 p-2 transition hover:bg-red-600"
                        ><Youtube class="h-4 w-4"
                    /></a>
                    <a
                        v-if="settings?.twitter_url"
                        :href="settings.twitter_url"
                        target="_blank"
                        class="rounded-full bg-gray-800 p-2 transition hover:bg-sky-500"
                        ><Twitter class="h-4 w-4"
                    /></a>
                    <a
                        v-if="settings?.instagram_url"
                        :href="settings.instagram_url"
                        target="_blank"
                        class="rounded-full bg-gray-800 p-2 transition hover:bg-pink-600"
                        ><Instagram class="h-4 w-4"
                    /></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="mb-4 text-lg font-bold text-white">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li>
                        <Link
                            href="/news-update"
                            class="transition hover:text-white"
                            >News & Updates</Link
                        >
                    </li>
                    <li>
                        <Link
                            href="/downloads"
                            class="transition hover:text-white"
                            >Downloads</Link
                        >
                    </li>
                    <li>
                        <Link
                            href="/gallery"
                            class="transition hover:text-white"
                            >Gallery</Link
                        >
                    </li>
                    <li>
                        <Link
                            href="/admission"
                            class="transition hover:text-white"
                            >Admission</Link
                        >
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="mb-4 text-lg font-bold text-white">Contact Us</h3>
                <ul class="space-y-3 text-sm">
                    <li v-if="settings?.address" class="flex items-start gap-2">
                        <MapPin class="mt-0.5 h-4 w-4 shrink-0" />
                        {{ settings.address }}
                    </li>
                    <li
                        v-if="settings?.phone_1"
                        class="flex items-center gap-2"
                    >
                        <Phone class="h-4 w-4 shrink-0" />
                        <a
                            :href="`tel:${settings.phone_1}`"
                            class="hover:text-white"
                            >{{ settings.phone_1 }}</a
                        >
                    </li>
                    <li
                        v-if="settings?.phone_2"
                        class="flex items-center gap-2"
                    >
                        <Phone class="h-4 w-4 shrink-0" />
                        <a
                            :href="`tel:${settings.phone_2}`"
                            class="hover:text-white"
                            >{{ settings.phone_2 }}</a
                        >
                    </li>
                    <li
                        v-if="settings?.email_1"
                        class="flex items-center gap-2"
                    >
                        <Mail class="h-4 w-4 shrink-0" />
                        <a
                            :href="`mailto:${settings.email_1}`"
                            class="hover:text-white"
                            >{{ settings.email_1 }}</a
                        >
                    </li>
                </ul>
            </div>

            <!-- Map -->
            <div>
                <h3 class="mb-4 text-lg font-bold text-white">Find Us</h3>
                <div
                    v-if="settings?.map_embed_code"
                    class="aspect-video overflow-hidden rounded-lg"
                    v-html="settings.map_embed_code"
                />
                <p v-else class="text-sm">Visit us at our campus.</p>
            </div>
        </div>

        <!-- Copyright -->
        <div
            class="border-t border-gray-800 px-4 py-4 text-center text-xs text-gray-500"
        >
            &copy; {{ new Date().getFullYear() }}
            {{ settings?.site_name ?? 'School' }}. All rights reserved.
        </div>
    </footer>
</template>
