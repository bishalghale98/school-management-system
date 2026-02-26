<script setup lang="ts">
import { Trophy, FlaskConical, Monitor, ArrowRight } from 'lucide-vue-next';
import { computed } from 'vue';
import type { FacilityItem } from '@/types';

const props = defineProps<{
    facilities?: FacilityItem[] | null;
}>();

const defaultFacilities: (FacilityItem & {
    icon: typeof Trophy;
    accentColor: string;
    textColor: string;
})[] = [
    {
        title: 'ECA/CCA ACTIVITIES',
        description:
            'Extra curricular activities in various sports and education activities. Our wards are well trained with professional trainers.',
        image: 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?auto=format&fit=crop&q=80',
        icon: Trophy,
        accentColor: 'bg-orange-500',
        textColor: 'text-orange-600',
    },
    {
        title: 'SCIENCE LAB',
        description:
            'Fully equipped science laboratories for Physics, Chemistry, and Biology with modern instruments for hands-on learning.',
        image: 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&q=80',
        icon: FlaskConical,
        accentColor: 'bg-blue-500',
        textColor: 'text-blue-600',
    },
    {
        title: 'COMPUTER LAB',
        description:
            'State-of-the-art computer lab with high-speed internet connectivity for digital literacy and IT education.',
        image: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80',
        icon: Monitor,
        accentColor: 'bg-purple-500',
        textColor: 'text-purple-600',
    },
];

const icons = [Trophy, FlaskConical, Monitor];
const accentColors = ['bg-orange-500', 'bg-blue-500', 'bg-purple-500'];
const textColors = ['text-orange-600', 'text-blue-600', 'text-purple-600'];

const facilitiesData = computed(() => {
    if (props.facilities && props.facilities.length > 0) {
        return props.facilities.map((f, i) => ({
            ...f,
            icon: icons[i % icons.length],
            accentColor: accentColors[i % accentColors.length],
            textColor: textColors[i % textColors.length],
        }));
    }
    return defaultFacilities;
});
</script>

<template>
    <section class="mx-auto max-w-7xl px-6 py-20">
        <div class="mb-16 text-center">
            <h2
                class="text-4xl font-extrabold tracking-tight text-slate-900 md:text-5xl"
            >
                Our <span class="text-school-600">Facilities</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-lg text-slate-600">
                Explore our world-class facilities designed to support academic
                excellence.
            </p>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="(facility, index) in facilitiesData"
                :key="index"
                class="group relative overflow-hidden rounded-3xl bg-white shadow-lg transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl"
            >
                <div class="relative h-56 overflow-hidden">
                    <img
                        :src="facility.image"
                        :alt="facility.title"
                        class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"
                    ></div>
                    <div
                        class="absolute top-4 left-4 flex h-12 w-12 items-center justify-center rounded-xl text-white shadow-lg"
                        :class="facility.accentColor"
                    >
                        <component :is="facility.icon" class="h-6 w-6" />
                    </div>
                </div>

                <div class="p-6">
                    <h3
                        class="mb-3 text-xl font-bold tracking-wide"
                        :class="facility.textColor"
                    >
                        {{ facility.title }}
                    </h3>
                    <p class="mb-4 text-sm leading-relaxed text-slate-600">
                        {{ facility.description }}
                    </p>
                    <a
                        href="/about-us"
                        class="inline-flex items-center gap-2 text-xs font-bold tracking-wider uppercase transition-all hover:gap-3"
                        :class="facility.textColor"
                    >
                        EXPLORE MORE
                        <ArrowRight class="h-3.5 w-3.5" />
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>
