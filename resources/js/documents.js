// Refresh the emission time even when printing a tab opened earlier.
window.addEventListener('beforeprint', () => {
    const issuedAt = new Date();
    const formatted = new Intl.DateTimeFormat('pt-PT', {
        timeZone: 'Europe/Lisbon', day: '2-digit', month: '2-digit', year: 'numeric',
        hour: '2-digit', minute: '2-digit', second: '2-digit', hourCycle: 'h23',
    }).format(issuedAt);
    document.querySelectorAll('[data-document-issued-at]').forEach(element => {
        element.dateTime = issuedAt.toISOString();
        element.textContent = formatted;
    });
});
