<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2, Eye, EyeOff } from 'lucide-vue-next';
import Pagination from '@/components/admin/Pagination.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { Page, PaginatedData } from '@/types';

defineProps<{
    pages: PaginatedData<Page>;
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Pages' },
];

function deletePage(page: Page) {
    if (confirm(`Delete "${page.title}"?`)) {
        router.delete(`/admin/pages/${page.id}`);
    }
}
</script>

<template>
    <Head title="Manage Pages" />

    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Pages</h1>
                    <p class="text-sm text-muted-foreground">
                        Manage static pages for your website
                    </p>
                </div>
                <Link
                    href="/admin/pages/create"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90"
                >
                    <Plus class="h-4 w-4" />
                    Add Page
                </Link>
            </div>

            <!-- Table -->
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
                                    Slug
                                </th>
                                <th
                                    class="px-4 py-3 text-center font-medium text-muted-foreground"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-4 py-3 text-center font-medium text-muted-foreground"
                                >
                                    Order
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
                                v-for="page in pages.data"
                                :key="page.id"
                                class="transition-colors hover:bg-accent/30"
                            >
                                <td class="px-4 py-3 font-medium">
                                    {{ page.title }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    /{{ page.slug }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        :class="[
                                            'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium',
                                            page.status === 'published'
                                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300'
                                                : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                                        ]"
                                    >
                                        <Eye
                                            v-if="page.status === 'published'"
                                            class="h-3 w-3"
                                        />
                                        <EyeOff v-else class="h-3 w-3" />
                                        {{ page.status }}
                                    </span>
                                </td>
                                <td
                                    class="px-4 py-3 text-center text-muted-foreground"
                                >
                                    {{ page.sort_order }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div
                                        class="flex items-center justify-end gap-1"
                                    >
                                        <Link
                                            :href="`/admin/pages/${page.id}/edit`"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-muted-foreground transition-colors hover:bg-accent hover:text-foreground"
                                        >
                                            <Pencil class="h-4 w-4" />
                                        </Link>
                                        <button
                                            @click="deletePage(page)"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-muted-foreground transition-colors hover:bg-destructive/10 hover:text-destructive"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!pages.data.length">
                                <td
                                    colspan="5"
                                    class="px-4 py-12 text-center text-muted-foreground"
                                >
                                    No pages found. Create your first page to
                                    get started.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :data="pages" />
            </div>
        </div>
    </AdminLayout>
</template>
