import { test, afterEach } from 'node:test';
import assert from 'node:assert/strict';
import cookieNotice, { CHOICE_KEY, CHOICE_LIFETIME } from '../resources/js/cookie-notice.js';

afterEach(() => { delete globalThis.localStorage; });

test('first visit, save and subsequent visits retain necessary-only preference', () => {
    const values = new Map();
    globalThis.localStorage = { getItem: key => values.get(key) ?? null, setItem: (key, value) => values.set(key, value) };
    const first = cookieNotice();
    first.init();
    assert.equal(first.visible, true);
    first.save();
    assert.equal(first.visible, false);
    assert.equal(JSON.parse(values.get(CHOICE_KEY)).necessaryOnly, true);
    const next = cookieNotice();
    next.init();
    assert.equal(next.visible, false);
});

test('expired, malformed and incompatible preferences show the notice again', () => {
    for (const value of ['invalid', 'null', '{}', JSON.stringify({ version: 1, necessaryOnly: true, expiresAt: Date.now() - 1 }), JSON.stringify({ version: 2, necessaryOnly: true, expiresAt: Date.now() + CHOICE_LIFETIME })]) {
        globalThis.localStorage = { getItem: () => value };
        const notice = cookieNotice();
        notice.init();
        assert.equal(notice.visible, true);
    }
});

test('blocked storage reports the failure without throwing or claiming persistence', () => {
    globalThis.localStorage = { getItem() { throw Error('blocked'); }, setItem() { throw Error('blocked'); } };
    const notice = cookieNotice();
    notice.init();
    notice.save();
    assert.equal(notice.visible, true);
    assert.equal(notice.storageFailed, true);
});
