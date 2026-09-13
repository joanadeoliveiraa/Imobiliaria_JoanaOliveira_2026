import './bootstrap';
import './management';

import Alpine from 'alpinejs';
import cookieNotice from './cookie-notice';

window.Alpine = Alpine;
Alpine.data('cookieNotice', cookieNotice);

Alpine.start();
