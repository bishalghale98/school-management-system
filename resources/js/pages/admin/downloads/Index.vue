<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Plus,
    Pencil,
    Trash2,
    Star,
    ExternalLink,
    FileDown,
} from 'lucide-vue-next';
import { ref, watch } from 'vue';

import Pagination from '@/components/admin/Pagination.vue';

import AdminLayout from '@/layouts/AdminLayout.vue';
import type { Download, DownloadCategory, PaginatedData } from '@/types';

const props = defineProps<{
    downloads: PaginatedData<Download>;
    categories: DownloadCategory[];
    filters: { category?: string; status?: string };
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Downloads' },
];
const category = ref(props.filters.category ?? '');
const status = ref(props.filters.status ?? '');

watch([category, status], () => {
    router.get(
        '/admin/downloads',
        {
            category: category.value || undefined,
            status: status.value || undefined,
        },
        { preserveState: true, replace: true },
    );
});

function deleteDownload(dl: Download) {
    if (confirm(`Delete "${dl.title}"?`))
        router.delete(`/admin/downloads/${dl.id}`);
}
</script>

<template>
    <Head title="Manage Downloads" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Downloads</h1>
                    <p class="text-sm text-muted-foreground">
                        Manage downloadable files and links
                    </p>
                </div>
                <Link
                    href="/admin/downloads/create"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90"
                >
                    <Plus class="h-4 w-4" /> Add Download
                </Link>
            </div>
            <div class="flex gap-3">
                <select
                    v-model="category"
                    class="rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                >
                    <option value="">All Categories</option>
                    <option
                        v-for="cat in categories"
                        :key="cat.id"
                        :value="cat.id"
                    >
                        {{ cat.name }}
                    </option>
                </select>
                <select
                    v-model="status"
                    class="rounded-lg border border-input bg-background px-3 py-2 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                >
                    <option value="">All Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
            <div
                class="rounded-xl border border-sidebar-border/70 bg-card shadow-sm dark:border-sidebar-border"
            >
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-muted/30">
                                <th
                                    class="px-4 py-3 text-left font-medium text-muted-foreground"
                                >
                                    Title
                                </th>
                                <th
                                    class="px-4 py-3 text-left font-medium text-muted-foreground"
                                >
                                    Category
                                </th>
                                <th
                                    class="px-4 py-3 text-center font-medium text-muted-foreground"
                                >
                                    Type
                                </th>
                                <th
                                    class="px-4 py-3 text-center font-medium text-muted-foreground"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-4 py-3 text-right font-medium text-muted-foreground"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr
                                v-for="dl in downloads.data"
                                :key="dl.id"
                                class="hover:bg-accent/30"
                            >
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <Star
                                            v-if="dl.is_featured"
                                            class="h-3.5 w-3.5 text-amber-500"
                                        />
                                        <span class="font-medium">{{
                                            dl.title
                                        }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ dl.category?.name }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        class="inline-flex items-center gap-1 text-xs"
                                    >
                                        <FileDown
                                            v-if="dl.type === 'file'"
                                            class="h-3 w-3"
                                        />
                                        <ExternalLink v-else class="h-3 w-3" />
                                        {{ dl.type }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        :class="[
                                            'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium',
                                            dl.status === 'published'
                                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300'
                                                : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                                        ]"
                                    >
                                        {{ dl.status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div
                                        class="flex items-center justify-end gap-1"
                                    >
                                        <Link
                                            :href="`/admin/downloads/${dl.id}/edit`"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-muted-foreground hover:bg-accent hover:text-foreground"
                                            ><Pencil class="h-4 w-4"
                                        /></Link>
                                        <button
                                            @click="deleteDownload(dl)"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!downloads.data.length">
                                <td
                                    colspan="5"
                                    class="px-4 py-12 text-center text-muted-foreground"
                                >
                                    No downloads found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :data="downloads" />
            </div>
        </div>
    </AdminLayout>
</template>
