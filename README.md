# 🏫 EcolePrime — Système de Gestion Scolaire (Cycle Primaire)

> Projet réalisé dans le cadre du cours de **Programmation Web et Framework**  
> Année académique 2025–2026

---

## 📋 Sujet

Conception d'une application web pour la gestion d'un établissement
d'enseignement primaire (du CP1 au CM2). L'application permet un suivi
rigoureux tant sur le plan **financier** que **pédagogique**.

---

## 👥 Membres du groupe

| Nom & Prénom | Rôle |
|---|---|
| SOME Firmin | Développeur principal |

---

## ⚙️ Installation

### Prérequis
- PHP >= 8.2
- Composer
- MySQL (XAMPP)
- Node.js et npm

### Étapes

**1. Cloner le projet**
```bash
git clone https://github.com/firmin-some/gestion-scolaire.git
cd gestion-scolaire
```

**2. Installer les dépendances PHP**
```bash
composer install
```

**3. Installer les dépendances JavaScript**
```bash
npm install && npm run build
```

**4. Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Configurer la base de données dans `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_scolaire
DB_USERNAME=root
DB_PASSWORD=
```

**6. Créer les tables**
```bash
php artisan migrate
```

**7. Lien de stockage**
```bash
php artisan storage:link
```

**8. Lancer l'application**
```bash
php artisan serve
```

Accéder à : **http://127.0.0.1:8000**

---

## ✨ Fonctionnalités

### 🔐 Authentification
- Connexion sécurisée Gestionnaire / Enseignant

### 📊 Tableau de bord
- Statistiques en temps réel
- Frais collectés vs attendus par classe
- Liste des élèves impayés

### 👦 Gestion des Élèves
- Inscription avec photo
- Recherche et filtrage par classe
- Fiche détaillée par élève

### 🏛️ Gestion des Classes
- Configuration CP1 → CM2
- Frais de scolarité par classe
- Enseignant titulaire

### 💰 Gestion des Paiements
- Enregistrement des versements
- Calcul automatique du reste à payer
- Génération de reçu PDF
- Historique des paiements

### 📝 Notes & Moyennes
- Saisie par matière et trimestre (T1, T2, T3)
- 6 matières : Français, Maths, Sciences, Histoire-Géo, Anglais, EPS
- Calcul automatique des moyennes avec mentions

### 🏆 Classement
- Classement par classe et trimestre
- Médailles 🥇🥈🥉
- Export bulletin PDF

---

## 🛠️ Technologies

| Technologie | Usage |
|---|---|
| Laravel 12 | Framework PHP |
| PHP 8.2 | Langage serveur |
| MySQL | Base de données |
| Bootstrap 5.3 | Interface utilisateur |
| DomPDF | Génération PDF |

---

## 📁 Structure

```
gestion-scolaire/
├── app/Http/Controllers/
│   ├── DashboardController.php
│   ├── ClasseController.php
│   ├── EleveController.php
│   ├── PaiementController.php
│   └── NoteController.php
├── app/Models/
│   ├── Classe.php
│   ├── Eleve.php
│   ├── Paiement.php
│   └── Note.php
├── database/migrations/
├── resources/views/
│   ├── layouts/
│   ├── classes/
│   ├── eleves/
│   ├── paiements/
│   ├── notes/
│   └── pdf/
└── routes/web.php
```

---

## 📄 Licence

Projet académique — 2025–2026