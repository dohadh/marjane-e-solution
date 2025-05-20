<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export des Ventes</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .header { margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .date { font-size: 12px; color: #666; }
        .total { font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Rapport des Ventes</div>
        <div class="date">Généré le : {{ now()->format('d/m/Y H:i') }}</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventes as $vente)
                @foreach($vente->produits as $produit)
                <tr>
                    <td>{{ $vente->id }}</td>
                    <td>{{ $vente->client->nom }}</td>
                    <td>{{ $produit->nom }}</td>
                    <td>{{ $produit->pivot->quantite }}</td>
                    <td>{{ number_format($produit->pivot->prix_vente, 2) }} MAD</td>
                    <td>{{ number_format($produit->pivot->prix_vente * $produit->pivot->quantite, 2) }} MAD</td>
                    <td>{{ \Carbon\Carbon::parse($vente->date_vente)->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            @endforeach
            <tr class="total">
                <td colspan="5" class="text-right">Total Général</td>
                <td colspan="2">{{ number_format($total, 2) }} MAD</td>
            </tr>
        </tbody>
    </table>
</body>
</html>