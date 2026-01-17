# Jour 17 : Domain Events

> **Statut** : 📝 À faire

## Objectif

Implémenter un système de Domain Events permettant à une Entity de publier des événements métier lorsqu'elle change d'état.

## Contexte

Les Domain Events sont un pattern DDD (Domain-Driven Design) qui permet de découpler les effets de bord des actions métier. Quand un utilisateur change son email, au lieu d'envoyer directement un email de confirmation dans l'Entity, on **enregistre un événement** `UserEmailChanged` que d'autres parties du système pourront traiter.

Avantages :
- Découplage : l'Entity ne connaît pas les effets de bord
- Testabilité : on peut vérifier qu'un événement a été émis sans mocker un service d'email
- Extensibilité : on peut ajouter des listeners sans modifier l'Entity

## Tests

**Tu dois écrire les tests toi-même** dans `tests/Day17/`. Je les reviewerai avant que tu implémentes.

## Architecture attendue

```
src/Day17/
├── Event/
│   ├── DomainEvent.php          # Interface pour tous les events
│   ├── UserRegistered.php       # Event : utilisateur créé
│   └── UserEmailChanged.php     # Event : email modifié
├── User.php                     # Entity qui émet des events
└── AggregateRoot.php            # Trait ou classe abstraite pour gérer les events
```

## Comportements attendus

### Interface DomainEvent

- Chaque event doit avoir une méthode `occurredAt(): DateTimeImmutable`
- Chaque event doit pouvoir être identifié par son nom via `eventName(): string`

### Event UserRegistered

- Contient l'id de l'utilisateur créé
- Contient l'email de l'utilisateur
- Contient la date de création
- `userId(): string` retourne l'id
- `email(): string` retourne l'email
- `occurredAt(): DateTimeImmutable` retourne la date

### Event UserEmailChanged

- Contient l'id de l'utilisateur
- Contient l'ancien email
- Contient le nouvel email
- Contient la date du changement
- `userId(): string` retourne l'id
- `oldEmail(): string` retourne l'ancien email
- `newEmail(): string` retourne le nouvel email
- `occurredAt(): DateTimeImmutable` retourne la date

### AggregateRoot (trait ou classe abstraite)

- `recordEvent(DomainEvent $event): void` enregistre un event (usage interne)
- `pullEvents(): array` retourne tous les events enregistrés ET les supprime de l'Entity
- Après `pullEvents()`, un second appel retourne un tableau vide

### Entity User

- Doit utiliser `AggregateRoot`
- `User::register(string $id, string $email, string $name)` crée un User ET enregistre un `UserRegistered`
- `$user->changeEmail(string $newEmail)` modifie l'email ET enregistre un `UserEmailChanged`
- Si le nouvel email est identique à l'actuel, **aucun event** n'est enregistré
- `$user->pullEvents()` retourne les events en attente

## Règles métier importantes

1. **Un event n'est enregistré que si un changement réel a lieu**
   - `changeEmail('same@email.com')` quand l'email est déjà `same@email.com` → pas d'event

2. **Les events sont purgés après `pullEvents()`**
   - Premier appel : retourne les events
   - Deuxième appel : retourne `[]`

3. **L'ordre des events est préservé**
   - Si on fait `register()` puis `changeEmail()`, `pullEvents()` retourne `[UserRegistered, UserEmailChanged]` dans cet ordre

4. **Les events sont immutables**
   - Une fois créé, un event ne peut pas être modifié

## Critères de validation des tests

Tes tests doivent couvrir :

- [ ] Création d'un UserRegistered avec les bonnes données
- [ ] Création d'un UserEmailChanged avec les bonnes données
- [ ] `User::register()` enregistre un `UserRegistered`
- [ ] `changeEmail()` avec un email différent enregistre un `UserEmailChanged`
- [ ] `changeEmail()` avec le même email n'enregistre rien
- [ ] `pullEvents()` retourne les events dans l'ordre
- [ ] `pullEvents()` vide la liste des events
- [ ] Les events ont une date `occurredAt()` valide
- [ ] Les events ont un `eventName()` correct

## Workflow

1. Crée tes tests dans `tests/Day17/`
2. Soumets-les moi pour review
3. Une fois validés, implémente le code
4. Soumets pour correction finale

## Fichiers à créer

**Tests :**
- `tests/Day17/UserRegisteredTest.php`
- `tests/Day17/UserEmailChangedTest.php`
- `tests/Day17/UserTest.php`

**Implémentation :**
- `src/Day17/Event/DomainEvent.php`
- `src/Day17/Event/UserRegistered.php`
- `src/Day17/Event/UserEmailChanged.php`
- `src/Day17/AggregateRoot.php`
- `src/Day17/User.php`

## Commandes utiles

```bash
# Lancer les tests du jour 17
task day -- 17

# Lancer PHPStan
task phpstan

# Fixer le code style
task cs-fix
```
