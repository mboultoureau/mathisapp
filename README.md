<h1 align="center">🍔 TakeFood</h1>

> TakeFood est une application factice simulant la commande de plats à emporter.

## Installation

- Configurer la connexion à la base de données dans le fichier `.env`.
- Écrire les commandes suivantes dans le terminal :

```sh
composer install

# Création de la base de données
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Pour initialiser des données de tests
php bin/console doctrine:fixtures:load

symfony server:start
```

## Installation avec Docker

```sh
docker-compose up

# Pour exécuter une commande sur le serveur
docker exec -it takefood_php-fpm_1 bin/console [VOTRE COMMANDE]
```

## Installation avec DockerSync

```sh
docker-sync-stack start

# Ou si vous souhaitez l'exécuter en tâche de fond
docker-sync start

# Pour exécuter une commande sur le serveur
docker exec -it takefood_php-fpm_1 bin/console [VOTRE COMMANDE]
```

## Crédits

- [Docker for Symfony](https://gitlab.com/martinpham/symfony-5-docker) by [Martin Pham](https://dev.to/martinpham)
- [Icons from flaticons](https://www.flaticon.com/) by [Freepik](http://www.freepik.com/)
