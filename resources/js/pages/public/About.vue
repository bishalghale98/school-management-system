<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import FacilitiesSection from '@/components/about/FacilitiesSection.vue';
import MissionVision from '@/components/about/MissionVision.vue';
import OverviewSection from '@/components/about/OverviewSection.vue';
import PrincipalMessage from '@/components/about/PrincipalMessage.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { SiteSettings } from '@/types';

const props = defineProps<{
    settings: SiteSettings;
}>();


const schoolName = props.settings?.site_name ?? 'Our School';
</script>

<template>
    <Head :title="`About Us — ${schoolName}`" />
    <PublicLayout>
        <!-- Hero Banner -->
        <section
            class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 py-24 text-white md:py-32"
        >
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-school-600/20 via-transparent to-transparent"
            ></div>
            <div
                class="absolute right-0 bottom-0 h-80 w-80 translate-x-1/2 translate-y-1/2 rounded-full bg-school-500/10 blur-3xl"
            ></div>

            <div class="relative z-10 mx-auto max-w-7xl px-6 text-center">
                <span
                    class="mb-6 inline-block rounded-full bg-white/10 px-5 py-2 text-xs font-bold tracking-widest uppercase backdrop-blur-sm"
                    >About Us</span
                >
                <h1
                    class="mx-auto mb-6 max-w-4xl text-5xl font-extrabold tracking-tight md:text-7xl"
                >
                    {{ schoolName }}
                </h1>
                <p
                    class="mx-auto max-w-2xl text-lg leading-relaxed text-slate-300"
                >
                    {{
                        settings?.tagline ||
                        'Committed to excellence in education and holistic development of every student.'
                    }}
                </p>

                <nav
                    class="mx-auto mt-12 flex max-w-2xl flex-wrap items-center justify-center gap-4"
                >
                    <a
                        href="#overview"
                        class="rounded-full bg-school-600 px-6 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-school-500"
                        >Overview</a
                    >
                    <a
                        href="#mission"
                        class="rounded-full bg-white/10 px-6 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-white/20"
                        >Mission & Vision</a
                    >
                    <a
                        href="#message"
                        class="rounded-full bg-white/10 px-6 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-white/20"
                        >Principal's Message</a
                    >
                </nav>
            </div>
        </section>

        <div class="mx-auto max-w-7xl space-y-24 px-6 py-16 md:py-24">
            <OverviewSection :settings="settings" />
            <MissionVision :settings="settings" />
            <PrincipalMessage :settings="settings" />
            <FacilitiesSection :facilities="settings.facilities" />
        </div>
    </PublicLayout>
</template>
