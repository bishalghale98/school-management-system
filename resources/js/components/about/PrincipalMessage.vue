<script setup lang="ts">
import { Quote, Award, BookOpen, Users } from 'lucide-vue-next';
import { computed } from 'vue';
import type { SiteSettings } from '@/types';

const props = defineProps<{
    settings?: SiteSettings | null;
}>();

const principalData = computed(() => ({
    name: props.settings?.principal_name || 'Mr. Ram Prasad Sharma',
    title: props.settings?.principal_title || 'Principal',
    credentials:
        props.settings?.principal_credentials || 'M.Ed. (Education Management)',
    experience:
        props.settings?.principal_experience ||
        '25+ Years of Educational Leadership',
    image: props.settings?.principal_image
        ? `/storage/${props.settings.principal_image}`
        : 'https://thumbs.dreamstime.com/b/african-american-man-wearing-winter-coat-28594045.jpg',
    message: props.settings?.principal_message?.length
        ? props.settings.principal_message
        : [
              'It is my distinct honor to welcome you to our school. Our institution is built on the belief that every child possesses a unique brilliance that, when nurtured with care and the right tools, can illuminate the world.',
              "We don't just aim for academic results; we aim for character. In an era of rapid technological change, we ensure our students are grounded in ethics while being equipped with 21st-century skills — critical thinking, digital literacy, and emotional intelligence.",
              "Our doors are always open to parents and well-wishers who share our vision of holistic excellence. Together, let us guide our children toward a future where they don't just find jobs, but create impact.",
          ],
}));
</script>

<template>
    <section id="message" class="relative scroll-mt-20">
        <div
            class="absolute top-0 right-0 -z-10 h-64 w-64 translate-x-1/2 rounded-full bg-slate-50 opacity-50 blur-3xl"
        ></div>
        <div
            class="absolute bottom-0 left-0 -z-10 h-64 w-64 -translate-x-1/2 rounded-full bg-school-50/30 opacity-50 blur-3xl"
        ></div>

        <div
            class="overflow-hidden rounded-[3rem] border border-slate-100 bg-white shadow-2xl shadow-slate-200/60"
        >
            <div class="grid lg:grid-cols-12">
                <div
                    class="bg-slate-900 p-10 text-center lg:col-span-4 lg:p-12"
                >
                    <div class="relative mx-auto mb-8 inline-block">
                        <div
                            class="relative z-10 h-64 w-52 overflow-hidden rounded-2xl border-4 border-slate-800 shadow-2xl transition-transform duration-500 hover:scale-[1.03]"
                        >
                            <img
                                :src="principalData.image"
                                :alt="principalData.name"
                                class="h-full w-full object-cover grayscale transition-all duration-700 hover:grayscale-0"
                            />
                        </div>
                        <div
                            class="absolute -right-4 -bottom-4 -z-0 h-32 w-32 rounded-xl bg-school-600/20"
                        ></div>
                    </div>

                    <h3 class="mb-1 text-2xl font-extrabold text-white">
                        {{ principalData.name }}
                    </h3>
                    <p
                        class="mb-4 text-xs font-medium tracking-widest text-school-500 uppercase"
                    >
                        {{ principalData.title }}
                    </p>

                    <div
                        class="mt-8 space-y-4 border-t border-slate-800 pt-8 text-left"
                    >
                        <div class="flex items-center gap-3 text-slate-400">
                            <Award class="h-5 w-5 text-school-500" />
                            <span class="text-sm">{{
                                principalData.credentials
                            }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-400">
                            <Users class="h-5 w-5 text-school-500" />
                            <span class="text-sm">{{
                                principalData.experience
                            }}</span>
                        </div>
                    </div>
                </div>

                <div class="relative p-10 lg:col-span-8 lg:p-16">
                    <Quote
                        class="absolute top-12 right-12 h-32 w-32 text-slate-50 opacity-50"
                    />

                    <div class="relative z-10">
                        <h2
                            class="mb-8 text-3xl font-bold text-slate-900 md:text-4xl"
                        >
                            Principal
                            <span class="text-school-600">Message</span>,
                        </h2>

                        <div
                            class="space-y-6 text-lg leading-relaxed text-slate-600"
                        >
                            <p
                                v-for="(para, index) in principalData.message"
                                :key="index"
                            >
                                {{ para }}
                            </p>
                        </div>

                        <div
                            class="mt-12 flex items-end justify-between border-t border-slate-100 pt-8"
                        >
                            <div>
                                <p
                                    class="text-sm font-bold tracking-widest text-slate-400 uppercase"
                                >
                                    Sincerely,
                                </p>
                                <p
                                    class="mt-2 font-serif text-3xl text-slate-900"
                                >
                                    {{ principalData.name }}
                                </p>
                                <p class="text-sm font-semibold text-slate-500">
                                    {{ principalData.title }}
                                </p>
                            </div>

                            <div class="h-16 w-16 opacity-20">
                                <BookOpen
                                    class="h-full w-full text-slate-900"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
