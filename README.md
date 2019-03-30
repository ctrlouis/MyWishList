# MyWishList.app
Repository du projet de fin de module de Conception programmation web serveur.

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

## Taches
### Principales
- [ ] 1. Afficher une liste de souhaits
- [ ] 2. Afficher un item d'une liste
- [ ] 3. Réserver un item
- [ ] 4. Ajouter un message avec sa réservation
- [ ] 5. Ajouter un message sur une liste
- [ ] 6. Créer une liste
- [ ] 7. Modifier les informations générales d'une de ses listes
- [ ] 8. Ajouter des items
- [ ] 9. Modifier un item
- [ ] 10. Supprimer un item
- [ ] 11. Rajouter une image à un item
- [ ] 12. Modifier une image d'un item
- [ ] 13 Supprimer une image d'un item
- [ ] 14. Partager une liste
- [ ] 15. Consulter les réservation d'une de ses listes avant échéance
- [ ] 16. Consulter les réservations et messages d'une de ses listes après échéance
### Extensions
- [ ] 17. Créer un compte
- [ ] 18. S'authentifier
- [ ] 19. Modifier son compte
- [ ] 20. Rendre une liste publique
- [ ] 21. Afficher les listes de souhaits publiques
- [ ] 22. Créer une cagnotte sur un item
- [ ] 23. Participer à une cagnotte
- [ ] 24. Uploader une image
- [ ] 25. Créer un compte participant
- [ ] 26. Afficher la liste des créateurs
- [ ] 27. SUpprimer son compte
- [ ] 28 Joindre des listes à son compte
