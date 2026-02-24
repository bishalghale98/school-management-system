<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { CheckCircle, XCircle, X } from 'lucide-vue-next';

const page = usePage();
const visible = ref(false);

const flash = computed(() => (page.props.flash as any) ?? {});

watch(
    () => [flash.value?.success, flash.value?.error],
    ([success, error]) => {
        if (success || error) {
            visible.value = true;
            setTimeout(() => {
                visible.value = false;
            }, 5000);
        }
    },
    { immediate: true },
);
</script>

<template>
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="translate-y-[-100%] opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-[-100%] opacity-0"
    >
        <div
            v-if="visible && (flash?.success || flash?.error)"
            class="mx-4 mt-4"
        >
            <div
                :class="[
                    'flex items-center gap-3 rounded-lg border px-4 py-3 text-sm shadow-sm',
                    flash?.success
                        ? 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-200'
                        : 'border-red-200 bg-red-50 text-red-800 dark:border-red-800 dark:bg-red-950/50 dark:text-red-200',
                ]"
            >
                <CheckCircle v-if="flash?.success" class="h-5 w-5 shrink-0" />
                <XCircle v-else class="h-5 w-5 shrink-0" />
                <span class="flex-1">{{ flash?.success || flash?.error }}</span>
                <button
                    @click="visible = false"
                    class="shrink-0 opacity-70 hover:opacity-100"
                >
                    <X class="h-4 w-4" />
                </button>
            </div>
        </div>
    </Transition>
</template>
