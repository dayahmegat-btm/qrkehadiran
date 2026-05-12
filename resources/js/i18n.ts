import { createI18n } from 'vue-i18n';
import ms from './locales/ms';
import en from './locales/en';

const i18n = createI18n({
    legacy: false,
    locale: 'ms', // default locale (Malay)
    fallbackLocale: 'en',
    messages: {
        ms,
        en,
    },
});

export default i18n;
