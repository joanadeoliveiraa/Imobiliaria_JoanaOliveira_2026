import { test } from 'node:test';
import assert from 'node:assert/strict';
import { matchingClients } from '../resources/js/reservation-form.js';

const clients = [
    { dataset: { name: 'Joana de Oliveira', phone: '912 345 678', nif: '123456789' } },
    { dataset: { name: 'Maria Costa', phone: '934 567 890', nif: '987654321' } },
];

test('client search finds existing customers by name, phone and NIF', () => {
    assert.deepEqual(matchingClients(clients, 'joana'), [clients[0]]);
    assert.deepEqual(matchingClients(clients, '912345'), [clients[0]]);
    assert.deepEqual(matchingClients(clients, 'NIF 123456789'), [clients[0]]);
    assert.deepEqual(matchingClients(clients, 'não existe'), []);
    assert.deepEqual(matchingClients(clients, ''), []);
});
