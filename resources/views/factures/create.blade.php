@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-file-earmark-plus me-2"></i> Ajouter une facture
        </h2>
        <a href="{{ route('factures.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body bg-light">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Erreur(s) :</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="bi bi-x-circle-fill me-1"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
            <form action="{{ route('factures.store') }}" method="POST">
                @csrf

                <!-- Numéro / Date / Montant -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="numero" class="form-label text-dark">Numéro de facture</label>
                        <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="date_facture" class="form-label text-dark">Date de la facture</label>
                        <input type="date" class="form-control" id="date_facture" name="date_facture" value="{{ old('date_facture') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="montant_total" class="form-label text-dark">Montant total (en DH)</label>
                        <input type="number" step="0.01" class="form-control" id="montant_total" name="montant_total" value="{{ old('montant_total') }}" required>
                    </div>
                </div>

                <!-- Client / Statut -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="client_id" class="form-label text-dark">Client</label>
                        <select class="form-select" id="client_id" name="client_id" required>
                            <option value="">Sélectionner un client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="statut" class="form-label text-dark">Statut</label>
                        <select class="form-select" id="statut" name="statut" required>
                            <option value="en attente" {{ old('statut') == 'en attente' ? 'selected' : '' }}>En attente</option>
                            <option value="payée" {{ old('statut') == 'payée' ? 'selected' : '' }}>Payée</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label text-dark">Description de la facture</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>

                <!-- Produits -->
                <div class="mb-3">
                    <label class="form-label text-dark">Produits</label>
                    <table class="table table-bordered" id="productTable">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th>Total</th>
                                <th><button type="button" class="btn btn-success" id="addProductRow">+</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="products[0][product_id]" class="form-select product-select" onchange="updatePrice(this)">
                                        <option value="">Choisir...</option>
                                        @foreach($produits as $produit)
                                            <option value="{{ $produit->id }}" data-price="{{ $produit->prix }}">{{ $produit->nom }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="products[0][quantity]" class="form-control" value="1"></td>
                                <td><input type="number" name="products[0][price]" class="form-control" value="0.00" step="0.01"></td>
                                <td><input type="number" name="products[0][total]" class="form-control" value="0.00" readonly></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Date échéance -->
                <div class="mb-3">
                    <label for="date_echeance" class="form-label text-dark">Date de sortie de facture</label>
                    <input type="date" class="form-control" id="date_echeance" name="date_echeance">
                </div>

                <!-- Enregistrer -->
                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle-fill me-1"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script -->
<script>
    function updateLineTotal(row) {
        const quantity = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
        const price = parseFloat(row.querySelector('input[name*="[price]"]').value) || 0;
        const totalInput = row.querySelector('input[name*="[total]"]');
        totalInput.value = (quantity * price).toFixed(2);
    }

    function attachListeners(row) {
        const quantity = row.querySelector('input[name*="[quantity]"]');
        const price = row.querySelector('input[name*="[price]"]');

        quantity.addEventListener('input', () => updateLineTotal(row));
        price.addEventListener('input', () => updateLineTotal(row));
    }

    function updatePrice(select) {
        const price = select.options[select.selectedIndex].dataset.price;
        const row = select.closest('tr');
        const priceInput = row.querySelector('input[name*="[price]"]');
        priceInput.value = parseFloat(price).toFixed(2);
        updateLineTotal(row);
    }

    document.querySelectorAll('#productTable tbody tr').forEach(attachListeners);

    document.getElementById('addProductRow').addEventListener('click', function () {
        const table = document.querySelector('#productTable tbody');
        const index = table.rows.length;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select name="products[${index}][product_id]" class="form-select product-select" onchange="updatePrice(this)">
                    <option value="">Choisir...</option>
                    @foreach($produits as $produit)
                        <option value="{{ $produit->id }}" data-price="{{ $produit->prix }}">{{ $produit->nom }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="products[${index}][quantity]" class="form-control" value="1"></td>
            <td><input type="number" name="products[${index}][price]" class="form-control" value="0.00" step="0.01"></td>
            <td><input type="number" name="products[${index}][total]" class="form-control" value="0.00" readonly></td>
            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">-</button></td>
        `;

        table.appendChild(row);
        attachListeners(row);
    });

    function removeRow(button) {
        button.closest('tr').remove();
    }
</script>
@endsection
