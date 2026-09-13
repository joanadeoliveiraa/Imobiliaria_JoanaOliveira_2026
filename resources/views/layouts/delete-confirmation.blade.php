<dialog id="delete-confirmation" class="confirmation-dialog" aria-labelledby="delete-confirmation-title">
    <form method="POST" id="delete-confirmation-form">
        @csrf
        @method('DELETE')
        <h2 id="delete-confirmation-title">Confirmar eliminação</h2>
        <p>Confirma que pretende eliminar este registo? Esta operação não pode ser anulada.</p>
        <div class="form-actions">
            <button type="button" class="button button--outline" data-close-confirmation autofocus>Voltar</button>
            <button type="submit" class="button button--danger">Confirmar eliminação</button>
        </div>
    </form>
</dialog>
