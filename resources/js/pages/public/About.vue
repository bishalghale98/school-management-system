<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import FacilitiesSection from '@/components/about/FacilitiesSection.vue';
import MissionVision from '@/components/about/MissionVision.vue';
import OverviewSection from '@/components/about/OverviewSection.vue';
import PrincipalMessage from '@/components/about/PrincipalMessage.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

const schoolName = 'Saraswati Secondary School';
</script>

<template>
    <Head>
        <title>About Us | {{ schoolName }}</title>
        <meta
            name="description"
            content="Discover the history, mission, and academic excellence of Saraswati Secondary School."
        />
    </Head>

    <PublicLayout>
        <div class="relative overflow-hidden bg-slate-900 py-24 text-white">
            <div
                class="absolute inset-0 opacity-20"
                style="
                    background-image: url('data:image/svg+xml,...');
                    background-size: 30px 30px;
                "
            ></div>

            <div
                class="relative z-10 container mx-auto max-w-7xl px-4 text-center"
            >
                <nav
                    class="mb-4 flex justify-center space-x-2 text-sm font-medium tracking-widest text-school-400 uppercase"
                >
                    <span>Home</span>
                    <span>/</span>
                    <span class="text-white">About Us</span>
                </nav>
                <h1
                    class="mb-6 text-5xl font-extrabold tracking-tight md:text-7xl"
                >
                    Our <span class="text-school-500">Story</span> & Legacy
                </h1>
                <p
                    class="mx-auto max-w-2xl text-lg leading-relaxed text-slate-300 md:text-xl"
                >
                    Dedicated to academic excellence and character building
                    since 1998, shaping the leaders of tomorrow in the heart of
                    Morang.
                </p>
            </div>

            <div
                class="absolute right-0 bottom-0 left-0 h-16 bg-white"
                style="clip-path: polygon(0 100%, 100% 100%, 100% 0)"
            ></div>
        </div>

        <div class="bg-white">
            <div class="container mx-auto max-w-7xl space-y-32 px-4 pt-20">
                <OverviewSection />

                <div class="relative">
                    <div
                        class="absolute inset-0 flex items-center"
                        aria-hidden="true"
                    >
                        <div class="w-full border-t border-slate-100"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="bg-white text-sm font-bold tracking-[0.3em] text-slate-400 uppercase"
                            >Values & Purpose</span
                        >
                    </div>
                </div>

                <MissionVision />

                <PrincipalMessage />

                <FacilitiesSection />
            </div>
        </div>

        <section class="border-t border-slate-100 bg-slate-50 py-20">
            <div class="container mx-auto px-4 text-center">
                <h2 class="mb-6 text-3xl font-bold text-slate-800">
                    Want to learn more?
                </h2>
                <div class="flex flex-wrap justify-center gap-4">
                    <button
                        class="rounded-full bg-school-600 px-8 py-3 font-bold text-white shadow-lg transition hover:bg-school-700"
                    >
                        View Achievements
                    </button>
                    <button
                        class="rounded-full border border-slate-200 bg-white px-8 py-3 font-bold text-slate-800 transition hover:bg-slate-50"
                    >
                        Contact Admissions
                    </button>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
