<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Nova Reserva</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">

        <h1>Olive Properties - Algarve</h1>
        <h3>Nova Reserva</h3>

        <form action="{{ route('vendas.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label class="form-label">Apartamento</label>

                <select name="apartamento" 
                        id="apartamento"
                        class="form-select">

                    @foreach($apartamentos as $apartamento)

                    <option value="{{ $apartamento->referencia }}"
                            data-preco="{{ $apartamento->preco }}">

                        {{ $apartamento->referencia }} - 
                        {{ $apartamento->tipologia }}
                    </option>

                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Nome do Hóspede
                </label>

                <input type="text"
                    name="cliente"
                    class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Data de Entrada
                </label>
                <input type="date"
                    id="data_entrada"
                    name="data_entrada"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Data de Saída
                </label>
                <input type="date"
                        id="data_saida"
                        name="data_saida"
                        class="form-control"
                        readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Valor Total (€)
                </label>
                <input type="number"
                        id="valor_total"
                        name="valor_total"
                        class="form-control"
                        readonly>
            </div>

            <button type="submit"
                class="btn btn-dark">
                Confirmar Reserva
            </button>

        </form>

    </div>
<script>

    // Atualizar valor automaticamente

    function atualizarPreco() {

        let apartamento =
            document.getElementById('apartamento');

        let preco =
            apartamento.options[apartamento.selectedIndex]
            .dataset.preco;

        document.getElementById('valor_total').value = preco;
    }

    // Atualizar data de saída (Reservas são feitas por semana)
    document.getElementById('data_entrada')
        .addEventListener('change', function() {

            let entrada = new Date(this.value);
            entrada.setDate(entrada.getDate() + 7);

            let saida = entrada.toISOString()
                .split('T')[0];
            document.getElementById('data_saida')
                .value = saida;
        });

    // Atualizar preço ao mudar apartamento
    document.getElementById('apartamento')
        .addEventListener('change', atualizarPreco);

    atualizarPreco();

</script>

</body>

</html>