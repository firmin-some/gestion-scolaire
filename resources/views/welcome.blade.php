<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcolePrime - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container text-center mt-5">
        <h1 class="mb-4">Bienvenue sur EcolePrime 🎓</h1>
        <p class="text-muted">Connectez-vous ou inscrivez-vous pour accéder à votre tableau de bord.</p>
        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary me-2">Connexion</a>
            <a href="{{ route('register') }}" class="btn btn-success">Inscription</a>
        </div>
    </div>
</body>
</html>
