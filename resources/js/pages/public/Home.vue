<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import CarouselSection from '@/components/home/CarouselSection.vue';
import FacilityGrid from '@/components/home/FacilityGrid.vue';
import Features from '@/components/home/Features.vue';
import PrincipleMessage from '@/components/home/PrincipleMessage.vue';
import WelcomeSection from '@/components/home/WelcomeSection.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type {
    Post,
    Download as DownloadType,
    GalleryAlbum,
    SiteSettings,
} from '@/types';

defineProps<{
    settings: SiteSettings;
    latestPosts: Post[];
    featuredDownloads: DownloadType[];
    albums: GalleryAlbum[];
}>();
</script>

<template>
    <Head :title="settings?.site_name ?? 'Welcome'" />
    <PublicLayout>
        <CarouselSection />

        <Features />

        <FacilityGrid />

        <PrincipleMessage />

        <WelcomeSection />
    </PublicLayout>
</template>
