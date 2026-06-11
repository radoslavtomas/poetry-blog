<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { useAppearance } from '@/composables/useAppearance';
import { useTranslation } from '@/composables/useTranslation';
import { home } from '@/routes';
import * as poems from '@/routes/poems';
import * as books from '@/routes/books';
import { about } from '@/routes';

const { appearance, updateAppearance } = useAppearance();
const { t } = useTranslation();
const page = usePage();

const mobileMenuOpen = ref(false);
const currentLocale = computed(() => (page.props.locale as string) || 'sk');

const toggleDarkMode = () => {
    updateAppearance(appearance.value === 'dark' ? 'light' : 'dark');
};

const switchLanguage = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    const newLocale = target.value;
    router.post(
        `/language/${newLocale}`,
        {},
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

const isDark = computed(() => appearance.value === 'dark');
const currentRoute = computed(() => page.url);
</script>

<template>
    <div
        class="flex min-h-screen flex-col bg-white transition-colors dark:bg-gray-900"
    >
        <!-- Header -->
        <header
            class="sticky top-0 z-50 border-b border-gray-200 bg-white transition-colors dark:border-gray-700 dark:bg-gray-800"
        >
            <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <Link :href="home.url()" class="mr-8 flex-shrink-0">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-teal-500 to-purple-600 font-logo font-bold text-white shadow-md transition-shadow hover:shadow-lg dark:from-teal-600 dark:to-purple-700"
                            >
                                RT
                            </div>
                        </Link>
                        <!-- Navigation Links -->
                        <div class="hidden sm:flex sm:space-x-8">
                            <Link
                                :href="home.url()"
                                class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors"
                                :class="
                                    currentRoute === '/'
                                        ? 'border-teal-600 text-gray-900 dark:text-white'
                                        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
                                "
                            >
                                {{ t('home') }}
                            </Link>
                            <Link
                                :href="poems.index.url()"
                                class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors"
                                :class="
                                    currentRoute.startsWith('/poems')
                                        ? 'border-teal-500 text-gray-900 dark:text-white'
                                        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
                                "
                            >
                                {{ t('all_poems') }}
                            </Link>
                            <Link
                                :href="books.index.url()"
                                class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors"
                                :class="
                                    currentRoute.startsWith('/books')
                                        ? 'border-teal-500 text-gray-900 dark:text-white'
                                        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
                                "
                            >
                                {{ t('books') }}
                            </Link>
                            <Link
                                :href="about.url()"
                                class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors"
                                :class="
                                    currentRoute === '/about'
                                        ? 'border-teal-500 text-gray-900 dark:text-white'
                                        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
                                "
                            >
                                {{ t('about_me') }}
                            </Link>
                        </div>
                    </div>

                    <div
                        class="hidden space-x-4 sm:ml-6 sm:flex sm:items-center"
                    >
                        <!-- Language Switcher -->
                        <select
                            :value="currentLocale"
                            @change="switchLanguage"
                            class="rounded border border-gray-300 bg-white px-3 py-1 text-sm font-medium text-gray-900 transition-colors focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                        >
                            <option value="sk">Slovenčina</option>
                            <option value="en">English</option>
                        </select>

                        <!-- Dark Mode Toggle -->
                        <button
                            @click="toggleDarkMode"
                            class="rounded-md p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                        >
                            <svg
                                v-if="isDark"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
                                />
                            </svg>
                            <svg
                                v-else
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                                />
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden">
                        <button
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 dark:hover:bg-gray-700"
                        >
                            <svg
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    v-if="!mobileMenuOpen"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    v-else
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Mobile menu -->
            <div v-if="mobileMenuOpen" class="sm:hidden">
                <div class="space-y-1 pt-2 pb-3">
                    <Link
                        :href="home.url()"
                        class="block border-l-4 py-2 pr-4 pl-3 text-base font-medium transition-colors"
                        :class="
                            currentRoute === '/'
                                ? 'border-teal-500 bg-indigo-50 text-indigo-700 dark:bg-teal-900 dark:text-indigo-300'
                                : 'border-transparent text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-200'
                        "
                    >
                        {{ t('home') }}
                    </Link>
                    <Link
                        :href="poems.index.url()"
                        class="block border-l-4 py-2 pr-4 pl-3 text-base font-medium transition-colors"
                        :class="
                            currentRoute.startsWith('/poems')
                                ? 'border-teal-500 bg-indigo-50 text-indigo-700 dark:bg-teal-900 dark:text-indigo-300'
                                : 'border-transparent text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-200'
                        "
                    >
                        {{ t('all_poems') }}
                    </Link>
                    <Link
                        :href="books.index.url()"
                        class="block border-l-4 py-2 pr-4 pl-3 text-base font-medium transition-colors"
                        :class="
                            currentRoute.startsWith('/books')
                                ? 'border-teal-500 bg-indigo-50 text-indigo-700 dark:bg-teal-900 dark:text-indigo-300'
                                : 'border-transparent text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-200'
                        "
                    >
                        {{ t('books') }}
                    </Link>
                    <Link
                        :href="about.url()"
                        class="block border-l-4 py-2 pr-4 pl-3 text-base font-medium transition-colors"
                        :class="
                            currentRoute === '/about'
                                ? 'border-teal-500 bg-indigo-50 text-indigo-700 dark:bg-teal-900 dark:text-indigo-300'
                                : 'border-transparent text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-200'
                        "
                    >
                        {{ t('about_me') }}
                    </Link>
                </div>
                <div
                    class="border-t border-gray-200 pt-4 pb-3 dark:border-gray-700"
                >
                    <div class="flex items-center justify-between px-4">
                        <select
                            :value="currentLocale"
                            @change="switchLanguage"
                            class="rounded border border-gray-300 bg-white px-3 py-1 text-sm font-medium text-gray-900 transition-colors focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                        >
                            <option value="sk">Slovenčina</option>
                            <option value="en">English</option>
                        </select>
                        <button
                            @click="toggleDarkMode"
                            class="rounded-md p-2 text-gray-500 dark:text-gray-400"
                        >
                            <svg
                                v-if="isDark"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
                                />
                            </svg>
                            <svg
                                v-else
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
            <slot />
        </main>

        <!-- Footer -->
        <footer
            class="border-t border-gray-200 bg-white transition-colors dark:border-gray-700 dark:bg-gray-800"
        >
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    © {{ new Date().getFullYear() }} | Radoslav Tomas
                </p>
            </div>
        </footer>
    </div>
</template>
