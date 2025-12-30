import { usePage } from '@inertiajs/vue3'

export function useTranslation() {
  const page = usePage()
  const locale = page.props.locale || 'sk'

  const t = (key: string): string => {
    const translations = page.props.translations as Record<string, string>
    return translations?.[key] || key
  }

  const trans = (obj: Record<string, string> | null | undefined): string => {
    if (!obj) return ''
    return obj[locale as string] || obj['sk'] || obj['en'] || ''
  }

  return {
    t,
    trans,
    locale,
  }
}
