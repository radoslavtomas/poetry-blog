<script setup lang="ts">
import MainLayout from '@/layouts/MainLayout.vue';
import { useTranslation } from '@/composables/useTranslation';

interface Author {
    id: number;
    name: string;
    bio: Record<string, string>;
    image_path: string | null;
}

const { author } = defineProps<{
    author: Author | null;
}>();

const { t, trans } = useTranslation();
</script>

<template>
    <MainLayout>
        <div class="mx-auto max-w-4xl">
            <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">
                {{ t('about_me') }}
            </h1>

            <div
                v-if="author"
                class="overflow-hidden rounded-lg bg-white shadow-lg dark:bg-gray-800"
            >
                <div class="p-8">
                    <div class="mb-8 flex flex-col gap-8 md:flex-row">
                        <!-- Author Image -->
                        <div class="mx-auto flex-shrink-0 md:mx-0">
                            <div
                                v-if="author.image_path"
                                class="h-48 w-48 overflow-hidden rounded-full bg-gray-200 shadow-lg dark:bg-gray-700"
                            >
                                <img
                                    :src="`/storage/${author.image_path}`"
                                    :alt="author.name"
                                    class="h-full w-full object-cover"
                                />
                            </div>
                            <div
                                v-else
                                class="flex h-48 w-48 items-center justify-center rounded-full bg-gray-200 shadow-lg dark:bg-gray-700"
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
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                            </div>
                        </div>

                        <!-- Author Info -->
                        <div class="flex-1">
                            <h2
                                class="mb-4 text-2xl font-bold text-gray-900 dark:text-white"
                            >
                                {{ author.name }}
                            </h2>
                            <div class="prose dark:prose-invert max-w-none">
                                <div
                                    class="leading-relaxed text-gray-700 dark:text-gray-300"
                                    v-html="trans(author.bio)"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-else
                class="rounded-lg bg-white py-12 text-center shadow dark:bg-gray-800"
            >
                <p class="text-gray-600 dark:text-gray-400">
                    No author information available.
                </p>
            </div>
        </div>
    </MainLayout>
</template>
