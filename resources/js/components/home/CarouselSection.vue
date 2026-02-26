<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue';
import type { CarouselSlide } from '@/types';

const props = defineProps<{
    slides?: CarouselSlide[] | null;
}>();

const defaultSlides: CarouselSlide[] = [
    {
        image: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070&auto=format&fit=crop',
        title: 'Shaping Future Leaders',
        description:
            'Empowering students with knowledge and values for a brighter tomorrow.',
    },
    {
        image: 'https://images.unsplash.com/photo-1523050854058-8df90110c476?q=80&w=2071&auto=format&fit=crop',
        title: 'Excellence in Education',
        description:
            'A tradition of academic achievement and holistic development.',
    },
    {
        image: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=2070&auto=format&fit=crop',
        title: 'Modern Learning Environment',
        description:
            'State-of-the-art facilities designed for 21st century education.',
    },
];

const heroImages = computed(() =>
    props.slides && props.slides.length > 0 ? props.slides : defaultSlides,
);

const currentIndex = ref(0);
let interval: ReturnType<typeof setInterval>;

function next() {
    currentIndex.value = (currentIndex.value + 1) % heroImages.value.length;
}

function prev() {
    currentIndex.value =
        (currentIndex.value - 1 + heroImages.value.length) %
        heroImages.value.length;
}

function goTo(index: number) {
    currentIndex.value = index;
}

onMounted(() => {
    interval = setInterval(next, 5000);
});

onUnmounted(() => {
    clearInterval(interval);
});
</script>

<template>
    <section class="relative h-[70vh] w-full overflow-hidden md:h-[80vh]">
        <!-- Images -->
        <div
            v-for="(slide, index) in heroImages"
            :key="index"
            class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
            :class="
                index === currentIndex ? 'z-10 opacity-100' : 'z-0 opacity-0'
            "
        >
            <img
                :src="
                    slide.image.startsWith('http')
                        ? slide.image
                        : `/storage/${slide.image}`
                "
                :alt="slide.title"
                class="h-full w-full object-cover"
            />
            <!-- Gradient overlay -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"
            ></div>
        </div>

        <!-- Text overlay -->
        <div class="absolute inset-0 z-20 flex items-end pb-24 md:pb-32">
            <div class="mx-auto w-full max-w-7xl px-6">
                <transition
                    enter-active-class="transition-all duration-700 ease-out"
                    enter-from-class="translate-y-4 opacity-0"
                    enter-to-class="translate-y-0 opacity-100"
                    leave-active-class="transition-all duration-300 ease-in"
                    leave-from-class="translate-y-0 opacity-100"
                    leave-to-class="-translate-y-4 opacity-0"
                    mode="out-in"
                >
                    <div :key="currentIndex" class="max-w-2xl">
                        <h1
                            class="mb-4 text-4xl font-extrabold tracking-tight text-white drop-shadow-lg md:text-6xl"
                        >
                            {{ heroImages[currentIndex].title }}
                        </h1>
                        <p
                            v-if="heroImages[currentIndex].description"
                            class="text-lg text-white/90 drop-shadow md:text-xl"
                        >
                            {{ heroImages[currentIndex].description }}
                        </p>
                    </div>
                </transition>
            </div>
        </div>

        <!-- Navigation Arrows -->
        <button
            @click="prev"
            class="absolute top-1/2 left-4 z-30 -translate-y-1/2 rounded-full bg-white/20 p-3 text-white backdrop-blur-sm transition-all hover:bg-white/30"
            aria-label="Previous slide"
        >
            <svg
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
        </button>
        <button
            @click="next"
            class="absolute top-1/2 right-4 z-30 -translate-y-1/2 rounded-full bg-white/20 p-3 text-white backdrop-blur-sm transition-all hover:bg-white/30"
            aria-label="Next slide"
        >
            <svg
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 5l7 7-7 7"
                />
            </svg>
        </button>

        <!-- Dots -->
        <div
            class="absolute bottom-8 left-1/2 z-30 flex -translate-x-1/2 gap-2"
        >
            <button
                v-for="(_, index) in heroImages"
                :key="index"
                @click="goTo(index)"
                class="h-2 rounded-full transition-all duration-300"
                :class="
                    index === currentIndex
                        ? 'w-8 bg-white'
                        : 'w-2 bg-white/50 hover:bg-white/70'
                "
                :aria-label="`Go to slide ${index + 1}`"
            />
        </div>
    </section>
</template>
