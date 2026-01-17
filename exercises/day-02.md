# Jour 2 : Value Object - Money

> **Statut** : ✅ Corrigé et validé

## Objectif

Créer un Value Object `Money` qui représente une somme d'argent avec un montant et une devise.

## Contexte

Dans les applications financières, manipuler de l'argent avec des `float` est une erreur classique qui mène à des problèmes de précision. La bonne pratique est de stocker les montants en **centimes** (entiers) et d'utiliser un Value Object pour encapsuler la logique.

## Tests

**Les tests sont fournis** dans `tests/Day02/MoneyTest.php`. Tu dois les faire passer sans les modifier.

## Contraintes

- La classe doit être **immutable**
- Les montants sont stockés en **centimes** (int)
- Les opérations entre devises différentes doivent lever une exception
- Les opérations arithmétiques retournent un **nouveau** Money

## Comportements attendus

### Construction et accès aux valeurs
- `new Money(1000, 'EUR')` crée 10,00 EUR (1000 centimes)
- `$money->amount()` retourne le montant en centimes
- `$money->currency()` retourne la devise (string)

### Opérations arithmétiques
- `$money->add(Money $other)` additionne deux montants (même devise)
- `$money->subtract(Money $other)` soustrait deux montants (même devise)
- `$money->multiply(float $multiplier)` multiplie le montant (arrondi à l'entier inférieur)

### Comparaison
- `$money->equals(Money $other)` compare montant ET devise
- `$money->isGreaterThan(Money $other)` compare les montants (même devise)
- `$money->isLessThan(Money $other)` compare les montants (même devise)

### Gestion des erreurs
- Lever `InvalidArgumentException` si :
  - Opération arithmétique entre devises différentes
  - Comparaison `isGreaterThan`/`isLessThan` entre devises différentes

## Critères de succès

Tous les tests dans `tests/Day02/MoneyTest.php` doivent passer.

## Fichier à créer

`src/Day02/Money.php`

## Commandes utiles

```bash
# Lancer les tests du jour 2
task day -- 02

# Lancer PHPStan
task phpstan

# Fixer le code style
task cs-fix
```
