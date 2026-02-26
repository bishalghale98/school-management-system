<script setup lang="ts">
import {
    School,
    Microscope,
    Monitor,
    BookOpen,
    Trophy,
    Music,
    ArrowRight,
} from 'lucide-vue-next';
import { computed } from 'vue';
import type { FacilityItem } from '@/types';

const props = defineProps<{
    facilities?: FacilityItem[] | null;
}>();

const defaultFacilities = [
    {
        title: 'Digital Classrooms',
        desc: 'Interactive smart boards and ergonomic furniture designed for collaborative learning and student engagement.',
        icon: School,
        color: 'green',
    },
    {
        title: 'Innovation Labs',
        desc: 'Advanced Physics, Chemistry, and Biology labs equipped with research-grade instruments for hands-on discovery.',
        icon: Microscope,
        color: 'blue',
    },
    {
        title: 'IT Hub',
        desc: 'A state-of-the-art computing center featuring high-speed fiber internet and professional creative software.',
        icon: Monitor,
        color: 'indigo',
    },
    {
        title: 'Central Library',
        desc: 'A quiet sanctuary housing over 10,000 volumes, plus a digital repository for global research access.',
        icon: BookOpen,
        color: 'orange',
    },
    {
        title: 'Sports Complex',
        desc: 'Professional-grade basketball courts and indoor arenas to foster physical fitness and team spirit.',
        icon: Trophy,
        color: 'red',
    },
    {
        title: 'Arts & Culture',
        desc: 'A 500-seat acoustic auditorium and dedicated studios for music, dance, and fine arts performances.',
        icon: Music,
        color: 'pink',
    },
];

const icons = [School, Microscope, Monitor, BookOpen, Trophy, Music];

const facilitiesData = computed(() => {
    if (props.facilities && props.facilities.length > 0) {
        return props.facilities.map((f, i) => ({
            title: f.title,
            desc: f.description,
            icon: icons[i % icons.length],
            color: ['green', 'blue', 'indigo', 'orange', 'red', 'pink'][i % 6],
        }));
    }
    return defaultFacilities;
});
</script>

<template>
    <section class="relative">
        <div
            class="absolute inset-0 -z-10 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)] [background-size:32px_32px]"
        ></div>

        <div class="mb-16 text-center">
            <h2
                class="mb-4 text-4xl font-extrabold tracking-tight text-slate-900 md:text-5xl"
            >
                World-Class <span class="text-school-600">Facilities</span>
            </h2>
            <p class="mx-auto max-w-2xl text-lg text-slate-600">
                We provide a robust infrastructure designed to support both
                academic rigor and creative exploration.
            </p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="item in facilitiesData"
                :key="item.title"
                class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 transition-all duration-300 hover:border-school-500 hover:shadow-2xl hover:shadow-school-100"
            >
                <div
                    class="absolute -top-8 -right-8 h-24 w-24 rounded-full bg-slate-50 transition-colors group-hover:bg-school-50"
                ></div>

                <div class="relative z-10">
                    <div
                        class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-50 text-slate-600 transition-all duration-500 group-hover:scale-110 group-hover:bg-school-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-school-200"
                    >
                        <component :is="item.icon" class="h-7 w-7" />
                    </div>

                    <h3
                        class="mb-3 text-2xl font-bold text-slate-800 transition-colors group-hover:text-school-700"
                    >
                        {{ item.title }}
                    </h3>

                    <p class="mb-6 leading-relaxed text-slate-600">
                        {{ item.desc }}
                    </p>

                    <div
                        class="flex items-center gap-2 text-sm font-bold text-slate-400 transition-all group-hover:gap-4 group-hover:text-school-600"
                    >
                        <span>EXPLORE MORE</span>
                        <ArrowRight class="h-4 w-4" />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
