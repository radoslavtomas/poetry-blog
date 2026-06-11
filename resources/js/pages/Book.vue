<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import { useTranslation } from '@/composables/useTranslation';
import * as poems from '@/routes/poems';

interface Poem {
    id: number;
    title: Record<string, string>;
}

interface Book {
    id: number;
    title: Record<string, string>;
    cover: string | null;
    publishing_year: number;
    publishing_house: Record<string, string>;
    description: Record<string, string>;
    pdf_path: string | null;
    poems: Poem[];
}

const props = defineProps<{
    book: Book;
}>();

const { t, trans } = useTranslation();
</script>

<template>
    <MainLayout>
        <div class="mx-auto max-w-5xl">
            <div class="mb-12 grid grid-cols-1 gap-8 md:grid-cols-3">
                <!-- Book Cover -->
                <div class="md:col-span-1">
                    <div
                        v-if="book.cover"
                        class="overflow-hidden rounded-lg p-8 border border-gray-200 dark:border-gray-800 shadow dark:bg-gray-800"
                    >
                        <img
                            :src="`/storage/${book.cover}`"
                            :alt="trans(book.title)"
                            class="h-auto w-full rounded-md"
                        />
                    </div>
                    <div
                        v-else
                        class="flex aspect-[3/4] items-center justify-center rounded-lg bg-gray-200 shadow-lg dark:bg-gray-700"
                    >
                        <svg
                            class="h-32 w-32 text-gray-400"
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

                    <a
                        v-if="book.pdf_path"
                        :href="`/storage/${book.pdf_path}`"
                        target="_blank"
                        class="mt-4 block w-full rounded-md bg-teal-500 px-4 py-2 text-center text-white transition-colors hover:bg-teal-600"
                    >
                        Download PDF
                    </a>
                </div>

                <!-- Book Info -->
                <div class="md:col-span-2">
                    <h1
                        class="mb-4 text-3xl font-bold text-gray-900 dark:text-white"
                        v-html="trans(book.title)"
                    ></h1>

                    <div
                        class="mb-6 space-y-2 text-gray-600 dark:text-gray-400"
                    >
                        <p>
                            <span class="font-semibold"
                                >{{ t('publishing_year') }}:</span
                            >
                            {{ book.publishing_year }}
                        </p>
                        <p>
                            <span class="font-semibold"
                                >{{ t('publishing_house') }}:</span
                            >
                            <span v-html="trans(book.publishing_house)"></span>
                        </p>
                    </div>

                    <div class="prose dark:prose-invert max-w-none">
                        <div
                            class="leading-relaxed text-gray-700 dark:text-gray-300"
                            v-html="trans(book.description)"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Poems List -->
            <div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800">
                <h2
                    class="mb-6 text-2xl font-bold text-gray-900 dark:text-white"
                >
                    {{ t('all_poems') }} ({{ book.poems.length }})
                </h2>
                <ul class="space-y-3">
                    <li
                        v-for="(poem, index) in book.poems"
                        :key="poem.id"
                        class="flex items-start"
                    >
                        <span
                            class="mt-1 mr-3 min-w-[2rem] text-sm font-medium text-gray-500 dark:text-gray-400"
                        >
                            {{ index + 1 }}.
                        </span>
                        <Link
                            :href="poems.show.url({ poem: poem.id })"
                            class="text-gray-700 transition-colors hover:text-purple-600 dark:text-gray-300 dark:hover:text-purple-400"
                        >
                        <span v-html="trans(poem.title)"></span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </MainLayout>
</template>
