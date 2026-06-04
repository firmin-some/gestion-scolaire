<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; color:#222; padding:20px; }
        .header { text-align:center; margin-bottom:16px; }
        .header h1 { font-size:18px; margin-bottom:4px; }
        .header p { font-size:10px; color:#555; }
        .info { margin-bottom:18px; background:#f8f9fa; padding:12px 14px; border-radius:8px; font-size:11px; }
        .info span { display:inline-block; margin-right:18px; }
        table { width:100%; border-collapse:collapse; margin-top:10px; }
        th, td { border:1px solid #bbb; padding:8px; text-align:left; }
        th { background:#343a40; color:#fff; font-size:11px; }
        tr:nth-child(even) { background:#f4f4f4; }
        .moy { font-weight:bold; }
        .mention { font-weight:bold; }
        .mention-excellent { color:#198754; }
        .mention-bien { color:#0d6efd; }
        .mention-assez { color:#fd7e14; }
        .mention-passable { color:#ffc107; }
        .mention-insuffisant { color:#dc3545; }
        .footer { margin-top:22px; font-size:10px; color:#666; text-align:center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bulletin de Notes</h1>
        <p>{{ $trimestre === 'T1' ? '1er Trimestre' : ($trimestre === 'T2' ? '2e Trimestre' : '3e Trimestre') }}</p>
    </div>

    <div class="info">
        <span><strong>Élève :</strong> {{ $eleve->prenom }} {{ $eleve->nom }}</span>
        <span><strong>Classe :</strong> {{ $eleve->classe->nom ?? '—' }}</span>
        <span><strong>Parent :</strong> {{ $eleve->nom_parent ?? '—' }}</span>
        <span><strong>Année :</strong> {{ date('Y') }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @php
                $notes = $eleve->notes->keyBy('matiere');
                $valides = [];
            @endphp
            @foreach($matieres as $matiere)
                @php
                    $note = $notes->has($matiere) ? $notes[$matiere]->note : null;
                    if ($note !== null) {
                        $valides[] = $note;
                    }
                @endphp
                <tr>
                    <td>{{ $matiere }}</td>
                    <td>{{ $note !== null ? number_format($note, 2, ',', ' ') : '—' }}</td>
                </tr>
            @endforeach
            @php
                $moy = count($valides) ? round(array_sum($valides) / count($valides), 2) : null;
                $mention = $moy === null ? '—' : (
                    $moy >= 16 ? 'Excellent' : (
                    $moy >= 14 ? 'Bien' : (
                    $moy >= 12 ? 'Assez bien' : (
                    $moy >= 10 ? 'Passable' : 'Insuffisant'))));
                $mentionClass = $moy === null ? '' : (
                    $moy >= 16 ? 'mention-excellent' : (
                    $moy >= 14 ? 'mention-bien' : (
                    $moy >= 12 ? 'mention-assez' : (
                    $moy >= 10 ? 'mention-passable' : 'mention-insuffisant'))));
            @endphp
            <tr>
                <th>Moyenne générale</th>
                <td class="moy">{{ $moy !== null ? number_format($moy, 2, ',', ' ') : '—' }}</td>
            </tr>
            <tr>
                <th>Mention</th>
                <td class="mention {{ $mentionClass }}">{{ $mention }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Bulletin généré le {{ now()->format('d/m/Y \à H:i') }}
    </div>
</body>
</html>
