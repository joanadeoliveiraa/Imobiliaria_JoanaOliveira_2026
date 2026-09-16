const key = 'olive-theme-v1';

function updateButtons() {
    const dark = document.documentElement.dataset.theme === 'dark';
    document.querySelectorAll('[data-theme-toggle]').forEach(button => {
        button.setAttribute('aria-label', dark ? 'Ativar modo claro' : 'Ativar modo escuro');
        button.setAttribute('aria-pressed', dark ? 'true' : 'false');
    });
}

document.addEventListener('click', event => {
    if (!event.target.closest('[data-theme-toggle]')) return;
    const next = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
    document.documentElement.dataset.theme = next;
    try { localStorage.setItem(key, next); } catch {}
    updateButtons();
    document.dispatchEvent(new Event('olive-theme-changed'));
});
document.addEventListener('DOMContentLoaded', updateButtons);
