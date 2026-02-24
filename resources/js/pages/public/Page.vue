<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Clock, Download, FileText, ChevronRight } from 'lucide-vue-next';
import type { Page, Post, Download as DownloadType } from '@/types';

const props = defineProps<{
    page: Page;
    latestPosts: Post[];
    featuredDownloads: DownloadType[];
    meta: {
        title: string;
        description: string | null;
        og_image: string | null;
    };
}>();

function formatDate(date: string) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
}
</script>

<template>
    <Head :title="meta.title">
        <meta
            v-if="meta.description"
            name="description"
            :content="meta.description"
        />
        <meta
            v-if="meta.og_image"
            property="og:image"
            :content="`/storage/${meta.og_image}`"
        />
    </Head>
    <PublicLayout>
        <!-- Header -->
        <section
            class="bg-gradient-to-br from-blue-900 to-indigo-900 py-16 text-white"
        >
            <div class="mx-auto max-w-7xl px-4">
                <h1 class="text-3xl font-bold sm:text-4xl">{{ page.title }}</h1>
            </div>
        </section>

        <div class="mx-auto max-w-7xl px-4 py-10">
            <div class="lg:flex lg:gap-10">
                <!-- Main Content -->
                <article class="min-w-0 flex-1">
                    <!-- Featured Image -->
                    <div
                        v-if="page.featured_image"
                        class="-mt-10 mb-8 overflow-hidden rounded-xl shadow-lg"
                    >
                        <img
                            :src="`/storage/${page.featured_image}`"
                            :alt="page.title"
                            class="w-full object-cover"
                        />
                    </div>

                    <div
                        class="prose prose-lg prose-headings:text-gray-900 prose-p:text-gray-600 prose-a:text-blue-600 prose-img:rounded-lg max-w-none"
                        v-html="page.content"
                    />
                </article>

                <!-- Sidebar -->
                <aside class="mt-8 w-full shrink-0 lg:mt-0 lg:w-72">
                    <div class="sticky top-24 space-y-6">
                        <!-- Latest Posts -->
                        <div
                            v-if="latestPosts.length"
                            class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100"
                        >
                            <h3
                                class="mb-4 text-sm font-semibold text-gray-900"
                            >
                                Latest News
                            </h3>
                            <div class="space-y-3">
                                <Link
                                    v-for="post in latestPosts"
                                    :key="post.id"
                                    :href="`/news-update/${post.slug}`"
                                    class="group block"
                                >
                                    <h4
                                        class="line-clamp-2 text-sm font-medium text-gray-700 group-hover:text-blue-600"
                                    >
                                        {{ post.title }}
                                    </h4>
                                    <p
                                        class="mt-0.5 flex items-center gap-1 text-xs text-gray-400"
                                    >
                                        <Clock class="h-3 w-3" />
                                        {{
                                            formatDate(
                                                post.published_at ??
                                                    post.created_at,
                                            )
                                        }}
                                    </p>
                                </Link>
                            </div>
                        </div>

                        <!-- Featured Downloads -->
                        <div
                            v-if="featuredDownloads.length"
                            class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100"
                        >
                            <h3
                                class="mb-4 text-sm font-semibold text-gray-900"
                            >
                                Downloads
                            </h3>
                            <div class="space-y-2">
                                <a
                                    v-for="dl in featuredDownloads"
                                    :key="dl.id"
                                    :href="
                                        dl.type === 'file' && dl.file_path
                                            ? `/storage/${dl.file_path}`
                                            : (dl.external_url ?? '#')
                                    "
                                    target="_blank"
                                    class="flex items-center gap-2 rounded-lg p-2 text-sm text-gray-600 transition hover:bg-gray-50 hover:text-blue-600"
                                >
                                    <Download
                                        class="h-4 w-4 shrink-0 text-gray-400"
                                    />
                                    <span class="truncate">{{ dl.title }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </PublicLayout>
</template>
