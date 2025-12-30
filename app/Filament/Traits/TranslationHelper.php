<?php

namespace App\Filament\Traits;

trait TranslationHelper
{
    protected static function getTranslation($state): string
    {
        if (empty($state)) {
            return 'N/A';
        }

        // Convert ArrayObject or object to array if needed
        if (is_object($state)) {
            $state = json_decode(json_encode($state), true);
        }

        if (!is_array($state)) {
            return 'N/A';
        }

        // Check if it's repeater format: [{"lang":"sk","content":"..."}, ...]
        if (isset($state[0]) && is_array($state[0]) && isset($state[0]['lang'])) {
            // Try to find Slovak translation
            foreach ($state as $item) {
                if (isset($item['lang']) && $item['lang'] === 'sk' && isset($item['content'])) {
                    return strip_tags($item['content']);
                }
            }
            // Fallback to first available
            foreach ($state as $item) {
                if (isset($item['content'])) {
                    return strip_tags($item['content']);
                }
            }
            return 'N/A';
        }

        // Old format: {"sk": "...", "en": "..."}
        return $state['sk'] ?? $state['en'] ?? 'N/A';
    }
}
