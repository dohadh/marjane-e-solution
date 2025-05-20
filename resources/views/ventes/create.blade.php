@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-file-earmark-plus me-2"></i> Ajouter une Vente
        </h2>
        <a href="{{ route('ventes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body bg-light">
            <form action="{{ route('ventes.store') }}" method="POST">
                @csrf

                <!-- Client -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="client_id" class="form-label text-dark">Client</label>
                        <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                            <option value="">Sélectionner un client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date de vente -->
                    <div class="col-md-6">
                        <label for="date_vente" class="form-label text-dark">Date de Vente</label>
                        <input type="date" class="form-control @error('date_vente') is-invalid @enderror" id="date_vente" name="date_vente" value="{{ old('date_vente') }}" required>
                        @error('date_vente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Produits -->
                <div class="mb-3">
                    <label class="form-label text-dark">Produits</label>
                    <table class="table table-bordered" id="productTable">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix de vente</th>
                                <th>Total</th>
                                <th><button type="button" class="btn btn-success" id="addProductRow">+</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-select" name="produits[0][id]" required>
                                        <option value="">Sélectionner un produit</option>
                                        @foreach($produits as $produit)
                                            <option value="{{ $produit->id }}" {{ old('produits.0.id') == $produit->id ? 'selected' : '' }}>
                                                {{ $produit->nom }} ({{ $produit->quantite_en_stock }} en stock)
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="produits[0][quantite]" class="form-control" value="{{ old('produits.0.quantite', 1) }}" required></td>
                                <td><input type="number" name="produits[0][prix_vente]" class="form-control" value="{{ old('produits.0.prix_vente') }}" required></td>
                                <td><input type="number" name="produits[0][total]" class="form-control" value="{{ old('produits.0.total', 0) }}" readonly></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle-fill me-1"></i> Enregistrer la Vente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Calcul automatique du total d'une ligne
    function updateLineTotal(row) {
        const quantityInput = row.querySelector('input[name*="[quantite]"]');
        const priceInput = row.querySelector('input[name*="[prix_vente]"]');
        const totalInput = row.querySelector('input[name*="[total]"]');

        const quantity = parseFloat(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = (quantity * price).toFixed(2);
        totalInput.value = total;
    }

    // Ajouter les événements sur les inputs d'une ligne
    function attachListeners(row) {
        const quantityInput = row.querySelector('input[name*="[quantite]"]');
        const priceInput = row.querySelector('input[name*="[prix_vente]"]');
        quantityInput.addEventListener('input', () => updateLineTotal(row));
        priceInput.addEventListener('input', () => updateLineTotal(row));
    }

    // Appliquer au premier produit déjà présent
    document.querySelectorAll('#productTable tbody tr').forEach(attachListeners);

    // Ajouter une nouvelle ligne de produit
    document.getElementById('addProductRow').addEventListener('click', function () {
        const table = document.getElementById('productTable').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);
        row.innerHTML = `
            <td>
                <select class="form-select" name="produits[${rowCount}][id]" required>
                    <option value="">Sélectionner un produit</option>
                    @foreach($produits as $produit)
                        <option value="{{ $produit->id }}">{{ $produit->nom }} ({{ $produit->quantite_en_stock }} en stock)</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="produits[${rowCount}][quantite]" class="form-control" value="1" required></td>
            <td><input type="number" name="produits[${rowCount}][prix_vente]" class="form-control" value="0.00" required></td>
            <td><input type="number" name="produits[${rowCount}][total]" class="form-control" value="0.00" readonly></td>
            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">-</button></td>
        `;
        attachListeners(row); // Appliquer les events à la nouvelle ligne
    });

    // Supprimer une ligne
    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
@endsection
