const normalizeClient = value => (value || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLocaleLowerCase('pt-PT').trim();

export function matchingClients(options, search) {
    const query = normalizeClient(search);
    if (!query) return [];
    const digits = query.replace(/\D/g, '');
    return options.filter(option => normalizeClient(option.dataset.name).includes(query)
        || (digits && [option.dataset.phone, option.dataset.nif].some(value => (value || '').replace(/\D/g, '').includes(digits))));
}

const form = typeof document === 'undefined' ? null : document.querySelector('[data-reservation-form]');
if (form) {
    const clientSearch = form.querySelector('#cliente_pesquisa');
    const clientSelect = form.querySelector('#cliente_id');
    const clientStatus = form.querySelector('#cliente_resultados');
    const clientOptions = Array.from(clientSelect.options).slice(1);
    const clientList = form.querySelector('#cliente_lista');
    const clientLabel = form.querySelector('[data-client-list-label]');
    const selectLabel = form.querySelector('[data-client-select-label]');
    const selectedSummary = form.querySelector('#cliente_escolhido');
    clientSelect.hidden = true;
    clientSelect.required = false;
    selectLabel.hidden = true;
    clientLabel.hidden = false;
    const selectedOption = clientSelect.selectedOptions[0];
    if (selectedOption?.value) {
        selectedSummary.textContent = `Cliente selecionado: ${selectedOption.textContent}`;
        selectedSummary.hidden = false;
    }
    clientSearch.addEventListener('input', () => {
        clientSearch.setCustomValidity('');
        clientSelect.value = '';
        selectedSummary.hidden = true;
        const matches = matchingClients(clientOptions, clientSearch.value);
        clientList.replaceChildren();
        for (const option of matches.slice(0, 8)) {
            const item = document.createElement('li');
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = option.textContent;
            button.addEventListener('click', () => {
                clientSelect.value = option.value;
                clientSearch.value = option.dataset.name;
                clientSearch.setCustomValidity('');
                selectedSummary.textContent = `Cliente selecionado: ${option.textContent}`;
                selectedSummary.hidden = false;
                clientList.hidden = true;
                clientStatus.textContent = 'Cliente selecionado.';
            });
            item.append(button);
            clientList.append(item);
        }
        clientList.hidden = matches.length === 0;
        clientStatus.textContent = !clientSearch.value.trim()
            ? 'Pesquise pelo nome, telefone ou NIF e escolha um cliente.'
            : matches.length
                ? `${matches.length} cliente${matches.length === 1 ? '' : 's'} encontrado${matches.length === 1 ? '' : 's'}. ${matches.length > 8 ? 'A mostrar os primeiros 8. ' : ''}Selecione na lista abaixo.`
                : 'Nenhum cliente encontrado. Experimente outro nome, telefone ou NIF, ou crie um novo cliente.';
    });
    form.addEventListener('submit', event => {
        if (clientSelect.value) return;
        event.preventDefault();
        clientSearch.setCustomValidity('Escolha um cliente da lista.');
        clientSearch.reportValidity();
        clientSearch.focus();
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
