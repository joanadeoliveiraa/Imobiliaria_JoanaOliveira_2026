document.addEventListener('click', event => {
    const trigger = event.target.closest('[data-delete-url]');
    const dialog = document.getElementById('delete-confirmation');
    if (trigger && dialog) {
        document.getElementById('delete-confirmation-form').action = trigger.dataset.deleteUrl;
        dialog.showModal();
    }
    if (event.target.closest('[data-close-confirmation]') && dialog) dialog.close();
});
