<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Factures</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { color: #3490dc; text-align: center; }
        .date { text-align: right; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; font-size: 13px; }
        th { background-color: #3490dc; color: white; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h1>Liste des Factures</h1>
    <div class="date">Date d'export : {{ $date }}</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Numéro</th>
                <th>Client</th>
                <th>Date</th>
                <th>Montant</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($factures as $facture)
            <tr>
                <td>{{ $facture->id }}</td>
                <td>{{ $facture->numero }}</td>
                <td>{{ $facture->client->nom }}</td>
                <td>{{ $facture->date_facture }}</td>
                <td>{{ number_format($facture->montant_total, 2) }} MAD</td>
                <td>{{ $facture->statut }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
