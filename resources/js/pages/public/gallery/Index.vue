<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Image, Calendar } from 'lucide-vue-next';
import type { GalleryAlbum, PaginatedData } from '@/types';

const props = defineProps<{
    albums: PaginatedData<GalleryAlbum>;
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
    <Head title="Photo Gallery" />
    <PublicLayout>
        <!-- Header -->
        <section
            class="bg-gradient-to-br from-purple-900 to-violet-900 py-16 text-white"
        >
            <div class="mx-auto max-w-7xl px-4">
                <h1 class="text-3xl font-bold sm:text-4xl">Photo Gallery</h1>
                <p class="mt-2 text-purple-200">
                    Browse our collection of school events and activities
                </p>
            </div>
        </section>

        <div class="mx-auto max-w-7xl px-4 py-10">
            <!-- Empty State -->
            <div
                v-if="!albums.data.length"
                class="rounded-xl bg-gray-50 py-16 text-center"
            >
                <Image class="mx-auto mb-4 h-12 w-12 text-gray-300" />
                <h3 class="text-lg font-semibold text-gray-600">
                    No albums yet
                </h3>
                <p class="mt-1 text-sm text-gray-400">
                    Photo albums will appear here.
                </p>
            </div>

            <!-- Albums Grid -->
            <div v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="album in albums.data"
                    :key="album.id"
                    :href="`/gallery/${album.slug}`"
                    class="group overflow-hidden rounded-xl bg-white shadow-md ring-1 ring-gray-100 transition hover:-translate-y-1 hover:shadow-lg"
                >
                    <div
                        class="relative aspect-[4/3] overflow-hidden bg-gray-100"
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
                            <Image class="h-16 w-16" />
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"
                        />
                        <div class="absolute right-3 bottom-3 left-3">
                            <h3
                                class="text-lg font-bold text-white drop-shadow-sm"
                            >
                                {{ album.title }}
                            </h3>
                        </div>
                        <span
                            class="absolute top-3 right-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-medium text-gray-900 shadow-sm backdrop-blur-sm"
                        >
                            {{ album.photos_count ?? 0 }} photos
                        </span>
                    </div>
                    <div class="p-4">
                        <p
                            v-if="album.description"
                            class="mb-2 line-clamp-2 text-sm text-gray-500"
                        >
                            {{ album.description }}
                        </p>
                        <p
                            v-if="album.event_date"
                            class="flex items-center gap-1 text-xs text-gray-400"
                        >
                            <Calendar class="h-3.5 w-3.5" />
                            {{ formatDate(album.event_date) }}
                        </p>
                    </div>
                </Link>
            </div>

            <!-- Pagination -->
            <nav
                v-if="albums.last_page > 1"
                class="mt-8 flex items-center justify-center gap-1"
            >
                <Link
                    v-for="link in albums.links"
                    :key="link.label"
                    :href="link.url ?? '#'"
                    :class="[
                        'rounded-lg px-3 py-2 text-sm font-medium transition',
                        link.active
                            ? 'bg-purple-600 text-white'
                            : link.url
                              ? 'text-gray-600 hover:bg-gray-100'
                              : 'cursor-default text-gray-300',
                    ]"
                    v-html="link.label"
                    preserve-scroll
                />
            </nav>
        </div>
    </PublicLayout>
</template>
