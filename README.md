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

## 🔐 Comptes de test (après `php artisan migrate:fresh --seed`)

| Rôle | Email | Mot de passe |
|---|---|---|
| Gestionnaire | gestionnaire@example.com | password123 |
| Enseignant | enseignant@example.com | password123 |
| Parent | parent@example.com | password123 |

**Note** : Après le seeder initial, le **gestionnaire peut ajouter directement les enseignants** via le tableau de bord avec un code d'accès. Voir la section ci-dessous pour plus de détails.

---

## 👨‍🏫 Gestion des Enseignants (flux recommandé)

Au lieu d'ajouter les enseignants via le seeder, le gestionnaire crée les comptes directement :

1. Se connecter au tableau de bord : **gestionnaire@example.com** / **password123**
2. Aller à la section **Gestion des Enseignants** → **Ajouter un enseignant**
3. Remplir le formulaire :
   - Nom, prénom, sexe
   - Email (doit être unique)
   - Spécialité/matière enseignée
   - **Code d'accès** : Un code unique que l'enseignant utilisera pour se connecter
   - Téléphone (optionnel)
   - Date de naissance (optionnel)
4. Soumettre le formulaire
5. Un compte `User` est créé automatiquement avec :
   - Email : celui fourni dans le formulaire
   - Mot de passe : le code d'accès (haché automatiquement)
   - Rôle : **Enseignant**

6. **Communiquer au nouvel enseignant** :
   - Email : l'adresse fournie
   - Mot de passe initial : le code d'accès

L'enseignant peut alors se connecter et modifier son mot de passe via son profil.

---

## ⚠️ Remarque importante — Seeders & Hachage des mots de passe

- Le projet contient des seeders qui créent des comptes par défaut, mais la base de données n'est pas incluse dans l'archive ZIP. Si vos camarades ne lancent pas les migrations et les seeders, ils n'auront pas les comptes.
- Le seeder principal est [database/seeders/DatabaseSeeder.php](database/seeders/DatabaseSeeder.php#L1-L48). Il crée les comptes avec les e-mails `gestionnaire@example.com`, `enseignant@example.com`, `parent@example.com` et le mot de passe par défaut `password123`.
- **Important** : Le modèle `User` contient le casting `'password' => 'hashed'`, qui hache automatiquement le mot de passe lors de la sauvegarde. Le seeder ne doit **pas** utiliser `Hash::make()` (sinon le mot de passe sera hashé deux fois et la connexion échouera). Le seeder passe donc le mot de passe en clair, et c'est le modèle qui le hache une seule fois.

Pour garantir que tout le monde dispose des mêmes comptes, demandez-leur d'exécuter ces commandes après avoir configuré `.env` :

```bash
composer install
cp .env.example .env
php artisan key:generate
# Mettre à jour la configuration DB dans .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Les comptes créés seront alors :
- **Gestionnaire** : gestionnaire@example.com / password123
- **Enseignant** : enseignant@example.com / password123
- **Parent** : parent@example.com / password123

Après connexion au tableau de bord gestionnaire, il est recommandé de créer les autres enseignants via l'interface d'administration plutôt que d'ajouter d'autres comptes via le seeder.

---

## 🔁 Changements récents (2026-06-03)

- **Routes**: la resource `classes` a été paramétrée en `{classe}` afin que le binding correspondre aux signatures des contrôleurs. Voir [routes/web.php](routes/web.php).
- **Suppression de classe**: `ClasseController::destroy()` a été corrigé pour exécuter la suppression, logger le résultat et fournir un message flash (`success` / `error`). Voir [app/Http/Controllers/ClasseController.php](app/Http/Controllers/ClasseController.php).
- **Enseignants**: ajout de la migration pour `classe_id` et `statut` (`nullOnDelete()`), ajout de la liste des matières (incluant `toutes-matieres`) et logique "titulaire / secondaire" lors de la création d'un enseignant. Fichiers concernés : [database/migrations/2026_06_03_000000_add_classe_id_and_statut_to_enseignants_table.php](database/migrations/2026_06_03_000000_add_classe_id_and_statut_to_enseignants_table.php), [app/Models/Enseignant.php](app/Models/Enseignant.php), [app/Http/Controllers/EnseignantController.php](app/Http/Controllers/EnseignantController.php).
- **Vues**: mises à jour des vues `classes` et `enseignants` pour utiliser l'`id` lors des routes et afficher les options de matières. Voir [resources/views/classes](resources/views/classes) et [resources/views/enseignants](resources/views/enseignants).
- **Cache / maintenance**: après pull ou modifications, exécuter :

```bash
php artisan view:clear && php artisan route:clear && php artisan config:clear
```

- **Rappels**:
   - Le modèle `User` a le casting `'password' => 'hashed'` : ne pas hacher les mots de passe deux fois dans les seeders.
   - Les migrations liées aux clés étrangères utilisent `onDelete('cascade')` pour `eleves`/`notes`, et `nullOnDelete()` pour `enseignants.classe_id`.

### Commandes recommandées après mise à jour

```bash
composer install
cp .env.example .env
php artisan key:generate
# mettre à jour la configuration DB dans .env
php artisan migrate
php artisan db:seed # ou php artisan migrate:fresh --seed
php artisan storage:link
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan serve
```



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