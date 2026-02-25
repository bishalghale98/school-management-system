<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import {
    CheckCircle2,
    AlertCircle,
    UploadCloud,
    FileText,
    X,
    ChevronRight,
    Info,
    XCircle,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
    CardDescription,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { AdmissionSetting } from '@/types';

// ✅ shadcn-vue components
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

defineProps<{
    admissionSettings: AdmissionSetting;
}>();

const page = usePage();
const flash = computed(
    () => page.props.flash as { success?: string; error?: string },
);

const form = useForm({
    student_name: '',
    guardian_name: '',
    email: '',
    phone: '',
    address: '',
    applying_class: '', // keep string for Select
    previous_school: '',
    documents: [] as File[],
});

const fileInput = ref<HTMLInputElement | null>(null);

function handleFiles(e: Event) {
    const input = e.target as HTMLInputElement;
    if (input.files) {
        form.documents = [...form.documents, ...Array.from(input.files)];
    }
    if (fileInput.value) fileInput.value.value = '';
}

function removeFile(index: number) {
    form.documents.splice(index, 1);
}

function submit() {
    form.post('/admission', {
        forceFormData: true,
        onSuccess: () => form.reset(),
        preserveScroll: true,
    });
}

// helper for class list
const grades = Array.from({ length: 10 }, (_, i) => String(i + 1));
</script>

<template>
    <Head title="Admission Application" />
    <PublicLayout>
        <header class="border-b border-gray-100 bg-white py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div
                    class="flex flex-col justify-between gap-6 md:flex-row md:items-end"
                >
                    <div class="max-w-2xl">
                        <div
                            class="mb-4 inline-flex items-center gap-2 rounded-full bg-orange-50 px-3 py-1 text-xs font-bold tracking-wider text-orange-600 uppercase"
                        >
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="absolute inline-flex h-full w-full animate-ping rounded-full bg-orange-400 opacity-75"
                                ></span>
                                <span
                                    class="relative inline-flex h-2 w-2 rounded-full bg-orange-500"
                                ></span>
                            </span>
                            Enrollment 2024/25
                        </div>

                        <h1
                            class="text-5xl font-extrabold tracking-tighter text-black md:text-7xl"
                        >
                            Start your
                            <span class="text-gray-400">journey.</span>
                        </h1>

                        <p class="mt-6 text-xl leading-relaxed text-gray-500">
                            Join a community dedicated to excellence. Complete
                            the digital application form below to begin.
                        </p>
                    </div>

                    <div
                        :class="[
                            'inline-flex items-center gap-3 rounded-2xl px-6 py-4 ring-1 transition-all',
                            admissionSettings.is_open
                                ? 'bg-green-50/50 ring-green-100'
                                : 'bg-red-50/50 ring-red-100',
                        ]"
                    >
                        <CheckCircle2
                            v-if="admissionSettings.is_open"
                            class="h-5 w-5 text-green-600"
                        />
                        <AlertCircle v-else class="h-5 w-5 text-red-500" />
                        <span
                            :class="[
                                'text-sm font-bold tracking-tight uppercase',
                                admissionSettings.is_open
                                    ? 'text-green-700'
                                    : 'text-red-700',
                            ]"
                        >
                            Admissions are
                            {{
                                admissionSettings.is_open
                                    ? 'Currently Open'
                                    : 'Closed'
                            }}
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <main class="min-h-screen py-12">
            <div class="mx-auto max-w-7xl px-6">
                <!-- Flash success -->
                <transition
                    enter-active-class="transform transition duration-300 ease-out"
                    enter-from-class="scale-95 opacity-0"
                    enter-to-class="scale-100 opacity-100"
                >
                    <div
                        v-if="flash.success"
                        class="mb-8 flex items-center justify-between gap-3 rounded-2xl bg-black p-5 text-white shadow-xl shadow-black/10"
                    >
                        <div class="flex items-center gap-3">
                            <CheckCircle2 class="h-6 w-6 text-green-400" />
                            <p class="font-medium">{{ flash.success }}</p>
                        </div>
                    </div>
                </transition>

                <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
                    <!-- LEFT GUIDE -->
                    <aside class="space-y-8 lg:col-span-4">
                        <div class="sticky top-8 space-y-6">
                            <div
                                class="rounded-3xl border border-gray-100 bg-white p-8 shadow-sm"
                            >
                                <h3
                                    class="mb-6 flex items-center gap-2 text-lg font-bold"
                                >
                                    <Info class="h-5 w-5 text-orange-500" />
                                    Application Guide
                                </h3>

                                <div
                                    v-if="admissionSettings.content"
                                    class="prose prose-sm mb-8 text-gray-500"
                                    v-html="admissionSettings.content"
                                />

                                <ul class="space-y-4">
                                    <li
                                        v-for="(
                                            req, i
                                        ) in admissionSettings.requirements"
                                        :key="i"
                                        class="group flex items-start gap-3"
                                    >
                                        <div
                                            class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-gray-50 transition-colors group-hover:bg-green-100"
                                        >
                                            <ChevronRight
                                                class="h-3 w-3 text-gray-400 group-hover:text-green-600"
                                            />
                                        </div>
                                        <span
                                            class="text-sm leading-snug font-medium text-gray-600"
                                            >{{ req }}</span
                                        >
                                    </li>
                                </ul>
                            </div>

                            <div
                                class="rounded-3xl bg-orange-600 p-8 text-white shadow-lg shadow-orange-200"
                            >
                                <p class="text-sm font-medium opacity-80">
                                    Need help?
                                </p>
                                <p class="mt-1 text-xl leading-tight font-bold">
                                    Visit the school office for manual
                                    registration.
                                </p>
                            </div>
                        </div>
                    </aside>

                    <!-- RIGHT FORM -->
                    <div class="lg:col-span-8">
                        <div
                            v-if="admissionSettings.is_open"
                            class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm"
                        >
                            <div class="p-8 md:p-12">
                                <form
                                    @submit.prevent="submit"
                                    class="space-y-10 rounded-3xl"
                                >
                                    <!-- Personal Information -->
                                    <Card class="border-gray-100">
                                        <CardHeader class="space-y-2">
                                            <div
                                                class="flex items-center justify-between"
                                            >
                                                <div>
                                                    <CardTitle
                                                        class="text-sm tracking-widest text-gray-400 uppercase"
                                                    >
                                                        Personal Information
                                                    </CardTitle>
                                                    <CardDescription
                                                        class="text-gray-500"
                                                    >
                                                        Student and guardian
                                                        details
                                                    </CardDescription>
                                                </div>
                                                <Badge variant="secondary"
                                                    >Step 1</Badge
                                                >
                                            </div>
                                        </CardHeader>

                                        <CardContent class="space-y-6">
                                            <div
                                                class="grid gap-6 sm:grid-cols-2"
                                            >
                                                <div class="space-y-2">
                                                    <Label for="student_name"
                                                        >Student Full
                                                        Name</Label
                                                    >
                                                    <Input
                                                        id="student_name"
                                                        v-model="
                                                            form.student_name
                                                        "
                                                        placeholder="John Doe"
                                                        :aria-invalid="
                                                            !!form.errors
                                                                .student_name
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            form.errors
                                                                .student_name
                                                        "
                                                        class="text-sm text-destructive"
                                                    >
                                                        {{
                                                            form.errors
                                                                .student_name
                                                        }}
                                                    </p>
                                                </div>

                                                <div class="space-y-2">
                                                    <Label for="guardian_name"
                                                        >Guardian Name</Label
                                                    >
                                                    <Input
                                                        id="guardian_name"
                                                        v-model="
                                                            form.guardian_name
                                                        "
                                                        placeholder="Jane Doe"
                                                        :aria-invalid="
                                                            !!form.errors
                                                                .guardian_name
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            form.errors
                                                                .guardian_name
                                                        "
                                                        class="text-sm text-destructive"
                                                    >
                                                        {{
                                                            form.errors
                                                                .guardian_name
                                                        }}
                                                    </p>
                                                </div>

                                                <div class="space-y-2">
                                                    <Label for="email"
                                                        >Email Address</Label
                                                    >
                                                    <Input
                                                        id="email"
                                                        v-model="form.email"
                                                        type="email"
                                                        placeholder="email@example.com"
                                                        :aria-invalid="
                                                            !!form.errors.email
                                                        "
                                                    />
                                                    <p
                                                        v-if="form.errors.email"
                                                        class="text-sm text-destructive"
                                                    >
                                                        {{ form.errors.email }}
                                                    </p>
                                                </div>

                                                <div class="space-y-2">
                                                    <Label for="phone"
                                                        >Phone Number</Label
                                                    >
                                                    <Input
                                                        id="phone"
                                                        v-model="form.phone"
                                                        type="tel"
                                                        placeholder="+977 98..."
                                                        :aria-invalid="
                                                            !!form.errors.phone
                                                        "
                                                    />
                                                    <p
                                                        v-if="form.errors.phone"
                                                        class="text-sm text-destructive"
                                                    >
                                                        {{ form.errors.phone }}
                                                    </p>
                                                </div>

                                                <div
                                                    class="space-y-2 sm:col-span-2"
                                                >
                                                    <Label for="address"
                                                        >Residential
                                                        Address</Label
                                                    >
                                                    <Input
                                                        id="address"
                                                        v-model="form.address"
                                                        placeholder="Street, City, District"
                                                        :aria-invalid="
                                                            !!form.errors
                                                                .address
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            form.errors.address
                                                        "
                                                        class="text-sm text-destructive"
                                                    >
                                                        {{
                                                            form.errors.address
                                                        }}
                                                    </p>
                                                </div>
                                            </div>
                                        </CardContent>
                                    </Card>

                                    <!-- Academic Details -->
                                    <Card class="border-gray-100">
                                        <CardHeader class="space-y-2">
                                            <div
                                                class="flex items-center justify-between"
                                            >
                                                <div>
                                                    <CardTitle
                                                        class="text-sm tracking-widest text-gray-400 uppercase"
                                                    >
                                                        Academic Details
                                                    </CardTitle>
                                                    <CardDescription
                                                        class="text-gray-500"
                                                    >
                                                        Class and previous
                                                        school
                                                    </CardDescription>
                                                </div>
                                                <Badge variant="secondary"
                                                    >Step 2</Badge
                                                >
                                            </div>
                                        </CardHeader>

                                        <CardContent class="space-y-6">
                                            <div
                                                class="grid gap-6 sm:grid-cols-2"
                                            >
                                                <div class="space-y-2">
                                                    <Label
                                                        >Applying for
                                                        Class</Label
                                                    >

                                                    <!-- Select -->
                                                    <Select
                                                        v-model="
                                                            form.applying_class
                                                        "
                                                    >
                                                        <SelectTrigger
                                                            :aria-invalid="
                                                                !!form.errors
                                                                    .applying_class
                                                            "
                                                        >
                                                            <SelectValue
                                                                placeholder="Select a class"
                                                            />
                                                        </SelectTrigger>
                                                        <SelectContent>
                                                            <SelectItem
                                                                v-for="g in grades"
                                                                :key="g"
                                                                :value="g"
                                                            >
                                                                Grade {{ g }}
                                                            </SelectItem>
                                                        </SelectContent>
                                                    </Select>

                                                    <p
                                                        v-if="
                                                            form.errors
                                                                .applying_class
                                                        "
                                                        class="text-sm text-destructive"
                                                    >
                                                        {{
                                                            form.errors
                                                                .applying_class
                                                        }}
                                                    </p>
                                                </div>

                                                <div class="space-y-2">
                                                    <Label for="previous_school"
                                                        >Previous School</Label
                                                    >
                                                    <Input
                                                        id="previous_school"
                                                        v-model="
                                                            form.previous_school
                                                        "
                                                        placeholder="Name of previous institution"
                                                        :aria-invalid="
                                                            !!form.errors
                                                                .previous_school
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            form.errors
                                                                .previous_school
                                                        "
                                                        class="text-sm text-destructive"
                                                    >
                                                        {{
                                                            form.errors
                                                                .previous_school
                                                        }}
                                                    </p>
                                                </div>
                                            </div>
                                        </CardContent>
                                    </Card>

                                    <!-- Documents -->
                                    <Card class="border-gray-100">
                                        <CardHeader class="space-y-2">
                                            <div
                                                class="flex items-center justify-between"
                                            >
                                                <div>
                                                    <CardTitle
                                                        class="text-sm tracking-widest text-gray-400 uppercase"
                                                    >
                                                        Documents & Attachments
                                                    </CardTitle>
                                                    <CardDescription
                                                        class="text-gray-500"
                                                    >
                                                        Birth certificate,
                                                        report cards (PDF/JPG)
                                                    </CardDescription>
                                                </div>
                                                <Badge variant="secondary"
                                                    >Step 3</Badge
                                                >
                                            </div>
                                        </CardHeader>

                                        <CardContent class="space-y-6">
                                            <button
                                                type="button"
                                                class="group relative w-full cursor-pointer rounded-2xl border-2 border-dashed border-gray-200 bg-white p-10 text-center transition-all hover:border-black hover:bg-gray-50"
                                                @click="fileInput?.click()"
                                            >
                                                <UploadCloud
                                                    class="mx-auto mb-4 h-10 w-10 text-gray-300 transition-colors group-hover:text-black"
                                                />
                                                <p class="text-base font-bold">
                                                    Upload supporting documents
                                                </p>
                                                <p
                                                    class="mt-1 text-sm text-gray-500"
                                                >
                                                    Birth Certificate, Report
                                                    Cards (PDF or JPG)
                                                </p>

                                                <input
                                                    ref="fileInput"
                                                    type="file"
                                                    multiple
                                                    class="hidden"
                                                    @change="handleFiles"
                                                />
                                            </button>

                                            <div
                                                v-if="form.documents.length"
                                                class="space-y-3"
                                            >
                                                <div
                                                    v-for="(
                                                        file, i
                                                    ) in form.documents"
                                                    :key="i"
                                                    class="flex items-center justify-between rounded-xl border border-gray-100 bg-gray-50 p-4"
                                                >
                                                    <div
                                                        class="flex items-center gap-3"
                                                    >
                                                        <div
                                                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white"
                                                        >
                                                            <FileText
                                                                class="h-5 w-5 text-gray-500"
                                                            />
                                                        </div>

                                                        <div>
                                                            <p
                                                                class="max-w-[220px] truncate text-sm font-bold"
                                                            >
                                                                {{ file.name }}
                                                            </p>
                                                            <p
                                                                class="text-xs text-gray-500 uppercase"
                                                            >
                                                                {{
                                                                    (
                                                                        file.size /
                                                                        1024 /
                                                                        1024
                                                                    ).toFixed(2)
                                                                }}
                                                                MB
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <Button
                                                        type="button"
                                                        size="icon"
                                                        variant="ghost"
                                                        class="rounded-full hover:bg-red-50 hover:text-red-500"
                                                        @click="removeFile(i)"
                                                    >
                                                        <X class="h-5 w-5" />
                                                    </Button>
                                                </div>
                                            </div>

                                            <p
                                                v-if="form.errors.documents"
                                                class="text-sm text-destructive"
                                            >
                                                {{ form.errors.documents }}
                                            </p>
                                        </CardContent>
                                    </Card>

                                    <!-- Footer -->
                                    <div class="space-y-6">
                                        <Separator class="bg-gray-100" />

                                        <div
                                            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                                        >
                                            <p
                                                class="max-w-[280px] text-xs text-gray-500"
                                            >
                                                By submitting, you agree to the
                                                school's terms of admission and
                                                privacy policy.
                                            </p>

                                            <Button
                                                type="submit"
                                                size="lg"
                                                class="h-14 rounded-full bg-black px-10 text-sm font-bold text-white hover:bg-gray-800"
                                                :disabled="form.processing"
                                            >
                                                <span>{{
                                                    form.processing
                                                        ? 'Submitting...'
                                                        : 'Send Application'
                                                }}</span>
                                                <ChevronRight
                                                    class="ml-2 h-4 w-4"
                                                />
                                            </Button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- CLOSED -->
                        <div
                            v-else
                            class="rounded-3xl border border-gray-100 bg-white p-20 text-center shadow-sm"
                        >
                            <div
                                class="mb-6 inline-flex h-20 w-20 items-center justify-center rounded-full bg-red-50 text-red-500"
                            >
                                <XCircle class="h-10 w-10" />
                            </div>
                            <h2
                                class="text-3xl font-black tracking-tight text-gray-900"
                            >
                                Admissions are closed.
                            </h2>
                            <p class="mt-4 text-gray-500">
                                We are currently not accepting new applications.
                                Please check back later or contact the
                                administration for more information.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>
