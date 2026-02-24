<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { Save, ArrowLeft, Upload, Trash2 } from 'lucide-vue-next';

import AdminLayout from '@/layouts/AdminLayout.vue';
import type { GalleryAlbum } from '@/types';

const props = defineProps<{ album?: GalleryAlbum }>();
const isEdit = !!props.album;

const form = useForm({
    title: props.album?.title ?? '',
    slug: props.album?.slug ?? '',
    description: props.album?.description ?? '',
    cover_image: null as File | null,
    event_date: props.album?.event_date?.substring(0, 10) ?? '',
    status: props.album?.status ?? 'draft',
    published_at: props.album?.published_at?.substring(0, 10) ?? '',
});

const photoForm = useForm({ photos: [] as File[] });

const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Gallery', href: '/admin/gallery' },
    { title: isEdit ? 'Edit Album' : 'Create Album' },
];

function generateSlug() {
    form.slug = form.title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
}

function submit() {
    if (isEdit) {
        form.post(`/admin/gallery/${props.album!.id}`, {
            forceFormData: true,
            headers: { 'X-HTTP-Method-Override': 'PUT' },
        });
    } else {
        form.post('/admin/gallery', { forceFormData: true });
    }
}

function uploadPhotos(e: Event) {
    const files = (e.target as HTMLInputElement).files;
    if (!files?.length || !isEdit) return;
    photoForm.photos = Array.from(files);
    photoForm.post(`/admin/gallery/${props.album!.id}/photos`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            photoForm.reset();
        },
    });
}

function deletePhoto(id: number) {
    if (confirm('Delete this photo?'))
        router.delete(`/admin/photos/${id}`, { preserveScroll: true });
}
</script>

<template>
    <Head :title="isEdit ? 'Edit Album' : 'Create Album'" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-tight">
                    {{ isEdit ? 'Edit Album' : 'Create Album' }}
                </h1>
                <button
                    @click="router.visit('/admin/gallery')"
                    class="inline-flex items-center gap-2 rounded-lg border px-3 py-2 text-sm hover:bg-accent"
                >
                    <ArrowLeft class="h-4 w-4" /> Back
                </button>
            </div>
            <form
                @submit.prevent="submit"
                class="mx-auto w-full max-w-2xl space-y-6"
            >
                <div
                    class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Title
                            <span class="text-destructive">*</span></label
                        >
                        <input
                            v-model="form.title"
                            @blur="!isEdit && !form.slug && generateSlug()"
                            type="text"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                        <p
                            v-if="form.errors.title"
                            class="mt-1 text-xs text-destructive"
                        >
                            {{ form.errors.title }}
                        </p>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Slug</label
                        >
                        <input
                            v-model="form.slug"
                            type="text"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Description</label
                        >
                        <textarea
                            v-model="form.description"
                            rows="3"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                        />
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Event Date</label
                            >
                            <input
                                v-model="form.event_date"
                                type="date"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Status</label
                            >
                            <select
                                v-model="form.status"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            >
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"
                            >Cover Image</label
                        >
                        <img
                            v-if="isEdit && album!.cover_image"
                            :src="`/storage/${album!.cover_image}`"
                            class="mb-2 h-32 w-full rounded-lg object-cover"
                        />
                        <input
                            type="file"
                            accept="image/*"
                            @change="
                                form.cover_image =
                                    ($event.target as HTMLInputElement)
                                        .files?.[0] ?? null
                            "
                            class="w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-sm file:text-primary-foreground"
                        />
                    </div>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90 disabled:opacity-50"
                    >
                        <Save class="h-4 w-4" />
                        {{
                            form.processing
                                ? 'Saving...'
                                : isEdit
                                  ? 'Update Album'
                                  : 'Create Album'
                        }}
                    </button>
                </div>
            </form>

            <!-- Photo Management (edit only) -->
            <div v-if="isEdit" class="mx-auto w-full max-w-2xl space-y-4">
                <div
                    class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                >
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold">
                            Photos ({{ album!.photos?.length ?? 0 }})
                        </h3>
                        <label
                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-primary px-3 py-1.5 text-xs font-medium text-primary-foreground hover:bg-primary/90"
                        >
                            <Upload class="h-3.5 w-3.5" /> Upload Photos
                            <input
                                type="file"
                                multiple
                                accept="image/*"
                                class="hidden"
                                @change="uploadPhotos"
                            />
                        </label>
                    </div>
                    <div
                        v-if="album!.photos?.length"
                        class="grid grid-cols-3 gap-3 sm:grid-cols-4"
                    >
                        <div
                            v-for="photo in album!.photos"
                            :key="photo.id"
                            class="group relative aspect-square overflow-hidden rounded-lg"
                        >
                            <img
                                :src="`/storage/${photo.image_path}`"
                                :alt="photo.caption ?? ''"
                                class="h-full w-full object-cover"
                            />
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 transition-opacity group-hover:opacity-100"
                            >
                                <button
                                    @click="deletePhoto(photo.id)"
                                    class="rounded-full bg-destructive p-2 text-white hover:bg-destructive/80"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                    <p
                        v-else
                        class="py-8 text-center text-sm text-muted-foreground"
                    >
                        No photos uploaded yet.
                    </p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
