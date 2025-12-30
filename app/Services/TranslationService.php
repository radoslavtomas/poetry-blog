<?php

namespace App\Services;

class TranslationService
{
    /**
     * Get translated value from JSON column based on current locale
     */
    public static function get(?array $translations, ?string $locale = null): ?string
    {
        if ($translations === null) {
            return null;
        }

        $locale = $locale ?? app()->getLocale();
        
        // Return translation for current locale if exists
        if (isset($translations[$locale])) {
            return $translations[$locale];
        }
        
        // Fallback to default language (Slovak)
        if (isset($translations['sk'])) {
            return $translations['sk'];
        }
        
        // Fallback to first available translation
        return reset($translations) ?: null;
    }
}
