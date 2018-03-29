# Tournament Manager - IFI PHP

Site réalisé en PHP 7 et Symfony 4 dans le cadre du module IFI PHP du Master 2 E-Services à l'Université Lille 1.

## Déploiement

Import des dépendances :
> `composer update`

Une base de données est nécessaire et doit être configurée dans le fichier ".env".

> `mv .env.dist .env`

Création des entités :
> `php bin/console doctrine:schema:update --force`

Run :
> `php -S 127.0.0.1:8080 -t public/`

## Travail réalisé

### A l'université :

Lors des séances de cours, nous avons réalisé un controleur qui permet d'afficher les tournois enregistrés en BDD.
Une ligne de commande a été programmée et permet d'ajouter un tournoi directement via le terminal :
> `php bin/console app:create-tournament {nameTournament} {dateTournament}`

### Personnel :

Un nouveau controleur : "SecurityController" gère l'accès au site.

Une inscription est requise pour accéder à la liste des tounois. Ce controleur gère l'inscription et la connexion.
Il utilise l'authentification de Symfony avec une entitée User.

Si l'utilisateur n'est pas connecté ou essaie de se rendre sur une page du site non autorisé il est automatiquement redirigé sur la page d'authentication.

Le controleur "HomepageController" gère l'accès aux tournois et aux matchs.

Une fois connecté, l'utiisateur peut choisir le tournoi sur lequel il souhaite avoir plus d'informations.
Sur une page tournoi l'utilisateur peut ajouter, supprimer et mettre à jour les scores d'un match.

## A améliorer :

- SecurityController -> la méthode register peut être plus symfony like
- Les entités -> les variables sont à mettre en private avec getters/setters
- templates -> une template parent doit être écrite pour simplifier les autres templates
