# Jour 1 : Value Object - Email

## Objectif

Créer un Value Object `Email` qui représente une adresse email valide.

## Contexte

Un Value Object est un objet dont l'identité est définie par ses attributs plutôt que par un identifiant unique. Deux Value Objects avec les mêmes attributs sont considérés comme égaux.

## Contraintes

- La classe doit être **immutable**
- La classe doit valider le format de l'email à la construction
- Deux emails identiques doivent être considérés comme égaux

## Critères de succès

Tous les tests dans `tests/Day01/EmailTest.php` doivent passer.

## Fichier à créer

`src/Day01/Email.php`

## Commandes utiles

```bash
# Lancer les tests
docker compose run --rm php vendor/bin/phpunit tests/Day01

# Lancer PHPStan
docker compose run --rm php vendor/bin/phpstan analyse src/Day01

# Fixer le code style
docker compose run --rm php vendor/bin/php-cs-fixer fix src/Day01
```
