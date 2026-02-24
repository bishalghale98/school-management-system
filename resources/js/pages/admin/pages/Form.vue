<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { Save, ArrowLeft } from 'lucide-vue-next';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { Page } from '@/types';

const props = defineProps<{
    page?: Page;
}>();

const isEdit = !!props.page;

const form = useForm({
    title: props.page?.title ?? '',
    slug: props.page?.slug ?? '',
    content: props.page?.content ?? '',
    excerpt: props.page?.excerpt ?? '',
    featured_image: null as File | null,
    meta_title: props.page?.meta_title ?? '',
    meta_description: props.page?.meta_description ?? '',
    og_image: null as File | null,
    status: props.page?.status ?? 'draft',
    published_at: props.page?.published_at?.substring(0, 10) ?? '',
    sort_order: props.page?.sort_order ?? 0,
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Pages', href: '/admin/pages' },
    { title: isEdit ? 'Edit Page' : 'Create Page' },
];

function generateSlug() {
    form.slug = form.title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
}

function submit() {
    if (isEdit) {
        form.post(`/admin/pages/${props.page!.id}`, {
            forceFormData: true,
            headers: { 'X-HTTP-Method-Override': 'PUT' },
        });
    } else {
        form.post('/admin/pages', { forceFormData: true });
    }
}
</script>

<template>
    <Head :title="isEdit ? `Edit: ${page!.title}` : 'Create Page'" />

    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        {{ isEdit ? 'Edit Page' : 'Create Page' }}
                    </h1>
                </div>
                <button
                    @click="router.visit('/admin/pages')"
                    class="inline-flex items-center gap-2 rounded-lg border px-3 py-2 text-sm transition-colors hover:bg-accent"
                >
                    <ArrowLeft class="h-4 w-4" /> Back
                </button>
            </div>

            <form @submit.prevent="submit" class="grid gap-6 lg:grid-cols-3">
                <!-- Main Content -->
                <div class="space-y-6 lg:col-span-2">
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
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="Page title"
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
                                >Slug
                                <span class="text-destructive">*</span></label
                            >
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-muted-foreground"
                                    >/</span
                                >
                                <input
                                    v-model="form.slug"
                                    type="text"
                                    class="flex-1 rounded-lg border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:ring-2 focus:ring-ring focus:outline-none"
                                    placeholder="page-slug"
                                />
                            </div>
                            <p
                                v-if="form.errors.slug"
                                class="mt-1 text-xs text-destructive"
                            >
                                {{ form.errors.slug }}
                            </p>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Content</label
                            >
                            <textarea
                                v-model="form.content"
                                rows="12"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="Page content..."
                            />
                            <p
                                v-if="form.errors.content"
                                class="mt-1 text-xs text-destructive"
                            >
                                {{ form.errors.content }}
                            </p>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Excerpt</label
                            >
                            <textarea
                                v-model="form.excerpt"
                                rows="3"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="Brief description..."
                            />
                        </div>
                    </div>

                    <!-- SEO Section -->
                    <div
                        class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                    >
                        <h3 class="font-semibold">SEO Settings</h3>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Meta Title</label
                            >
                            <input
                                v-model="form.meta_title"
                                type="text"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm ring-offset-background focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="SEO title"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Meta Description</label
                            >
                            <textarea
                                v-model="form.meta_description"
                                rows="2"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm ring-offset-background focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="SEO description"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >OG Image</label
                            >
                            <input
                                type="file"
                                accept="image/*"
                                @change="
                                    form.og_image =
                                        ($event.target as HTMLInputElement)
                                            .files?.[0] ?? null
                                "
                                class="w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-sm file:text-primary-foreground hover:file:bg-primary/90"
                            />
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <div
                        class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                    >
                        <h3 class="font-semibold">Publish</h3>
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
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Publish Date</label
                            >
                            <input
                                v-model="form.published_at"
                                type="date"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Sort Order</label
                            >
                            <input
                                v-model.number="form.sort_order"
                                type="number"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90 disabled:opacity-50"
                        >
                            <Save class="h-4 w-4" />
                            {{
                                form.processing
                                    ? 'Saving...'
                                    : isEdit
                                      ? 'Update Page'
                                      : 'Create Page'
                            }}
                        </button>
                    </div>

                    <div
                        class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                    >
                        <h3 class="font-semibold">Featured Image</h3>
                        <img
                            v-if="isEdit && page!.featured_image"
                            :src="`/storage/${page!.featured_image}`"
                            class="w-full rounded-lg object-cover"
                        />
                        <input
                            type="file"
                            accept="image/*"
                            @change="
                                form.featured_image =
                                    ($event.target as HTMLInputElement)
                                        .files?.[0] ?? null
                            "
                            class="w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-sm file:text-primary-foreground hover:file:bg-primary/90"
                        />
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
