# MyWishList.app
Repository du projet de fin de module de Conception programmation web serveur.

Gestion de projet : [Trello publique](https://trello.com/login?returnUrl=%2Fb%2FdkVNoaSX%2Fmywishlist)

Site en ligne : [webetu](https://webetu.iutnc.univ-lorraine.fr/www/bertschy4u/MyWishList/)

## Documents
[Sujet](https://drive.google.com/open?id=1_C5TikA4-pmoG6bVhuTVz3OIJVCgeFdv)

[Détail du projet](https://drive.google.com/open?id=137uIp9akhLvtiGbK5ae_0n1sGnZahEw4)

[url-rewrite](https://drive.google.com/open?id=1mnisRqe2jJNZ6YKJTS_EAuAjk5TbhjXQ)

## Requis
- Apache
- Composer
- MySQL
- PHP 7.0.0 et +

## Installation
1. Clonez le repository dans votre répertoire de serveur `www/` en utilisant la commande suivante :
```
git clone git@github.com:ctrlouis/MyWishList.git
```
2. Placez vous à la racine du repository avec `cd MyWishList.app` et installez les dépendances avec en vous placant a la racine du repository en executant la commande suivante :
```
composer install
```
4. Empechez le suivie du fichier conf.ini par git :
```
git update-index --assume-unchanged src/conf/conf.ini
```

**OU** 1 à 4 en oneshot :
```
git clone git@github.com:ctrlouis/MyWishList.git && cd MyWishList && composer install && git update-index --assume-unchanged src/conf/conf.ini
```
5. Créez la base de données avec le fichier `/MyWishList/src/schema-sql/wishlist.sql`. Si des erreurs arrivent, utilisez le fichier `/MyWishList/src/schema-sql/wishlist-alternatif.sql`
6. Modifier le nom de la base de données et les identifiants (= lignes commentées) de connexion dans le fichier `../MyWishList/src/conf/conf.ini` et décommentez les lignes.
7. Dans le fichier `/MyWishList/src/divers/Outils.php` à la ligne 11, modifiez la valeur de la variable **$arbo** en indiquant le chemin depuis la source du serveur apache jusqu'au fichier index.php

## Taches
### Principales
- [X] 1. Afficher une liste de souhaits (Bour Victor)
- [X] 2. Afficher un item d'une liste (Bertschy Louis)
- [X] 3. Réserver un item (Bertschy Louis)
- [X] 4. Ajouter un message avec sa réservation (Bertschy Louis)
- [X] 5. Ajouter un message sur une liste (Bour Victor)
- [X] 6. Créer une liste (Bour Victor)
- [X] 7. Modifier les informations générales d'une de ses listes (Bour Victor)
- [X] 8. Ajouter des items (Bertschy Louis)
- [X] 9. Modifier un item (Bertschy Louis)
- [X] 10. Supprimer un item (Bertschy Louis)
- [X] 11. Rajouter une image à un item (Bertschy Louis)
- [X] 12. Modifier une image d'un item (Bertschy Louis)
- [X] 13 Supprimer une image d'un item (Bertschy Louis)
- [X] 14. Partager une liste (Bour Victor)
- [X] 15. Consulter les réservation d'une de ses listes avant échéance (Bour Victor)
- [X] 16. Consulter les réservations et messages d'une de ses listes après échéance (Bour Victor)
### Extensions
- [X] 17. Créer un compte (Bertschy Louis)
- [X] 18. S'authentifier (Bertschy Louis)
- [X] 19. Modifier son compte (Bertschy Louis)
- [X] 20. Rendre une liste publique (Bour Victor)
- [X] 21. Afficher les listes de souhaits publiques (Bour Victor)
- [X] 22. Créer une cagnotte sur un item (Bour Victor)
- [X] 23. Participer à une cagnotte (Bour Victor)
- [X] 24. Uploader une image (Bertschy Louis)
- [X] 25. Créer un compte participant (Bertschy Louis)
- [ ] 26. Afficher la liste des créateurs
- [X] 27. Supprimer son compte (Bertschy Louis)
- [X] 28 Joindre des listes à son compte (Bour Victor)
