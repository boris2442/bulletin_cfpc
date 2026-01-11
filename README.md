# management_evaluation_school
# 🎓 SysGestionNotesAcademiques (Système de Gestion des Évaluations Étudiantes)

## 🌟 Description du Projet

Ce projet est une application web complète, développée sous Laravel, visant à informatiser et centraliser l'ensemble du processus d'évaluation et de suivi des performances académiques pour un établissement d'enseignement supérieur.

Il répond au besoin d'une gestion plus structurée et transparente des notes, en remplaçant les méthodes dispersées (fichiers Excel) par un système robuste, offrant une traçabilité complète et un accès transparent aux informations académiques pour tous les utilisateurs (Administrateurs, Enseignants, Étudiants).

## 🚀 Fonctionnalités Implémentées

Le système supporte les fonctionnalités suivantes :

### 1. Organisation Pédagogique
* **Gestion des Années Académiques :** Création, modification et définition de l'année **active** pour les opérations courantes.
* **Gestion des Spécialités :** Création et description des filières de formation.
* **Gestion des Modules :** Définition des modules (unités d'enseignement) avec un **code unique par spécialité**, un **coefficient** (poids dans le calcul) et un **ordre** d'apparition.

### 2. Gestion des Utilisateurs et Accès
* Enregistrement des Utilisateurs avec un rôle (`Administrateur`, `Enseignant`, `Étudiant`) et un **Matricule unique**.
* Support de la **suppression logique** (`soft deletes`) pour la traçabilité des comptes.
* Gestion des relations Enseignant-Module (savoir quel enseignant est responsable de la saisie des notes).

### 3. Cœur de l'Évaluation
* **Saisie des Notes :** Enregistrement des notes par les enseignants (sur 20, avec deux décimales).
* **Unicité Garantie (Contrainte Métier #6) :** Le système empêche la double saisie : un Étudiant ne peut avoir qu'une seule **Évaluation** pour un **Module**, dans un **Semestre**, au cours d'une **Année Académique** donnée.

### 4. Synthèse et Bilan
* **Calcul Automatique :** Calcul des moyennes pondérées par semestre et de la moyenne générale annuelle.
* **Génération de Bilans :** Génération du **Bilan de Compétences** annuel pour chaque étudiant.
* **Unicité Garantie (Contrainte Métier #7) :** Un étudiant ne peut avoir qu'un seul **Bilan de Compétences** par **Année Académique**.
* Inclusion d'un champ d'**observations** pour les commentaires qualitatifs.

## 🏛️ Modèle de Données (MCD)

La structure de la base de données est normalisée et conçue pour appliquer les règles métier complexes via des clés primaires composées.



*Le modèle de données ci-dessus garantit l'intégrité et la cohérence des données grâce à l'utilisation de clés primaires composées sur les entités **Évaluation** et **Bilan de Compétences**.*

## ⚙️ Stack Technique

* **Framework Back-end :** Laravel 11 / 12 (PHP)
* **Base de Données :** MySQL / MariaDB (Modélisation via Migrations)
* **Gestion des Assets :** Vite (npm)
* **Dépendances Front-end :** NProgress (pour les barres de progression de chargement)
* **Outil de Saisie :** Blade / JavaScript natif
* **Sécurité :** Utilisation des features standard de Laravel (Hashing, Authentification, etc.)

## 💻 Installation et Démarrage

Suivez ces étapes pour installer et lancer le projet localement :

### Prérequis

Assurez-vous d'avoir installé PHP, Composer, Node.js et une base de données MySQL (ou MariaDB).

### 1. Clonage du Dépôt et Dépendances

```bash
# Clonez le dépôt
git clone [https://github.com/boris2442/management_evaluation_school]
cd SysGestionNotesAcademiques

# Installez les dépendances PHP
composer install
# Créez le fichier d'environnement
cp .env.example .env

# Générez la clé d'application
php artisan key:generate

# Configurez les informations de votre base de données dans le fichier .env
# DB_DATABASE=...
# DB_USERNAME=...
# DB_PASSWORD=...
# Exécutez les migrations pour créer les tables
# Cela appliquera toutes les contraintes d'unicité (PK composées)
php artisan migrate

# Installez les dépendances NPM (pour Vite et NProgress)
npm install

# Lancez le serveur de développement (nécessaire pour servir les assets Front-end via Vite)
npm run dev
# OU, pour une construction de production : npm run build
# bulletin_cfpc
