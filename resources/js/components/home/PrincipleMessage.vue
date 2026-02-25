<script setup lang="ts">
import { Quote } from 'lucide-vue-next';

const principalData = {
    name: 'TIKARAM PURI',
    designation: 'PRINCIPAL',
    image: 'https://ebs.edu.np/wp-content/uploads/2023/03/everest-school-principal-tikaram-puri.webp',
    paragraphs: [
        'The quality of education is closely related with the learning environment and student’s motivation. Proper policies and adequate inputs, tailored to specify conditions, can bring about effective education. New technologies stand to improve the efficiency of education through tools that enhance student’s performance and serve as new means of providing instructions and educational resources.',
        'The demands of the modern era are being pushed at ever increasing speed by extraordinary advances in technology. Guardians who anticipate these advances and best prepare their children for the future are likely to reap the utmost benefit from them. To neglect individual’s education today is to condemn him or her to mediocrity tomorrow.',
        'Education programmed on social demands, efficient faculties, real academic environment, adequate physical facilities and alertness towards the changes that are taking place rapidly at local and international levels in creation of new knowledge and development of new technologies are essential for an institution to keep itself ever updated.',
    ],
};
</script>

<template>
    <section class="overflow-hidden bg-white py-16 md:py-24">
        <div class="container mx-auto px-4 max-w-7xl">
            <div
                class="flex flex-col items-center gap-12 lg:flex-row lg:gap-20"
            >
                <div class="order-2 w-full lg:order-1 lg:w-3/5">
                    <div class="mb-4 inline-flex items-center gap-2">
                        <div class="h-1 w-12 rounded-full bg-indigo-600"></div>
                        <span
                            class="text-sm font-bold tracking-widest text-indigo-600 uppercase"
                            >Leadership</span
                        >
                    </div>

                    <h2
                        class="mb-8 text-3xl leading-tight font-black text-slate-900 md:text-4xl"
                    >
                        Message from the
                        <span class="text-indigo-600">Principal</span>
                    </h2>

                    <div class="relative">
                        <Quote
                            class="absolute -top-6 -left-8 -z-10 h-16 w-16 text-slate-100"
                        />

                        <div
                            class="space-y-6 text-lg leading-relaxed text-slate-600"
                        >
                            <p
                                v-for="(
                                    para, index
                                ) in principalData.paragraphs"
                                :key="index"
                            >
                                {{ para }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-slate-100 pt-8">
                        <p class="font-medium text-indigo-600 italic">
                            "Striving for excellence in every step of the
                            educational journey."
                        </p>
                    </div>
                </div>

                <div class="order-1 w-full lg:order-2 lg:w-2/5">
                    <div class="relative">
                        <div
                            class="absolute -right-6 -bottom-6 -z-10 hidden h-full w-full rounded-2xl border-2 border-indigo-600 md:block"
                        ></div>
                        <div
                            class="absolute -top-6 -left-6 -z-10 h-32 w-32 rounded-full bg-indigo-50"
                        ></div>

                        <div
                            class="overflow-hidden rounded-2xl bg-slate-900 shadow-2xl transition-transform duration-500 hover:scale-[1.01]"
                        >
                            <img
                                :src="principalData.image"
                                :alt="principalData.name"
                                class="h-auto w-full object-cover grayscale-[20%] transition-all duration-700 hover:grayscale-0"
                            />
                            <div class="bg-slate-900 p-6 text-center">
                                <h3
                                    class="text-2xl font-bold tracking-wide text-white"
                                >
                                    {{ principalData.name }}
                                </h3>
                                <div
                                    class="mt-1 flex items-center justify-center gap-2"
                                >
                                    <div
                                        class="h-[1px] w-8 bg-indigo-400"
                                    ></div>
                                    <span
                                        class="text-sm font-bold tracking-widest text-indigo-400 uppercase"
                                    >
                                        {{ principalData.designation }}
                                    </span>
                                    <div
                                        class="h-[1px] w-8 bg-indigo-400"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
p {
    font-family: 'Inter', sans-serif; /* Recommended for readability */
}
</style>
