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
        
        // Check if it's in the new repeater format: [{"lang":"sk","content":"..."}, ...]
        if (isset($translations[0]) && is_array($translations[0]) && isset($translations[0]['lang'])) {
            // Find translation for current locale
            foreach ($translations as $item) {
                if (isset($item['lang']) && $item['lang'] === $locale && isset($item['content'])) {
                    return $item['content'];
                }
            }
            
            // Fallback to Slovak
            foreach ($translations as $item) {
                if (isset($item['lang']) && $item['lang'] === 'sk' && isset($item['content'])) {
                    return $item['content'];
                }
            }
            
            // Fallback to first available
            foreach ($translations as $item) {
                if (isset($item['content'])) {
                    return $item['content'];
                }
            }
            
            return null;
        }
        
        // Old format: {"sk": "...", "en": "..."}
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
