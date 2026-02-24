<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { Save, ArrowLeft } from 'lucide-vue-next';

import AdminLayout from '@/layouts/AdminLayout.vue';
import type { Download, DownloadCategory } from '@/types';

const props = defineProps<{
    download?: Download;
    categories: DownloadCategory[];
}>();
const isEdit = !!props.download;

const form = useForm({
    title: props.download?.title ?? '',
    description: props.download?.description ?? '',
    category_id: props.download?.category_id ?? '',
    type: props.download?.type ?? 'file',
    file: null as File | null,
    external_url: props.download?.external_url ?? '',
    is_featured: props.download?.is_featured ?? false,
    status: props.download?.status ?? 'draft',
    published_at: props.download?.published_at?.substring(0, 10) ?? '',
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Downloads', href: '/admin/downloads' },
    { title: isEdit ? 'Edit' : 'Create' },
];

function submit() {
    if (isEdit) {
        form.post(`/admin/downloads/${props.download!.id}`, {
            forceFormData: true,
            headers: { 'X-HTTP-Method-Override': 'PUT' },
        });
    } else {
        form.post('/admin/downloads', { forceFormData: true });
    }
}
</script>

<template>
    <Head :title="isEdit ? 'Edit Download' : 'Create Download'" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-tight">
                    {{ isEdit ? 'Edit Download' : 'Create Download' }}
                </h1>
                <button
                    @click="router.visit('/admin/downloads')"
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
                                >Category
                                <span class="text-destructive">*</span></label
                            >
                            <select
                                v-model="form.category_id"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            >
                                <option value="" disabled>Select</option>
                                <option
                                    v-for="cat in categories"
                                    :key="cat.id"
                                    :value="cat.id"
                                >
                                    {{ cat.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium"
                                >Type
                                <span class="text-destructive">*</span></label
                            >
                            <select
                                v-model="form.type"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            >
                                <option value="file">File Upload</option>
                                <option value="link">External Link</option>
                            </select>
                        </div>
                    </div>
                    <div v-if="form.type === 'file'">
                        <label class="mb-1.5 block text-sm font-medium"
                            >File</label
                        >
                        <input
                            type="file"
                            @change="
                                form.file =
                                    ($event.target as HTMLInputElement)
                                        .files?.[0] ?? null
                            "
                            class="w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-sm file:text-primary-foreground"
                        />
                    </div>
                    <div v-else>
                        <label class="mb-1.5 block text-sm font-medium"
                            >External URL</label
                        >
                        <input
                            v-model="form.external_url"
                            type="url"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                            placeholder="https://"
                        />
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
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
                    </div>
                    <label class="flex items-center gap-2 text-sm"
                        ><input
                            v-model="form.is_featured"
                            type="checkbox"
                            class="h-4 w-4 rounded border-input"
                        />
                        Featured download</label
                    >
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
                                  ? 'Update'
                                  : 'Create'
                        }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
