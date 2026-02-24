<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import {
    GraduationCap,
    CheckCircle,
    XCircle,
    Upload,
    FileText,
    X,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { AdmissionSetting } from '@/types';

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
    applying_class: '',
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
    });
}
</script>

<template>
    <Head title="Admission" />
    <PublicLayout>
        <!-- Header -->
        <section
            class="bg-gradient-to-br from-orange-800 to-amber-900 py-16 text-white"
        >
            <div class="mx-auto max-w-7xl px-4">
                <h1 class="text-3xl font-bold sm:text-4xl">Admission</h1>
                <p class="mt-2 text-orange-200">Join our school community</p>
            </div>
        </section>

        <div class="mx-auto max-w-4xl px-4 py-10">
            <!-- Flash -->
            <div
                v-if="flash.success"
                class="mb-6 flex items-center gap-3 rounded-xl bg-green-50 p-4 text-green-700 ring-1 ring-green-200"
            >
                <CheckCircle class="h-5 w-5 shrink-0" />
                <p class="text-sm font-medium">{{ flash.success }}</p>
            </div>
            <div
                v-if="flash.error"
                class="mb-6 flex items-center gap-3 rounded-xl bg-red-50 p-4 text-red-700 ring-1 ring-red-200"
            >
                <XCircle class="h-5 w-5 shrink-0" />
                <p class="text-sm font-medium">{{ flash.error }}</p>
            </div>

            <!-- Status -->
            <div
                :class="[
                    'mb-8 rounded-xl p-6 ring-1',
                    admissionSettings.is_open
                        ? 'bg-green-50 ring-green-200'
                        : 'bg-red-50 ring-red-200',
                ]"
            >
                <div class="flex items-center gap-3">
                    <CheckCircle
                        v-if="admissionSettings.is_open"
                        class="h-6 w-6 text-green-600"
                    />
                    <XCircle v-else class="h-6 w-6 text-red-500" />
                    <h2
                        class="text-lg font-semibold"
                        :class="
                            admissionSettings.is_open
                                ? 'text-green-800'
                                : 'text-red-800'
                        "
                    >
                        Admission is
                        {{ admissionSettings.is_open ? 'Open' : 'Closed' }}
                    </h2>
                </div>
            </div>

            <!-- Content / Requirements -->
            <div
                v-if="admissionSettings.content"
                class="prose prose-sm mb-8 max-w-none text-gray-600"
                v-html="admissionSettings.content"
            />

            <div
                v-if="admissionSettings.requirements?.length"
                class="mb-8 rounded-xl border border-gray-200 bg-gray-50 p-6"
            >
                <h3 class="mb-3 text-base font-semibold text-gray-900">
                    Requirements
                </h3>
                <ul class="space-y-2">
                    <li
                        v-for="(req, i) in admissionSettings.requirements"
                        :key="i"
                        class="flex items-start gap-2 text-sm text-gray-600"
                    >
                        <CheckCircle
                            class="mt-0.5 h-4 w-4 shrink-0 text-green-500"
                        />
                        {{ req }}
                    </li>
                </ul>
            </div>

            <!-- Form -->
            <div
                v-if="admissionSettings.is_open"
                class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100"
            >
                <h2
                    class="mb-6 flex items-center gap-2 text-xl font-bold text-gray-900"
                >
                    <GraduationCap class="h-6 w-6 text-orange-600" />
                    Application Form
                </h2>
                <form @submit.prevent="submit" class="space-y-5">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700"
                                >Student Name *</label
                            >
                            <input
                                v-model="form.student_name"
                                type="text"
                                required
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            />
                            <p
                                v-if="form.errors.student_name"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ form.errors.student_name }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700"
                                >Guardian Name *</label
                            >
                            <input
                                v-model="form.guardian_name"
                                type="text"
                                required
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            />
                            <p
                                v-if="form.errors.guardian_name"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ form.errors.guardian_name }}
                            </p>
                        </div>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700"
                                >Email</label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            />
                            <p
                                v-if="form.errors.email"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ form.errors.email }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700"
                                >Phone *</label
                            >
                            <input
                                v-model="form.phone"
                                type="tel"
                                required
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            />
                            <p
                                v-if="form.errors.phone"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ form.errors.phone }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                            >Address</label
                        >
                        <textarea
                            v-model="form.address"
                            rows="2"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                        />
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700"
                                >Applying Class *</label
                            >
                            <input
                                v-model="form.applying_class"
                                type="text"
                                required
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            />
                            <p
                                v-if="form.errors.applying_class"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ form.errors.applying_class }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700"
                                >Previous School</label
                            >
                            <input
                                v-model="form.previous_school"
                                type="text"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            />
                        </div>
                    </div>

                    <!-- Documents -->
                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                            >Documents</label
                        >
                        <div
                            @click="fileInput?.click()"
                            class="cursor-pointer rounded-lg border-2 border-dashed border-gray-300 p-6 text-center transition hover:border-blue-400 hover:bg-blue-50/50"
                        >
                            <Upload
                                class="mx-auto mb-2 h-8 w-8 text-gray-400"
                            />
                            <p class="text-sm text-gray-500">
                                Click to upload documents
                            </p>
                            <p class="text-xs text-gray-400">
                                PDF, JPG, PNG up to 5MB each
                            </p>
                        </div>
                        <input
                            ref="fileInput"
                            type="file"
                            multiple
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="hidden"
                            @change="handleFiles"
                        />
                        <div
                            v-if="form.documents.length"
                            class="mt-3 space-y-2"
                        >
                            <div
                                v-for="(file, i) in form.documents"
                                :key="i"
                                class="flex items-center gap-3 rounded-lg bg-gray-50 p-2.5"
                            >
                                <FileText class="h-4 w-4 text-gray-400" />
                                <span
                                    class="flex-1 truncate text-sm text-gray-600"
                                    >{{ file.name }}</span
                                >
                                <button
                                    @click="removeFile(i)"
                                    type="button"
                                    class="text-gray-400 hover:text-red-500"
                                >
                                    <X class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center gap-2 rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-700 disabled:opacity-50"
                    >
                        <GraduationCap class="h-5 w-5" />
                        {{
                            form.processing
                                ? 'Submitting...'
                                : 'Submit Application'
                        }}
                    </button>
                </form>
            </div>
        </div>
    </PublicLayout>
</template>
