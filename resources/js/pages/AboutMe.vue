<script setup lang="ts">
import MainLayout from '@/layouts/MainLayout.vue'
import { useTranslation } from '@/composables/useTranslation'

interface Author {
  id: number
  name: string
  bio: Record<string, string>
  image_path: string | null
}

const props = defineProps<{
  author: Author | null
}>()

const { t, trans } = useTranslation()
</script>

<template>
  <MainLayout>
    <div class="max-w-4xl mx-auto">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
        {{ t('about_me') }}
      </h1>

      <div v-if="author" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        <div class="p-8">
          <div class="flex flex-col md:flex-row gap-8 mb-8">
            <!-- Author Image -->
            <div class="flex-shrink-0">
              <div v-if="author.image_path" class="w-48 h-48 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700 shadow-lg">
                <img
                  :src="`/storage/${author.image_path}`"
                  :alt="author.name"
                  class="w-full h-full object-cover"
                />
              </div>
              <div v-else class="w-48 h-48 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center shadow-lg">
                <svg class="w-24 h-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
            </div>

            <!-- Author Info -->
            <div class="flex-1">
              <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                {{ author.name }}
              </h2>
              <div class="prose dark:prose-invert max-w-none">
                <div class="text-gray-700 dark:text-gray-300 leading-relaxed" v-html="trans(author.bio)"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow">
        <p class="text-gray-600 dark:text-gray-400">No author information available.</p>
      </div>
    </div>
  </MainLayout>
</template>
