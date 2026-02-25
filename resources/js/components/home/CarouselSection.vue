<script setup lang="ts">
import { ref, onBeforeUnmount } from 'vue';
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselNext,
    CarouselPrevious,
} from '@/components/ui/carousel';
import { type CarouselApi } from '@/components/ui/carousel';

const api = ref<CarouselApi | null>(null);
const current = ref(0);
const count = ref(0);

let autoSlideInterval: number | null = null;
const AUTO_SLIDE_DELAY = 4000; // 4 seconds

const startAutoSlide = () => {
    stopAutoSlide();
    autoSlideInterval = window.setInterval(() => {
        api.value?.scrollNext();
    }, AUTO_SLIDE_DELAY);
};

const stopAutoSlide = () => {
    if (autoSlideInterval) {
        clearInterval(autoSlideInterval);
        autoSlideInterval = null;
    }
};

// Carousel init
const onInit = (eventApi: CarouselApi) => {
    api.value = eventApi;
    count.value = eventApi.scrollSnapList().length;
    current.value = eventApi.selectedScrollSnap() + 1;

    eventApi.on('select', () => {
        current.value = eventApi.selectedScrollSnap() + 1;
    });

    startAutoSlide();
};

onBeforeUnmount(() => {
    stopAutoSlide();
});

// Images
const heroImages = [
    {
        id: 1,
        src: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070&auto=format&fit=crop',
        alt: 'Mountain landscape at sunrise',
    },
    {
        id: 2,
        src: 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?q=80&w=1948&auto=format&fit=crop',
        alt: 'Foggy forest with tall trees',
    },
    {
        id: 3,
        src: 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=1960&auto=format&fit=crop',
        alt: 'Sunlight through dense forest',
    },
    {
        id: 4,
        src: 'https://images.unsplash.com/photo-1426604966841-d7adac402b38?q=80&w=2070&auto=format&fit=crop',
        alt: 'Green valley with river',
    },
    {
        id: 5,
        src: 'https://images.unsplash.com/photo-1505765050516-f72dcac9c60e?q=80&w=2070&auto=format&fit=crop',
        alt: 'Northern lights over mountains',
    },
];
</script>

<template>
    <section class="relative h-screen w-full overflow-hidden">
        <!-- Carousel Component -->
        <Carousel
            class="absolute inset-0"
            :opts="{ loop: true }"
            @init-api="onInit"
            @mouseenter="stopAutoSlide"
            @mouseleave="startAutoSlide"
        >
            <!-- Carousel Content -->
            <CarouselContent class="-ml-0">
                <CarouselItem
                    v-for="image in heroImages"
                    :key="image.id"
                    class="basis-full pl-0"
                >
                    <div class="relative h-screen w-full">
                        <!-- Image with overlay -->
                        <img
                            :src="image.src"
                            :alt="image.alt"
                            class="absolute inset-0 h-full w-full object-cover"
                        />
                        <!-- Gradient overlay for text contrast -->
                        <div class="absolute inset-0 bg-black/30" />

                        <!-- Text Overlay Example -->
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center text-white"
                        >
                            <h1
                                class="mb-4 text-4xl font-bold drop-shadow-lg md:text-6xl"
                            >
                                {{ image.alt }}
                            </h1>
                            <p
                                class="max-w-2xl text-lg drop-shadow-md md:text-xl"
                            >
                                Experience the beauty of nature with our curated
                                collection.
                            </p>
                            <button
                                class="hover:bg-opacity-90 mt-8 rounded-full bg-white px-8 py-3 font-semibold text-black transition"
                            >
                                Explore Now
                            </button>
                        </div>
                    </div>
                </CarouselItem>
            </CarouselContent>

            <!-- Carousel Controls -->
            <CarouselPrevious
                class="absolute top-1/2 left-4 z-10 -translate-y-1/2 border-white/50 bg-white/20 text-white hover:bg-white/40"
            />
            <CarouselNext
                class="absolute top-1/2 right-4 z-10 -translate-y-1/2 border-white/50 bg-white/20 text-white hover:bg-white/40"
            />

            <!-- Optional Slide Indicators -->
            <div
                class="absolute bottom-8 left-1/2 z-10 flex -translate-x-1/2 gap-2"
            >
                <button
                    v-for="index in count"
                    :key="index"
                    class="h-2 w-2 rounded-full transition-all"
                    :class="current === index ? 'w-4 bg-white' : 'bg-white/50'"
                    @click="api?.scrollTo(index - 1)"
                />
            </div>
        </Carousel>
    </section>
</template>
