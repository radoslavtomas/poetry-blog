import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

export function useTranslation() {
  const page = usePage()
  const locale = computed(() => page.props.locale || 'sk')

  const t = (key: string): string => {
    const translations = page.props.translations as Record<string, string>
    return translations?.[key] || key
  }

  const trans = (obj: Record<string, string> | any[] | null | undefined): string => {
    if (!obj) return ''
    
    const currentLocale = locale.value
    
    // Handle new repeater format: [{lang: "sk", content: "..."}, ...]
    if (Array.isArray(obj)) {
      // Try to find translation for current locale
      const currentLocaleItem = obj.find((item: any) => item.lang === currentLocale)
      if (currentLocaleItem?.content) return currentLocaleItem.content
      
      // Fallback to Slovak
      const skItem = obj.find((item: any) => item.lang === 'sk')
      if (skItem?.content) return skItem.content
      
      // Fallback to first item with content
      const firstItem = obj.find((item: any) => item.content)
      if (firstItem?.content) return firstItem.content
      
      return ''
    }
    
    // Old format: {sk: "...", en: "..."}
    return obj[currentLocale as string] || obj['sk'] || obj['en'] || ''
  }

  return {
    t,
    trans,
    locale,
  }
}
