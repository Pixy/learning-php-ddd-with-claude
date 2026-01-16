# Spécifications du projet orni-teach

## Objectif

Projet d'apprentissage quotidien pour améliorer ses compétences en architecture de code, refactoring et manipulation de base de données via des exercices progressifs en TDD.

---

## Règles fondamentales

1. **TDD obligatoire** : Les tests doivent toujours passer
2. **Pas de problèmes mathématiques** : Pas d'algorithmes de tri, calculs complexes, etc.
3. **Thèmes autorisés** :
   - Architecture de code (Clean Architecture, Hexagonal, Ports & Adapters)
   - Principes SOLID
   - Design Patterns (Repository, Factory, Strategy, Specification, etc.)
   - Refactoring de code legacy
   - Value Objects, Entities, Aggregates
   - DTOs et séparation des couches
   - Optimisation de requêtes SQL
   - Gestion des transactions
   - Caching

---

## Progression de difficulté

| Niveau | Durée estimée | Description |
|--------|---------------|-------------|
| Facile | 10-20 min | Concepts de base, peu de code |
| Moyen | 20-40 min | Patterns simples, refactoring léger |
| Moyen-Difficile | 30-45 min | Architecture, plusieurs fichiers |
| Difficile | 45-60 min max | BDD, optimisation, cas complexes |

---

## Format d'un exercice

```
exercises/day-XX.md     # Énoncé (très peu d'indices)
tests/DayXX/*Test.php   # Tests à faire passer
src/DayXX/              # Code à implémenter
```

---

## Workflow d'un exercice

1. Claude génère l'énoncé + les tests (au début), puis juste l'énoncé (plus tard)
2. L'utilisateur implémente en TDD
3. L'utilisateur soumet ses tests pour validation (si c'est lui qui les écrit)
4. L'utilisateur soumet sa solution pour review
5. Claude donne du feedback sans donner la solution directement

---

## Contraintes techniques

- **PHP** : 8.3
- **Base de données** : PostgreSQL 16
- **Tests** : PHPUnit
- **Qualité** : PHPStan level 8, PHP-CS-Fixer PSR-12
- **Environnement** : Docker

---

## Indices

- Par défaut : aucun indice dans l'énoncé
- L'utilisateur peut demander des indices s'il bloque
- Les indices sont donnés de façon progressive (du plus vague au plus précis)

---

## Plan des exercices

### Semaine 1 : Fondations (Facile)
- Jour 1 : Value Object Email
- Jour 2 : Value Object Money
- Jour 3 : Entity User
- Jour 4 : Repository in-memory
- Jour 5 : Repository PostgreSQL
- Jour 6 : DTOs
- Jour 7 : Refactoring code spaghetti

### Semaine 2 : SOLID & Patterns (Moyen)
- Jour 8-12 : Principes SOLID (un par jour)
- Jour 13 : Factory Pattern
- Jour 14 : Strategy Pattern

### Semaine 3 : Clean Architecture (Moyen-Difficile)
- Jour 15 : Use Case
- Jour 16 : Ports & Adapters
- Jour 17 : Domain Events
- Jour 18 : Aggregates
- Jour 19 : Specification Pattern
- Jour 20 : CQRS intro
- Jour 21 : Refactoring complet

### Semaine 4 : BDD & Optimisation (Difficile)
- Jour 22 : Query Builder
- Jour 23 : N+1 Problem
- Jour 24 : Pagination
- Jour 25 : Transactions
- Jour 26 : Optimisation requêtes
- Jour 27 : Caching
- Jour 28 : Projet final
