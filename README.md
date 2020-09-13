# TakeFood

TakeFood est une application factice simulant la commande de plats à emporter.

## Installation

-   Configurer la connexion à la base de données dans le fichier `.env`.
-   Écrire les commandes suivantes dans le terminal :

```sh
composer install
php bin/console doctrine:migrations:migrate

# Pour initialiser des données de tests
php bin/console doctrine:fixtures:load

symfony server:start
```
