<script setup lang="ts">
import { Laptop, Microscope, Trophy, ArrowRight } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';

const facilities = [
    {
        id: 1,
        title: 'ECA/CCA ACTIVITIES',
        description:
            'Everest Secondary School holds pride to conduct Extra curricular activities in various sports and education activities. Our wards are well trained with professional trainers.',
        image: 'https://ebs.edu.np/wp-content/uploads/2023/03/everest-eca.webp',
        icon: Trophy,
        accentColor: 'bg-orange-500',
        textColor: 'text-orange-600',
    },
    {
        id: 2,
        title: 'COMPUTER LAB',
        description:
            'We acknowledge the importance of IT education in this hi-tech world. Computer education is an integral part of our curriculum from grade three to ten.',
        image: 'https://ebs.edu.np/wp-content/uploads/2023/03/everest-computer-lab.webp',
        icon: Laptop,
        accentColor: 'bg-indigo-600',
        textColor: 'text-indigo-600',
    },
    {
        id: 3,
        title: 'SCIENCE LAB',
        description:
            'Separate labs for physics, chemistry, and biology where practical classes are conducted. Our labs stand out as the best in the entire province.',
        image: 'https://ebs.edu.np/wp-content/uploads/2023/03/everest-school-lab.webp',
        icon: Microscope,
        accentColor: 'bg-emerald-600',
        textColor: 'text-emerald-600',
    },
];
</script>

<template>
    <section class="bg-slate-50 py-20">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="mb-16 text-center">
                <h2
                    class="text-3xl font-extrabold tracking-tight text-slate-900 md:text-4xl"
                >
                    World Class <span class="text-indigo-600">Facilities</span>
                </h2>
                <div
                    class="mx-auto mt-4 h-1.5 w-20 rounded-full bg-indigo-600"
                ></div>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <Card
                    v-for="item in facilities"
                    :key="item.id"
                    class="group border-none bg-white shadow-md transition-all duration-500 hover:shadow-2xl"
                >
                    <div class="relative h-64 overflow-hidden rounded-t-xl">
                        <img
                            :src="item.image"
                            :alt="item.title"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                        />
                        <div
                            :class="[
                                item.accentColor,
                                'absolute right-6 -bottom-2 z-10 rounded-xl p-4 text-white shadow-lg transition-transform group-hover:-translate-y-3',
                            ]"
                        >
                            <component :is="item.icon" class="h-6 w-6" />
                        </div>
                    </div>

                    <CardContent class="px-8 pt-10 pb-8">
                        <h3
                            class="mb-3 text-xl font-bold tracking-wide text-slate-900"
                        >
                            {{ item.title }}
                        </h3>
                        <p class="mb-6 text-sm leading-relaxed text-slate-600">
                            {{ item.description }}
                        </p>

                        <Button
                            variant="ghost"
                            :class="[
                                'group/btn h-auto p-0 font-bold transition-colors hover:bg-transparent',
                                item.textColor,
                            ]"
                        >
                            <span
                                class="border-b-2 border-transparent py-1 group-hover/btn:border-current"
                            >
                                EXPLORE MORE
                            </span>
                            <ArrowRight
                                class="ml-2 h-4 w-4 transition-transform group-hover/btn:translate-x-2"
                            />
                        </Button>
                    </CardContent>
                </Card>
            </div>
        </div>
    </section>
</template>
