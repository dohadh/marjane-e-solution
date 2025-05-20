<!DOCTYPE html>
<html>
<head>
    <title>Rupture de Stock - {{ $date }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        h1 { color: #dc3545; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 30px; text-align: right; font-size: 0.8em; }
    </style>
</head>
<body>
    <h1>Produits en rupture de stock</h1>
    <p style="text-align: center">Date : {{ $date }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Référence</th>
                <th>Nom</th>
                <th>Quantité</th>
                <th>Dernière mise à jour</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ruptures as $produit)
            <tr>
                <td>{{ $produit->reference }}</td>
                <td>{{ $produit->nom }}</td>
                <td style="color: red;">{{ $produit->quantite_en_stock }}</td>
                <td>{{ $produit->updated_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Généré le {{ now()->format('d/m/Y H:i') }} par {{ auth()->user()->name ?? 'Système' }}
    </div>
</body>
</html>