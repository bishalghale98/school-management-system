<template>
    <section id="overview" class="relative scroll-mt-20 overflow-hidden ">
        <!-- Enhanced Background Elements -->
        <div
            class="absolute top-0 right-0 -z-10 h-96 w-96 rounded-full bg-gradient-to-bl from-school-100/50 to-school-200/50 blur-3xl"
        ></div>
        <div
            class="absolute bottom-0 left-0 -z-10 h-96 w-96 rounded-full bg-gradient-to-tr from-blue-100/50 to-cyan-100/50 blur-3xl"
        ></div>

        <!-- Subtle Pattern Overlay -->
        <div
            class="absolute inset-0 -z-10 opacity-5"
            style="
                background-image: radial-gradient(#0f766e 1px, transparent 1px);
                background-size: 30px 30px;
            "
        ></div>

        <div class="grid items-center gap-12 lg:grid-cols-12">
            <!-- Content Section -->
            <div class="order-2 lg:order-1 lg:col-span-7">
                <div class="relative">
                    <!-- Enhanced Badge -->
                    <span
                        class="mb-6 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-school-600 to-school-700 px-5 py-2 text-sm font-semibold tracking-wide text-white shadow-lg"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        Since 1998
                    </span>

                    <!-- Enhanced Headline -->
                    <h2
                        class="mb-6 text-4xl font-extrabold tracking-tight text-slate-400 md:text-5xl lg:text-6xl"
                    >
                        Nurturing Minds for
                        <span class="relative inline-block">
                            <span
                                class="relative z-10 bg-gradient-to-r from-school-600 to-school-700 bg-clip-text text-transparent"
                                >25+ Years</span
                            >
                            <svg
                                class="absolute -bottom-2 left-0 h-3 w-full"
                                viewBox="0 0 100 10"
                                preserveAspectRatio="none"
                            >
                                <path
                                    d="M0,5 Q25,0 50,5 T100,5"
                                    stroke="#059669"
                                    stroke-width="2"
                                    fill="none"
                                    stroke-opacity="0.3"
                                />
                            </svg>
                        </span>
                    </h2>

                    <!-- Enhanced Quote -->
                    <div class="mb-8 space-y-6 text-lg leading-relaxed">
                        <div
                            class="relative rounded-2xl bg-gradient-to-r from-school-50 to-school-100 p-6 shadow-inner"
                        >
                            <svg
                                class="absolute top-4 left-4 h-8 w-8 text-school-200"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"
                                />
                            </svg>
                            <p
                                class="relative z-10 pl-8 text-lg font-medium text-school-800"
                            >
                                "XYZ School has been a cornerstone of quality
                                education in Biratnagar, Morang, shaping the
                                leaders of tomorrow."
                            </p>
                        </div>

                        <p class="leading-relaxed text-slate-400">
                            Our school offers education from Grade 1 to Grade
                            12, following the national curriculum while
                            incorporating modern teaching methodologies. We
                            don't just teach; we inspire curiosity and foster
                            character development through innovative learning
                            approaches and holistic development programs.
                        </p>
                    </div>

                    <!-- Enhanced Stats Section -->
                    <div
                        class="mt-12 grid grid-cols-2 gap-8 rounded-2xl bg-white/80 p-8 shadow-lg backdrop-blur-sm sm:grid-cols-3"
                    >
                        <div class="text-center sm:text-left">
                            <p
                                class="bg-gradient-to-r from-school-600 to-school-700 bg-clip-text text-3xl font-bold text-transparent"
                            >
                                25+
                            </p>
                            <p class="mt-1 text-sm font-medium text-slate-500">
                                Years of Excellence
                            </p>
                            <div
                                class="mt-2 h-1 w-full rounded-full bg-gradient-to-r from-school-200 to-school-300"
                            ></div>
                        </div>
                        <div class="text-center sm:text-left">
                            <p
                                class="bg-gradient-to-r from-school-600 to-school-700 bg-clip-text text-3xl font-bold text-transparent"
                            >
                                1.2k+
                            </p>
                            <p class="mt-1 text-sm font-medium text-slate-500">
                                Active Students
                            </p>
                            <div
                                class="mt-2 h-1 w-full rounded-full bg-gradient-to-r from-school-200 to-school-300"
                            ></div>
                        </div>
                        <div
                            class="col-span-2 text-center sm:col-span-1 sm:text-left"
                        >
                            <p
                                class="bg-gradient-to-r from-school-600 to-school-700 bg-clip-text text-3xl font-bold text-transparent"
                            >
                                100%
                            </p>
                            <p class="mt-1 text-sm font-medium text-slate-500">
                                SEE/SLC Success
                            </p>
                            <div
                                class="mt-2 h-1 w-full rounded-full bg-gradient-to-r from-school-200 to-school-300"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            <div class="relative order-1 lg:order-2 lg:col-span-5">
                <!-- Main Image Card -->
                <div class="group relative">
                    <div
                        class="absolute -inset-1 rounded-[3rem] bg-gradient-to-r from-school-600 to-school-700 opacity-20 blur transition duration-1000 group-hover:opacity-30"
                    ></div>
                    <div
                        class="relative overflow-hidden rounded-[2.5rem] shadow-2xl transition-all duration-700 group-hover:scale-[1.02] group-hover:shadow-school-200/50"
                    >
                        <img
                            src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop"
                            alt="Students in Classroom"
                            class="h-[500px] w-full object-cover transition-transform duration-700 group-hover:scale-110"
                        />
                        <!-- Overlay Gradient -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-school-900/20 via-transparent to-transparent"
                        ></div>
                    </div>
                </div>

                <!-- Enhanced Floating Card -->
                <div
                    class="animate-bounce-slow absolute -bottom-6 -left-6 z-20 hidden rounded-2xl bg-white p-5 shadow-2xl shadow-school-200/50 sm:block lg:-left-10"
                >
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-school-600 to-school-700 text-white shadow-lg"
                        >
                            <svg
                                class="h-7 w-7"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-base font-bold text-slate-800">
                                Government Approved
                            </p>
                            <p class="text-sm font-medium text-school-600">
                                National Curriculum Standards
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div
                    class="absolute -top-8 -right-8 h-32 w-32 rounded-full bg-gradient-to-br from-school-200 to-school-300 opacity-30 blur-2xl"
                ></div>
                <div
                    class="absolute -right-8 -bottom-8 h-32 w-32 rounded-full bg-gradient-to-tl from-blue-200 to-cyan-200 opacity-30 blur-2xl"
                ></div>

                <!-- Floating Shapes -->
                <div
                    class="absolute top-20 -right-4 h-16 w-16 animate-pulse rounded-full bg-gradient-to-r from-school-400 to-school-500 opacity-20 blur-lg"
                ></div>
                <div
                    class="absolute bottom-20 -left-4 h-20 w-20 animate-pulse rounded-full bg-gradient-to-r from-blue-400 to-cyan-400 opacity-20 blur-lg delay-1000"
                ></div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@keyframes bounce-slow {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}
.animate-bounce-slow {
    animation: bounce-slow 3s infinite;
}
</style>
