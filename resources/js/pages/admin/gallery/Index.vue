<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2, Image as ImageIcon } from 'lucide-vue-next';
import Pagination from '@/components/admin/Pagination.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { GalleryAlbum, PaginatedData } from '@/types';

defineProps<{ albums: PaginatedData<GalleryAlbum> }>();
const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Gallery' },
];

function deleteAlbum(album: GalleryAlbum) {
    if (confirm(`Delete "${album.title}"?`))
        router.delete(`/admin/gallery/${album.id}`);
}
</script>

<template>
    <Head title="Manage Gallery" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        Gallery Albums
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        Manage photo albums
                    </p>
                </div>
                <Link
                    href="/admin/gallery/create"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90"
                >
                    <Plus class="h-4 w-4" /> New Album
                </Link>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="album in albums.data"
                    :key="album.id"
                    class="group overflow-hidden rounded-xl border border-sidebar-border/70 bg-card shadow-sm transition-all hover:shadow-md dark:border-sidebar-border"
                >
                    <div class="relative aspect-video bg-muted">
                        <img
                            v-if="album.cover_image"
                            :src="`/storage/${album.cover_image}`"
                            :alt="album.title"
                            class="h-full w-full object-cover"
                        />
                        <div
                            v-else
                            class="flex h-full items-center justify-center"
                        >
                            <ImageIcon
                                class="h-10 w-10 text-muted-foreground/30"
                            />
                        </div>
                        <span
                            :class="[
                                'absolute top-2 right-2 rounded-full px-2 py-0.5 text-[10px] font-medium',
                                album.status === 'published'
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : 'bg-gray-100 text-gray-600',
                            ]"
                            >{{ album.status }}</span
                        >
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold">{{ album.title }}</h3>
                        <p class="mt-1 text-xs text-muted-foreground">
                            {{ album.photos_count }} photos
                        </p>
                        <div class="mt-3 flex gap-2">
                            <Link
                                :href="`/admin/gallery/${album.id}/edit`"
                                class="inline-flex flex-1 items-center justify-center gap-1 rounded-md border px-3 py-1.5 text-xs hover:bg-accent"
                            >
                                <Pencil class="h-3 w-3" /> Edit
                            </Link>
                            <button
                                @click="deleteAlbum(album)"
                                class="inline-flex items-center justify-center rounded-md border px-3 py-1.5 text-xs text-destructive hover:bg-destructive/10"
                            >
                                <Trash2 class="h-3 w-3" />
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    v-if="!albums.data.length"
                    class="col-span-full py-12 text-center text-muted-foreground"
                >
                    No albums yet.
                </div>
            </div>
            <Pagination :data="albums" />
        </div>
    </AdminLayout>
</template>
