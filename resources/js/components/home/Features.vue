<script setup lang="ts">
import { Award, Users2, TrendingUp, ArrowRight } from 'lucide-vue-next';
import { computed } from 'vue';
import type { FeatureItem } from '@/types';

const props = defineProps<{
    features?: FeatureItem[] | null;
}>();

const defaultFeatures: (FeatureItem & { icon: typeof Award; color: string })[] =
    [
        {
            title: 'Award & Recognition',
            description:
                'Our school has succeeded in bagging multiple Regional Shields and National Shields for outstanding scholastic performance.',
            image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80',
            badge: 'Top Ranked',
            icon: Award,
            metric: '5 Shields',
            stats: 'National Winner',
            color: 'from-amber-500/20',
        },
        {
            title: 'Experienced Faculty',
            description:
                'Our dedicated team of highly qualified teachers brings decades of expertise, ensuring every student receives mentorship that goes beyond textbooks.',
            image: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80',
            badge: 'Expert Team',
            icon: Users2,
            metric: '50+',
            stats: 'Qualified Teachers',
            color: 'from-blue-500/20',
        },
        {
            title: 'Holistic Development',
            description:
                'From sports to arts, debate to community service, our programs nurture well-rounded individuals who lead with confidence and empathy.',
            image: 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80',
            badge: 'All-Round',
            icon: TrendingUp,
            metric: '30+',
            stats: 'ECA Programs',
            color: 'from-emerald-500/20',
        },
    ];

const icons = [Award, Users2, TrendingUp];
const colors = ['from-amber-500/20', 'from-blue-500/20', 'from-emerald-500/20'];

const featuresData = computed(() => {
    if (props.features && props.features.length > 0) {
        return props.features.map((f, i) => ({
            ...f,
            icon: icons[i % icons.length],
            color: colors[i % colors.length],
        }));
    }
    return defaultFeatures;
});
</script>

<template>
    <section class="mx-auto max-w-7xl px-6 py-20">
        <div class="mb-16 text-center">
            <span
                class="mb-4 inline-block rounded-full bg-school-50 px-4 py-1.5 text-xs font-bold tracking-wider text-school-700 uppercase"
                >Why Choose Us</span
            >
            <h2
                class="text-4xl font-extrabold tracking-tight text-slate-900 md:text-5xl"
            >
                What Makes Us
                <span class="text-school-600">Different</span>
            </h2>
        </div>

        <div class="space-y-20">
            <div
                v-for="(feature, index) in featuresData"
                :key="index"
                class="group grid items-center gap-12 lg:grid-cols-2"
                :class="{ 'lg:direction-reverse': index % 2 !== 0 }"
            >
                <div :class="index % 2 !== 0 ? 'lg:order-2' : ''">
                    <div class="relative">
                        <div class="mb-4 flex items-center gap-3">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-school-600 text-white shadow"
                            >
                                <component :is="feature.icon" class="h-6 w-6" />
                            </div>
                            <span
                                v-if="feature.badge"
                                class="rounded-full bg-school-50 px-3 py-1 text-xs font-bold text-school-700"
                                >{{ feature.badge }}</span
                            >
                        </div>

                        <h3 class="mb-4 text-3xl font-bold text-slate-900">
                            {{ feature.title }}
                        </h3>

                        <p class="mb-6 text-lg leading-relaxed text-slate-600">
                            {{ feature.description }}
                        </p>

                        <div class="mb-6 flex items-center gap-6">
                            <div v-if="feature.metric">
                                <p class="text-2xl font-bold text-school-600">
                                    {{ feature.metric }}
                                </p>
                                <p
                                    v-if="feature.stats"
                                    class="text-sm font-medium text-slate-500"
                                >
                                    {{ feature.stats }}
                                </p>
                            </div>
                        </div>

                        <a
                            href="/about-us"
                            class="inline-flex items-center gap-2 text-sm font-bold text-school-600 transition-all hover:gap-3"
                        >
                            Learn More
                            <ArrowRight class="h-4 w-4" />
                        </a>
                    </div>
                </div>

                <div :class="index % 2 !== 0 ? 'lg:order-1' : ''">
                    <div class="group/img relative overflow-hidden rounded-3xl">
                        <img
                            :src="feature.image"
                            :alt="feature.title"
                            class="h-[400px] w-full object-cover transition-transform duration-700 group-hover/img:scale-110"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t opacity-30"
                            :class="feature.color"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
