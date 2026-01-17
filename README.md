# Orni-Teach

Projet d'apprentissage quotidien pour améliorer ses compétences en **architecture de code**, **refactoring** et **manipulation de base de données** via des exercices progressifs en TDD.

## Objectif

Progresser chaque jour sur des concepts fondamentaux du développement logiciel à travers des exercices pratiques. Chaque exercice est conçu pour être réalisé en 10 à 60 minutes selon sa difficulté.

## Thèmes abordés

- **Architecture de code** : Clean Architecture, Hexagonal, Ports & Adapters
- **Principes SOLID** : Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion
- **Design Patterns** : Repository, Factory, Strategy, Specification, etc.
- **Domain-Driven Design** : Value Objects, Entities, Aggregates, Domain Events
- **Refactoring** : Transformation de code legacy en code propre
- **Base de données** : Optimisation de requêtes SQL, gestion des transactions, caching

## Prérequis

- Docker
- PHP 8.3
- Composer

## Installation

```bash
# Cloner le projet
git clone <repo-url>
cd orni-teach

# Lancer l'environnement Docker
docker compose up -d

# Installer les dépendances
composer install
```

## Structure du projet

```
exercises/day-XX.md     # Énoncé de l'exercice
tests/DayXX/*Test.php   # Tests à faire passer
src/DayXX/              # Code à implémenter
```

## Comment utiliser

### 1. Choisir un exercice

Les exercices sont dans le dossier `exercises/`. Commencer par `day-01.md` et progresser dans l'ordre.

### 2. Lire l'énoncé

Chaque énoncé contient :
- Le contexte et l'objectif
- Les critères d'acceptance
- Les contraintes techniques
- L'indication si les tests sont fournis ou à écrire

### 3. Implémenter en TDD

```bash
# Lancer les tests de l'exercice
task test -- --filter DayXX

# Ou tous les tests
task test
```

### 4. Vérifier la qualité

```bash
# Lancer toutes les vérifications (CS, PHPStan, tests)
task quality
```

### 5. Soumettre pour correction

Demander une review à Claude. La correction vérifie :
- Les tests passent
- Le code respecte les contraintes de l'énoncé
- La qualité du code (PHPStan level 8, PSR-12)

## Processus de travail

```
┌─────────────────┐
│  Lire l'énoncé  │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Écrire le code  │◄──────┐
│    (TDD)        │       │
└────────┬────────┘       │
         │                │
         ▼                │
┌─────────────────┐       │
│ Lancer tests    │       │
└────────┬────────┘       │
         │                │
    Tests KO? ────────────┘
         │
    Tests OK
         │
         ▼
┌─────────────────┐
│ task quality    │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   Correction    │
│   par Claude    │
└─────────────────┘
```

## Progression

| Semaine | Thème | Difficulté |
|---------|-------|------------|
| 1 | Fondations (Value Objects, Entities, Repository, DTOs) | Facile |
| 2 | SOLID & Design Patterns | Moyen |
| 3 | Clean Architecture (Use Cases, Ports & Adapters, DDD) | Moyen-Difficile |
| 4 | Base de données & Optimisation | Difficile |

## Commandes utiles

| Commande | Description |
|----------|-------------|
| `task test` | Lancer tous les tests |
| `task test -- --filter DayXX` | Lancer les tests d'un exercice |
| `task quality` | CS-Fixer + PHPStan + Tests |
| `task cs-fix` | Corriger le style de code |
| `task phpstan` | Analyse statique |

## Règles

- **TDD obligatoire** : Les tests doivent toujours passer
- **Pas de triche** : Ne pas modifier les tests fournis
- **Demander des indices** : Si tu bloques, demande un indice progressif plutôt que la solution
