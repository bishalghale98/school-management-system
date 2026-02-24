<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Calendar,
    Tag,
    Download,
    FileText,
    Paperclip,
} from 'lucide-vue-next';
import type { Post } from '@/types';

const props = defineProps<{
    post: Post;
    meta: {
        title: string;
        description: string | null;
        og_image: string | null;
    };
}>();

function formatDate(date: string) {
    return new Date(date).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
}

function formatFileSize(bytes: number | null): string {
    if (!bytes) return '';
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
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
            <div class="mx-auto max-w-4xl px-4">
                <Link
                    href="/news-update"
                    class="mb-4 inline-flex items-center gap-1 text-sm text-blue-300 transition hover:text-white"
                >
                    <ArrowLeft class="h-4 w-4" />
                    Back to News
                </Link>
                <div class="mb-3 flex flex-wrap items-center gap-2">
                    <span
                        v-if="post.category"
                        class="rounded-full bg-blue-700/50 px-3 py-1 text-xs font-medium text-blue-200"
                    >
                        {{ post.category.name }}
                    </span>
                </div>
                <h1 class="text-3xl leading-tight font-bold sm:text-4xl">
                    {{ post.title }}
                </h1>
                <p class="mt-3 flex items-center gap-2 text-sm text-blue-300">
                    <Calendar class="h-4 w-4" />
                    {{ formatDate(post.published_at ?? post.created_at) }}
                </p>
            </div>
        </section>

        <article class="mx-auto max-w-4xl px-4 py-10">
            <!-- Featured Image -->
            <div
                v-if="post.featured_image"
                class="-mt-10 mb-8 overflow-hidden rounded-xl shadow-lg"
            >
                <img
                    :src="`/storage/${post.featured_image}`"
                    :alt="post.title"
                    class="w-full object-cover"
                />
            </div>

            <!-- Content -->
            <div
                class="prose prose-lg prose-headings:text-gray-900 prose-p:text-gray-600 prose-a:text-blue-600 prose-img:rounded-lg max-w-none"
                v-html="post.content"
            />

            <!-- Attachments -->
            <div
                v-if="post.attachments?.length"
                class="mt-10 rounded-xl border border-gray-200 bg-gray-50 p-6"
            >
                <h3
                    class="mb-4 flex items-center gap-2 text-lg font-semibold text-gray-900"
                >
                    <Paperclip class="h-5 w-5" />
                    Attachments
                </h3>
                <div class="space-y-2">
                    <a
                        v-for="attachment in post.attachments"
                        :key="attachment.id"
                        :href="`/storage/${attachment.file_path}`"
                        target="_blank"
                        class="flex items-center gap-3 rounded-lg bg-white p-3 shadow-sm ring-1 ring-gray-100 transition hover:shadow-md"
                    >
                        <div class="rounded-lg bg-blue-100 p-2 text-blue-600">
                            <FileText class="h-5 w-5" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <p
                                class="truncate text-sm font-medium text-gray-900"
                            >
                                {{ attachment.file_name }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ attachment.file_type }}
                                {{ formatFileSize(attachment.file_size) }}
                            </p>
                        </div>
                        <Download class="h-4 w-4 shrink-0 text-gray-400" />
                    </a>
                </div>
            </div>

            <!-- Bottom Nav -->
            <div class="mt-10 border-t pt-6">
                <Link
                    href="/news-update"
                    class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200"
                >
                    <ArrowLeft class="h-4 w-4" />
                    All News & Updates
                </Link>
            </div>
        </article>
    </PublicLayout>
</template>
