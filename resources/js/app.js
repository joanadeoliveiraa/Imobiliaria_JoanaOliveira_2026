import './management';
import './reservation-form';
import './documents';
import './theme';

import Alpine from 'alpinejs';
import cookieNotice from './cookie-notice';
import faqTabs from './faq-tabs';

window.Alpine = Alpine;
Alpine.data('cookieNotice', cookieNotice);
Alpine.data('faqTabs', faqTabs);

Alpine.start();
