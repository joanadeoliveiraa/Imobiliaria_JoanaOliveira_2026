import test from 'node:test';
import assert from 'node:assert/strict';
import faqTabs from '../resources/js/faq-tabs.js';

test('keyboard navigation wraps, supports Home/End and moves focus', () => {
    let focused;
    globalThis.document = { getElementById: id => ({ focus: () => { focused = id; } }) };
    try {
        const tabs = faqTabs();
        for (const [key, index, expected] of [['ArrowLeft', 0, 7], ['ArrowRight', 7, 0], ['Home', 4, 0], ['End', 2, 7], ['ArrowDown', 0, 1], ['ArrowUp', 1, 0]]) {
            let prevented = false;
            tabs.navigate({ key, preventDefault: () => { prevented = true; } }, index, 8);
            assert.equal(tabs.active, expected);
            assert.equal(focused, `faq-tab-${expected}`);
            assert.equal(prevented, true);
        }
        tabs.navigate({ key: 'Tab', preventDefault: () => assert.fail('Tab must remain native') }, 0, 8);
    } finally {
        delete globalThis.document;
    }
});
