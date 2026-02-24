<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';

import { Search, Clock, FileText, ChevronRight, Tag } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

import type { Post, PostCategory, PaginatedData } from '@/types';

const props = defineProps<{
    posts: PaginatedData<Post>;
    categories: PostCategory[];
    filters: { search?: string; category?: string };
}>();

const search = ref(props.filters.search ?? '');
const selectedCategory = ref(props.filters.category ?? '');

let debounceTimer: ReturnType<typeof setTimeout>;

function applyFilters() {
    const params: Record<string, string> = {};
    if (search.value) params.search = search.value;
    if (selectedCategory.value) params.category = selectedCategory.value;
    router.get('/news-update', params, { preserveState: true, replace: true });
}

watch(search, () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(applyFilters, 400);
});

watch(selectedCategory, applyFilters);

function formatDate(date: string) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
}
</script>

<template>
    <Head title="News & Updates" />
    <PublicLayout>
        <!-- Page Header -->
        <section
            class="bg-gradient-to-br from-blue-900 to-indigo-900 py-16 text-white"
        >
            <div class="mx-auto max-w-7xl px-4">
                <h1 class="text-3xl font-bold sm:text-4xl">News & Updates</h1>
                <p class="mt-2 text-blue-200">
                    Stay up to date with school announcements
                </p>
            </div>
        </section>

        <div class="mx-auto max-w-7xl px-4 py-10">
            <div class="lg:flex lg:gap-8">
                <!-- Main Content -->
                <div class="flex-1">
                    <!-- Search -->
                    <div class="relative mb-6">
                        <Search
                            class="absolute top-1/2 left-3 h-5 w-5 -translate-y-1/2 text-gray-400"
                        />
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Search news..."
                            class="w-full rounded-lg border border-gray-200 bg-white py-3 pr-4 pl-10 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                        />
                    </div>

                    <!-- Empty State -->
                    <div
                        v-if="!posts.data.length"
                        class="rounded-xl bg-gray-50 py-16 text-center"
                    >
                        <FileText
                            class="mx-auto mb-4 h-12 w-12 text-gray-300"
                        />
                        <h3 class="text-lg font-semibold text-gray-600">
                            No posts found
                        </h3>
                        <p class="mt-1 text-sm text-gray-400">
                            Try adjusting your search or filter.
                        </p>
                    </div>

                    <!-- Posts Grid -->
                    <div v-else class="space-y-6">
                        <Link
                            v-for="post in posts.data"
                            :key="post.id"
                            :href="`/news-update/${post.slug}`"
                            class="group flex flex-col gap-4 overflow-hidden rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-100 transition hover:shadow-md sm:flex-row"
                        >
                            <div
                                class="aspect-[16/9] w-full shrink-0 overflow-hidden rounded-lg bg-gray-100 sm:aspect-square sm:w-40"
                            >
                                <img
                                    v-if="post.featured_image"
                                    :src="`/storage/${post.featured_image}`"
                                    :alt="post.title"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                />
                                <div
                                    v-else
                                    class="flex h-full items-center justify-center text-gray-300"
                                >
                                    <FileText class="h-8 w-8" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <div
                                    class="mb-2 flex flex-wrap items-center gap-2"
                                >
                                    <span
                                        v-if="post.category"
                                        class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-700"
                                    >
                                        {{ post.category.name }}
                                    </span>
                                    <span
                                        v-if="post.is_pinned"
                                        class="rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-700"
                                    >
                                        Pinned
                                    </span>
                                </div>
                                <h2
                                    class="mb-1 text-lg font-semibold text-gray-900 group-hover:text-blue-600"
                                >
                                    {{ post.title }}
                                </h2>
                                <p
                                    v-if="post.excerpt"
                                    class="mb-3 line-clamp-2 text-sm text-gray-500"
                                >
                                    {{ post.excerpt }}
                                </p>
                                <div
                                    class="flex items-center gap-3 text-xs text-gray-400"
                                >
                                    <span class="flex items-center gap-1">
                                        <Clock class="h-3.5 w-3.5" />
                                        {{
                                            formatDate(
                                                post.published_at ??
                                                    post.created_at,
                                            )
                                        }}
                                    </span>
                                </div>
                            </div>
                            <div class="hidden items-center sm:flex">
                                <ChevronRight
                                    class="h-5 w-5 text-gray-300 transition group-hover:text-blue-500"
                                />
                            </div>
                        </Link>
                    </div>

                    <!-- Pagination -->
                    <nav
                        v-if="posts.last_page > 1"
                        class="mt-8 flex items-center justify-center gap-1"
                    >
                        <Link
                            v-for="link in posts.links"
                            :key="link.label"
                            :href="link.url ?? '#'"
                            :class="[
                                'rounded-lg px-3 py-2 text-sm font-medium transition',
                                link.active
                                    ? 'bg-blue-600 text-white'
                                    : link.url
                                      ? 'text-gray-600 hover:bg-gray-100'
                                      : 'cursor-default text-gray-300',
                            ]"
                            v-html="link.label"
                            preserve-scroll
                        />
                    </nav>
                </div>

                <!-- Sidebar -->
                <aside class="mt-8 w-full shrink-0 lg:mt-0 lg:w-64">
                    <div class="sticky top-24 space-y-6">
                        <!-- Categories -->
                        <div
                            class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100"
                        >
                            <h3
                                class="mb-3 flex items-center gap-2 text-sm font-semibold text-gray-900"
                            >
                                <Tag class="h-4 w-4" />
                                Categories
                            </h3>
                            <ul class="space-y-1">
                                <li>
                                    <button
                                        @click="selectedCategory = ''"
                                        :class="[
                                            'flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm transition',
                                            !selectedCategory
                                                ? 'bg-blue-50 font-medium text-blue-700'
                                                : 'text-gray-600 hover:bg-gray-50',
                                        ]"
                                    >
                                        All
                                    </button>
                                </li>
                                <li v-for="cat in categories" :key="cat.id">
                                    <button
                                        @click="
                                            selectedCategory = String(cat.id)
                                        "
                                        :class="[
                                            'flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm transition',
                                            selectedCategory === String(cat.id)
                                                ? 'bg-blue-50 font-medium text-blue-700'
                                                : 'text-gray-600 hover:bg-gray-50',
                                        ]"
                                    >
                                        {{ cat.name }}
                                        <span class="text-xs text-gray-400">{{
                                            cat.posts_count ?? 0
                                        }}</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </PublicLayout>
</template>
