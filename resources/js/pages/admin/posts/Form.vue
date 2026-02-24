<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { Save, ArrowLeft, Trash2, Paperclip } from 'lucide-vue-next';
import RichTextEditor from '@/components/admin/RichTextEditor.vue';

import AdminLayout from '@/layouts/AdminLayout.vue';
import type { Post, PostCategory } from '@/types';

const props = defineProps<{
    post?: Post;
    categories: PostCategory[];
}>();

const isEdit = !!props.post;

const form = useForm({
    title: props.post?.title ?? '',
    slug: props.post?.slug ?? '',
    category_id: props.post?.category_id ?? '',
    content: props.post?.content ?? '',
    excerpt: props.post?.excerpt ?? '',
    featured_image: null as File | null,
    is_pinned: props.post?.is_pinned ?? false,
    meta_title: props.post?.meta_title ?? '',
    meta_description: props.post?.meta_description ?? '',
    og_image: null as File | null,
    status: props.post?.status ?? 'draft',
    published_at: props.post?.published_at?.substring(0, 10) ?? '',
    attachments: [] as File[],
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Posts', href: '/admin/posts' },
    { title: isEdit ? 'Edit Post' : 'Create Post' },
];

function generateSlug() {
    form.slug = form.title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
}

function submit() {
    if (isEdit) {
        form.post(`/admin/posts/${props.post!.id}`, {
            forceFormData: true,
            headers: { 'X-HTTP-Method-Override': 'PUT' },
        });
    } else {
        form.post('/admin/posts', { forceFormData: true });
    }
}

function deleteAttachment(id: number) {
    if (confirm('Delete this attachment?')) {
        router.delete(`/admin/posts/${props.post!.id}/attachments/${id}`);
    }
}

function handleFiles(e: Event) {
    const files = (e.target as HTMLInputElement).files;
    if (files) form.attachments = Array.from(files);
}
</script>

<template>
    <Head :title="isEdit ? `Edit: ${post!.title}` : 'Create Post'" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-tight">
                    {{ isEdit ? 'Edit Post' : 'Create Post' }}
                </h1>
                <button
                    @click="router.visit('/admin/posts')"
                    class="inline-flex items-center gap-2 rounded-lg border px-3 py-2 text-sm hover:bg-accent"
                >
                    <ArrowLeft class="h-4 w-4" /> Back
                </button>
            </div>

            <form @submit.prevent="submit" class="grid gap-6 lg:grid-cols-3">
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
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="Post title"
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
                            <input
                                v-model="form.slug"
                                type="text"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
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
                            <RichTextEditor
                                v-model="form.content"
                                placeholder="Write your post..."
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Excerpt</label
                            >
                            <textarea
                                v-model="form.excerpt"
                                rows="3"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                                placeholder="Brief summary..."
                            />
                        </div>
                    </div>

                    <!-- Attachments -->
                    <div
                        class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                    >
                        <h3 class="flex items-center gap-2 font-semibold">
                            <Paperclip class="h-4 w-4" /> Attachments
                        </h3>
                        <div
                            v-if="isEdit && post!.attachments?.length"
                            class="space-y-2"
                        >
                            <div
                                v-for="att in post!.attachments"
                                :key="att.id"
                                class="flex items-center justify-between rounded-lg bg-muted/50 px-3 py-2 text-sm"
                            >
                                <span>{{ att.file_name }}</span>
                                <button
                                    type="button"
                                    @click="deleteAttachment(att.id)"
                                    class="text-destructive hover:text-destructive/80"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                        <input
                            type="file"
                            multiple
                            @change="handleFiles"
                            class="w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-sm file:text-primary-foreground hover:file:bg-primary/90"
                        />
                    </div>

                    <!-- SEO -->
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
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Meta Description</label
                            >
                            <textarea
                                v-model="form.meta_description"
                                rows="2"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
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
                                >Category
                                <span class="text-destructive">*</span></label
                            >
                            <select
                                v-model="form.category_id"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            >
                                <option value="" disabled>
                                    Select category
                                </option>
                                <option
                                    v-for="cat in categories"
                                    :key="cat.id"
                                    :value="cat.id"
                                >
                                    {{ cat.name }}
                                </option>
                            </select>
                            <p
                                v-if="form.errors.category_id"
                                class="mt-1 text-xs text-destructive"
                            >
                                {{ form.errors.category_id }}
                            </p>
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
                        <label class="flex items-center gap-2 text-sm">
                            <input
                                v-model="form.is_pinned"
                                type="checkbox"
                                class="h-4 w-4 rounded border-input"
                            />
                            Pin this post
                        </label>
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
                                      ? 'Update Post'
                                      : 'Create Post'
                            }}
                        </button>
                    </div>
                    <div
                        class="space-y-4 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
                    >
                        <h3 class="font-semibold">Featured Image</h3>
                        <img
                            v-if="isEdit && post!.featured_image"
                            :src="`/storage/${post!.featured_image}`"
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
