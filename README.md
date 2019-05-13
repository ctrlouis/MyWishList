# MyWishList.app
Repository du projet de fin de module de Conception programmation web serveur.

Gestion de projet : [Trello](https://trello.com/login?returnUrl=%2Fb%2FdkVNoaSX%2Fmywishlist)

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
5. Créez la base de données avec le fichier `../MyWishList/sql/wishlist.sql`
6. Modifier le nom de la base de données et les identifiants (= lignes commentées) de connexion dans le fichier `../MyWishList/src/conf/conf.ini` et décommentez les lignes.

## Taches
### Principales
- [X] 1. Afficher une liste de souhaits
- [X] 2. Afficher un item d'une liste
- [X] 3. Réserver un item
- [X] 4. Ajouter un message avec sa réservation
- [ ] 5. Ajouter un message sur une liste
- [X] 6. Créer une liste
- [X] 7. Modifier les informations générales d'une de ses listes
- [X] 8. Ajouter des items
- [X] 9. Modifier un item
- [X] 10. Supprimer un item
- [X] 11. Rajouter une image à un item
- [X] 12. Modifier une image d'un item
- [X] 13 Supprimer une image d'un item
- [X] 14. Partager une liste
- [ ] 15. Consulter les réservation d'une de ses listes avant échéance
- [ ] 16. Consulter les réservations et messages d'une de ses listes après échéance
### Extensions
- [X] 17. Créer un compte
- [X] 18. S'authentifier
- [ ] 19. Modifier son compte
- [ ] 20. Rendre une liste publique
- [ ] 21. Afficher les listes de souhaits publiques
- [ ] 22. Créer une cagnotte sur un item
- [ ] 23. Participer à une cagnotte
- [ ] 24. Uploader une image
- [X] 25. Créer un compte participant
- [ ] 26. Afficher la liste des créateurs
- [ ] 27. Supprimer son compte
- [X] 28 Joindre des listes à son compte
