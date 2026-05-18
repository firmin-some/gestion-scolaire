<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size:13px; color:#1a1a1a; padding:30px; }

        .header { text-align:center; margin-bottom:24px; padding-bottom:16px; border-bottom:3px solid #1a1a2e; }
        .header h1 { font-size:22px; color:#1a1a2e; margin-bottom:4px; }
        .header p { color:#666; font-size:11px; }

        .recu-title {
            background:#1a1a2e; color:#f0c040; text-align:center;
            padding:10px; font-size:14px; font-weight:bold;
            text-transform:uppercase; letter-spacing:2px;
            margin-bottom:20px; border-radius:4px;
        }

        .info-box { background:#f8f9fa; border-radius:6px; padding:14px; margin-bottom:16px; }
        .info-row { display:flex; justify-content:space-between; margin-bottom:8px; }
        .info-row:last-child { margin-bottom:0; }
        .info-label { color:#666; }
        .info-value { font-weight:bold; }

        .montant-box {
            border:2px solid #1a1a2e; border-radius:6px; padding:14px;
            margin-bottom:16px;
        }
        .montant-row {
            display:flex; justify-content:space-between;
            padding:6px 0; border-bottom:1px solid #eee; font-size:13px;
        }
        .montant-row:last-child { border-bottom:none; }
        .montant-total {
            display:flex; justify-content:space-between;
            font-size:16px; font-weight:bold; margin-top:8px;
            padding-top:8px; border-top:2px solid #1a1a2e;
        }

        .statut {
            text-align:center; padding:12px; border-radius:6px;
            font-weight:bold; font-size:14px; margin-bottom:20px;
        }
        .statut-solde { background:#d4edda; color:#155724; }
        .statut-partiel { background:#fff3cd; color:#856404; }

        .footer {
            text-align:center; font-size:10px; color:#999;
            border-top:1px solid #eee; padding-top:12px; margin-top:20px;
        }
        .signature-box {
            display:flex; justify-content:space-between; margin-top:30px;
        }
        .signature { text-align:center; width:45%; }
        .signature .ligne { border-top:1px solid #333; margin-top:40px; padding-top:4px; font-size:11px; }
    </style>
</head>
<body>

<div class="header">
    <h1>🏫 EcolePrime</h1>
    <p>Système de Gestion Scolaire — Cycle Primaire</p>
    <p>Année scolaire 2025–2026</p>
</div>

<div class="recu-title">Reçu de Paiement N° {{ str_pad($paiement->id, 4, '0', STR_PAD_LEFT) }}</div>

<div class="info-box">
    <div class="info-row">
        <span class="info-label">Élève :</span>
        <span class="info-value">{{ $eleve->prenom }} {{ $eleve->nom }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Classe :</span>
        <span class="info-value">{{ $classe->nom ?? '—' }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Parent / Tuteur :</span>
        <span class="info-value">{{ $eleve->nom_parent }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Date du versement :</span>
        <span class="info-value">{{ $paiement->date_paiement->format('d/m/Y') }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Mode de paiement :</span>
        <span class="info-value">{{ $paiement->mode_paiement }}</span>
    </div>
</div>

<div class="montant-box">
    <div class="montant-row">
        <span>Frais annuels de scolarité</span>
        <span>{{ number_format($classe->frais ?? 0, 0, ',', ' ') }} FCFA</span>
    </div>
    <div class="montant-row">
        <span>Total déjà versé</span>
        <span>{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</span>
    </div>
    <div class="montant-total">
        <span>Montant du présent versement</span>
        <span style="color:#28a745">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
    </div>
    <div class="montant-total">
        <span>Reste à payer</span>
        <span style="color:{{ $reste > 0 ? '#dc3545' : '#28a745' }}">
            {{ number_format($reste, 0, ',', ' ') }} FCFA
        </span>
    </div>
</div>

<div class="statut {{ $reste == 0 ? 'statut-solde' : 'statut-partiel' }}">
    {{ $reste == 0 ? '✅ COMPTE SOLDÉ — Merci pour votre paiement !' : '⚠️ Solde restant à régler : '.number_format($reste,0,","," ").' FCFA' }}
</div>

<div class="signature-box">
    <div class="signature">
        <div class="ligne">Signature du parent</div>
    </div>
    <div class="signature">
        <div class="ligne">Cachet & Signature Direction</div>
    </div>
</div>

<div class="footer">
    Document généré le {{ now()->format('d/m/Y à H:i') }} — EcolePrime © {{ date('Y') }}
</div>

</body>
</html>