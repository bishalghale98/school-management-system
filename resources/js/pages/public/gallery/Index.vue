<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    Image as ImageIcon,
    Calendar,
    ArrowRight,
    Camera,
} from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { GalleryAlbum, PaginatedData } from '@/types';

defineProps<{
    albums: PaginatedData<GalleryAlbum>;
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
    <Head title="Photo Gallery" />
    <PublicLayout>
        <div
            class="relative overflow-hidden bg-slate-950 py-24 text-white lg:py-32"
        >
            <div class="absolute inset-0 z-0">
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-purple-900/40 via-slate-950 to-slate-950"
                ></div>
                <div
                    class="absolute inset-0 opacity-[0.03]"
                    style="
                        background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
                    "
                ></div>
            </div>

            <div class="relative z-10 container mx-auto max-w-7xl px-4">
                <div class="flex flex-col items-center text-center">
                    <Badge
                        variant="outline"
                        class="mb-4 border-purple-500/50 bg-purple-500/5 px-4 py-1 tracking-widest text-purple-400 uppercase"
                    >
                        Visual Archives
                    </Badge>
                    <h1
                        class="mb-6 text-5xl font-extrabold tracking-tight md:text-7xl"
                    >
                        Our
                        <span
                            class="bg-gradient-to-r from-purple-400 to-violet-400 bg-clip-text text-transparent"
                            >Journey</span
                        >
                        in Frames
                    </h1>
                    <p
                        class="mx-auto max-w-2xl text-lg leading-relaxed text-slate-400 md:text-xl"
                    >
                        A visual chronicle of academic milestones, cultural
                        celebrations, and the vibrant life at our institution
                        since 1998.
                    </p>
                </div>
            </div>

            <div
                class="absolute right-0 bottom-0 left-0 h-16 bg-slate-50"
                style="clip-path: polygon(0 100%, 100% 100%, 100% 0)"
            ></div>
        </div>

        <section class="relative overflow-hidden bg-slate-50 py-20">
            <!-- Soft background decor -->
            <div class="pointer-events-none absolute inset-0">
                <div
                    class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-purple-200/40 blur-3xl"
                />
                <div
                    class="absolute -right-24 -bottom-24 h-72 w-72 rounded-full bg-sky-200/40 blur-3xl"
                />
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(124,58,237,0.08),transparent_55%)]"
                />
            </div>

            <div class="relative mx-auto max-w-7xl px-4">
                <!-- Header -->
                <div
                    class="mb-12 flex flex-col gap-6 md:flex-row md:items-end md:justify-between"
                >
                    <div class="max-w-2xl">
                        <div
                            class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/70 px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm backdrop-blur"
                        >
                            <Camera class="h-4 w-4 text-purple-600" />
                            Photo Gallery
                        </div>

                        <h2
                            class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl"
                        >
                            Recent Photo Albums
                        </h2>

                        <p
                            class="mt-3 text-base leading-relaxed text-slate-600 sm:text-lg"
                        >
                            Explore the stories behind our latest events and
                            moments.
                        </p>
                    </div>

                    <div
                        class="flex items-center gap-2 text-sm font-semibold text-slate-500"
                    >
                        <span class="h-2 w-2 rounded-full bg-purple-500" />
                        Showing {{ albums.data.length }} collections
                    </div>
                </div>

                <!-- Empty state -->
                <div
                    v-if="!albums.data.length"
                    class="rounded-3xl border border-dashed border-slate-200 bg-white/70 p-10 text-center shadow-sm backdrop-blur sm:p-14"
                >
                    <div
                        class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100"
                    >
                        <ImageIcon class="h-8 w-8 text-slate-300" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">
                        No albums yet
                    </h3>
                    <p
                        class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-slate-600"
                    >
                        We haven’t uploaded any albums yet. Please check back
                        soon for new memories!
                    </p>
                </div>

                <!-- Albums Grid -->
                <div v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="album in albums.data"
                        :key="album.id"
                        :href="`/gallery/${album.slug}`"
                        class="group"
                    >
                        <article
                            class="relative overflow-hidden rounded-3xl border border-slate-200/70 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-slate-200/60"
                        >
                            <!-- Media -->
                            <div
                                class="relative aspect-[16/10] overflow-hidden"
                            >
                                <img
                                    v-if="album.cover_image"
                                    :src="`/storage/${album.cover_image}`"
                                    :alt="album.title"
                                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                                    loading="lazy"
                                />
                                <div
                                    v-else
                                    class="flex h-full items-center justify-center bg-slate-100"
                                >
                                    <ImageIcon
                                        class="h-14 w-14 text-slate-300"
                                    />
                                </div>

                                <!-- Gradient overlay -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-950/35 via-slate-950/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                />

                                <!-- Photos count -->
                                <div class="absolute top-4 right-4">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-slate-950/60 px-3 py-1 text-xs font-bold text-white backdrop-blur"
                                    >
                                        {{ album.photos_count ?? 0 }} Photos
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <!-- Meta -->
                                <div
                                    class="mb-3 flex flex-wrap items-center gap-2"
                                >
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700"
                                    >
                                        <Calendar class="h-3.5 w-3.5" />
                                        {{
                                            album.event_date
                                                ? formatDate(album.event_date)
                                                : 'Recent'
                                        }}
                                    </span>

                                    <span
                                        v-if="album.location"
                                        class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600"
                                    >
                                        <MapPin class="h-3.5 w-3.5" />
                                        {{ album.location }}
                                    </span>
                                </div>

                                <h3
                                    class="text-xl leading-snug font-extrabold text-slate-900 transition-colors group-hover:text-purple-700"
                                >
                                    {{ album.title }}
                                </h3>

                                <p
                                    v-if="album.description"
                                    class="mt-2 line-clamp-2 text-sm leading-relaxed text-slate-600"
                                >
                                    {{ album.description }}
                                </p>

                                <!-- CTA -->
                                <div
                                    class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-slate-900"
                                >
                                    <span class="relative">
                                        View Album
                                        <span
                                            class="absolute -bottom-1 left-0 h-0.5 w-0 bg-purple-600 transition-all duration-300 group-hover:w-full"
                                        />
                                    </span>
                                    <ArrowRight
                                        class="h-4 w-4 text-purple-600 transition-transform duration-300 group-hover:translate-x-1"
                                    />
                                </div>
                            </div>
                        </article>
                    </Link>
                </div>

                <!-- Pagination -->
                <nav
                    v-if="albums.last_page > 1"
                    class="mt-14 flex flex-wrap items-center justify-center gap-2"
                >
                    <Link
                        v-for="link in albums.links"
                        :key="link.label"
                        :href="link.url ?? '#'"
                        preserve-scroll
                        :class="[
                            'inline-flex h-11 min-w-[44px] items-center justify-center rounded-2xl px-3 text-sm font-bold transition',
                            link.active
                                ? 'bg-purple-600 text-white shadow-md shadow-purple-200'
                                : link.url
                                  ? 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-100'
                                  : 'cursor-not-allowed border border-slate-200/60 bg-white/50 text-slate-400 opacity-60',
                        ]"
                    >
                        <span v-html="link.label" />
                    </Link>
                </nav>
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
/* Smooth transition for clip-path */
.bg-slate-50 {
    transition: all 0.3s ease;
}
</style>
