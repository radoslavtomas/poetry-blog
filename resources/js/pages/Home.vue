<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import MainLayout from '@/layouts/MainLayout.vue'
import { useTranslation } from '@/composables/useTranslation'
import * as books from '@/routes/books'

interface Poem {
  id: number
  title: Record<string, string>
  body: Record<string, string>
  book?: {
    id: number
    title: Record<string, string>
  }
  source?: {
    id: number
    name: Record<string, string>
  }
}

const props = defineProps<{
  poem: Poem | null
}>()

const { t, trans } = useTranslation()
const showFullPoem = ref(false)

const poemBody = computed(() => {
  if (!props.poem) return ''
  return trans(props.poem.body)
})

const poemExcerpt = computed(() => {
  const body = poemBody.value
  if (body.length <= 150) {
    return body
  }

  // Find the last newline before character 150
  const excerpt = body.substring(0, 150)
  const lastNewLine = excerpt.lastIndexOf('\n')

  if (lastNewLine > 0) {
    return excerpt.substring(0, lastNewLine)
  }

  // If no newline found, try to break at last space
  const lastSpace = excerpt.lastIndexOf(' ')
  if (lastSpace > 0) {
    return excerpt.substring(0, lastSpace)
  }

  return excerpt
})

const shouldShowExcerpt = computed(() => {
  return poemBody.value.length > 150
})

const displayedBody = computed(() => {
  if (!shouldShowExcerpt.value || showFullPoem.value) {
    return poemBody.value
  }
  return poemExcerpt.value
})

// Post-process poem body to add styling to empty paragraphs
const processedBody = computed(() => {
  const body = displayedBody.value
  // Replace empty <p></p> tags with styled versions
  return body.replace(/<p><\/p>/g, '<p style="min-height: 1.5em; display: block;"></p>')
})

const getAnotherPoem = () => {
  router.reload({ only: ['poem'] })
}
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
    <div class="max-w-3xl mx-auto">
      <div v-if="poem" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden transition-colors">
        <div class="p-8">
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4" v-html="trans(poem.title)">
          </h1>

           <div class="prose dark:prose-invert max-w-none">
             <div class="poem-body whitespace-pre-wrap font-serif text-lg text-gray-700 dark:text-gray-300 leading-relaxed" v-html="processedBody"></div>
           </div>

          <div v-if="shouldShowExcerpt && !showFullPoem" class="mt-4">
            <button
              @click="showFullPoem = true"
              class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium cursor-pointer"
            >
              {{ t('read_more') }}
            </button>
          </div>

          <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-400">
              <span v-if="poem.book">
                {{ t('published_in') }}:
                <Link
                  :href="books.show.url({ book: poem.book.id })"
                  class="text-purple-600 dark:text-purple-400 hover:underline cursor-pointer"
                >
                  <span v-html="trans(poem.book.title)"></span>
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

        <div class="px-8 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
          <button
            @click="getAnotherPoem"
            class="w-full sm:w-auto px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-md transition-colors cursor-pointer"
          >
            {{ t('get_another_poem') }}
          </button>
        </div>
      </div>

      <div v-else class="text-center py-12">
        <p class="text-gray-600 dark:text-gray-400">{{ t('no_poems') }}</p>
      </div>
    </div>
  </MainLayout>
</template>
