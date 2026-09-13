const form = document.querySelector('[data-reservation-form]');
if (form) {
    const clientSearch = form.querySelector('#cliente_pesquisa');
    const clientSelect = form.querySelector('#cliente_id');
    const clientStatus = form.querySelector('#cliente_resultados');
    const clientOptions = Array.from(clientSelect.options).slice(1);
    const normalize = value => value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLocaleLowerCase('pt-PT').trim();
    clientSearch.addEventListener('input', () => {
        const query = normalize(clientSearch.value);
        const digits = query.replace(/\D/g, '');
        const numericQuery = digits.length > 0 && /^[\d\s+().-]+$/.test(query);
        const selected = clientSelect.value;
        const matches = clientOptions.filter(option => normalize(option.dataset.name).includes(query)
            || (numericQuery && [option.dataset.phone, option.dataset.nif].some(value => value.replace(/\D/g, '').includes(digits))));
        clientSelect.replaceChildren(new Option(matches.length ? 'Selecione um cliente' : 'Nenhum cliente encontrado', ''), ...matches);
        clientSelect.value = matches.some(option => option.value === selected) ? selected : '';
        clientStatus.textContent = matches.length
            ? `${matches.length} cliente${matches.length === 1 ? '' : 's'} encontrado${matches.length === 1 ? '' : 's'}. Selecione na lista abaixo.`
            : 'Nenhum cliente encontrado. Experimente outro nome, contacto ou NIF, ou crie um novo cliente.';
    });
    const property = form.querySelector('#apartamento_id');
    const arrival = form.querySelector('#data_entrada');
    const departure = form.querySelector('#data_saida');
    const money = new Intl.NumberFormat('pt-PT', { style: 'currency', currency: 'EUR' });
    const day = 86400000;
    const update = () => {
        const nights = (Date.parse(departure.value) - Date.parse(arrival.value)) / day;
        const price = Number(property.selectedOptions[0]?.dataset.preco);
        departure.min = arrival.value ? new Date(Date.parse(arrival.value) + day).toISOString().slice(0, 10) : '';
        const valid = Number.isFinite(nights) && nights > 0 && Number.isFinite(price);
        form.querySelector('#reservation-nights').textContent = valid ? `${nights} noites · estimativa da estadia` : 'Escolha a propriedade e as datas para ver a estimativa.';
        form.querySelector('#reservation-estimate').textContent = valid ? money.format(Math.round(Math.round(price * 100) * nights / 7) / 100) : '—';
    };
    arrival.addEventListener('change', () => {
        if (arrival.value && (!departure.value || departure.value <= arrival.value)) {
            departure.value = new Date(Date.parse(arrival.value) + 7 * day).toISOString().slice(0, 10);
        }
        update();
    });
    property.addEventListener('change', update);
    departure.addEventListener('change', update);
    update();
}
