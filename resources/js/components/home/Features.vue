<script setup lang="ts">
import { ArrowRight, Award, Users, Building2 } from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle } from '@/components/ui/card';

const featuresData = [
    {
        id: 1,
        title: 'Award & Recognition',
        description:
            'Everest Secondary School has succeeded in bagging four Regional Shields and one National Shield for outstanding scholastic performance.',
        image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80',
        badge: 'Top Ranked',
        icon: Award,
        metric: '5 Shields',
        stats: 'National Winner',
        color: 'from-amber-500/20',
    },
    {
        id: 2,
        title: 'Team of Professionals',
        description:
            'We hire subject experts and professional trainers to equip teachers with contemporary teaching methods and digital tools.',
        image: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80',
        badge: 'Expert Faculty',
        icon: Users,
        metric: '50+ Experts',
        stats: 'PhD & Masters',
        color: 'from-blue-500/20',
    },
    {
        id: 3,
        title: 'Ambient Infrastructure',
        description:
            'Spacious, well-ventilated classrooms digitized with latest technology and fully equipped specialized science and math labs.',
        image: 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80',
        badge: 'Smart Campus',
        icon: Building2,
        metric: '20+ Labs',
        stats: 'Tech Enabled',
        color: 'from-emerald-500/20',
    },
];
</script>

<template>
    <div class="min-h-screen bg-slate-50 p-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 space-y-4">
                <Badge
                    variant="outline"
                    class="rounded-full border-primary/20 bg-primary/5 px-4 py-1 text-[10px] font-bold tracking-widest text-primary uppercase"
                >
                    Our Excellence
                </Badge>
                <h2
                    class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl"
                >
                    Why Choose <span class="text-gray-800">Everest?</span>
                </h2>
                <p class="max-w-2xl text-lg text-slate-600">
                    Combining traditional values with modern technology to
                    create a world-class learning environment.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <Card
                    v-for="feature in featuresData"
                    :key="feature.id"
                    class="group relative flex flex-col overflow-hidden border-slate-200 bg-white transition-all duration-500 hover:shadow-2xl hover:shadow-primary/10"
                >
                    <div
                        class="absolute inset-0 z-10 translate-x-[-100%] bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-1000 group-hover:translate-x-[100%]"
                    ></div>

                    <div class="relative h-64 overflow-hidden">
                        <img
                            :src="feature.image"
                            :alt="feature.title"
                            class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                        />

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent opacity-80"
                        ></div>
                        <div
                            :class="[
                                'absolute inset-0 bg-gradient-to-br opacity-40 transition-opacity group-hover:opacity-60',
                                feature.color,
                            ]"
                        ></div>

                        <div
                            class="absolute top-4 right-4 left-4 flex items-start justify-between"
                        >
                            <div class="flex items-center gap-2">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/20 bg-white/10 backdrop-blur-md"
                                >
                                    <component
                                        :is="feature.icon"
                                        class="h-5 w-5 text-white"
                                    />
                                </div>
                                <Badge
                                    class="border-none bg-white/90 font-bold text-slate-900 backdrop-blur-sm"
                                >
                                    {{ feature.badge }}
                                </Badge>
                            </div>
                        </div>

                        <div class="absolute right-6 bottom-6 left-6">
                            <div class="space-y-1">
                                <p
                                    class="text-3xl font-black tracking-tighter text-white"
                                >
                                    {{ feature.metric }}
                                </p>
                                <p
                                    class="text-xs font-medium tracking-widest text-white/70 uppercase"
                                >
                                    {{ feature.stats }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <CardHeader class="flex-1 space-y-3 p-6">
                        <CardTitle
                            class="text-xl font-bold text-slate-900 transition-colors group-hover:text-gray-800"
                        >
                            {{ feature.title }}
                        </CardTitle>
                        <p
                            class="line-clamp-3 text-sm leading-relaxed text-slate-600"
                        >
                            {{ feature.description }}
                        </p>
                    </CardHeader>

                    <div class="mt-auto p-6 pt-0">
                        <Button
                            variant="secondary"
                            class="group/btn w-full justify-between bg-slate-100 text-gray-800 transition-all duration-300 hover:bg-gray-800 hover:text-white"
                        >
                            <span
                                class="text-xs font-semibold tracking-wider uppercase"
                                >Learn More</span
                            >
                            <ArrowRight
                                class="h-4 w-4 transition-transform group-hover/btn:translate-x-1"
                            />
                        </Button>
                    </div>

                    <div
                        class="h-1 w-0 bg-primary transition-all duration-500 group-hover:w-full"
                    ></div>
                </Card>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Added for extra-smooth text rendering on high-res screens */
h2,
p {
    text-rendering: optimizeLegibility;
}
</style>
