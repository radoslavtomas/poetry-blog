<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'
import { useTranslation } from '@/composables/useTranslation'
import * as books from '@/routes/books'
import * as poems from '@/routes/poems'

interface Book {
  id: number
  title: Record<string, string>
  cover: string | null
}

interface Source {
  id: number
  name: Record<string, string>
}

interface Poem {
  id: number
  title: Record<string, string>
  body: Record<string, string>
  book?: Book
  source?: Source
}

interface NavPoem {
  id: number
  title: Record<string, string>
}

const props = defineProps<{
  poem: Poem
  prevPoem?: NavPoem | null
  nextPoem?: NavPoem | null
}>()

const { t, trans } = useTranslation()
</script>

<template>
  <MainLayout>
    <div class="max-w-3xl mx-auto">
      <article class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        <div class="p-8">
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
            {{ trans(poem.title) }}
          </h1>
          
          <div class="prose dark:prose-invert max-w-none mb-8">
            <pre class="whitespace-pre-wrap font-serif text-lg text-gray-700 dark:text-gray-300 leading-relaxed">{{ trans(poem.body) }}</pre>
          </div>

          <!-- Source/Book Info -->
          <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-400">
              <span v-if="poem.book">
                {{ t('published_in') }}:
                <Link
                  :href="books.show.url({ book: poem.book.id })"
                  class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium"
                >
                  {{ trans(poem.book.title) }}
                </Link>
              </span>
              <span v-else-if="poem.source">
                {{ t('published_in') }}: {{ trans(poem.source.name) }}
              </span>
              <span v-else class="italic">
                {{ t('unpublished') }}
              </span>
            </p>
          </div>
        </div>

        <!-- Book Cover and Navigation (only for book poems) -->
        <div v-if="poem.book" class="bg-gray-50 dark:bg-gray-700 p-6 border-t border-gray-200 dark:border-gray-600">
          <div class="flex items-center justify-between">
            <Link
              :href="books.show.url({ book: poem.book.id })"
              class="flex items-center space-x-4 hover:opacity-80 transition-opacity"
            >
              <div v-if="poem.book.cover" class="w-16 h-20 bg-gray-200 dark:bg-gray-600 rounded overflow-hidden flex-shrink-0">
                <img
                  :src="`/storage/${poem.book.cover}`"
                  :alt="trans(poem.book.title)"
                  class="w-full h-full object-cover"
                />
              </div>
              <div v-else class="w-16 h-20 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center flex-shrink-0">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
              </div>
              <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ t('back_to_book') }}</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ trans(poem.book.title) }}</p>
              </div>
            </Link>
          </div>

          <!-- Prev/Next Navigation -->
          <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
            <Link
              v-if="prevPoem"
              :href="poems.show.url({ poem: prevPoem.id })"
              class="flex items-center text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors group"
            >
              <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
              <div class="text-left">
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ t('previous_poem') }}</p>
                <p class="font-medium line-clamp-1">{{ trans(prevPoem.title) }}</p>
              </div>
            </Link>
            <div v-else></div>

            <Link
              v-if="nextPoem"
              :href="poems.show.url({ poem: nextPoem.id })"
              class="flex items-center text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors group"
            >
              <div class="text-right">
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ t('next_poem') }}</p>
                <p class="font-medium line-clamp-1">{{ trans(nextPoem.title) }}</p>
              </div>
              <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </Link>
            <div v-else></div>
          </div>
        </div>
      </article>
    </div>
  </MainLayout>
</template>
