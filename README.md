# 🏫 EcolePrime — Système de Gestion Scolaire (Cycle Primaire)

> Projet réalisé dans le cadre du cours de **Programmation Web et Framework**  
> Année académique 2025–2026

---

## 📋 Sujet

Conception d'une application web pour la gestion d'un établissement
d'enseignement primaire (du CP1 au CM2). L'application permet un suivi
rigoureux tant sur le plan **financier** que **pédagogique**, avec un
espace dédié pour les parents d'élèves.

---

## 👥 Membres du groupe



| Nom & Prénom | Rôle |

|--------------|------|

| SOME Firmin  | Membre développeur |

| MOYENGA Aziz | Membre développeur |

``
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

**8. Créer les comptes par défaut**
```bash
php artisan tinker
```
```php
// Compte Gestionnaire
\App\Models\User::create([
    'name' => 'Admin Gestionnaire',
    'email' => 'admin@ecoleprime.bf',
    'password' => bcrypt('Admin@2025'),
    'role' => 'gestionnaire'
]);

// Compte Enseignant
\App\Models\User::create([
    'name' => 'M. Enseignant',
    'email' => 'enseignant@ecoleprime.bf',
    'password' => bcrypt('Enseignant@2025'),
    'role' => 'enseignant'
]);
```

**9. Lancer l'application**
```bash
php artisan serve
```

Accéder à : **http://127.0.0.1:8000**

---

## 🔐 Comptes de test

| Rôle | Email | Mot de passe |
|---|---|---|
| Gestionnaire | admin@ecoleprime.bf | Admin@2025 |
| Enseignant | enseignant@ecoleprime.bf | Enseignant@2025 |
| Parent | S'inscrire via /register | — |

---

## ✨ Fonctionnalités

### 🔐 Authentification & Sécurité
- Connexion sécurisée avec 3 rôles : Gestionnaire, Enseignant, Parent
- Middleware de protection par rôle
- Protection CSRF sur tous les formulaires
- Inscription publique réservée aux parents
- Mots de passe hashés (Bcrypt)

### 📊 Tableau de bord (Gestionnaire)
- Statistiques en temps réel
- Frais collectés vs attendus par classe
- Taux de collecte avec barres de progression
- Liste des élèves impayés

### 👦 Gestion des Élèves (Gestionnaire)
- Inscription avec photo
- Recherche et filtrage par classe
- Fiche détaillée par élève
- Statut de paiement visible

### 🏛️ Gestion des Classes (Gestionnaire)
- Configuration CP1 → CM2
- Frais de scolarité par classe
- Enseignant titulaire

### 💰 Gestion des Paiements (Gestionnaire)
- Enregistrement des versements
- Calcul automatique du reste à payer
- Génération de reçu PDF téléchargeable
- Historique complet des paiements

### 📝 Notes & Moyennes (Gestionnaire + Enseignant)
- Saisie par matière et trimestre (T1, T2, T3)
- 6 matières : Français, Maths, Sciences, Histoire-Géo, Anglais, EPS
- Calcul automatique des moyennes avec mentions
- Export bulletin PDF

### 🏆 Classement (Gestionnaire + Enseignant)
- Classement par classe et trimestre
- Médailles 🥇🥈🥉
- Barres de progression

### 👨‍🏫 Gestion des Enseignants (Gestionnaire)
- Inscription des enseignants
- Spécialité / matière enseignée
- CRUD complet

### 👨‍👩‍👦 Espace Parent
- Inscription libre via /register
- Inscription de ses enfants directement
- Consultation des notes par trimestre
- Consultation des paiements et frais
- Accès limité (pas aux données administratives)

---

## 🛠️ Technologies

| Technologie | Version | Usage |
|---|---|---|
| Laravel | 12.x | Framework PHP backend |
| PHP | 8.2 | Langage serveur |
| MySQL | 10.4 | Base de données |
| Bootstrap | 5.3 | Interface utilisateur |
| Bootstrap Icons | 1.11 | Icônes |
| DomPDF | 3.x | Génération PDF |
| Blade | — | Moteur de templates |

---

## 🔒 Sécurité

| Mesure | Description |
|---|---|
| Authentification | Laravel Breeze |
| Protection CSRF | Token sur tous les formulaires |
| Middleware rôles | Accès restreint par rôle |
| Validation | Toutes les entrées validées |
| Protection XSS | Échappement automatique Blade |
| Injection SQL | Eloquent ORM (requêtes préparées) |
| Hash passwords | Bcrypt |

---

## 📁 Structure

```
gestion-scolaire/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── ClasseController.php
│   │   │   ├── EleveController.php
│   │   │   ├── PaiementController.php
│   │   │   ├── NoteController.php
│   │   │   ├── EnseignantController.php
│   │   │   └── ParentController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── User.php
│       ├── Classe.php
│       ├── Eleve.php
│       ├── Paiement.php
│       ├── Note.php
│       └── Enseignant.php
├── database/migrations/
├── resources/views/
│   ├── layouts/
│   ├── dashboard.blade.php
│   ├── classes/
│   ├── eleves/
│   ├── paiements/
│   ├── notes/
│   ├── enseignants/
│   ├── parent/
│   └── pdf/
└── routes/web.php
```

---

## 📄 Licence

Projet académique — Université Joseph KI-ZERBO licence3 2025–2026