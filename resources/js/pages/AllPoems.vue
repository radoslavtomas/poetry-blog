<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import { useTranslation } from '@/composables/useTranslation';
import * as books from '@/routes/books';
import * as poems from '@/routes/poems';

interface Poem {
    id: number;
    title: Record<string, string>;
    body: Record<string, string>;
}

interface Book {
    id: number;
    title: Record<string, string>;
    poems: Poem[];
}

interface Source {
    id: number;
    name: Record<string, string>;
    poems: Poem[];
}

const { poemsByBooks, poemsBySources, unpublishedPoems } = defineProps<{
    poemsByBooks: Book[];
    poemsBySources: Source[];
    unpublishedPoems: Poem[];
}>();

const { t, trans } = useTranslation();
</script>

<template>
    <MainLayout>
        <div class="mx-auto max-w-4xl space-y-12">
            <!-- Poems by Books -->
            <section v-if="poemsByBooks.length > 0">
                <h2
                    class="mb-6 text-2xl font-bold text-gray-900 dark:text-white"
                >
                    {{ t('poems_by_books') }}
                </h2>
                <div class="space-y-8">
                    <div
                        v-for="book in poemsByBooks"
                        :key="book.id"
                        class="rounded-lg bg-white p-6 shadow dark:bg-gray-800"
                    >
                        <Link
                            :href="books.show.url({ book: book.id })"
                            class="mb-4 block text-xl font-semibold text-teal-600 hover:underline dark:text-teal-400"
                        >
                            <span v-html="trans(book.title)"></span>
                        </Link>
                        <ul class="space-y-2">
                            <li v-for="poem in book.poems" :key="poem.id">
                                <Link
                                    :href="poems.show.url({ poem: poem.id })"
                                    class="text-gray-700 transition-colors hover:text-purple-600 hover:underline dark:text-gray-300 dark:hover:text-purple-400"
                                >
                                    <span v-html="trans(poem.title)"></span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Poems by Sources -->
            <section v-if="poemsBySources.length > 0">
                <h2
                    class="mb-6 text-2xl font-bold text-gray-900 dark:text-white"
                >
                    {{ t('poems_by_sources') }}
                </h2>
                <div class="space-y-8">
                    <div
                        v-for="source in poemsBySources"
                        :key="source.id"
                        class="rounded-lg bg-white p-6 shadow dark:bg-gray-800"
                    >
                        <h3
                            class="mb-4 text-xl font-semibold text-gray-900 dark:text-white"
                        >
                            <span v-html="trans(source.name)"></span>
                        </h3>
                        <ul class="space-y-2">
                            <li v-for="poem in source.poems" :key="poem.id">
                                <Link
                                    :href="poems.show.url({ poem: poem.id })"
                                    class="text-gray-700 transition-colors hover:text-purple-600 hover:underline dark:text-gray-300 dark:hover:text-purple-400"
                                >
                                    <span v-html="trans(poem.title)"></span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Unpublished Poems -->
            <section v-if="unpublishedPoems.length > 0">
                <h2
                    class="mb-6 text-2xl font-bold text-gray-900 dark:text-white"
                >
                    {{ t('unpublished_poems') }}
                </h2>
                <div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800">
                    <ul class="space-y-2">
                        <li v-for="poem in unpublishedPoems" :key="poem.id">
                            <Link
                                :href="poems.show.url({ poem: poem.id })"
                                class="text-gray-700 transition-colors hover:text-purple-600 hover:underline dark:text-gray-300 dark:hover:text-purple-400"
                            >
                                <span v-html="trans(poem.title)"></span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </section>

            <div
                v-if="
                    poemsByBooks.length === 0 &&
                    poemsBySources.length === 0 &&
                    unpublishedPoems.length === 0
                "
                class="py-12 text-center"
            >
                <p class="text-gray-600 dark:text-gray-400">
                    {{ t('no_poems') }}
                </p>
            </div>
        </div>
    </MainLayout>
</template>
