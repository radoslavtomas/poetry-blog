<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'
import { useTranslation } from '@/composables/useTranslation'
import * as books from '@/routes/books'
import * as poems from '@/routes/poems'

interface Poem {
  id: number
  title: Record<string, string>
  body: Record<string, string>
}

interface Book {
  id: number
  title: Record<string, string>
  poems: Poem[]
}

interface Source {
  id: number
  name: Record<string, string>
  poems: Poem[]
}

const props = defineProps<{
  poemsByBooks: Book[]
  poemsBySources: Source[]
  unpublishedPoems: Poem[]
}>()

const { t, trans } = useTranslation()
</script>

<template>
  <MainLayout>
    <div class="max-w-4xl mx-auto space-y-12">
      <!-- Poems by Books -->
      <section v-if="poemsByBooks.length > 0">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
          {{ t('poems_by_books') }}
        </h2>
        <div class="space-y-8">
          <div v-for="book in poemsByBooks" :key="book.id" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <Link 
              :href="books.show.url({ book: book.id })"
              class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 hover:underline mb-4 block"
              v-html="trans(book.title)"
            >
            </Link>
            <ul class="space-y-2">
              <li v-for="poem in book.poems" :key="poem.id">
                <Link
                  :href="poems.show.url({ poem: poem.id })"
                  class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
                  v-html="trans(poem.title)"
                >
                </Link>
              </li>
            </ul>
          </div>
        </div>
      </section>

      <!-- Poems by Sources -->
      <section v-if="poemsBySources.length > 0">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
          {{ t('poems_by_sources') }}
        </h2>
        <div class="space-y-8">
          <div v-for="source in poemsBySources" :key="source.id" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4" v-html="trans(source.name)">
            </h3>
            <ul class="space-y-2">
              <li v-for="poem in source.poems" :key="poem.id">
                <Link
                  :href="poems.show.url({ poem: poem.id })"
                  class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
                  v-html="trans(poem.title)"
                >
                </Link>
              </li>
            </ul>
          </div>
        </div>
      </section>

      <!-- Unpublished Poems -->
      <section v-if="unpublishedPoems.length > 0">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
          {{ t('unpublished_poems') }}
        </h2>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
          <ul class="space-y-2">
            <li v-for="poem in unpublishedPoems" :key="poem.id">
              <Link
                :href="poems.show.url({ poem: poem.id })"
                class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
                v-html="trans(poem.title)"
              >
              </Link>
            </li>
          </ul>
        </div>
      </section>

      <div v-if="poemsByBooks.length === 0 && poemsBySources.length === 0 && unpublishedPoems.length === 0" class="text-center py-12">
        <p class="text-gray-600 dark:text-gray-400">{{ t('no_poems') }}</p>
      </div>
    </div>
  </MainLayout>
</template>
