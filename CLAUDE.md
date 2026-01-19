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

### Précision sur les tests dans l'énoncé

Chaque énoncé d'exercice doit **explicitement préciser** qui écrit les tests :

- **"Les tests sont fournis"** : Claude fournit les tests, l'utilisateur doit les faire passer sans les modifier
- **"Tu dois écrire les tests"** : L'utilisateur écrit ses propres tests, Claude les reviewera

Dans les deux cas, **les tests doivent toujours passer** à la fin de l'exercice.

### Autonomie de l'énoncé

L'énoncé doit être **auto-suffisant** pour permettre la correction même si le contexte de la conversation est perdu. Il doit contenir :

- Les critères d'acceptance clairs
- Les contraintes techniques spécifiques à l'exercice
- Les comportements attendus (cas nominaux et cas d'erreur)
- Les règles métier à respecter

Cela permet de corriger l'exercice dans une nouvelle conversation sans avoir besoin de contexte supplémentaire.

### Statut d'un exercice

Chaque fichier `exercises/day-XX.md` contient un statut après le titre :

| Statut | Signification |
|--------|---------------|
| `> **Statut** : 📝 À faire` | Exercice créé, pas encore commencé |
| `> **Statut** : 🚧 En cours` | L'utilisateur travaille dessus |
| `> **Statut** : ✅ Corrigé et validé` | Exercice terminé et validé |

### Gestion du statut

- **À la création** : Mettre `📝 À faire`
- **Quand l'utilisateur commence** : Mettre `🚧 En cours` (quand il pose des questions, demande des indices, etc.)
- **À la correction réussie** : Mettre `✅ Corrigé et validé`

**IMPORTANT** : À chaque changement de statut d'un exercice, mettre à jour **simultanément** :
1. Le fichier `exercises/day-XX.md` (statut dans l'en-tête)
2. Le tableau "Suivi des exercices" dans ce fichier CLAUDE.md

### Correction d'exercice

Quand l'utilisateur demande de **corriger** ou **valider** son exercice :

1. **Lancer les vérifications** : `task quality` (cs-check + phpstan + tests)
2. **Revue de code** : Lire le code implémenté par l'utilisateur et vérifier :
   - Respect des contraintes de l'énoncé (immutabilité, patterns demandés, etc.)
   - Pas de triche (code en dur, contournement des tests, etc.)
   - Qualité du code (lisibilité, bonnes pratiques)
   - Code mort ou inutile (variables non utilisées, opérations redondantes, etc.)
3. **Si tout passe** :
   - Valider que l'exercice est réussi
   - Mettre à jour le statut en `✅ Corrigé et validé`
4. **Si des erreurs ou problèmes** :
   - Indiquer **quelles** erreurs existent (tests qui échouent, erreurs PHPStan, etc.)
   - Signaler les problèmes de qualité ou de triche détectés
   - **Ne PAS donner la solution** ni comment corriger
   - L'utilisateur doit trouver par lui-même

**Important** : La correction valide le travail de l'utilisateur, elle ne donne jamais la réponse.

---

## Contraintes techniques

- **PHP** : 8.3
- **Base de données** : PostgreSQL 16
- **Tests** : PHPUnit
- **Qualité** : PHPStan level 8, PHP-CS-Fixer PSR-12
- **Environnement** : Docker

### Commandes à utiliser

**IMPORTANT** : Toujours utiliser les commandes `task` du Taskfile pour lancer les outils de qualité et tests. Ne jamais appeler directement les binaires vendor.

| Action | Commande |
|--------|----------|
| Tests complets | `task test` |
| Tests d'un jour | `task day -- XX` |
| PHPStan | `task phpstan` |
| CS-Fixer (vérification) | `task cs-check` |
| CS-Fixer (correction) | `task cs-fix` |
| Qualité complète | `task quality` |

---

## Indices

- Par défaut : aucun indice dans l'énoncé
- L'utilisateur peut demander des indices s'il bloque
- Les indices sont donnés de façon progressive (du plus vague au plus précis)

---

## Suivi des exercices

| Jour | Thème | Statut |
|------|-------|--------|
| 01 | Value Object Email | ✅ Validé |
| 02 | Value Object Money | ✅ Validé |
| 03 | Entity User | ✅ Validé |
| 04 | Repository in-memory | ✅ Validé |
| 05 | Repository PostgreSQL | ✅ Validé |
| 06 | DTOs | 📝 À faire |
| 07 | Refactoring code spaghetti | 📝 À faire |
| 08 | SOLID - Single Responsibility | 📝 À faire |
| 09 | SOLID - Open/Closed | 📝 À faire |
| 10 | SOLID - Liskov Substitution | 📝 À faire |
| 11 | SOLID - Interface Segregation | 📝 À faire |
| 12 | SOLID - Dependency Inversion | 📝 À faire |
| 13 | Factory Pattern | 📝 À faire |
| 14 | Strategy Pattern | 📝 À faire |
| 15 | Use Case | 📝 À faire |
| 16 | Ports & Adapters | 📝 À faire |
| 17 | Domain Events | 📝 À faire |
| 18 | Aggregates | 📝 À faire |
| 19 | Specification Pattern | 📝 À faire |
| 20 | CQRS intro | 📝 À faire |
| 21 | Refactoring complet | 📝 À faire |
| 22 | Query Builder | 📝 À faire |
| 23 | N+1 Problem | 📝 À faire |
| 24 | Pagination | 📝 À faire |
| 25 | Transactions | 📝 À faire |
| 26 | Optimisation requêtes | 📝 À faire |
| 27 | Caching | 📝 À faire |
| 28 | Projet final | 📝 À faire |

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
