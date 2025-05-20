<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventaire du Stock</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #3490dc; text-align: center; }
        .header { margin-bottom: 20px; }
        .date { text-align: right; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #3490dc; color: white; padding: 10px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .text-center { text-align: center; }
        .total { font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Inventaire du Stock</h1>
        <div class="date">Date : {{ $date }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th class="text-center">Quantité en Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produits as $produit)
            <tr>
                <td>{{ $produit->nom }}</td>
                <td class="text-center">{{ $produit->quantite_en_stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total produits : {{ $produits->count() }} | 
        Total quantité : {{ $produits->sum('quantite_en_stock') }}
    </div>
</body>
</html>