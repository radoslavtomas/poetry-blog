<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'
import { useTranslation } from '@/composables/useTranslation'
import * as poems from '@/routes/poems'

interface Poem {
  id: number
  title: Record<string, string>
}

interface Book {
  id: number
  title: Record<string, string>
  cover: string | null
  publishing_year: number
  publishing_house: Record<string, string>
  description: Record<string, string>
  pdf_path: string | null
  poems: Poem[]
}

const props = defineProps<{
  book: Book
}>()

const { t, trans } = useTranslation()
</script>

<template>
  <MainLayout>
    <div class="max-w-5xl mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Book Cover -->
        <div class="md:col-span-1">
          <div v-if="book.cover" class="aspect-[3/4] bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg">
            <img
              :src="`/storage/${book.cover}`"
              :alt="trans(book.title)"
              class="w-full h-full object-cover"
            />
          </div>
          <div v-else class="aspect-[3/4] bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center shadow-lg">
            <svg class="w-32 h-32 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
          </div>
          
          <a
            v-if="book.pdf_path"
            :href="`/storage/${book.pdf_path}`"
            target="_blank"
            class="mt-4 block w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-center rounded-md transition-colors"
          >
            Download PDF
          </a>
        </div>

        <!-- Book Info -->
        <div class="md:col-span-2">
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
            {{ trans(book.title) }}
          </h1>
          
          <div class="space-y-2 text-gray-600 dark:text-gray-400 mb-6">
            <p>
              <span class="font-semibold">{{ t('publishing_year') }}:</span> {{ book.publishing_year }}
            </p>
            <p>
              <span class="font-semibold">{{ t('publishing_house') }}:</span> {{ trans(book.publishing_house) }}
            </p>
          </div>

          <div class="prose dark:prose-invert max-w-none">
            <div class="text-gray-700 dark:text-gray-300 leading-relaxed" v-html="trans(book.description)"></div>
          </div>
        </div>
      </div>

      <!-- Poems List -->
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
          {{ t('all_poems') }} ({{ book.poems.length }})
        </h2>
        <ul class="space-y-3">
          <li v-for="(poem, index) in book.poems" :key="poem.id" class="flex items-start">
            <span class="text-gray-500 dark:text-gray-400 mr-3 mt-1 text-sm font-medium min-w-[2rem]">
              {{ index + 1 }}.
            </span>
            <Link
              :href="poems.show.url({ poem: poem.id })"
              class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
            >
              {{ trans(poem.title) }}
            </Link>
          </li>
        </ul>
      </div>
    </div>
  </MainLayout>
</template>
