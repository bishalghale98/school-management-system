<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Search,
    Calendar,
    ChevronRight,
    Share2,
    Facebook,
    Twitter,
    Linkedin,
} from 'lucide-vue-next';
import { ref, watch } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { Post, PostCategory, PaginatedData } from '@/types';

const props = defineProps<{
    posts: PaginatedData<Post>;
    categories: PostCategory[];
    filters: { search?: string; category?: string };
}>();

console.log(props.posts);

const search = ref(props.filters.search ?? '');

let debounceTimer: ReturnType<typeof setTimeout>;

function applyFilters() {
    const params: Record<string, string> = {};
    if (search.value) params.search = search.value;
    router.get('/news-update', params, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
    });
}

watch(search, () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(applyFilters, 400);
});

function formatDate(date: string) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
}
</script>

<template>
    <Head title="Notices & Updates" />
    <PublicLayout>
        <div class="bg-[#1a2b4c] py-12 text-white">
            <div class="container mx-auto max-w-7xl px-4">
                <h1
                    class="text-3xl font-bold tracking-wider uppercase md:text-4xl"
                >
                    Notices & Updates
                </h1>
            </div>
        </div>

            <div class="container mx-auto max-w-7xl px-4 py-10">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
                    <div class="lg:col-span-8">
                        <div class="relative mb-10">
                            <div
                                class="flex overflow-hidden rounded border border-gray-300 shadow-sm focus-within:ring-2 focus-within:ring-blue-500/20"
                            >
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Search..."
                                    class="w-full border-none px-4 py-3 text-sm focus:ring-0 focus:outline-none"
                                />
                                <button
                                    class="border-l bg-gray-50 px-5 text-gray-500 transition-colors hover:bg-gray-100"
                                >
                                    <Search class="h-4 w-4" />
                                </button>
                            </div>
                        </div>

                        <div v-if="posts.data.length" class="space-y-8">
                            <article
                                v-for="post in posts.data"
                                :key="post.id"
                                class="group overflow-hidden rounded-lg border border-gray-100 bg-white shadow-sm transition-all hover:shadow-md"
                            >
                                <div class="p-6">
                                    <h3
                                        class="mb-3 text-xl font-bold text-[#1a2b4c] uppercase group-hover:text-blue-600"
                                    >
                                        <Link
                                            :href="`/news-update/${post.slug}`"
                                            >{{ post.title }}</Link
                                        >
                                    </h3>

                                    <p
                                        class="mb-4 text-sm leading-relaxed text-gray-600"
                                    >
                                        {{
                                            post.excerpt ||
                                            'Successful publication of news from Everest Secondary School...'
                                        }}
                                    </p>

                                    <Link
                                        :href="`/news-update/${post.slug}`"
                                        class="inline-flex items-center text-xs font-bold tracking-wider text-blue-600 uppercase hover:text-blue-800"
                                    >
                                        Read More
                                        <ChevronRight class="ml-1 h-3 w-3" />
                                    </Link>
                                </div>

                                <div
                                    class="flex items-center gap-4 border-t border-gray-50 bg-gray-50/50 px-6 py-3 text-xs text-gray-400"
                                >
                                    <span class="flex items-center gap-1.5">
                                        <Calendar class="h-3 w-3" />
                                        {{
                                            formatDate(
                                                post.published_at ||
                                                    post.created_at,
                                            )
                                        }}
                                    </span>
                                    <span>No Comments</span>
                                </div>
                            </article>
                        </div>

                        <div v-else class="py-20 text-center text-gray-500">
                            No updates found.
                        </div>

                        <nav
                            v-if="posts.last_page > 1"
                            class="mt-12 flex items-center gap-2"
                        >
                            <Link
                                v-for="link in posts.links"
                                :key="link.label"
                                :href="link.url ?? '#'"
                                class="flex h-10 w-10 items-center justify-center rounded border text-sm font-medium transition-colors"
                                :class="[
                                    link.active
                                        ? 'border-blue-600 bg-blue-600 text-white'
                                        : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50',
                                ]"
                                preserve-scroll
                            >
                                <span v-html="link.label" />
                            </Link>
                        </nav>
                    </div>

                    <aside class="lg:col-span-4">
                        <div class="sticky top-10 space-y-10">
                            <div class="flex gap-2">
                                <button
                                    class="flex h-10 w-10 items-center justify-center bg-[#3b5998] text-white hover:opacity-90"
                                >
                                    <Facebook class="h-4 w-4" />
                                </button>
                                <button
                                    class="flex h-10 w-10 items-center justify-center bg-[#1da1f2] text-white hover:opacity-90"
                                >
                                    <Twitter class="h-4 w-4" />
                                </button>
                                <button
                                    class="flex h-10 w-10 items-center justify-center bg-[#0077b5] text-white hover:opacity-90"
                                >
                                    <Linkedin class="h-4 w-4" />
                                </button>
                                <button
                                    class="flex h-10 w-10 items-center justify-center bg-[#25d366] text-white hover:opacity-90"
                                >
                                    <Share2 class="h-4 w-4" />
                                </button>
                            </div>

                            <div>
                                <h2
                                    class="mb-6 border-b pb-2 text-lg font-bold text-[#1a2b4c]"
                                >
                                    Most Popular:
                                </h2>
                                <div class="space-y-6">
                                    <div
                                        v-for="post in posts.data.slice(0, 5)"
                                        :key="'pop-' + post.id"
                                        class="group"
                                    >
                                        <h4
                                            class="text-sm leading-tight font-bold text-[#1a2b4c] uppercase group-hover:text-blue-600"
                                        >
                                            <Link
                                                :href="`/news-update/${post.slug}`"
                                                >{{ post.title }}</Link
                                            >
                                        </h4>
                                        <Link
                                            :href="`/news-update/${post.slug}`"
                                            class="mt-1 inline-flex items-center text-[10px] font-bold text-blue-600 uppercase"
                                        >
                                            Read More »
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
    </PublicLayout>
</template>

