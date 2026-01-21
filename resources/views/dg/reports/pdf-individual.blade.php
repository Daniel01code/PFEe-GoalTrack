<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rapport - {{ $rapport->user->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
        h1 { color: #4f46e5; text-align: center; }
        h2 { color: #374151; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; }
        .section { margin-bottom: 30px; }
        .label { font-weight: bold; color: #4b5563; }
        .value { color: #1f2937; }
        .footer { text-align: center; margin-top: 50px; color: #6b7280; }
    </style>
</head>
<body>
    <h1>Rapport Individuel</h1>

    <div class="section">
        <p><span class="label">Employé :</span> <span class="value">{{ $rapport->user->name }}</span></p>
        <p><span class="label">Service :</span> <span class="value">{{ $rapport->user->service->nom ?? 'Non défini' }}</span></p>
        <p><span class="label">Chef :</span> <span class="value">{{ $rapport->user->chef->name ?? 'Non défini' }}</span></p>
        <p><span class="label">Période :</span> <span class="value">{{ $rapport->periode->libelle }}</span></p>
        <p><span class="label">Soumis le :</span> <span class="value">{{ $rapport->date_soumission?->format('d/m/Y à H:i') }}</span></p>
        <p><span class="label">Statut :</span> <span class="value">{{ ucfirst($rapport->statut) }}</span></p>
    </div>

    @if($objectif = $rapport->user->objectifsIndividuels->where('objectif_global.periode_id', $rapport->periode_id)->first())
        <div class="section">
            <h2>Objectif assigné</h2>
            <p><span class="label">Objectif :</span> <span class="value">{{ $objectif->objectifGlobal->description }}</span></p>
            <p><span class="label">Cible personnelle :</span> <span class="value">{{ $objectif->cible_personnelle }} ({{ $objectif->objectifGlobal->unite }})</span></p>
            <p><span class="label">Progression :</span> <span class="value">{{ $objectif->pourcentage_atteinte }}%</span></p>
        </div>
    @endif

    <div class="section">
        <h2>Contenu du rapport</h2>
        <p><span class="label">Réalisations :</span></p>
        <p class="value whitespace-pre-line">{{ $rapport->contenu['realisations'] ?? 'Non renseigné' }}</p>

        <p class="mt-4"><span class="label">Difficultés :</span></p>
        <p class="value whitespace-pre-line">{{ $rapport->contenu['difficultes'] ?? 'Aucune' }}</p>

        @if($rapport->pourcentage_atteinte !== null)
            <p class="mt-4"><span class="label">Pourcentage déclaré :</span> <span class="value">{{ $rapport->pourcentage_atteinte }}%</span></p>
        @endif
    </div>

    @if($rapport->validation)
        <div class="section">
            <h2>Validation</h2>
            <p><span class="label">Statut :</span> <span class="value">{{ ucfirst($rapport->validation->statut) }}</span></p>
            <p><span class="label">Commentaire :</span> <span class="value">{{ $rapport->validation->commentaire ?? 'Aucun' }}</span></p>
            <p><span class="label">Validé le :</span> <span class="value">{{ $rapport->validation->date_validation?->format('d/m/Y à H:i') }}</span></p>
        </div>
    @endif

    <div class="footer">
        Généré le {{ now()->format('d/m/Y à H:i') }} par e-GoalTrack Enterprise
    </div>
</body>
</html>