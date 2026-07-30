# FreelanceConnect

Plateforme de mise en relation entre donneurs d'ordre (Clients) et prestataires (Freelances).
Application web développée avec Symfony 7.4 (LTS) dans le cadre d'un projet d'alternance.

## Stack technique

- **Framework** : Symfony 7.4 LTS
- **Langage** : PHP 8.4
- **Base de données** : MySQL 8.0 (via Doctrine ORM)
- **Templating** : Twig
- **Gestion des dépendances** : Composer

## Prérequis

Avant d'installer le projet, assurez-vous d'avoir :

- **PHP 8.4** ou supérieur, avec les extensions suivantes activées : `pdo_mysql`, `intl`, `mbstring`, `ctype`, `sodium`
- **Composer** 2.x
- **Symfony CLI**
- **MySQL 8.0**, par exemple via Laragon, WAMP ou XAMPP
- **Git**

> Sous Windows avec Laragon, veillez à installer une version **Thread Safe (TS)** de PHP 8.4.

## Installation

1. **Cloner le dépôt**

```bash
git clone https://github.com/Qbeaudiquez/freelanceConnect.git
cd freelanceConnect
```

2. **Installer les dépendances**

```bash
composer install
```

## Configuration

La connexion à la base de données se configure via un fichier `.env.local` à créer à la racine du projet. Ce fichier n'est pas versionné : chaque développeur y met ses propres identifiants.

Créez un fichier `.env.local` et ajoutez-y votre chaîne de connexion MySQL :

```dotenv
DATABASE_URL="mysql://root:@127.0.0.1:3306/freelanceconnect?serverVersion=8.0.30&charset=utf8mb4"
```

Adaptez l'utilisateur, le mot de passe et la version de MySQL selon votre environnement local.

## Base de données

1. **Créer la base de données**

```bash
php bin/console doctrine:database:create
```

2. **Exécuter les migrations** (création des tables)

```bash
php bin/console doctrine:migrations:migrate
```

3. **Charger les données de référence** (statuts, catégories)

```bash
php bin/console doctrine:fixtures:load
```

> Les fixtures remplissent les tables de référence (statuts de mission, statuts de candidature, statuts de facture, catégories). Sans cette étape, aucune mission ne peut être créée correctement.

## Pour tester l'application, créez un compte via la page d'inscription :

[http://127.0.0.1:8000/register](http://127.0.0.1:8000/register)

Choisissez le type de compte (**Client** ou **Freelance**) lors de l'inscription selon le rôle que vous souhaitez tester.


## Auteurs

Projet réalisé dans le cadre d'une formation en alternance (Concepteur Développeur d'Applications).

- Quentin Beaudiquez
- Lucas Lutz