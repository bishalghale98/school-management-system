<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Calendar,
    X,
    ChevronLeft,
    ChevronRight,
} from 'lucide-vue-next';
import { ref } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { GalleryAlbum } from '@/types';

const props = defineProps<{
    album: GalleryAlbum;
}>();

const lightboxIndex = ref<number | null>(null);

function openLightbox(index: number) {
    lightboxIndex.value = index;
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    lightboxIndex.value = null;
    document.body.style.overflow = '';
}

function prevPhoto() {
    if (lightboxIndex.value === null || !props.album.photos?.length) return;
    lightboxIndex.value =
        (lightboxIndex.value - 1 + props.album.photos.length) %
        props.album.photos.length;
}

function nextPhoto() {
    if (lightboxIndex.value === null || !props.album.photos?.length) return;
    lightboxIndex.value = (lightboxIndex.value + 1) % props.album.photos.length;
}

function handleKeydown(e: KeyboardEvent) {
    if (lightboxIndex.value === null) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') prevPhoto();
    if (e.key === 'ArrowRight') nextPhoto();
}

function formatDate(date: string) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
}
</script>

<template>
    <Head :title="album.title" />
    <PublicLayout>
        <!-- Header -->
        <section
            class="bg-gradient-to-br from-purple-900 to-violet-900 py-16 text-white"
        >
            <div class="mx-auto max-w-7xl px-4">
                <Link
                    href="/gallery"
                    class="mb-4 inline-flex items-center gap-1 text-sm text-purple-300 transition hover:text-white"
                >
                    <ArrowLeft class="h-4 w-4" />
                    Back to Gallery
                </Link>
                <h1 class="text-3xl font-bold sm:text-4xl">
                    {{ album.title }}
                </h1>
                <div
                    class="mt-3 flex flex-wrap items-center gap-4 text-sm text-purple-300"
                >
                    <span
                        v-if="album.event_date"
                        class="flex items-center gap-1"
                    >
                        <Calendar class="h-4 w-4" />
                        {{ formatDate(album.event_date) }}
                    </span>
                    <span>{{ album.photos?.length ?? 0 }} photos</span>
                </div>
                <p
                    v-if="album.description"
                    class="mt-3 max-w-2xl text-purple-200"
                >
                    {{ album.description }}
                </p>
            </div>
        </section>

        <div
            class="mx-auto max-w-7xl px-4 py-10"
            @keydown="handleKeydown"
            tabindex="0"
        >
            <!-- Photo Grid -->
            <div
                v-if="album.photos?.length"
                class="grid gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
            >
                <button
                    v-for="(photo, index) in album.photos"
                    :key="photo.id"
                    @click="openLightbox(index)"
                    class="group relative aspect-square overflow-hidden rounded-lg bg-gray-100 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >
                    <img
                        :src="`/storage/${photo.image_path}`"
                        :alt="photo.caption ?? `Photo ${index + 1}`"
                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                    />
                    <div
                        class="absolute inset-0 bg-black/0 transition group-hover:bg-black/20"
                    />
                    <p
                        v-if="photo.caption"
                        class="absolute right-0 bottom-0 left-0 bg-gradient-to-t from-black/70 to-transparent p-3 text-xs text-white opacity-0 transition group-hover:opacity-100"
                    >
                        {{ photo.caption }}
                    </p>
                </button>
            </div>
            <div v-else class="rounded-xl bg-gray-50 py-16 text-center">
                <p class="text-gray-500">No photos in this album yet.</p>
            </div>
        </div>

        <!-- Lightbox -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-200"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="lightboxIndex !== null && album.photos?.length"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4"
                    @click.self="closeLightbox"
                    @keydown="handleKeydown"
                    tabindex="0"
                >
                    <!-- Close -->
                    <button
                        @click="closeLightbox"
                        class="absolute top-4 right-4 rounded-full bg-white/10 p-2 text-white transition hover:bg-white/20"
                    >
                        <X class="h-6 w-6" />
                    </button>

                    <!-- Prev -->
                    <button
                        @click="prevPhoto"
                        class="absolute left-4 rounded-full bg-white/10 p-3 text-white transition hover:bg-white/20"
                    >
                        <ChevronLeft class="h-6 w-6" />
                    </button>

                    <!-- Image -->
                    <img
                        :src="`/storage/${album.photos[lightboxIndex].image_path}`"
                        :alt="album.photos[lightboxIndex].caption ?? ''"
                        class="max-h-[85vh] max-w-[85vw] rounded-lg object-contain shadow-2xl"
                    />

                    <!-- Next -->
                    <button
                        @click="nextPhoto"
                        class="absolute right-4 rounded-full bg-white/10 p-3 text-white transition hover:bg-white/20"
                    >
                        <ChevronRight class="h-6 w-6" />
                    </button>

                    <!-- Caption & Counter -->
                    <div class="absolute bottom-6 text-center text-white">
                        <p
                            v-if="album.photos[lightboxIndex].caption"
                            class="mb-1 text-sm"
                        >
                            {{ album.photos[lightboxIndex].caption }}
                        </p>
                        <p class="text-xs text-white/60">
                            {{ lightboxIndex + 1 }} / {{ album.photos.length }}
                        </p>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </PublicLayout>
</template>
