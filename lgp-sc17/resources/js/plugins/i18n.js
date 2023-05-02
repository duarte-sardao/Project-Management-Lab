import { createI18n } from 'vue-i18n';
import messages from '@intlify/unplugin-vue-i18n/messages'

export const i18n = new createI18n({
    legacy: false,
    locale: 'pt', // set locale
    fallbacklocale: 'en', // set fallback locale
    messages,    //set locale translations
});

export function changeLocale(locale) {
    if (locale !== 'pt' && locale !== 'en') return;
    i18n.global.locale.value = locale;
};
