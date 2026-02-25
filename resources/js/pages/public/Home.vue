<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BookOpen,
    Download,
    GraduationCap,
    Image,
    Calendar,
    Clock,
    FileText,
    Users,
    ChevronRight,
} from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type {
    Post,
    Download as DownloadType,
    GalleryAlbum,
    SiteSettings,
} from '@/types';

defineProps<{
    settings: SiteSettings;
    latestPosts: Post[];
    featuredDownloads: DownloadType[];
    albums: GalleryAlbum[];
}>();

function formatDate(date: string) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
}
</script>

<template>
    <Head :title="settings?.site_name ?? 'Welcome'" />
    <PublicLayout>
        <!-- Hero Section -->
        <section
            class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 py-24 text-white"
        >
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute top-1/4 left-1/4 h-96 w-96 rounded-full bg-blue-400 blur-3xl"
                />
                <div
                    class="absolute right-1/4 bottom-1/4 h-96 w-96 rounded-full bg-indigo-400 blur-3xl"
                />
            </div>
            <div class="relative mx-auto max-w-7xl px-4 text-center">
                <h1
                    class="mb-4 text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl"
                >
                    Welcome to<br />
                    <span
                        class="bg-gradient-to-r from-blue-300 to-cyan-300 bg-clip-text text-transparent"
                    >
                        {{ settings?.site_name ?? 'Our School' }}
                    </span>
                </h1>
                <p
                    v-if="settings?.tagline"
                    class="mx-auto mb-8 max-w-2xl text-lg text-blue-200"
                >
                    {{ settings.tagline }}
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <Link
                        href="/admission"
                        class="inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-blue-900 shadow-lg transition hover:bg-blue-50 hover:shadow-xl"
                    >
                        <GraduationCap class="h-5 w-5" />
                        Apply for Admission
                    </Link>
                    <Link
                        href="/contact-us"
                        class="inline-flex items-center gap-2 rounded-lg border-2 border-white/30 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:border-white/60 hover:bg-white/10"
                    >
                        Contact Us
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <Link
                    href="/news-update"
                    class="group flex items-center gap-4 rounded-xl bg-white p-5 shadow-lg ring-1 ring-gray-100 transition hover:-translate-y-0.5 hover:shadow-xl"
                >
                    <div
                        class="rounded-lg bg-blue-100 p-3 text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white"
                    >
                        <BookOpen class="h-6 w-6" />
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-gray-900"
                            >News & Notices</span
                        >
                        <p class="text-xs text-gray-500">Latest updates</p>
                    </div>
                </Link>
                <Link
                    href="/downloads"
                    class="group flex items-center gap-4 rounded-xl bg-white p-5 shadow-lg ring-1 ring-gray-100 transition hover:-translate-y-0.5 hover:shadow-xl"
                >
                    <div
                        class="rounded-lg bg-green-100 p-3 text-green-600 transition group-hover:bg-green-600 group-hover:text-white"
                    >
                        <Download class="h-6 w-6" />
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-gray-900"
                            >Downloads</span
                        >
                        <p class="text-xs text-gray-500">Forms & resources</p>
                    </div>
                </Link>
                <Link
                    href="/gallery"
                    class="group flex items-center gap-4 rounded-xl bg-white p-5 shadow-lg ring-1 ring-gray-100 transition hover:-translate-y-0.5 hover:shadow-xl"
                >
                    <div
                        class="rounded-lg bg-purple-100 p-3 text-purple-600 transition group-hover:bg-purple-600 group-hover:text-white"
                    >
                        <Image class="h-6 w-6" />
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-gray-900"
                            >Gallery</span
                        >
                        <p class="text-xs text-gray-500">Photo albums</p>
                    </div>
                </Link>
                <Link
                    href="/admission"
                    class="group flex items-center gap-4 rounded-xl bg-white p-5 shadow-lg ring-1 ring-gray-100 transition hover:-translate-y-0.5 hover:shadow-xl"
                >
                    <div
                        class="rounded-lg bg-orange-100 p-3 text-orange-600 transition group-hover:bg-orange-600 group-hover:text-white"
                    >
                        <GraduationCap class="h-6 w-6" />
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-gray-900"
                            >Admission</span
                        >
                        <p class="text-xs text-gray-500">Apply now</p>
                    </div>
                </Link>
            </div>
        </section>

        <!-- Latest News -->
        <section v-if="latestPosts.length" class="mx-auto max-w-7xl px-4 py-16">
            <div class="mb-8 flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                        Latest News & Updates
                    </h2>
                    <p class="mt-1 text-gray-500">
                        Stay informed about school activities
                    </p>
                </div>
                <Link
                    href="/news-update"
                    class="hidden items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700 sm:flex"
                >
                    View all <ChevronRight class="h-4 w-4" />
                </Link>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="post in latestPosts"
                    :key="post.id"
                    :href="`/news-update/${post.slug}`"
                    class="group overflow-hidden rounded-xl bg-white shadow-md ring-1 ring-gray-100 transition hover:-translate-y-1 hover:shadow-lg"
                >
                    <div class="aspect-[16/9] overflow-hidden bg-gray-100">
                        <img
                            v-if="post.featured_image"
                            :src="`/storage/${post.featured_image}`"
                            :alt="post.title"
                            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                        />
                        <div
                            v-else
                            class="flex h-full items-center justify-center text-gray-300"
                        >
                            <FileText class="h-12 w-12" />
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="mb-2 flex items-center gap-2">
                            <span
                                v-if="post.category"
                                class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-700"
                            >
                                {{ post.category.name }}
                            </span>
                            <span
                                v-if="post.is_pinned"
                                class="rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-700"
                            >
                                Pinned
                            </span>
                        </div>
                        <h3
                            class="mb-2 line-clamp-2 text-base font-semibold text-gray-900 group-hover:text-blue-600"
                        >
                            {{ post.title }}
                        </h3>
                        <p
                            v-if="post.excerpt"
                            class="mb-3 line-clamp-2 text-sm text-gray-500"
                        >
                            {{ post.excerpt }}
                        </p>
                        <div
                            class="flex items-center gap-2 text-xs text-gray-400"
                        >
                            <Clock class="h-3.5 w-3.5" />
                            {{
                                formatDate(post.published_at ?? post.created_at)
                            }}
                        </div>
                    </div>
                </Link>
            </div>
            <div class="mt-6 text-center sm:hidden">
                <Link
                    href="/news-update"
                    class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700"
                >
                    View all news <ChevronRight class="h-4 w-4" />
                </Link>
            </div>
        </section>

        <!-- Gallery Preview -->
        <section v-if="albums.length" class="bg-gray-50 py-16">
            <div class="mx-auto max-w-7xl px-4">
                <div class="mb-8 flex items-end justify-between">
                    <div>
                        <h2
                            class="text-2xl font-bold text-gray-900 sm:text-3xl"
                        >
                            Photo Gallery
                        </h2>
                        <p class="mt-1 text-gray-500">
                            Moments from our school life
                        </p>
                    </div>
                    <Link
                        href="/gallery"
                        class="hidden items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700 sm:flex"
                    >
                        View all <ChevronRight class="h-4 w-4" />
                    </Link>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <Link
                        v-for="album in albums"
                        :key="album.id"
                        :href="`/gallery/${album.slug}`"
                        class="group overflow-hidden rounded-xl bg-white shadow-md ring-1 ring-gray-100 transition hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div
                            class="relative aspect-square overflow-hidden bg-gray-100"
                        >
                            <img
                                v-if="album.cover_image"
                                :src="`/storage/${album.cover_image}`"
                                :alt="album.title"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                            />
                            <div
                                v-else
                                class="flex h-full items-center justify-center text-gray-300"
                            >
                                <Image class="h-12 w-12" />
                            </div>
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 transition group-hover:opacity-100"
                            />
                            <span
                                class="absolute right-3 bottom-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-medium text-gray-900 backdrop-blur-sm"
                            >
                                {{ album.photos_count ?? 0 }} photos
                            </span>
                        </div>
                        <div class="p-4">
                            <h3
                                class="font-semibold text-gray-900 group-hover:text-blue-600"
                            >
                                {{ album.title }}
                            </h3>
                            <p
                                v-if="album.event_date"
                                class="mt-1 flex items-center gap-1 text-xs text-gray-400"
                            >
                                <Calendar class="h-3.5 w-3.5" />
                                {{ formatDate(album.event_date) }}
                            </p>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Featured Downloads -->
        <section
            v-if="featuredDownloads.length"
            class="mx-auto max-w-7xl px-4 py-16"
        >
            <div class="mb-8 flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                        Downloads
                    </h2>
                    <p class="mt-1 text-gray-500">
                        Important documents & resources
                    </p>
                </div>
                <Link
                    href="/downloads"
                    class="hidden items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700 sm:flex"
                >
                    View all <ChevronRight class="h-4 w-4" />
                </Link>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="dl in featuredDownloads"
                    :key="dl.id"
                    class="flex items-center gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-100 transition hover:shadow-md"
                >
                    <div
                        class="shrink-0 rounded-lg bg-green-100 p-3 text-green-600"
                    >
                        <Download class="h-5 w-5" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3
                            class="truncate text-sm font-semibold text-gray-900"
                        >
                            {{ dl.title }}
                        </h3>
                        <span
                            v-if="dl.category"
                            class="text-xs text-gray-400"
                            >{{ dl.category.name }}</span
                        >
                    </div>
                    <a
                        v-if="dl.type === 'file' && dl.file_path"
                        :href="`/storage/${dl.file_path}`"
                        target="_blank"
                        class="shrink-0 rounded-lg bg-gray-100 p-2 text-gray-600 transition hover:bg-blue-600 hover:text-white"
                    >
                        <Download class="h-4 w-4" />
                    </a>
                    <a
                        v-else-if="dl.external_url"
                        :href="dl.external_url"
                        target="_blank"
                        class="shrink-0 rounded-lg bg-gray-100 p-2 text-gray-600 transition hover:bg-blue-600 hover:text-white"
                    >
                        <ArrowRight class="h-4 w-4" />
                    </a>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section
            class="bg-gradient-to-r from-blue-600 to-indigo-700 py-16 text-white"
        >
            <div class="mx-auto max-w-4xl px-4 text-center">
                <h2 class="mb-4 text-3xl font-bold">
                    Ready to Join Our School?
                </h2>
                <p class="mb-8 text-lg text-blue-200">
                    Start your journey with us today. Apply for admission or
                    reach out for more information.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <Link
                        href="/admission"
                        class="inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-blue-700 shadow-lg transition hover:bg-blue-50"
                    >
                        <GraduationCap class="h-5 w-5" />
                        Apply Now
                    </Link>
                    <Link
                        href="/contact-us"
                        class="inline-flex items-center gap-2 rounded-lg border-2 border-white/30 px-6 py-3 text-sm font-semibold text-white transition hover:border-white/60 hover:bg-white/10"
                    >
                        <Users class="h-5 w-5" />
                        Contact Us
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
