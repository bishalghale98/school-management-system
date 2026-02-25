<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    Download as DownloadIcon,
    ExternalLink,
    FileText,
    BookOpen,
    ImageIcon,
    ChevronRight,
    Archive,
    Video,
    Music,
    File,
} from 'lucide-vue-next';
import { computed } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

import type { Download as DownloadType, PaginatedData } from '@/types';

const props = defineProps<{
    downloads: PaginatedData<DownloadType>;
}>();

const fileUrl = (path: string) => `/storage/${path}`;

// Get file extension and type
const getFileInfo = (dl: DownloadType) => {
    const extension = dl.file_path.split('.').pop()?.toLowerCase() || '';
    const mimeType = (dl as any).mime_type || '';

    return { extension, mimeType };
};

// Get appropriate icon based on file type
const getFileIcon = (dl: DownloadType) => {
    const { extension, mimeType } = getFileInfo(dl);
    const type = String(mimeType || dl.type || '').toLowerCase();

    // Image files
    if (
        type.includes('image') ||
        ['png', 'jpg', 'jpeg', 'webp', 'svg', 'gif'].includes(extension)
    ) {
        return ImageIcon;
    }

    // Document files
    if (type.includes('pdf') || extension === 'pdf') return FileText;
    if (type.includes('word') || ['doc', 'docx'].includes(extension))
        return FileText;
    if (type.includes('excel') || ['xls', 'xlsx', 'csv'].includes(extension))
        return FileText;
    if (type.includes('powerpoint') || ['ppt', 'pptx'].includes(extension))
        return FileText;

    // Archive files
    if (['zip', 'rar', '7z', 'tar', 'gz'].includes(extension)) return Archive;

    // Video files
    if (
        type.includes('video') ||
        ['mp4', 'avi', 'mov', 'wmv'].includes(extension)
    )
        return Video;

    // Audio files
    if (
        type.includes('audio') ||
        ['mp3', 'wav', 'ogg', 'm4a'].includes(extension)
    )
        return Music;

    // Books
    if (type.includes('book') || extension === 'epub') return BookOpen;

    return File;
};

// Get color accent based on file type
const getFileAccentColor = (dl: DownloadType) => {
    const { extension } = getFileInfo(dl);

    const colorMap: Record<string, string> = {
        pdf: 'bg-rose-50 text-rose-600 border-rose-200',
        doc: 'bg-blue-50 text-blue-600 border-blue-200',
        docx: 'bg-blue-50 text-blue-600 border-blue-200',
        xls: 'bg-emerald-50 text-emerald-600 border-emerald-200',
        xlsx: 'bg-emerald-50 text-emerald-600 border-emerald-200',
        ppt: 'bg-orange-50 text-orange-600 border-orange-200',
        pptx: 'bg-orange-50 text-orange-600 border-orange-200',
        jpg: 'bg-purple-50 text-purple-600 border-purple-200',
        jpeg: 'bg-purple-50 text-purple-600 border-purple-200',
        png: 'bg-purple-50 text-purple-600 border-purple-200',
        gif: 'bg-pink-50 text-pink-600 border-pink-200',
        zip: 'bg-amber-50 text-amber-600 border-amber-200',
        mp4: 'bg-indigo-50 text-indigo-600 border-indigo-200',
        mp3: 'bg-cyan-50 text-cyan-600 border-cyan-200',
    };

    return colorMap[extension] || 'bg-slate-50 text-slate-600 border-slate-200';
};

// Format file size
const formatFileSize = (bytes?: number) => {
    if (!bytes) return null;

    const units = ['B', 'KB', 'MB', 'GB'];
    let size = bytes;
    let unitIndex = 0;

    while (size >= 1024 && unitIndex < units.length - 1) {
        size /= 1024;
        unitIndex++;
    }

    return `${size.toFixed(1)} ${units[unitIndex]}`;
};

// Group downloads by category for the grid view
const groupedDownloads = computed(() => {
    const groups: Record<string, DownloadType[]> = {};

    props.downloads.data.forEach((dl) => {
        const categoryName = dl.category.name;
        if (!groups[categoryName]) {
            groups[categoryName] = [];
        }
        groups[categoryName].push(dl);
    });

    return groups;
});
</script>

<template>
    <Head title="Downloads" />
    <PublicLayout>
        <div class="min-h-screen bg-gradient-to-b from-white to-slate-50">
            <!-- Hero Section - Apple-inspired clarity and depth -->
            <div
                class="relative overflow-hidden border-b border-slate-200/80 bg-white"
            >
                <!-- Subtle gradient overlay for depth -->
                <div
                    class="absolute inset-0 bg-gradient-to-br from-blue-50/30 via-transparent to-purple-50/30"
                ></div>

                <div class="relative container mx-auto max-w-7xl px-4 py-15">
                    <!-- Back navigation with subtle depth -->
                    <Link
                        href="/"
                        class="group mb-8 inline-flex items-center text-sm text-slate-500 transition-colors hover:text-slate-900"
                    >
                        <ChevronRight
                            class="mr-1 h-4 w-4 rotate-180 transition-transform group-hover:-translate-x-1"
                        />
                        Back to Home
                    </Link>

                    <!-- Main heading with depth through layering -->
                    <div class="max-w-3xl">
                        <div
                            class="mb-6 inline-flex items-center gap-2 rounded-full border border-slate-200/60 bg-slate-100/80 px-4 py-2 backdrop-blur-sm"
                        >
                            <DownloadIcon class="h-4 w-4 text-slate-600" />
                            <span class="text-sm font-medium text-slate-700"
                                >Resource Library</span
                            >
                        </div>

                        <h1
                            class="mb-4 text-5xl font-semibold tracking-tight text-slate-900 md:text-6xl"
                        >
                            Downloads
                        </h1>

                        <p
                            class="max-w-2xl text-xl leading-relaxed text-slate-600"
                        >
                            Access important documents, forms, and educational
                            resources for students and parents.
                        </p>
                    </div>

                    <!-- Decorative elements for visual interest -->
                    <div
                        class="absolute top-0 right-0 -mt-20 -mr-20 h-96 w-96 rounded-full bg-blue-500/5 blur-3xl"
                    ></div>
                    <div
                        class="absolute right-20 bottom-0 h-64 w-64 rounded-full bg-purple-500/5 blur-3xl"
                    ></div>
                </div>
            </div>

            <!-- Main Content Section -->
            <div class="container mx-auto max-w-7xl px-4 py-12 md:py-16">
                <!-- Empty State - Clean and informative -->
                <div
                    v-if="!downloads.data.length"
                    class="relative rounded-2xl border border-slate-200/80 bg-white p-16 text-center shadow-sm"
                >
                    <div
                        class="absolute inset-0 rounded-2xl bg-gradient-to-b from-slate-50/50 to-transparent"
                    ></div>
                    <div class="relative">
                        <div
                            class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-100"
                        >
                            <FileText class="h-10 w-10 text-slate-400" />
                        </div>
                        <h3 class="mb-2 text-xl font-semibold text-slate-900">
                            No downloads available
                        </h3>
                        <p class="mx-auto max-w-md text-slate-500">
                            We're currently updating our resource library.
                            Please check back soon for new materials.
                        </p>
                    </div>
                </div>

                <!-- Downloads Content -->
                <div v-else class="space-y-8">
                    <!-- Category-based Grid Layout - Vercel-inspired cards -->
                    <div
                        v-for="(items, category) in groupedDownloads"
                        :key="category"
                        class="space-y-4"
                    >
                        <!-- Category Header with subtle depth -->
                        <div class="mb-6 flex items-center gap-3">
                            <h2 class="text-2xl font-semibold text-slate-900">
                                {{ category }}
                            </h2>
                            <div
                                class="h-px flex-1 bg-gradient-to-r from-slate-200 to-transparent"
                            ></div>
                            <span class="text-sm text-slate-500"
                                >{{ items.length }} items</span
                            >
                        </div>

                        <!-- Card Grid - Material Design elevation and depth -->
                        <div
                            class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
                        >
                            <div
                                v-for="dl in items"
                                :key="dl.id"
                                class="group relative rounded-xl border border-slate-200/80 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md"
                            >
                                <!-- Card content with Apple's clarity and deference -->
                                <div class="p-6">
                                    <!-- Icon with file-type specific color -->
                                    <div
                                        :class="[
                                            'group-hover:border-opacity-100 mb-4 flex h-12 w-12 items-center justify-center rounded-xl border transition-colors',
                                            getFileAccentColor(dl),
                                        ]"
                                    >
                                        <component
                                            :is="getFileIcon(dl)"
                                            class="h-6 w-6"
                                        />
                                    </div>

                                    <!-- Title and description with proper hierarchy -->
                                    <h3
                                        class="mb-2 line-clamp-1 text-lg font-semibold text-slate-900"
                                    >
                                        {{ dl.title }}
                                    </h3>

                                    <p
                                        v-if="dl.description"
                                        class="mb-4 line-clamp-2 text-sm text-slate-500"
                                    >
                                        {{ dl.description }}
                                    </p>

                                    <!-- Metadata with visual separation -->
                                    <div
                                        class="mb-4 flex items-center gap-3 text-xs text-slate-400"
                                    >
                                        <span
                                            class="rounded-md bg-slate-100 px-2 py-1"
                                        >
                                            {{
                                                getFileInfo(
                                                    dl,
                                                ).extension.toUpperCase()
                                            }}
                                        </span>
                                        <span
                                            v-if="(dl as any).file_size"
                                            class="flex items-center gap-1"
                                        >
                                            <span>•</span>
                                            {{
                                                formatFileSize(
                                                    (dl as any).file_size,
                                                )
                                            }}
                                        </span>
                                    </div>

                                    <!-- Action Button with Material Design elevation on hover -->
                                    <div class="mt-auto">
                                        <!-- File Download -->
                                        <a
                                            v-if="
                                                dl.type === 'file' &&
                                                (dl as any).file_path
                                            "
                                            :href="
                                                fileUrl((dl as any).file_path)
                                            "
                                            target="_blank"
                                            class="group inline-flex w-full items-center justify-between rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition-all hover:bg-slate-800 hover:shadow-md"
                                        >
                                            <span>Download</span>
                                            <DownloadIcon
                                                class="h-4 w-4 transition-transform group-hover:translate-y-0.5"
                                            />
                                        </a>

                                        <!-- External Link -->
                                        <a
                                            v-else-if="(dl as any).external_url"
                                            :href="(dl as any).external_url"
                                            target="_blank"
                                            class="group inline-flex w-full items-center justify-between rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition-all hover:bg-blue-700 hover:shadow-md"
                                        >
                                            <span>Open Link</span>
                                            <ExternalLink
                                                class="h-4 w-4 transition-transform group-hover:translate-x-0.5"
                                            />
                                        </a>
                                    </div>
                                </div>

                                <!-- Subtle hover effect overlay for depth -->
                                <div
                                    class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-slate-900/5 ring-inset group-hover:ring-slate-900/10"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination - Clean and functional with Vercel aesthetics -->
                    <nav
                        v-if="downloads.last_page > 1"
                        class="mt-12 flex items-center justify-center gap-2"
                    >
                        <Link
                            v-for="link in downloads.links"
                            :key="link.label"
                            :href="link.url ?? '#'"
                            preserve-scroll
                            :class="[
                                'flex h-10 min-w-[40px] items-center justify-center rounded-lg text-sm font-medium transition-all',
                                link.active
                                    ? 'bg-slate-900 text-white shadow-sm'
                                    : link.url
                                      ? 'border border-slate-200/80 text-slate-600 hover:bg-slate-100'
                                      : 'cursor-default border border-slate-200/50 text-slate-300',
                            ]"
                        >
                            <span v-html="link.label" />
                        </Link>
                    </nav>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>

<style scoped>
/* Smooth scrolling and better text rendering */
* {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Line clamp utilities */
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}
</style>
