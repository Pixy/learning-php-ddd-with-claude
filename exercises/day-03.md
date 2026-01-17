# Jour 3 : Entity - User

> **Statut** : 📝 À faire

## Objectif

Créer une Entity `User` qui représente un utilisateur avec une identité unique.

## Contexte

Contrairement aux Value Objects (comme `Email` ou `Money`), une **Entity** possède une identité unique qui la distingue des autres, même si ses attributs sont identiques. Deux utilisateurs avec le même nom et email sont des entités **différentes** s'ils ont des identifiants différents.

## Tests

**Les tests sont fournis** dans `tests/Day03/UserTest.php`. Tu dois les faire passer sans les modifier.

## Contraintes

- L'Entity doit avoir un **identifiant unique** (UUID v4)
- L'identité est basée sur l'**id**, pas sur les attributs
- L'Entity peut être **modifiée** (contrairement aux Value Objects)
- Utiliser le Value Object `Email` du Jour 1

## Comportements attendus

### Construction

- `User::create(Email $email, string $name)` crée un nouvel utilisateur avec un UUID généré
- `User::fromExisting(UserId $id, Email $email, string $name)` reconstruit un utilisateur existant (ex: depuis la BDD)

### Accès aux valeurs

- `$user->id()` retourne l'identifiant (`UserId`)
- `$user->email()` retourne l'email (`Email`)
- `$user->name()` retourne le nom (string)

### Modification

- `$user->rename(string $newName)` change le nom de l'utilisateur
- `$user->changeEmail(Email $newEmail)` change l'email de l'utilisateur

### Comparaison

- `$user1->equals($user2)` retourne `true` si les deux utilisateurs ont le **même id** (peu importe les autres attributs)

## UserId (Value Object)

Tu dois également créer un Value Object `UserId` pour encapsuler l'identifiant :

- Construction avec `new UserId(string $value)` ou `UserId::generate()` pour créer un nouvel UUID
- `$userId->value()` retourne la valeur (string UUID)
- `$userId->equals(UserId $other)` compare deux identifiants
- `(string) $userId` retourne la valeur (implémentation de `__toString`)
- Le format UUID v4 doit être validé à la construction

## Critères de succès

Tous les tests dans `tests/Day03/UserTest.php` doivent passer.

## Fichiers à créer

- `src/Day03/User.php`
- `src/Day03/UserId.php`

## Commandes utiles

```bash
# Lancer les tests du jour 3
task day -- 03

# Lancer PHPStan
task phpstan

# Fixer le code style
task cs-fix
```
