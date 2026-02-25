<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {
    Download,
    FileText,
    BookOpen,
    ImageIcon,
    Filter,
} from 'lucide-vue-next';
import { motion } from 'motion-v';
import { ref, watch } from 'vue';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table';
import PublicLayout from '@/layouts/PublicLayout.vue';

interface Download {
    id: number;
    title: string;
    description: string;
    type: string;
    icon: string;
    size: string;
}

defineProps<{
    downloads: PaginatedData<DownloadType>;
    categories: DownloadCategory[];
    filters: { category?: string };
}>();


// const downloads = ref<Download[]>([
//     {
//         id: 1,
//         title: 'Book List 2024',
//         description: 'Complete list of required textbooks for all grades',
//         type: 'PDF',
//         icon: 'BookOpen',
//         size: '245 KB',
//     },
//     {
//         id: 2,
//         title: 'Copy List 2024',
//         description: 'List of notebooks and stationery required for students',
//         type: 'PDF',
//         icon: 'FileText',
//         size: '180 KB',
//     },
//     {
//         id: 3,
//         title: 'School Brochure',
//         description:
//             'Comprehensive information about our school facilities and programs',
//         type: 'PDF',
//         icon: 'ImageIcon',
//         size: '2.1 MB',
//     },
//     {
//         id: 4,
//         title: 'Admission Form 2024',
//         description: 'Application form for new student admissions',
//         type: 'PDF',
//         icon: 'FileText',
//         size: '320 KB',
//     },
//     {
//         id: 5,
//         title: 'Academic Calendar 2024',
//         description:
//             'Complete academic calendar with important dates and events',
//         type: 'PDF',
//         icon: 'FileText',
//         size: '195 KB',
//     },
//     {
//         id: 6,
//         title: 'Fee Structure 2024',
//         description: 'Detailed fee structure for all grades and programs',
//         type: 'PDF',
//         icon: 'FileText',
//         size: '150 KB',
//     },
// ]);

// Helper function to get the correct icon component
const getIconComponent = (iconName: string) => {
    const icons: Record<string, any> = {
        BookOpen,
        FileText,
        ImageIcon,
    };
    return icons[iconName] || FileText;
};

// Animation variants
const containerVariants = {
    hidden: { opacity: 0, y: 20 },
    visible: {
        opacity: 1,
        y: 0,
        transition: {
            staggerChildren: 0.15,
        },
    },
};

const itemVariants = {
    hidden: { opacity: 0, y: 20, scale: 0.95 },
    visible: { opacity: 1, y: 0, scale: 1, transition: { duration: 0.4 } },
};

// Filter functionality (if needed)
const selectedCategory = ref('');
// const categories = ref([
//     { id: 1, name: 'PDF', count: 6 },
//     { id: 2, name: 'Documents', count: 4 },
//     { id: 3, name: 'Forms', count: 2 },
// ]);

watch(selectedCategory, (val) => {
    // Handle category filtering logic here
    console.log('Selected category:', val);
});
</script>

<template>
    <Head title="Downloads" />
    <PublicLayout>
        <motion.div
            class="py-16"
            :initial="containerVariants.hidden"
            :animate="containerVariants.visible"
            :variants="containerVariants"
        >
            <div class="container mx-auto px-4">
                <!-- Page Header -->
                <motion.div class="mb-16 text-center" :variants="itemVariants">
                    <h1 class="mb-4 text-4xl font-bold text-slate-800">
                        Downloads
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-slate-600">
                        Download important documents, forms, and resources for
                        students and parents.
                    </p>
                </motion.div>

                <!-- Category Filter -->
                <motion.div
                    class="mb-8 flex flex-wrap items-center gap-2"
                    :variants="itemVariants"
                >
                    <Filter class="h-4 w-4 text-gray-400" />
                    <button
                        @click="selectedCategory = ''"
                        :class="[
                            'rounded-full px-4 py-1.5 text-sm font-medium transition',
                            !selectedCategory
                                ? 'bg-green-600 text-white'
                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                        ]"
                    >
                        All
                    </button>
                    <button
                        v-for="cat in categories"
                        :key="cat.id"
                        @click="selectedCategory = String(cat.id)"
                        :class="[
                            'rounded-full px-4 py-1.5 text-sm font-medium transition',
                            selectedCategory === String(cat.id)
                                ? 'bg-green-600 text-white'
                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                        ]"
                    >
                        {{ cat.name }}
                        <span class="ml-1 text-xs opacity-70"
                            >({{ cat.count }})</span
                        >
                    </button>
                </motion.div>

                <!-- Downloads Table -->
                <motion.div :variants="itemVariants">
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-2xl text-slate-800"
                                >Available Downloads</CardTitle
                            >
                        </CardHeader>
                        <CardContent>
                            <div class="overflow-x-auto">
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead class="w-12"></TableHead>
                                            <TableHead>Title</TableHead>
                                            <TableHead
                                                class="hidden md:table-cell"
                                                >Description</TableHead
                                            >
                                            <TableHead
                                                class="hidden sm:table-cell"
                                                >Type</TableHead
                                            >
                                            <TableHead
                                                class="hidden sm:table-cell"
                                                >Size</TableHead
                                            >
                                            <TableHead class="text-right"
                                                >Action</TableHead
                                            >
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        <motion.tr
                                            v-for="item in downloads"
                                            :key="item.id"
                                            :variants="itemVariants"
                                            class="transition-shadow duration-200"
                                            :style="{ boxShadow: 'none' }"
                                            @mouseenter="
                                                (
                                                    $event.target as HTMLElement
                                                ).style.boxShadow =
                                                    '0 5px 10px rgba(0,0,0,0.08)'
                                            "
                                            @mouseleave="
                                                (
                                                    $event.target as HTMLElement
                                                ).style.boxShadow = 'none'
                                            "
                                        >
                                            <TableCell>
                                                <div
                                                    class="flex h-8 w-8 items-center justify-center rounded bg-slate-100"
                                                >
                                                    <component
                                                        :is="
                                                            getIconComponent(
                                                                item.icon,
                                                            )
                                                        "
                                                        class="h-4 w-4 text-slate-600"
                                                    />
                                                </div>
                                            </TableCell>
                                            <TableCell class="font-medium">{{
                                                item.title
                                            }}</TableCell>
                                            <TableCell
                                                class="hidden text-slate-600 md:table-cell"
                                                >{{
                                                    item.description
                                                }}</TableCell
                                            >
                                            <TableCell
                                                class="hidden sm:table-cell"
                                            >
                                                <span
                                                    class="inline-flex items-center rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-800"
                                                >
                                                    {{ item.type }}
                                                </span>
                                            </TableCell>
                                            <TableCell
                                                class="hidden text-slate-600 sm:table-cell"
                                                >{{ item.size }}</TableCell
                                            >
                                            <TableCell class="text-right">
                                                <Button
                                                    size="sm"
                                                    class="bg-slate-800 hover:bg-slate-700"
                                                >
                                                    <Download
                                                        class="mr-2 h-4 w-4"
                                                    />
                                                    Download
                                                </Button>
                                            </TableCell>
                                        </motion.tr>
                                    </TableBody>
                                </Table>
                            </div>
                        </CardContent>
                    </Card>
                </motion.div>

                <!-- Additional Information -->
                <motion.div
                    class="mt-12 grid gap-8 md:grid-cols-2"
                    :variants="itemVariants"
                >
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-xl text-slate-800"
                                >Important Notice</CardTitle
                            >
                        </CardHeader>
                        <CardContent>
                            <ul class="space-y-2 text-slate-600">
                                <li>
                                    • All documents are in PDF format and
                                    require Adobe Reader or similar software
                                </li>
                                <li>
                                    • Please ensure you have the latest version
                                    of the documents
                                </li>
                                <li>
                                    • For any issues with downloads, contact our
                                    office
                                </li>
                                <li>
                                    • Some documents may require parent/guardian
                                    signature
                                </li>
                            </ul>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle class="text-xl text-slate-800"
                                >Need Help?</CardTitle
                            >
                        </CardHeader>
                        <CardContent>
                            <p class="mb-4 text-slate-600">
                                If you're having trouble downloading any
                                document or need additional information, please
                                don't hesitate to contact us.
                            </p>
                            <div class="space-y-2 text-sm text-slate-600">
                                <p><strong>Phone:</strong> +977-021-123456</p>
                                <p><strong>Email:</strong> info@xyz.edu.np</p>
                                <p>
                                    <strong>Office Hours:</strong> Sunday -
                                    Friday, 9:00 AM - 4:00 PM
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </motion.div>
            </div>
        </motion.div>
    </PublicLayout>
</template>

<style scoped>
/* Add any custom styles here if needed */
</style>
