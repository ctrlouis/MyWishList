# MyWishList.app
Repository du projet de fin de module de Conception programmation web serveur.
Les documents du projet sont disponibles [ici](https://drive.google.com/drive/folders/1gz3XX0uUzgDBoddUDKjwSm8RGNTaoO4F?usp=sharing).

## Requis
- Apache
- Composer
- MySQL
- PHP 7.0.0 et +

## Installation
1. Clonez le repository dans votre répertoire de serveur `www/` en utilisant la commande suivante :
```
git clone git@github.com:ctrlouis/MyWishList.app.git
```
2. Placez vous à la racine du repository avec `cd MyWishList.app` et installez les dépendances avec en vous placant a la racine du repository en executant la commande suivante :
```
composer install
```

**OU** etape 1 et 2 en oneshot :
```
git clone git@github.com:ctrlouis/MyWishList.app.git && cd MyWishList.app && composer install
```
3. Modifier le nom de la base de données et les identifiants (= lignes commentées) de connexion dans le fichier `../MyWishList.app/src/conf/conf.ini` et décommentez les lignes.
4. Si vous n'avez pas la base de données utilisé, actuellement `mywishlist`, elle est disponible [ici](https://textup.fr/323707cT).
