<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rapport Consolidé - {{ $periode->libelle }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #4f46e5; text-align: center; }
        h2 { color: #374151; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #d1d5db; padding: 12px; text-align: left; }
        th { background-color: #f3f4f6; }
        .taux { font-size: 2em; font-weight: bold; color: #10b981; text-align: center; margin: 40px 0; }
        .footer { text-align: center; margin-top: 50px; color: #6b7280; }
    </style>
</head>
<body>
    <h1>Rapport Consolidé</h1>
    <h2>Période : {{ $periode->libelle }}</h2>
    <p style="text-align: center;">
        Du {{ $periode->date_debut->format('d/m/Y') }} au {{ $periode->date_fin->format('d/m/Y') }}
    </p>

    <div class="taux">
        Taux d'atteinte global : {{ $tauxAtteinte }}%
    </div>

    <h2>Objectifs stratégiques</h2>
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Description</th>
                <th>Cible</th>
                <th>Unité</th>
            </tr>
        </thead>
        <tbody>
            @foreach($objectifsGlobaux as $objectif)
                <tr>
                    <td>{{ $objectif->service->nom }}</td>
                    <td>{{ $objectif->description }}</td>
                    <td>{{ $objectif->cible }}</td>
                    <td>{{ $objectif->unite }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Rapports validés</h2>
    <p style="text-align: center; font-size: 1.2em;">
        {{ $rapportsValides }} rapport(s) validé(s)
    </p>

    <div class="footer">
        Généré le {{ now()->format('d/m/Y à H:i') }} par e-GoalTrack Enterprise
    </div>
</body>
</html>