# ⚡ EVolt API

> REST API Laravel pour la gestion intelligente des bornes de recharge pour véhicules électriques.

---

## 📋 Table des matières

- [À propos](#-à-propos)
- [Fonctionnalités](#-fonctionnalités)
- [Stack technique](#-stack-technique)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Structure de la base de données](#-structure-de-la-base-de-données)
- [Endpoints de l'API](#-endpoints-de-lapi)
- [Authentification](#-authentification)
- [Tests](#-tests)
- [Documentation Postman / Swagger](#-documentation-postman--swagger)
- [Contribuer](#-contribuer)
- [Licence](#-licence)

---

## 🚀 À propos

**EVolt API** est une API RESTful développée avec Laravel permettant de gérer un réseau de bornes de recharge pour véhicules électriques. Elle offre aux utilisateurs la possibilité de rechercher des bornes disponibles, de réserver des créneaux de recharge et de suivre leurs sessions en temps réel. Les administrateurs disposent d'outils complets pour gérer le parc de bornes et consulter des statistiques détaillées.

---

## ✨ Fonctionnalités

### 👤 Utilisateur
- 🔒 **Authentification** via Laravel Sanctum (inscription, connexion, déconnexion)
- ⚡ **Recherche** de bornes disponibles avec filtres (connecteur, puissance, disponibilité en temps réel)
- 📅 **Réservation** d'une borne pour une période définie (heure de début + durée estimée)
- 🔄 **Modification** d'une réservation existante (heure, durée)
- ❌ **Annulation** d'une réservation
- 📊 **Historique** des sessions de recharge (passées et en cours)

### 🛡️ Administrateur
- 🔌 **Gestion des bornes** : ajout, modification, suppression
- ⚙️ **Configuration** du type de connecteur et de la puissance (kW) par borne
- 🔍 **Statistiques** : taux d'occupation, énergie délivrée, sessions actives

---

## 🛠️ Stack technique

| Composant        | Technologie              |
|------------------|--------------------------|
| Framework        | Laravel 11.x             |
| Language         | PHP 8.2+                 |
| Authentification | Laravel Sanctum          |
| Base de données  | PostgreSQL               |
| Tests            | PHPUnit / Pest           |
| Documentation    | Postman                  |
| Versioning       | Git + GitHub             |

---

## 📦 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- PHP >= 8.2
- Composer >= 2.x
- MySQL >= 8.0 ou PostgreSQL >= 15
- Node.js >= 18.x (optionnel, pour les assets)
- Git

---

## ⚙️ Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/MhammedGabigabe/EVolt_API.git
cd EVolt_API
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Copier et configurer le fichier d'environnement

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurer la base de données

Éditez le fichier `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=evolt_db
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

### 5. Exécuter les migrations et les seeders

```bash
php artisan migrate --seed
```

### 6. Lancer le serveur de développement

```bash
php artisan serve
```

L'API sera disponible sur : `http://localhost:8000`

---

## 🔧 Configuration

### Variables d'environnement importantes

```env
# Application
APP_NAME=EVoltAPI
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost

# Géolocalisation (rayon de recherche par défaut en km)
SEARCH_DEFAULT_RADIUS=10
```

---

## 📡 Endpoints de l'API

Base URL : `http://localhost:8000/api`

### 🔐 Authentification

| Méthode | Endpoint             | Description              | Auth requise |
|---------|----------------------|--------------------------|:------------:|
| POST    | `/auth/register`     | Inscription              | ❌           |
| POST    | `/auth/login`        | Connexion                | ❌           |
| POST    | `/auth/logout`       | Déconnexion              | ✅           |
| GET     | `/auth/me`           | Profil utilisateur       | ✅           |

### ⚡ Bornes de recharge

| Méthode | Endpoint                  | Description                              | Auth requise | Rôle    |
|---------|---------------------------|------------------------------------------|:------------:|---------|
| GET     | `/stations`               | Recherche par zone géographique          | ✅           | User    |
| GET     | `/stations/{id}`          | Détail d'une borne                       | ✅           | User    |
| POST    | `/admin/stations`         | Ajouter une borne                        | ✅           | Admin   |
| PUT     | `/admin/stations/{id}`    | Modifier une borne                       | ✅           | Admin   |
| DELETE  | `/admin/stations/{id}`    | Supprimer une borne                      | ✅           | Admin   |

**Paramètres de recherche (`GET /stations`) :**

```
?latitude=33.5731&longitude=-7.5898&radius=10&connector_type=CCS&min_power=50
```

### 📅 Réservations

| Méthode | Endpoint                      | Description                    | Auth requise |
|---------|-------------------------------|--------------------------------|:------------:|
| GET     | `/reservations`               | Mes réservations               | ✅           |
| POST    | `/reservations`               | Créer une réservation          | ✅           |
| GET     | `/reservations/{id}`          | Détail d'une réservation       | ✅           |
| PUT     | `/reservations/{id}`          | Modifier une réservation       | ✅           |
| DELETE  | `/reservations/{id}/cancel`   | Annuler une réservation        | ✅           |

## 👥 Auteurs

- **Votre GABIGABE** – [Mhammed-Gabigabe](https://github.com/MhammedGabigabe)

---

## 📜 Licence

Ce projet est sous licence **MIT**. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

<p align="center">
  Fait avec ❤️ et ⚡ pour un avenir plus vert
</p>