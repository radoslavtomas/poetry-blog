<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import { useTranslation } from '@/composables/useTranslation';
import * as bookRoutes from '@/routes/books';

interface Book {
    id: number;
    title: Record<string, string>;
    cover: string | null;
    publishing_year: number;
    publishing_house: Record<string, string>;
    description: Record<string, string>;
    poems_count: number;
}

const { books } = defineProps<{
    books: Book[];
}>();

const { t, trans } = useTranslation();
</script>

<template>
    <MainLayout>
        <div class="mx-auto max-w-6xl">
            <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">
                {{ t('books') }}
            </h1>

            <div
                v-if="books.length > 0"
                class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
            >
                <Link
                    v-for="book in books"
                    :key="book.id"
                    :href="bookRoutes.show.url({ book: book.id })"
                    class="group overflow-hidden rounded-lg bg-white shadow transition-shadow hover:shadow-lg dark:bg-gray-800"
                >
                    <div v-if="book.cover" class="p-10">
                        <img
                            :src="`/storage/${book.cover}`"
                            :alt="trans(book.title)"
                            class="h-auto w-full rounded transition-transform duration-300 group-hover:scale-102"
                        />
                    </div>
                    <div
                        v-else
                        class="flex aspect-[3/4] items-center justify-center bg-gray-200 dark:bg-gray-700"
                    >
                        <svg
                            class="h-24 w-24 text-gray-400"
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
                    <div class="p-4">
                        <h2
                            class="mb-2 text-xl font-semibold text-gray-900 group-hover:underline dark:text-white"
                            v-html="trans(book.title)"
                        ></h2>
                        <div
                            class="space-y-1 text-sm text-gray-600 dark:text-gray-400"
                        >
                            <p>
                                <span class="font-medium"
                                    >{{ t('publishing_year') }}:</span
                                >
                                {{ book.publishing_year }}
                            </p>
                            <p>
                                <span class="font-medium"
                                    >{{ t('publishing_house') }}:</span
                                >
                                <span
                                    v-html="trans(book.publishing_house)"
                                ></span>
                            </p>
                            <p class="text-purple-600 dark:text-purple-400">
                                {{ book.poems_count }}
                                {{ book.poems_count === 1 ? 'poem' : 'poems' }}
                            </p>
                        </div>
                        <div
                            class="mt-3 line-clamp-3 text-sm text-gray-700 dark:text-gray-300"
                            v-html="trans(book.description)"
                        ></div>
                    </div>
                </Link>
            </div>

            <div v-else class="py-12 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    {{ t('no_poems') }}
                </p>
            </div>
        </div>
    </MainLayout>
</template>
