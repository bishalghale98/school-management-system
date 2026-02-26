<script setup lang="ts">
import { Target, Eye } from 'lucide-vue-next';
import { computed } from 'vue';
import type { SiteSettings } from '@/types';

const props = defineProps<{
    settings?: SiteSettings | null;
}>();

const mission = computed(() => ({
    title: props.settings?.mission_title || 'Our Mission',
    subtitle:
        props.settings?.mission_subtitle || 'Empowering the next generation',
    desc:
        props.settings?.mission_description ||
        'To cultivate a dynamic learning environment that bridges the gap between traditional values and global innovation. We are committed to nurturing critical thinkers who approach challenges with integrity, empathy, and a relentless pursuit of excellence.',
    tags: ['Integrity', 'Innovation', 'Inclusivity'],
}));

const vision = computed(() => ({
    title: props.settings?.vision_title || 'Our Vision',
    subtitle: props.settings?.vision_subtitle || 'Shaping a global future',
    desc:
        props.settings?.vision_description ||
        'To emerge as a world-class center of academic distinction, where every student is inspired to redefine their potential. We envision our graduates as compassionate global leaders who drive positive change in an ever-evolving digital landscape.',
    tags: ['Leadership', 'Character', 'Global Citizenship'],
}));
</script>

<template>
    <section id="mission" class="relative scroll-mt-20">
        <div
            class="absolute top-1/2 left-1/2 -z-10 h-[500px] w-[500px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-gradient-to-tr from-school-50 to-blue-50 opacity-70 blur-3xl"
        ></div>

        <div class="grid gap-12 lg:grid-cols-2">
            <div
                class="group relative flex flex-col justify-between overflow-hidden rounded-[2.5rem] bg-gray-300 p-10 shadow-xl shadow-slate-300/50 transition-all duration-500 hover:-translate-y-2"
            >
                <div>
                    <div class="flex items-start justify-between">
                        <div
                            class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-school-600 text-white shadow-lg shadow-school-200 transition-transform duration-500 group-hover:rotate-12"
                        >
                            <Target class="h-8 w-8" />
                        </div>
                    </div>

                    <p
                        class="mb-2 text-sm font-bold tracking-wider text-school-600 uppercase"
                    >
                        {{ mission.subtitle }}
                    </p>
                    <h3 class="mb-6 text-4xl font-extrabold text-slate-900">
                        {{ mission.title }}
                    </h3>

                    <p class="mb-8 text-lg leading-relaxed text-slate-600">
                        {{ mission.desc }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <span
                        v-for="tag in mission.tags"
                        :key="tag"
                        class="rounded-full bg-slate-50 px-4 py-1.5 text-xs font-semibold text-slate-500 transition-colors group-hover:bg-school-50 group-hover:text-school-700"
                    >
                        #{{ tag }}
                    </span>
                </div>

                <Target
                    class="absolute -right-8 -bottom-8 h-40 w-40 text-slate-50 opacity-0 transition-all duration-500 group-hover:opacity-100"
                />
            </div>

            <div
                class="group relative flex flex-col justify-between overflow-hidden rounded-[2.5rem] bg-slate-900 p-10 shadow-2xl transition-all duration-500 hover:-translate-y-2"
            >
                <div>
                    <div class="flex items-start justify-between">
                        <div
                            class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-500 text-white shadow-lg shadow-blue-900/50 transition-transform duration-500 group-hover:-rotate-12"
                        >
                            <Eye class="h-8 w-8" />
                        </div>
                    </div>

                    <p
                        class="mb-2 text-sm font-bold tracking-wider text-blue-400 uppercase"
                    >
                        {{ vision.subtitle }}
                    </p>
                    <h3 class="mb-6 text-4xl font-extrabold text-white">
                        {{ vision.title }}
                    </h3>

                    <p class="mb-8 text-lg leading-relaxed text-slate-300">
                        {{ vision.desc }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <span
                        v-for="tag in vision.tags"
                        :key="tag"
                        class="rounded-full bg-white/5 px-4 py-1.5 text-xs font-semibold text-slate-400 transition-colors group-hover:bg-blue-500 group-hover:text-white"
                    >
                        #{{ tag }}
                    </span>
                </div>

                <Eye
                    class="absolute -right-8 -bottom-8 h-40 w-40 text-white opacity-0 transition-all duration-500 group-hover:opacity-5"
                />
            </div>
        </div>
    </section>
</template>
