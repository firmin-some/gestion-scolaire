<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size:11px; color:#1a1a1a; padding:20px; }

        .header { text-align:center; margin-bottom:16px; padding-bottom:12px; border-bottom:3px solid #1a1a2e; }
        .header h1 { font-size:18px; color:#1a1a2e; }
        .header p { color:#666; font-size:10px; margin-top:2px; }

        .bulletin-title {
            background:#1a1a2e; color:#f0c040; text-align:center;
            padding:8px; font-size:13px; font-weight:bold;
            text-transform:uppercase; letter-spacing:1px;
            margin-bottom:16px; border-radius:4px;
        }

        .classe-info {
            display:flex; justify-content:space-between;
            background:#f8f9fa; padding:8px 12px;
            border-radius:4px; margin-bottom:16px; font-size:11px;
        }

        table { width:100%; border-collapse:collapse; margin-bottom:20px; font-size:10px; }
        th { background:#1a1a2e; color:#fff; padding:6px 8px; text-align:center; font-size:10px; }
        th.text-left { text-align:left; }
        td { padding:6px 8px; border:1px solid #dee2e6; text-align:center; }
        td.text-left { text-align:left; }
        tr:nth-child(even) { background:#f8f9fa; }
        tr.top3 { background:#fff8e1; font-weight:bold; }

        .moy-bien { color:#28a745; font-weight:bold; }
        .moy-moyen { color:#856404; font-weight:bold; }
        .moy-faible { color:#dc3545; font-weight:bold; }

        .badge { padding:2px 6px; border-radius:3px; font-size:9px; font-weight:bold; }
        .badge-success { background:#d4edda; color:#155724; }
        .badge-warning { background:#fff3cd; color:#856404; }
        .badge-danger { background:#f8d7da; color:#721c24; }

        .footer { text-align:center; font-size:9px; color:#999; border-top:1px solid #eee; padding-top:8px; margin-top:10px; }
        .rang-medal { font-size:14px; }
    </style>
</head>
<body>

<div class="header">
    <h1>🏫 EcolePrime — Bulletin de Notes</h1>
    <p>Système de Gestion Scolaire — Cycle Primaire — Année scolaire 2025–2026</p>
</div>

<div class="bulletin-title">
    Bulletin {{ $trimestre == 'T1' ? '1er Trimestre' : ($trimestre == 'T2' ? '2e Trimestre' : '3e Trimestre') }}
    — Classe : {{ $classe->nom }}
</div>

<div class="classe-info">
    <span><strong>Classe :</strong> {{ $classe->nom }} ({{ $classe->niveau }})</span>
    <span><strong>Enseignant :</strong> {{ $classe->enseignant }}</span>
    <span><strong>Effectif :</strong> {{ $eleves->count() }} élève(s)</span>
    <span><strong>Trimestre :</strong> {{ $trimestre }}</span>
</div>

<table>
    <thead>
        <tr>
            <th style="width:30px">Rang</th>
            <th class="text-left" style="width:120px">Élève</th>
            @foreach($matieres as $m)
                <th style="width:60px">{{ substr($m,0,6) }}.</th>
            @endforeach
            <th style="width:50px">Moy.</th>
            <th style="width:70px">Mention</th>
        </tr>
    </thead>
    <tbody>
        @foreach($eleves as $index => $eleve)
        @php
            $notesList = [];
            foreach($matieres as $m) {
                $n = $eleve->notes->firstWhere('matiere', $m);
                $notesList[$m] = $n ? (float)$n->note : null;
            }
            $valides = array_filter($notesList, fn($v) => $v !== null);
            $moy = count($valides) ? round(array_sum($valides)/count($valides), 2) : null;
            $rang = $index + 1;
            $medal = $rang==1 ? '🥇' : ($rang==2 ? '🥈' : ($rang==3 ? '🥉' : $rang));
            $mention = $moy === null ? '—' :
                ($moy >= 16 ? 'Excellent' :
                ($moy >= 14 ? 'Bien' :
                ($moy >= 12 ? 'Assez bien' :
                ($moy >= 10 ? 'Passable' : 'Insuffisant'))));
            $moyClass = $moy === null ? '' :
                ($moy >= 10 ? 'moy-bien' : 'moy-faible');
            $badgeClass = $moy === null ? '' :
                ($moy >= 14 ? 'badge-success' :
                ($moy >= 10 ? 'badge-warning' : 'badge-danger'));
        @endphp
        <tr class="{{ $rang <= 3 ? 'top3' : '' }}">
            <td><span class="rang-medal">{{ $medal }}</span></td>
            <td class="text-left">{{ $eleve->prenom }} {{ $eleve->nom }}</td>
            @foreach($matieres as $m)
                <td>{{ $notesList[$m] !== null ? $notesList[$m] : '—' }}</td>
            @endforeach
            <td class="{{ $moyClass }}">{{ $moy ?? '—' }}</td>
            <td>
                @if($moy !== null)
                <span class="badge {{ $badgeClass }}">{{ $mention }}</span>
                @else — @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Bulletin généré le {{ now()->format('d/m/Y à H:i') }} — EcolePrime © {{ date('Y') }}
</div>

</body>
</html>