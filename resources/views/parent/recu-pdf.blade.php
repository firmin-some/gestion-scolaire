<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 10px; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .line { border-top: 1px dashed #000; margin: 8px 0; }
        .row { display: flex; justify-content: space-between; margin: 4px 0; }
    </style>
</head>
<body>
    <div class="center bold" style="font-size:16px;">🏫 EcolePrime</div>
    <div class="center" style="font-size:10px;">Reçu de paiement</div>
    <div class="line"></div>

    <div class="row"><span>N° Reçu :</span><span class="bold">#{{ str_pad($paiement->id, 5, '0', STR_PAD_LEFT) }}</span></div>
    <div class="row"><span>Date :</span><span>{{ $paiement->date_paiement->format('d/m/Y') }}</span></div>

    <div class="line"></div>

    <div class="row"><span>Élève :</span><span class="bold">{{ $paiement->eleve->prenom }} {{ $paiement->eleve->nom }}</span></div>
    <div class="row"><span>Classe :</span><span>{{ $paiement->eleve->classe->nom ?? '—' }}</span></div>
    <div class="row"><span>Parent :</span><span>{{ $paiement->eleve->nom_parent }}</span></div>

    <div class="line"></div>

    <div class="row"><span>Montant payé :</span><span class="bold">{{ number_format($paiement->montant,0,',',' ') }} F CFA</span></div>
    <div class="row"><span>Mode :</span><span>{{ $paiement->mode_paiement }}</span></div>

    <div class="line"></div>
    <div class="center" style="font-size:10px; margin-top:10px;">Merci pour votre confiance 🙏</div>
</body>
</html>