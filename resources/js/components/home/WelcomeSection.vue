<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, GraduationCap, PhoneCall } from 'lucide-vue-next';

// Props make the component truly reusable
interface Props {
    title?: string;
    subtitle?: string;
    description?: string;
    image?: string;
}

withDefaults(defineProps<Props>(), {
    title: 'WELCOME TO OUR SCHOOL',
    subtitle: 'Shaping Futures, One Student at a Time',
    description:
        'Our School provides a nurturing environment where students are encouraged to achieve their highest potential through academic excellence and personal growth.',
    image: 'https://media.sciencephoto.com/f0/15/01/49/f0150149-800px-wm.jpg',
});
</script>

<template>
    <section
        class="relative mx-auto overflow-hidden bg-slate-50 py-16 md:py-24"
    >
        <div
            class="absolute top-0 right-0 h-96 w-96 translate-x-1/4 -translate-y-1/2 rounded-full bg-indigo-100/50 blur-3xl"
        ></div>
        <div
            class="absolute bottom-0 left-0 h-72 w-72 -translate-x-1/4 translate-y-1/2 rounded-full bg-blue-50 blur-3xl"
        ></div>

        <div class="relative z-10 container mx-auto max-w-7xl px-4">
            <div class="flex flex-col items-center gap-12 lg:flex-row">
                <div class="w-full space-y-6 lg:w-1/2">
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-4 py-2"
                    >
                        <span class="relative flex h-2 w-2">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-indigo-400 opacity-75"
                            ></span>
                            <span
                                class="relative inline-flex h-2 w-2 rounded-full bg-indigo-600"
                            ></span>
                        </span>
                        <span
                            class="text-xs font-bold tracking-widest text-indigo-700 uppercase"
                            >{{ title }}</span
                        >
                    </div>

                    <h1
                        class="text-4xl leading-[1.1] font-black text-slate-900 md:text-5xl lg:text-6xl"
                    >
                        {{ subtitle }}
                    </h1>

                    <p class="max-w-xl text-lg leading-relaxed text-slate-600">
                        {{ description }}
                    </p>

                    <div class="flex flex-wrap gap-4 pt-4">
                        <Link
                            href="/admission"
                            class="text-md flex items-center rounded-xl bg-indigo-600 px-4 py-2 font-bold text-white shadow-lg shadow-indigo-200 transition-all hover:bg-indigo-700"
                        >
                            <GraduationCap class="mr-2 h-5 w-5" />
                            ADMISSION NOW
                        </Link>

                        <Link
                            href="/about"
                            class="text-md flex items-center rounded-xl border-2 border-slate-200 px-4 py-2 font-bold text-gray-700 transition-all hover:border-indigo-600 hover:text-indigo-600"
                        >
                            ABOUT US
                        </Link>

                        <Link
                            href="/contact-us"
                            class="group flex items-center gap-2 font-bold text-slate-600 hover:text-indigo-600"
                        >
                            <PhoneCall class="h-5 w-5" />
                            CONTACT US
                            <ArrowRight
                                class="h-4 w-4 transition-transform group-hover:translate-x-1"
                            />
                        </Link>
                    </div>
                </div>

                <div class="w-full lg:w-1/2">
                    <div class="group relative">
                        <div
                            class="absolute -inset-4 rotate-3 rounded-3xl bg-gradient-to-tr from-indigo-500 to-blue-400 opacity-20 transition-transform duration-500 group-hover:rotate-1"
                        ></div>

                        <div
                            class="relative overflow-hidden rounded-2xl border-8 border-white shadow-2xl"
                        >
                            <img
                                :src="image"
                                alt="School Campus"
                                class="h-[400px] w-full object-cover"
                            />
                            <div
                                class="absolute right-6 bottom-6 left-6 flex justify-around rounded-xl bg-white/90 p-6 shadow-xl backdrop-blur-md"
                            >
                                <div class="text-center">
                                    <div
                                        class="text-2xl font-black text-indigo-600"
                                    >
                                        25+
                                    </div>
                                    <div
                                        class="text-[10px] font-bold tracking-tighter text-slate-500 uppercase"
                                    >
                                        Years Excellence
                                    </div>
                                </div>
                                <div class="w-px bg-slate-200"></div>
                                <div class="text-center">
                                    <div
                                        class="text-2xl font-black text-indigo-600"
                                    >
                                        1.2k+
                                    </div>
                                    <div
                                        class="text-[10px] font-bold tracking-tighter text-slate-500 uppercase"
                                    >
                                        Happy Students
                                    </div>
                                </div>
                                <div class="w-px bg-slate-200"></div>
                                <div class="text-center">
                                    <div
                                        class="text-2xl font-black text-indigo-600"
                                    >
                                        50+
                                    </div>
                                    <div
                                        class="text-[10px] font-bold tracking-tighter text-slate-500 uppercase"
                                    >
                                        Expert Teachers
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
