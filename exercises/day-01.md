# Jour 1 : Value Object - Email

> **Statut** : ✅ Corrigé et validé

## Objectif

Créer un Value Object `Email` qui représente une adresse email valide.

## Contexte

Un Value Object est un objet dont l'identité est définie par ses attributs plutôt que par un identifiant unique. Deux Value Objects avec les mêmes attributs sont considérés comme égaux.

## Tests

**Les tests sont fournis** dans `tests/Day01/EmailTest.php`. Tu dois les faire passer sans les modifier.

## Contraintes

- La classe doit être **immutable**
- La classe doit valider le format de l'email à la construction
- Deux emails identiques doivent être considérés comme égaux

## Comportements attendus

### Construction et accès à la valeur
- `new Email('john.doe@example.com')` crée un email valide
- `$email->value()` retourne la valeur de l'email
- `(string) $email` retourne la valeur de l'email (implémentation de `__toString`)

### Normalisation
- L'email doit être **normalisé en minuscules** : `John.Doe@Example.COM` devient `john.doe@example.com`

### Validation
- Lever une `InvalidArgumentException` si l'email est invalide
- Cas invalides à gérer :
  - Chaîne vide
  - Pas de `@`
  - Pas de domaine (ex: `johndoe@`)
  - Pas de partie locale (ex: `@example.com`)
  - Espaces dans l'email
  - Double `@`

### Comparaison
- `$email1->equals($email2)` retourne `true` si les deux emails ont la même valeur

### Extraction
- `$email->domain()` retourne le domaine (ex: `example.com`)
- `$email->localPart()` retourne la partie locale (ex: `john.doe`)

## Critères de succès

Tous les tests dans `tests/Day01/EmailTest.php` doivent passer.

## Fichier à créer

`src/Day01/Email.php`

## Commandes utiles

> **Important** : Toujours utiliser les commandes `task` plutôt que d'appeler directement `docker` ou les binaires dans `vendor/bin`.

```bash
# Lancer les tests du jour 1
task day -- 01

# Lancer PHPStan
task phpstan

# Fixer le code style
task cs-fix

# Voir toutes les commandes disponibles
task --list
```
