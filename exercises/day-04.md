# Jour 4 : Repository In-Memory

> **Statut** : ✅ Corrigé et validé

## Objectif

Créer un Repository in-memory pour persister et récupérer des entités `User`.

## Contexte

Le **Repository Pattern** est une abstraction qui isole la logique métier de la persistence des données. Un repository in-memory stocke les données en mémoire (dans un tableau PHP), ce qui est parfait pour les tests et le prototypage.

L'idée est de définir une **interface** (le contrat) et une **implémentation** (in-memory pour l'instant, PostgreSQL plus tard).

## Tests

**Les tests sont fournis** dans `tests/Day04/`. Tu dois les faire passer sans les modifier.

## Contraintes

- Définir une interface `UserRepositoryInterface` avec les méthodes du contrat
- Implémenter `InMemoryUserRepository` qui stocke les users dans un tableau
- Réutiliser les classes `User`, `UserId` et `Email` des jours précédents
- Le repository doit être **stateful** : les données persistent entre les appels (dans la même instance)

## Comportements attendus

### Interface UserRepositoryInterface

- `save(User $user): void` - Persiste un utilisateur (création ou mise à jour)
- `findById(UserId $id): ?User` - Retourne l'utilisateur ou `null` si non trouvé
- `findByEmail(Email $email): ?User` - Retourne l'utilisateur ou `null` si non trouvé
- `findAll(): array` - Retourne tous les utilisateurs (tableau vide si aucun)
- `delete(UserId $id): void` - Supprime un utilisateur (ne fait rien si non trouvé)
- `exists(UserId $id): bool` - Retourne `true` si l'utilisateur existe

### Règles métier

- `save()` crée l'utilisateur s'il n'existe pas, le met à jour sinon (upsert)
- `findById()` et `findByEmail()` retournent `null` si non trouvé (pas d'exception)
- `delete()` est idempotent : supprimer un utilisateur inexistant ne lève pas d'exception
- `findAll()` retourne un tableau indexé numériquement (pas associatif)

### Comportement de mise à jour

Quand un utilisateur est sauvegardé puis modifié, le repository doit refléter les modifications :

```php
$user = User::create($email, 'Alice');
$repository->save($user);

$user->rename('Bob');
$repository->save($user);

$found = $repository->findById($user->id());
$found->name(); // 'Bob'
```

## Critères de succès

Tous les tests dans `tests/Day04/` doivent passer.

## Fichiers à créer

- `src/Day04/UserRepositoryInterface.php`
- `src/Day04/InMemoryUserRepository.php`

## Commandes utiles

```bash
# Lancer les tests du jour 4
task day -- 04

# Lancer PHPStan
task phpstan

# Fixer le code style
task cs-fix
```
