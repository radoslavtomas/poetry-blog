<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import MainLayout from '@/layouts/MainLayout.vue';
import { useTranslation } from '@/composables/useTranslation';
import * as books from '@/routes/books';

interface Poem {
    id: number;
    title: Record<string, string>;
    body: Record<string, string>;
    book?: {
        id: number;
        title: Record<string, string>;
    };
    source?: {
        id: number;
        name: Record<string, string>;
    };
}

const props = defineProps<{
    poem: Poem | null;
}>();

const { t, trans } = useTranslation();
const showFullPoem = ref(false);

const poemBody = computed(() => {
    if (!props.poem) return '';
    return trans(props.poem.body);
});

const poemExcerpt = computed(() => {
    const body = poemBody.value;
    if (body.length <= 150) {
        return body;
    }

    // Find the last newline before character 150
    const excerpt = body.substring(0, 150);
    const lastNewLine = excerpt.lastIndexOf('\n');

    if (lastNewLine > 0) {
        return excerpt.substring(0, lastNewLine);
    }

    // If no newline found, try to break at last space
    const lastSpace = excerpt.lastIndexOf(' ');
    if (lastSpace > 0) {
        return excerpt.substring(0, lastSpace);
    }

    return excerpt;
});

const shouldShowExcerpt = computed(() => {
    return poemBody.value.length > 150;
});

const displayedBody = computed(() => {
    if (!shouldShowExcerpt.value || showFullPoem.value) {
        return poemBody.value;
    }
    return poemExcerpt.value;
});

// Post-process poem body to add styling to empty paragraphs
const processedBody = computed(() => {
    const body = displayedBody.value;
    // Replace empty <p></p> tags with styled versions
    return body.replace(
        /<p><\/p>/g,
        '<p style="min-height: 1.5em; display: block;"></p>',
    );
});

const getAnotherPoem = () => {
    router.reload({ only: ['poem'] });
};
</script>

<style>
/* Create visual breaks for paragraphs in poem body */
.poem-body p {
    min-height: 1.5em;
    line-height: 1.5em;
    display: block;
    margin: 0;
}
</style>

<template>
    <MainLayout>
        <div class="mx-auto max-w-3xl">
            <div
                v-if="poem"
                class="overflow-hidden rounded-lg bg-white shadow-lg transition-colors dark:bg-gray-800"
            >
                <div class="p-8">
                    <h1
                        class="mb-4 text-3xl font-bold text-gray-900 dark:text-white"
                        v-html="trans(poem.title)"
                    ></h1>

                    <div class="prose dark:prose-invert max-w-none">
                        <div
                            class="poem-body font-serif text-lg leading-relaxed whitespace-pre-wrap text-gray-700 dark:text-gray-300"
                            v-html="processedBody"
                        ></div>
                    </div>

                    <div v-if="shouldShowExcerpt && !showFullPoem" class="mt-4">
                        <button
                            @click="showFullPoem = true"
                            class="cursor-pointer font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300"
                        >
                            {{ t('read_more') }}
                        </button>
                    </div>

                    <div
                        class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-700"
                    >
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span v-if="poem.book">
                                {{ t('published_in') }}:
                                <Link
                                    :href="
                                        books.show.url({ book: poem.book.id })
                                    "
                                    class="cursor-pointer text-purple-600 hover:underline dark:text-purple-400"
                                >
                                    <span
                                        v-html="trans(poem.book.title)"
                                    ></span>
                                </Link>
                            </span>
                            <span v-else-if="poem.source">
                                {{ t('published_in') }}:
                                <span v-html="trans(poem.source.name)"></span>
                            </span>
                            <span v-else class="italic">
                                {{ t('unpublished') }}
                            </span>
                        </p>
                    </div>
                </div>

                <div
                    class="border-t border-gray-200 bg-gray-50 px-8 py-4 dark:border-gray-600 dark:bg-gray-700"
                >
                    <button
                        @click="getAnotherPoem"
                        class="w-full cursor-pointer rounded-md bg-teal-600 px-6 py-2 font-medium text-white transition-colors hover:bg-teal-700 sm:w-auto"
                    >
                        {{ t('get_another_poem') }}
                    </button>
                </div>
            </div>

            <div v-else class="py-12 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    {{ t('no_poems') }}
                </p>
            </div>
        </div>
    </MainLayout>
</template>
