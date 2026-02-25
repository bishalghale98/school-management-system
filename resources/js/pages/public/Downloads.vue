<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Download, ExternalLink, FileText, Filter } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type {
    Download as DownloadType,
    DownloadCategory,
    PaginatedData,
} from '@/types';

const props = defineProps<{
    downloads: PaginatedData<DownloadType>;
    categories: DownloadCategory[];
    filters: { category?: string };
}>();

const selectedCategory = ref(props.filters.category ?? '');

watch(selectedCategory, (val) => {
    const params: Record<string, string> = {};
    if (val) params.category = val;
    router.get('/downloads', params, { preserveState: true, replace: true });
});
</script>

<template>
    <Head title="Downloads" />
    <PublicLayout>
        <!-- Header -->
        <section
            class="bg-gradient-to-br from-green-900 to-emerald-900 py-16 text-white"
        >
            <div class="mx-auto max-w-7xl px-4">
                <h1 class="text-3xl font-bold sm:text-4xl">Downloads</h1>
                <p class="mt-2 text-green-200">
                    Important documents, forms, and resources
                </p>
            </div>
        </section>

        <div class="mx-auto max-w-7xl px-4 py-10">
            <!-- Category Filter -->
            <div class="mb-8 flex flex-wrap items-center gap-2">
                <Filter class="h-4 w-4 text-gray-400" />
                <button
                    @click="selectedCategory = ''"
                    :class="[
                        'rounded-full px-4 py-1.5 text-sm font-medium transition',
                        !selectedCategory
                            ? 'bg-green-600 text-white'
                            : 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                    ]"
                >
                    All
                </button>
                <button
                    v-for="cat in categories"
                    :key="cat.id"
                    @click="selectedCategory = String(cat.id)"
                    :class="[
                        'rounded-full px-4 py-1.5 text-sm font-medium transition',
                        selectedCategory === String(cat.id)
                            ? 'bg-green-600 text-white'
                            : 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                    ]"
                >
                    {{ cat.name }}
                    <span class="ml-1 text-xs opacity-70"
                        >({{ cat.downloads_count ?? 0 }})</span
                    >
                </button>
            </div>

            <!-- Empty State -->
            <div
                v-if="!downloads.data.length"
                class="rounded-xl bg-gray-50 py-16 text-center"
            >
                <FileText class="mx-auto mb-4 h-12 w-12 text-gray-300" />
                <h3 class="text-lg font-semibold text-gray-600">
                    No downloads available
                </h3>
                <p class="mt-1 text-sm text-gray-400">
                    Check back later for new resources.
                </p>
            </div>

            <!-- Downloads Grid -->
            <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="dl in downloads.data"
                    :key="dl.id"
                    class="flex items-start gap-4 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition hover:shadow-md"
                >
                    <div
                        class="shrink-0 rounded-lg bg-green-100 p-3 text-green-600"
                    >
                        <Download class="h-5 w-5" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-semibold text-gray-900">
                            {{ dl.title }}
                        </h3>
                        <p
                            v-if="dl.description"
                            class="mt-1 line-clamp-2 text-xs text-gray-500"
                        >
                            {{ dl.description }}
                        </p>
                        <div class="mt-3 flex items-center gap-3">
                            <span
                                v-if="dl.category"
                                class="rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-500"
                            >
                                {{ dl.category.name }}
                            </span>
                            <a
                                v-if="dl.type === 'file' && dl.file_path"
                                :href="`/storage/${dl.file_path}`"
                                target="_blank"
                                class="inline-flex items-center gap-1 rounded-lg bg-green-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-green-700"
                            >
                                <Download class="h-3 w-3" />
                                Download
                            </a>
                            <a
                                v-else-if="dl.external_url"
                                :href="dl.external_url"
                                target="_blank"
                                class="inline-flex items-center gap-1 rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-blue-700"
                            >
                                <ExternalLink class="h-3 w-3" />
                                Open Link
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <nav
                v-if="downloads.last_page > 1"
                class="mt-8 flex items-center justify-center gap-1"
            >
                <Link
                    v-for="link in downloads.links"
                    :key="link.label"
                    :href="link.url ?? '#'"
                    :class="[
                        'rounded-lg px-3 py-2 text-sm font-medium transition',
                        link.active
                            ? 'bg-green-600 text-white'
                            : link.url
                              ? 'text-gray-600 hover:bg-gray-100'
                              : 'cursor-default text-gray-300',
                    ]"
                    preserve-scroll
                >
                    <span v-html="link.label" />
                </Link>
            </nav>
        </div>
    </PublicLayout>
</template>
