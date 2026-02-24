<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Plus,
    Pencil,
    Trash2,
    Eye,
    EyeOff,
    Pin,
    Search,
} from 'lucide-vue-next';
import { ref, watch } from 'vue';
import Pagination from '@/components/admin/Pagination.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { Post, PostCategory, PaginatedData } from '@/types';

const props = defineProps<{
    posts: PaginatedData<Post>;
    categories: PostCategory[];
    filters: { search?: string; category?: string; status?: string };
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Posts' },
];

const search = ref(props.filters.search ?? '');
const category = ref(props.filters.category ?? '');
const status = ref(props.filters.status ?? '');

let debounce: ReturnType<typeof setTimeout>;

function applyFilters() {
    clearTimeout(debounce);
    debounce = setTimeout(() => {
        router.get(
            '/admin/posts',
            {
                search: search.value || undefined,
                category: category.value || undefined,
                status: status.value || undefined,
            },
            { preserveState: true, replace: true },
        );
    }, 300);
}

watch([search, category, status], applyFilters);

function deletePost(post: Post) {
    if (confirm(`Delete "${post.title}"?`)) {
        router.delete(`/admin/posts/${post.id}`);
    }
}

function formatDate(d: string) {
    return new Date(d).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });
}
</script>

<template>
    <Head title="Manage Posts" />
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Posts</h1>
                    <p class="text-sm text-muted-foreground">
                        Manage news, notices, and updates
                    </p>
                </div>
                <Link
                    href="/admin/posts/create"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90"
                >
                    <Plus class="h-4 w-4" /> New Post
                </Link>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap gap-3">
                <div class="relative min-w-48 flex-1">
                    <Search
                        class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                    />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search posts..."
                        class="w-full rounded-lg border border-input bg-background py-2 pr-3 pl-9 text-sm focus:ring-2 focus:ring-ring focus:outline-none"
                    />
                </div>
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
                                    Category
                                </th>
                                <th
                                    class="px-4 py-3 text-center font-medium text-muted-foreground"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-4 py-3 text-left font-medium text-muted-foreground"
                                >
                                    Date
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
                                v-for="post in posts.data"
                                :key="post.id"
                                class="transition-colors hover:bg-accent/30"
                            >
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <Pin
                                            v-if="post.is_pinned"
                                            class="h-3.5 w-3.5 text-amber-500"
                                        />
                                        <span class="font-medium">{{
                                            post.title
                                        }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ post.category?.name }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        :class="[
                                            'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium',
                                            post.status === 'published'
                                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300'
                                                : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                                        ]"
                                    >
                                        <Eye
                                            v-if="post.status === 'published'"
                                            class="h-3 w-3"
                                        />
                                        <EyeOff v-else class="h-3 w-3" />
                                        {{ post.status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ formatDate(post.created_at) }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div
                                        class="flex items-center justify-end gap-1"
                                    >
                                        <Link
                                            :href="`/admin/posts/${post.id}/edit`"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-muted-foreground hover:bg-accent hover:text-foreground"
                                        >
                                            <Pencil class="h-4 w-4" />
                                        </Link>
                                        <button
                                            @click="deletePost(post)"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-muted-foreground hover:bg-destructive/10 hover:text-destructive"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!posts.data.length">
                                <td
                                    colspan="5"
                                    class="px-4 py-12 text-center text-muted-foreground"
                                >
                                    No posts found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :data="posts" />
            </div>
        </div>
    </AdminLayout>
</template>
