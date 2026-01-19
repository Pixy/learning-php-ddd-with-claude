# Jour 5 : Repository PostgreSQL

> **Statut** : ✅ Corrigé et validé

## Objectif

Implémenter un Repository PostgreSQL pour persister les utilisateurs en base de données, en respectant le même contrat que le repository in-memory du jour 4.

## Contexte

Après avoir créé un repository in-memory (parfait pour les tests), il est temps de passer aux choses sérieuses : la persistence réelle en base de données. L'avantage du **Repository Pattern** est que ton code métier n'a pas à changer : il utilise toujours l'interface `UserRepositoryInterface`.

Tu vas utiliser **PDO** pour communiquer avec PostgreSQL. Pas d'ORM, pas de query builder : du SQL brut pour bien comprendre ce qui se passe.

## Tests

**Les tests sont fournis** dans `tests/Day05/`. Tu dois les faire passer sans les modifier.

## Prérequis

La base de données PostgreSQL doit être lancée :

```bash
docker compose up -d postgres
```

## Contraintes

- Implémenter `PostgresUserRepository` qui implémente `UserRepositoryInterface` du jour 4
- Utiliser **PDO** pour les requêtes (pas d'ORM)
- La connexion PDO est injectée dans le constructeur
- Utiliser des **requêtes préparées** (protection contre les injections SQL)
- La table `users` doit être créée par ton code (méthode `createTable()`)

## Structure de la table

La table `users` doit contenir :

| Colonne | Type | Contraintes |
|---------|------|-------------|
| id | UUID | PRIMARY KEY |
| email | VARCHAR(255) | UNIQUE, NOT NULL |
| name | VARCHAR(255) | NOT NULL |

## Comportements attendus

### Méthode createTable()

- `createTable(): void` - Crée la table `users` si elle n'existe pas (idempotent)

### Méthodes du contrat (rappel)

- `save(User $user): void` - Persiste un utilisateur (INSERT ou UPDATE)
- `findById(UserId $id): ?User` - Retourne l'utilisateur ou `null`
- `findByEmail(Email $email): ?User` - Retourne l'utilisateur ou `null`
- `findAll(): array` - Retourne tous les utilisateurs
- `delete(UserId $id): void` - Supprime un utilisateur (idempotent)
- `exists(UserId $id): bool` - Vérifie l'existence

### Règles métier

- `save()` fait un **upsert** : INSERT si nouveau, UPDATE si existant
- La recherche par email est **case-insensitive** (comme au jour 1)
- `delete()` ne lève pas d'exception si l'utilisateur n'existe pas
- `findAll()` retourne un tableau indexé numériquement

### Reconstruction des entités

Quand tu récupères un utilisateur de la base, tu dois reconstruire l'entité `User` avec ses Value Objects (`UserId`, `Email`).

## Critères de succès

Tous les tests dans `tests/Day05/` doivent passer.

## Fichiers à créer

- `src/Day05/PostgresUserRepository.php`

## Commandes utiles

```bash
# Lancer PostgreSQL
docker compose up -d postgres

# Lancer les tests du jour 5
task day -- 05

# Lancer PHPStan
task phpstan

# Fixer le code style
task cs-fix
```
