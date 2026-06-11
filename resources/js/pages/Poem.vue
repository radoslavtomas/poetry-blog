<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import { useTranslation } from '@/composables/useTranslation';
import * as books from '@/routes/books';
import * as poems from '@/routes/poems';

interface Book {
    id: number;
    title: Record<string, string>;
    cover: string | null;
}

interface Source {
    id: number;
    name: Record<string, string>;
}

interface Poem {
    id: number;
    title: Record<string, string>;
    body: Record<string, string>;
    book?: Book;
    source?: Source;
}

interface NavPoem {
    id: number;
    title: Record<string, string>;
}

const { poem, prevPoem, nextPoem } = defineProps<{
    poem: Poem;
    prevPoem?: NavPoem | null;
    nextPoem?: NavPoem | null;
}>();

const { t, trans } = useTranslation();
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
            <article
                class="overflow-hidden rounded-lg bg-white shadow-lg dark:bg-gray-800"
            >
                <div class="p-8">
                    <h1
                        class="mb-6 text-3xl font-bold text-gray-900 dark:text-white"
                        v-html="trans(poem.title)"
                    ></h1>

                    <div class="prose dark:prose-invert mb-8 max-w-none">
                        <div
                            class="poem-body font-serif text-lg leading-relaxed whitespace-pre-wrap text-gray-700 dark:text-gray-300"
                            v-html="trans(poem.body)"
                        ></div>
                    </div>

                    <!-- Source/Book Info -->
                    <div
                        class="border-t border-gray-200 pt-6 dark:border-gray-700"
                    >
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span v-if="poem.book">
                                {{ t('published_in') }}:
                                <Link
                                    :href="
                                        books.show.url({ book: poem.book.id })
                                    "
                                    class="font-medium text-purple-600 hover:underline dark:text-purple-400"
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

                <!-- Book Cover and Navigation (only for book poems) -->
                <div
                    v-if="poem.book"
                    class="border-t border-gray-200 bg-gray-50 p-6 dark:border-gray-600 dark:bg-gray-700"
                >
                    <div class="flex items-center justify-between">
                        <Link
                            :href="books.show.url({ book: poem.book.id })"
                            class="flex items-center space-x-4 transition-opacity hover:opacity-80"
                        >
                            <div
                                v-if="poem.book.cover"
                                class="h-auto w-16 flex-shrink-0 overflow-hidden rounded bg-gray-200 dark:bg-gray-600"
                            >
                                <img
                                    :src="`/storage/${poem.book.cover}`"
                                    :alt="trans(poem.book.title)"
                                    class="h-auto w-full"
                                />
                            </div>
                            <div
                                v-else
                                class="flex h-20 w-16 flex-shrink-0 items-center justify-center rounded bg-gray-200 dark:bg-gray-600"
                            >
                                <svg
                                    class="h-8 w-8 text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p
                                    class="mb-1 text-xs text-gray-500 dark:text-gray-400"
                                >
                                    {{ t('back_to_book') }}
                                </p>
                                <p
                                    class="mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    v-html="trans(poem.book.title)"
                                ></p>
                            </div>
                        </Link>
                    </div>

                    <!-- Prev/Next Navigation -->
                    <div
                        class="mt-6 flex items-center justify-between border-t border-gray-200 pt-6 dark:border-gray-600"
                    >
                        <Link
                            v-if="prevPoem"
                            :href="poems.show.url({ poem: prevPoem.id })"
                            class="group flex items-center text-sm text-gray-700 transition-colors hover:text-purple-600 dark:text-gray-300 dark:hover:text-purple-400"
                        >
                            <svg
                                class="mr-2 h-5 w-5 transition-transform group-hover:-translate-x-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>
                            <div class="text-left">
                                <p
                                    class="text-xs text-gray-500 dark:text-gray-400"
                                >
                                    {{ t('previous_poem') }}
                                </p>
                                <p
                                    class="mb-2 font-medium"
                                    v-html="trans(prevPoem.title)"
                                ></p>
                            </div>
                        </Link>
                        <div v-else></div>

                        <Link
                            v-if="nextPoem"
                            :href="poems.show.url({ poem: nextPoem.id })"
                            class="group flex items-center text-sm text-gray-700 transition-colors hover:text-purple-600 dark:text-gray-300 dark:hover:text-purple-400"
                        >
                            <div class="text-right">
                                <p
                                    class="text-xs text-gray-500 dark:text-gray-400"
                                >
                                    {{ t('next_poem') }}
                                </p>
                                <p
                                    class="mb-2 font-medium"
                                    v-html="trans(nextPoem.title)"
                                ></p>
                            </div>
                            <svg
                                class="ml-2 h-5 w-5 transition-transform group-hover:translate-x-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </Link>
                        <div v-else></div>
                    </div>
                </div>
            </article>
        </div>
    </MainLayout>
</template>
