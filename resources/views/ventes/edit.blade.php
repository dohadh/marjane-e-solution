@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Modifier la vente #{{ $vente->id }}</h2>
        <a href="{{ route('ventes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Détails de la vente</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('ventes.update', $vente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="client_id" class="form-label">Client</label>
                        <select name="client_id" id="client_id" class="form-select" required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $vente->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="date_vente" class="form-label">Date</label>
                        <input type="date" name="date_vente" id="date_vente" 
                               value="{{ old('date_vente', \Carbon\Carbon::parse($vente->date_vente)->format('Y-m-d')) }}"
                               class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Produits</label>
                        <table class="table table-bordered" id="productTable">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix de vente</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vente->produits as $index => $produit)
                                <tr>
                                    <td>
                                        <select class="form-select" name="produits[{{ $index }}][id]" required>
                                            <option value="">Sélectionner un produit</option>
                                            @foreach($produits as $p)
                                                <option value="{{ $p->id }}" 
                                                    {{ $produit->id == $p->id ? 'selected' : '' }}
                                                    data-prix="{{ $p->prix }}">
                                                    {{ $p->nom }} ({{ $p->quantite_en_stock }} en stock)
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="produits[{{ $index }}][quantite]" 
                                               value="{{ $produit->pivot->quantite }}" 
                                               class="form-control" min="1" required>
                                    </td>
                                    <td>
                                        <input type="number" name="produits[{{ $index }}][prix_vente]" 
                                               value="{{ $produit->pivot->prix_vente }}" 
                                               class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="number" name="produits[{{ $index }}][total]" 
                                               value="{{ $produit->pivot->quantite * $produit->pivot->prix_vente }}" 
                                               class="form-control" readonly>
                                    </td>
                                    <td>
                                        @if($index > 0)
                                            <button type="button" class="btn btn-danger removeRow">-</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="button" id="addProductRow" class="btn btn-success mt-2">
                            <i class="bi bi-plus"></i> Ajouter un produit
                        </button>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Total Général</label>
                        <input type="number" id="grandTotal" name="total" class="form-control" value="{{ $vente->total }}" readonly>
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-save2-fill me-1"></i> Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calcul du total pour une ligne
    function calculateLineTotal(row) {
        const quantity = parseFloat(row.querySelector('input[name*="[quantite]"]').value) || 0;
        const price = parseFloat(row.querySelector('input[name*="[prix_vente]"]').value) || 0;
        const total = (quantity * price).toFixed(2);
        row.querySelector('input[name*="[total]"]').value = total;
        return parseFloat(total);
    }

    // Calcul du total général
    function calculateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('#productTable tbody tr').forEach(row => {
            grandTotal += calculateLineTotal(row);
        });
        document.getElementById('grandTotal').value = grandTotal.toFixed(2);
    }

    // Mise à jour du prix de vente lorsqu'un produit est sélectionné
    function updatePriceFromProduct(row) {
        const select = row.querySelector('select[name*="[id]"]');
        const priceInput = row.querySelector('input[name*="[prix_vente]"]');
        if (select.selectedIndex > 0) {
            const selectedOption = select.options[select.selectedIndex];
            priceInput.value = selectedOption.getAttribute('data-prix');
        }
        calculateLineTotal(row);
        calculateGrandTotal();
    }

    // Ajouter les événements à une ligne
    function attachRowEvents(row) {
        row.querySelector('select[name*="[id]"]').addEventListener('change', function() {
            updatePriceFromProduct(row);
        });
        
        row.querySelector('input[name*="[quantite]"]').addEventListener('input', function() {
            calculateLineTotal(row);
            calculateGrandTotal();
        });
        
        row.querySelector('input[name*="[prix_vente]"]').addEventListener('input', function() {
            calculateLineTotal(row);
            calculateGrandTotal();
        });
        
        if (row.querySelector('.removeRow')) {
            row.querySelector('.removeRow').addEventListener('click', function() {
                row.remove();
                calculateGrandTotal();
            });
        }
    }

    // Ajouter une nouvelle ligne de produit
    document.getElementById('addProductRow').addEventListener('click', function() {
        const tbody = document.querySelector('#productTable tbody');
        const rowCount = tbody.querySelectorAll('tr').length;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select class="form-select" name="produits[${rowCount}][id]" required>
                    <option value="">Sélectionner un produit</option>
                    @foreach($produits as $p)
                        <option value="{{ $p->id }}" data-prix="{{ $p->prix }}">
                            {{ $p->nom }} ({{ $p->quantite_en_stock }} en stock)
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="produits[${rowCount}][quantite]" 
                       class="form-control" min="1" value="1" required>
            </td>
            <td>
                <input type="number" name="produits[${rowCount}][prix_vente]" 
                       class="form-control" value="0" required>
            </td>
            <td>
                <input type="number" name="produits[${rowCount}][total]" 
                       class="form-control" value="0" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-danger removeRow">-</button>
            </td>
        `;
        tbody.appendChild(row);
        attachRowEvents(row);
    });

    // Attacher les événements aux lignes existantes
    document.querySelectorAll('#productTable tbody tr').forEach(row => {
        attachRowEvents(row);
    });

    // Calculer le total initial
    calculateGrandTotal();
});
</script>
@endsection