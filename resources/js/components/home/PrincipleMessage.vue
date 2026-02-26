<script setup lang="ts">
import { Quote } from 'lucide-vue-next';
import { computed } from 'vue';
import type { SiteSettings } from '@/types';

const props = defineProps<{
    settings?: SiteSettings | null;
}>();

const principalData = computed(() => ({
    name: props.settings?.principal_name || 'TIKARAM PURI',
    designation: props.settings?.principal_title || 'PRINCIPAL',
    image: props.settings?.principal_image
        ? `/storage/${props.settings.principal_image}`
        : 'https://ebs.edu.np/wp-content/uploads/2023/03/everest-school-principal-tikaram-puri.webp',
    paragraphs: props.settings?.principal_message?.length
        ? props.settings.principal_message
        : [
              "The quality of education is closely related with the learning environment and student's motivation. Proper policies and adequate inputs, tailored to specify conditions, can bring about effective education.",
              'The demands of the modern era are being pushed at ever increasing speed by extraordinary advances in technology. Guardians who anticipate these advances and best prepare their children for the future are likely to reap the utmost benefit from them.',
              'Education programmed on social demands, efficient faculties, real academic environment, adequate physical facilities and alertness towards the changes that are taking place rapidly at local and international levels are essential for an institution to keep itself ever updated.',
          ],
}));
</script>

<template>
    <section class="mx-auto max-w-7xl px-6 py-20">
        <div
            class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 shadow-2xl"
        >
            <div class="grid lg:grid-cols-5">
                <!-- Image side -->
                <div class="relative lg:col-span-2">
                    <img
                        :src="principalData.image"
                        :alt="principalData.name"
                        class="h-72 w-full object-cover lg:h-full"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-transparent to-slate-900/80 lg:bg-gradient-to-r"
                    ></div>
                    <div class="absolute bottom-6 left-6 lg:bottom-8 lg:left-8">
                        <p class="text-xl font-bold text-white">
                            {{ principalData.name }}
                        </p>
                        <p
                            class="text-sm font-semibold tracking-widest text-school-400 uppercase"
                        >
                            {{ principalData.designation }}
                        </p>
                    </div>
                </div>

                <!-- Text side -->
                <div class="relative p-8 lg:col-span-3 lg:p-12">
                    <Quote
                        class="absolute top-6 right-6 h-20 w-20 text-white/5"
                    />

                    <div class="relative z-10">
                        <h2
                            class="mb-8 text-3xl font-bold text-white md:text-4xl"
                        >
                            From the
                            <span class="text-school-400">Principal's</span>
                            Desk
                        </h2>

                        <div class="space-y-5">
                            <p
                                v-for="(
                                    para, index
                                ) in principalData.paragraphs"
                                :key="index"
                                class="leading-relaxed text-slate-300"
                            >
                                {{ para }}
                            </p>
                        </div>

                        <div class="mt-8 border-t border-slate-700 pt-6">
                            <p
                                class="text-sm tracking-widest text-slate-500 uppercase"
                            >
                                Warm regards,
                            </p>
                            <p class="mt-1 text-lg font-semibold text-white">
                                {{ principalData.name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
