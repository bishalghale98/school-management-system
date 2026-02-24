<script setup lang="ts">
import Image from '@tiptap/extension-image';
import Link from '@tiptap/extension-link';
import Placeholder from '@tiptap/extension-placeholder';
import TextAlign from '@tiptap/extension-text-align';
import Underline from '@tiptap/extension-underline';
import StarterKit from '@tiptap/starter-kit';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import axios from 'axios';
import {
    Bold,
    Italic,
    Underline as UnderlineIcon,
    Strikethrough,
    List,
    ListOrdered,
    Quote,
    Code,
    Heading1,
    Heading2,
    Heading3,
    AlignLeft,
    AlignCenter,
    AlignRight,
    Link as LinkIcon,
    Undo2,
    Redo2,
    Minus,
    Loader2,
    Upload,
} from 'lucide-vue-next';
import { ref, watch } from 'vue';

const props = defineProps<{
    modelValue: string;
    placeholder?: string;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();

const uploading = ref(false);
const fileInput = ref<HTMLInputElement | null>(null);

async function uploadImage(file: File) {
    uploading.value = true;
    try {
        const formData = new FormData();
        formData.append('image', file);
        const { data } = await axios.post('/admin/upload/image', formData);
        editor.value?.chain().focus().setImage({ src: data.url }).run();
    } catch (err) {
        console.error('Image upload failed:', err);
        alert('Image upload failed. Please try again.');
    } finally {
        uploading.value = false;
    }
}

function handleImageInput(e: Event) {
    const files = (e.target as HTMLInputElement).files;
    if (files?.length) {
        for (const file of Array.from(files)) {
            uploadImage(file);
        }
    }
    if (fileInput.value) fileInput.value.value = '';
}

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit.configure({
            heading: { levels: [1, 2, 3] },
        }),
        Link.configure({
            openOnClick: false,
            HTMLAttributes: { class: 'text-blue-600 underline' },
        }),
        Image.configure({
            HTMLAttributes: { class: 'rounded-lg max-w-full' },
            inline: true,
        }),
        Underline,
        TextAlign.configure({ types: ['heading', 'paragraph'] }),
        Placeholder.configure({
            placeholder: props.placeholder ?? 'Start writing...',
        }),
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm max-w-none focus:outline-none min-h-[200px] px-4 py-3',
        },
        handleDrop(view, event) {
            const files = event.dataTransfer?.files;
            if (files?.length) {
                const images = Array.from(files).filter((f) =>
                    f.type.startsWith('image/'),
                );
                if (images.length) {
                    event.preventDefault();
                    images.forEach((file) => uploadImage(file));
                    return true;
                }
            }
            return false;
        },
        handlePaste(view, event) {
            const items = event.clipboardData?.items;
            if (items) {
                for (const item of Array.from(items)) {
                    if (item.type.startsWith('image/')) {
                        event.preventDefault();
                        const file = item.getAsFile();
                        if (file) uploadImage(file);
                        return true;
                    }
                }
            }
            return false;
        },
    },
    onUpdate({ editor }) {
        emit('update:modelValue', editor.getHTML());
    },
});

watch(
    () => props.modelValue,
    (val) => {
        if (editor.value && editor.value.getHTML() !== val) {
            editor.value.commands.setContent(val, { emitUpdate: false } as any);
        }
    },
);

function setLink() {
    const url = prompt('Enter URL');
    if (url) {
        editor.value
            ?.chain()
            .focus()
            .extendMarkRange('link')
            .setLink({ href: url })
            .run();
    }
}

function triggerImageUpload() {
    fileInput.value?.click();
}
</script>

<template>
    <div class="overflow-hidden rounded-lg border border-input bg-background">
        <!-- Toolbar -->
        <div
            v-if="editor"
            class="flex flex-wrap items-center gap-0.5 border-b border-input bg-muted/30 px-2 py-1.5"
        >
            <button
                type="button"
                @click="editor.chain().focus().toggleBold().run()"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground':
                            editor.isActive('bold'),
                    },
                ]"
                title="Bold"
            >
                <Bold class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleItalic().run()"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground':
                            editor.isActive('italic'),
                    },
                ]"
                title="Italic"
            >
                <Italic class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleUnderline().run()"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground':
                            editor.isActive('underline'),
                    },
                ]"
                title="Underline"
            >
                <UnderlineIcon class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleStrike().run()"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground':
                            editor.isActive('strike'),
                    },
                ]"
                title="Strikethrough"
            >
                <Strikethrough class="h-4 w-4" />
            </button>

            <div class="mx-1 h-5 w-px bg-border" />

            <button
                type="button"
                @click="
                    editor.chain().focus().toggleHeading({ level: 1 }).run()
                "
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground': editor.isActive(
                            'heading',
                            { level: 1 },
                        ),
                    },
                ]"
                title="Heading 1"
            >
                <Heading1 class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="
                    editor.chain().focus().toggleHeading({ level: 2 }).run()
                "
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground': editor.isActive(
                            'heading',
                            { level: 2 },
                        ),
                    },
                ]"
                title="Heading 2"
            >
                <Heading2 class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="
                    editor.chain().focus().toggleHeading({ level: 3 }).run()
                "
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground': editor.isActive(
                            'heading',
                            { level: 3 },
                        ),
                    },
                ]"
                title="Heading 3"
            >
                <Heading3 class="h-4 w-4" />
            </button>

            <div class="mx-1 h-5 w-px bg-border" />

            <button
                type="button"
                @click="editor.chain().focus().toggleBulletList().run()"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground':
                            editor.isActive('bulletList'),
                    },
                ]"
                title="Bullet List"
            >
                <List class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleOrderedList().run()"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground':
                            editor.isActive('orderedList'),
                    },
                ]"
                title="Ordered List"
            >
                <ListOrdered class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleBlockquote().run()"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground':
                            editor.isActive('blockquote'),
                    },
                ]"
                title="Quote"
            >
                <Quote class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleCodeBlock().run()"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground':
                            editor.isActive('codeBlock'),
                    },
                ]"
                title="Code Block"
            >
                <Code class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setHorizontalRule().run()"
                class="rounded p-1.5 hover:bg-accent"
                title="Horizontal Rule"
            >
                <Minus class="h-4 w-4" />
            </button>

            <div class="mx-1 h-5 w-px bg-border" />

            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('left').run()"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground': editor.isActive({
                            textAlign: 'left',
                        }),
                    },
                ]"
                title="Align Left"
            >
                <AlignLeft class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('center').run()"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground': editor.isActive({
                            textAlign: 'center',
                        }),
                    },
                ]"
                title="Align Center"
            >
                <AlignCenter class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('right').run()"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground': editor.isActive({
                            textAlign: 'right',
                        }),
                    },
                ]"
                title="Align Right"
            >
                <AlignRight class="h-4 w-4" />
            </button>

            <div class="mx-1 h-5 w-px bg-border" />

            <button
                type="button"
                @click="setLink"
                :class="[
                    'rounded p-1.5 hover:bg-accent',
                    {
                        'bg-accent text-accent-foreground':
                            editor.isActive('link'),
                    },
                ]"
                title="Link"
            >
                <LinkIcon class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="triggerImageUpload"
                class="rounded p-1.5 hover:bg-accent"
                title="Upload Image"
                :disabled="uploading"
            >
                <Loader2 v-if="uploading" class="h-4 w-4 animate-spin" />
                <Upload v-else class="h-4 w-4" />
            </button>

            <div class="mx-1 h-5 w-px bg-border" />

            <button
                type="button"
                @click="editor.chain().focus().undo().run()"
                :disabled="!editor.can().undo()"
                class="rounded p-1.5 hover:bg-accent disabled:opacity-30"
                title="Undo"
            >
                <Undo2 class="h-4 w-4" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().redo().run()"
                :disabled="!editor.can().redo()"
                class="rounded p-1.5 hover:bg-accent disabled:opacity-30"
                title="Redo"
            >
                <Redo2 class="h-4 w-4" />
            </button>
        </div>

        <!-- Upload indicator -->
        <div
            v-if="uploading"
            class="flex items-center gap-2 border-t border-input bg-muted/30 px-3 py-1.5 text-xs text-muted-foreground"
        >
            <Loader2 class="h-3 w-3 animate-spin" /> Uploading image...
        </div>

        <!-- Editor -->
        <EditorContent :editor="editor" />

        <!-- Hidden file input -->
        <input
            ref="fileInput"
            type="file"
            accept="image/*"
            multiple
            class="hidden"
            @change="handleImageInput"
        />
    </div>
</template>

<style>
.tiptap p.is-editor-empty:first-child::before {
    content: attr(data-placeholder);
    float: left;
    color: hsl(var(--muted-foreground));
    pointer-events: none;
    height: 0;
}
</style>
