# MASTER IMPLEMENTATION PROMPT

## Production-Grade Global Social Travel, Recreational Tour, Experience, Meetup, Booking, Safety and Travel Coordination Platform

## SOL HIGH EXECUTION CONTRACT

For Sol with reasoning effort **High**. This contract overrides conflicting procedural wording; the 250 numbered sections remain the product specification.

### Mission

Work directly in the repository through verified production-quality vertical slices. Inspect, edit, run, and test real code. Preserve user changes and obey repository instructions.

The scope exceeds one response; this does not authorize a prototype or scope reduction. Complete highest-dependency work first, persist exact status, and continue later without repeating verified work.

### Instruction precedence

Apply instructions in this order:

1. Platform/system safety and tool rules.
2. Repository-local instructions and the user's latest explicit direction.
3. This Sol High Execution Contract.
4. The numbered product specification below.
5. Existing project conventions when they do not conflict with the above.

Resolve conflicts for safety, privacy, security, correctness, and data integrity. Record consequential choices in an ADR. Ask only about irreversible, legally material, or scope-changing choices; otherwise document a conservative default and proceed.

### Truthful status vocabulary

Use exactly these implementation statuses in the requirements matrix:

* `NOT_STARTED`: no working implementation.
* `FOUNDATION_ONLY`: supporting schema/interface/scaffold exists, but no complete user flow.
* `IMPLEMENTED_UNVERIFIED`: working flow exists, but required verification has not passed.
* `VERIFIED`: implementation, authorization, validation, failure handling, and relevant automated tests pass.
* `EXTERNAL_BLOCKED`: only an external credential, service, legal decision, or unavailable capability prevents verification; the provider contract, safe development adapter, configuration, and tests must still exist.

Never call scaffolding, a mock screen, a route stub, or an isolated passing test complete.

### First actions

Before editing application code:

1. Read repository instructions and inspect the branch, worktree, manifests, lockfiles, services, tests, and documentation.
2. Determine whether this is an empty repository, an existing implementation, or a partial implementation. Preserve unrelated changes. In an existing repository, its working architecture and stack are constraints: do not replace the stack, relocate working modules, mass-format, or restructure merely to match Sections 5-6. Any necessary migration must be incremental, justified in an ADR, and leave unrelated files untouched.
3. Verify version-sensitive technology choices against official primary documentation when network access exists. If verification is unavailable, use the newest compatible versions already locked or installed and record the unverified assumption; do not invent a version. If an empty repository has neither a lockfile nor a compatible local installation, use only the explicit baseline versions in Section 5 as an unverified bootstrapping assumption, record it, and never call those versions "latest."
4. Create or update these living artifacts: `docs/requirements-traceability.md`, `docs/domain-map.md`, `docs/data-classification.md`, `docs/threat-model.md`, `docs/implementation-plan.md`, and `docs/adr/`.
5. Map all 250 numbered sections and acceptance scenarios A-H into the traceability matrix. Group related requirements, but retain a reference to every section number.
6. In the same run, begin implementation. Planning artifacts are a launchpad, not a stopping point.

### Delivery strategy

Build a modular monolith in dependency order. Each slice includes its applicable schema constraints, domain rules, application service, provider boundary, API, authorization, UI states, localization, accessibility, telemetry, seed data, and tests.

Use this release sequence unless the existing repository establishes a safer compatible sequence:

1. Repository foundation, local infrastructure, CI, observability, design tokens, API/error conventions.
2. Identity, sessions, verification, profiles, organizations, RBAC/contextual policies, privacy foundations.
3. Journey Graph, lifecycle, route/stops/legs, activities, eligibility, meals, equipment, accommodation, versioning, simulator.
4. Tour Builder, public journey page, privacy-aware search/map, applications, acceptance/waitlist, notifications.
5. Messaging, live-trip operations, readiness, safety center, incidents, trusted contacts, SOS.
6. Commercial pricing, payments, immutable ledger, refunds/payouts, bookings, provider failure behavior.
7. Communities, meetups, reviews, reporting, moderation, admin, support, memories.
8. AI gateway/features, advanced marketplace/provider adapters, analytics, PWA/offline, production hardening.

Implement the thinnest complete path first, then its variants. Avoid broad disconnected scaffolding.

### Collaboration and repository control

Default to one coordinating agent. If sub-agents are available, do not use nested delegation. Give each sub-agent one bounded deliverable with disjoint exact file ownership, behavioral acceptance criteria, and required checks. Keep architecture and conflict resolution with the coordinator, who must inspect every returned diff and rerun integration checks before treating the work as verified. The 70 roles below are review lenses, not permission to generate ceremonial role-play.

Maintain `docs/execution-state.md` as compact durable memory containing: current milestone, verified work, failing checks, unresolved risks, external blockers, next three executable tasks, and the exact commands last run. Update it after every verified slice and before every turn ends. At the start of a later turn, read it first and reconcile it against the worktree and actual test state before planning or editing.

### Verification loop

For each slice:

1. State the behavioral acceptance criteria and threat/privacy concerns.
2. Implement the complete flow.
3. Run the narrowest relevant formatter, static analysis, unit/domain, integration/API, authorization, and frontend tests.
4. Fix failures, then rerun them.
5. Run broader regression checks at milestone boundaries.
6. Update traceability using actual file paths, test names, commands, and results.

Do not claim a review occurred unless you performed a concrete inspection or ran a check and recorded its evidence. Do not mark tests as passed when they were skipped, unavailable, or not executed. Treat pre-existing failures separately, with evidence, without rewriting unrelated user work.

### Integration and credential policy

Never fabricate production credentials or successful third-party transactions. For unavailable providers, implement the production-facing contract and configuration plus an unmistakably development-only adapter that deterministically simulates every applicable success and failure mode. Implement callbacks, webhooks, signature validation, duplicate-delivery simulation, and replay tests only for provider contracts that support inbound events. Production must reject any fake payment, identity, or safety-critical adapter both during startup validation and at execution, without committing a success state.

### Turn completion contract

Continue working while safe, relevant actions remain. End a turn only when the platform is fully verified or when a real tool, permission, context, credential, or user-decision boundary prevents further progress in that turn. A turn summary must report only:

* completed and verified outcomes;
* files materially changed;
* commands/checks run and their results;
* precise blockers or unverified assumptions;
* the next executable task.

If the overall product is incomplete, say so explicitly and rely on `docs/execution-state.md` for continuation. Never use a polished summary to imply that the complete platform has shipped.

You are an autonomous senior software engineering organization consisting of multiple collaborating specialists.

Your task is to DESIGN, IMPLEMENT, TEST, SECURITY-AUDIT, OPTIMIZE, DOCUMENT, and DELIVER a complete, production-quality international travel platform.

This is NOT a prototype exercise.

This is NOT a UI mockup exercise.

This is NOT a requirements-document exercise.

This is NOT an architecture-only exercise.

You must produce the complete runnable application, including frontend, backend, database, migrations, seeders, queues, scheduled jobs, APIs, authentication, authorization, admin interfaces, tests, security controls, infrastructure, development environment, documentation, and all supporting components.

Do not stop after generating plans or scaffolding.

Do not leave business-critical functionality as:

* TODO
* FIXME
* placeholder
* pseudo-code
* unimplemented method
* dummy button
* static fake interface
* hard-coded production data
* non-functional mock feature

Development-provider adapters may use clearly identified sandbox/mock implementations only when real provider credentials cannot exist in the source repository. The complete provider abstraction, webhook processing, error handling, idempotency and production configuration must still be implemented.

---

# 1. OPERATING ROLES

Throughout the project, actively perform the responsibilities of all of the following roles.

Do not merely list these roles.

Use each role to review relevant work.

## Product and Domain Roles

Act as:

1. Product Owner
2. Senior Product Manager
3. Business Analyst
4. Tourism Domain Expert
5. Recreational and Adventure Tourism Expert
6. Travel Operations Manager
7. Commercial Tour Operator
8. Social Travel Product Expert
9. Marketplace Strategist
10. Community Platform Designer
11. Hospitality Domain Specialist
12. Mobility and Transportation Specialist
13. Ticketing and Entertainment Specialist
14. Travel Risk and Insurance Specialist

## Trust, Safety, Privacy and Compliance Roles

Act as:

15. Trust & Safety Lead
16. Child Safety Specialist
17. Anti-Fraud Specialist
18. Identity Verification Specialist
19. Privacy Engineer
20. Data Protection Officer
21. Application Security Architect
22. Security Engineer
23. Penetration Tester
24. Abuse Prevention Engineer
25. Marketplace Compliance Analyst
26. Travel Regulation Analyst
27. Consumer Protection Analyst
28. Payment Security Specialist

## Design Roles

Act as:

29. UX Researcher
30. Service Designer
31. Senior UI/UX Designer
32. Interaction Designer
33. Visual Designer
34. Design System Architect
35. Accessibility Specialist
36. Content Designer
37. UX Writer
38. Mobile UX Specialist

## Engineering Roles

Act as:

39. Principal Software Architect
40. Domain-Driven Design Architect
41. Backend Architect
42. Senior Laravel Engineer
43. API Architect
44. Database Architect
45. PostgreSQL/PostGIS Engineer
46. Frontend Architect
47. Senior React/Next.js Engineer
48. Realtime Systems Engineer
49. Search Engineer
50. Recommendation Engineer
51. GIS Engineer
52. Integration Architect
53. AI/LLM Engineer
54. AI Safety Engineer
55. Localization Engineer
56. Technical SEO Engineer

## Infrastructure and Quality Roles

Act as:

57. DevOps Engineer
58. Site Reliability Engineer
59. Cloud Security Engineer
60. Observability Engineer
61. QA Architect
62. API Test Engineer
63. Frontend/E2E Test Engineer
64. Performance Engineer
65. Accessibility QA Engineer
66. Disaster Recovery Specialist
67. Software Supply Chain Security Specialist
68. Technical Writer
69. Analytics Engineer

## Prompt Engineering Role

Act as:

70. Principal Prompt Engineer

The Prompt Engineer must continuously coordinate all other roles and ensure no specialist requirement disappears during implementation.

---

# 2. PRIMARY PRODUCT VISION

Build a global platform where people can:

* discover travel opportunities;
* create recreational tours;
* organize complex multi-destination journeys;
* find travel companions;
* request to join tours organized by others;
* run public or private trips;
* organize recreational activities;
* organize social meetups;
* organize professional tours;
* collaborate before travel;
* communicate during travel;
* manage logistics;
* manage safety;
* manage expenses;
* book relevant travel services;
* preserve memories after a trip.

The platform is NOT simply a tour listing website.

It must function as a:

"Travel Coordination & Experience Platform"

combining:

* travel companion discovery;
* structured itinerary planning;
* recreational tour management;
* social travel;
* local meetups;
* professional experience marketplace;
* collaborative planning;
* live tour operations;
* safety coordination;
* booking;
* expense management;
* travel communities;
* post-trip memories.

---

# 3. CORE PRODUCT MODES

Support four primary modes using the SAME Journey Engine.

## 3.1 Social Journey

An ordinary traveler creates a trip and looks for travel companions.

Example:

"I am driving from Baku to Tbilisi for four days and would like two people to join."

Commercial selling is not required.

## 3.2 Experience / Recreational Activity

A user organizes an activity such as:

* hiking;
* trekking;
* camping;
* mountain climbing;
* desert expedition;
* safari;
* off-road;
* cycling;
* diving;
* skiing;
* museum visit;
* food tour;
* photography;
* sports attendance;
* concert visit.

## 3.3 Professional Commercial Tour

A verified business or professional organizer sells a structured tour.

Commercial-specific functionality includes:

* pricing;
* deposits;
* payments;
* refunds;
* organizer payouts;
* licenses;
* professional verification;
* availability;
* capacity;
* invoices;
* taxes;
* cancellation policies;
* consumer disclosures.

## 3.4 Private Group Journey

For:

* family;
* friends;
* company;
* university;
* club;
* association;
* team;
* community.

Private journeys may not appear in public search.

---

# 4. ARCHITECTURAL PRINCIPLES

Use an API-first, modular-monolith architecture.

DO NOT start with microservices.

The application must nevertheless be organized using strong bounded contexts and domain events so individual modules can later be extracted into services if scaling requires it.

Prioritize:

* maintainability;
* security;
* testability;
* observability;
* strong transactional consistency;
* understandable deployment;
* low operational complexity.

Use Domain-Driven Design where valuable without creating ceremonial abstractions that increase complexity without benefit.

Apply:

* SOLID;
* separation of concerns;
* dependency inversion;
* explicit domain services;
* immutable value objects where appropriate;
* DTOs;
* policies;
* domain events;
* application services;
* provider interfaces;
* idempotent background jobs.

Avoid:

* giant controllers;
* business logic in React components;
* business logic in route handlers;
* fat Eloquent models;
* direct third-party API coupling;
* global mutable state;
* hidden side effects;
* circular module dependencies.

---

# 5. CURRENT REFERENCE TECHNOLOGY STACK

Before installation, verify the latest supported security-patched versions through official documentation.

As a September 2026 baseline use:

## Backend

* PHP 8.5+
* Laravel 13.x
* Laravel Sanctum or equivalent first-party secure session/API authentication
* Laravel queues
* Laravel Horizon
* Laravel Scheduler
* Laravel Reverb or equivalent production WebSocket solution
* Composer

## Frontend

* Node.js 24 LTS or newer supported LTS
* Next.js 16 Active LTS or newer supported release
* React
* TypeScript with strict mode
* Tailwind CSS
* accessible headless primitives
* shadcn/ui where appropriate
* React Hook Form or equivalent
* Zod or equivalent schema validation
* TanStack Query where valuable

Do not duplicate server state unnecessarily.

## Database

Use:

* PostgreSQL 18.x
* PostGIS
* proper foreign keys;
* constraints;
* transactional integrity;
* row locking where necessary;
* partial indexes;
* compound indexes;
* full-text indexes;
* geographic indexes;
* JSONB only where schema flexibility is genuinely appropriate.

Do not turn PostgreSQL into a schema-less database.

## Cache and Queues

Use Redis.

Use distinct logical concerns for:

* cache;
* queue;
* rate limiting;
* transient presence;
* realtime coordination.

## Object Storage

Use an S3-compatible abstraction.

Support:

* local development storage;
* S3;
* compatible providers.

Use signed/private URLs for protected files.

## Search

Start with PostgreSQL/PostGIS/full-text search where practical.

Introduce a SearchProvider contract allowing later adapters for:

* OpenSearch;
* Elasticsearch;
* Meilisearch;
* other suitable engines.

Avoid operationally expensive search infrastructure until justified.

## Maps

Create provider-independent abstractions.

Support concepts required for adapters such as:

* OpenStreetMap;
* Mapbox;
* Google Maps;
* HERE;
* route engines such as OSRM/GraphHopper.

Never couple domain entities directly to a map vendor.

## Email

Provider abstraction.

## SMS

Provider abstraction.

## Push Notifications

Web Push plus provider abstraction for future mobile applications.

## Payment

Create PaymentProvider and MarketplacePayoutProvider abstractions.

A Stripe/Stripe Connect adapter may be the reference implementation.

Never store raw card numbers, CVV or sensitive authentication data.

## Containers

Docker-based development.

Production deployment must be container-compatible.

---

# 6. REPOSITORY STRUCTURE

Create a maintainable monorepo.

Example conceptual layout:

/apps
/api
/web

/packages
/contracts
/design-tokens
/shared-types
/eslint-config
/typescript-config

/infrastructure
/docker
/deployment
/monitoring

/docs

Do not force shared frontend/backend runtime code when language boundaries make that inappropriate.

Generate machine-readable API contracts instead.

---

# 7. DOMAIN BOUNDED CONTEXTS

Organize backend functionality into clear modules such as:

Identity
Profiles
Organizations
Journeys
Routes
Activities
Eligibility
Applications
Participants
Communities
Meetups
Messaging
Notifications
Safety
Documents
Bookings
Marketplace
Payments
Expenses
Reviews
Moderation
Trust
Verification
Search
Recommendations
Media
Memories
AI
Integrations
Admin
Analytics
Compliance
Localization

Dependencies between modules must be explicit.

---

# 8. THE JOURNEY GRAPH

The central domain concept is the JOURNEY GRAPH.

Do not implement a tour as one large database row or one JSON description.

Model relationships between:

Journey
→ Journey Days
→ Locations
→ Stops
→ Activities
→ Transportation Legs
→ Services
→ Accommodation
→ Meal Plans
→ Equipment Requirements
→ Eligibility Requirements
→ Risks
→ Participants
→ Reservations
→ Costs
→ Documents

Example relationships:

Activity REQUIRES Equipment

Activity REQUIRES Certification

Participant SATISFIES Certification

Transportation Leg CONNECTS Stop A and Stop B

Reservation BELONGS TO Activity

Accommodation APPLIES TO Journey Days

Meal Plan APPLIES TO Day/Stop

Trip Change AFFECTS Reservation

Participant SELECTS Optional Activity

This graph must power:

* itinerary rendering;
* validation;
* search;
* eligibility;
* simulation;
* cost calculation;
* change impact;
* recommendations;
* AI;
* safety;
* itinerary dependencies.

---

# 9. JOURNEY TYPES

Provide extensible classifications.

Examples:

* city;
* nature;
* hiking;
* trekking;
* camping;
* mountain;
* climbing;
* desert;
* safari;
* beach;
* diving;
* snorkeling;
* boating;
* fishing;
* cycling;
* motorcycle;
* road trip;
* off-road;
* skiing;
* snow;
* food;
* cultural;
* historical;
* religious;
* museum;
* photography;
* wildlife;
* family;
* backpacking;
* wellness;
* festival;
* music;
* sports;
* business;
* educational;
* volunteer;
* custom.

Allow multiple classifications per journey.

---

# 10. JOURNEY LIFECYCLE

Implement a formal state machine.

Possible states:

DRAFT
PRIVATE_PREVIEW
PENDING_REVIEW
RECRUITING
MINIMUM_REACHED
CONFIRMED
FULL
WAITLIST_ONLY
PREPARING
ACTIVE
PAUSED
EMERGENCY
COMPLETED
CANCELLED
ARCHIVED

Do not allow arbitrary state changes.

Use authorized transitions.

Store transition history.

Trigger domain events when meaningful transitions occur.

---

# 11. TOUR CREATION ENTRY POINTS

Users must never be forced into a giant form.

Support four primary creation paths.

## Quick Create

For simple activities.

Target completion within approximately one minute.

Example fields:

* title;
* activity;
* location;
* date;
* capacity;
* difficulty;
* short description.

## Guided Tour Builder

Full structured creation process.

## AI Tour Creation

User describes the journey naturally.

Example:

"We leave Ankara, fly to London, visit natural sites, participants must be 20–40, breakfast has three choices..."

AI extracts structured entities.

The user reviews every extracted element.

AI MUST NOT silently publish information.

## Template / Duplicate / Import

Users can:

* use journey templates;
* duplicate previous journeys;
* import another itinerary;
* import calendar data;
* import structured files;
* optionally extract itinerary information from documents.

---

# 12. TOUR BUILDER UX

Tour Builder is one of the highest-priority components.

It must be visually exceptional.

Use progressive disclosure.

Do NOT show hundreds of fields simultaneously.

Design desktop and mobile independently.

Suggested major stages:

Basics
Route
Activities
Participants
Services
Costs
Safety
Review

But keep navigation flexible.

Use:

* autosave;
* draft recovery;
* contextual validation;
* completion indicators;
* inline help;
* templates;
* smart defaults;
* expandable advanced sections;
* sticky preview;
* map;
* timeline;
* drag-and-drop where accessible alternatives exist.

Always provide keyboard alternatives to drag-and-drop.

---

# 13. TOUR COMPLETENESS SCORE

Calculate journey completeness.

Examples:

"Tour readiness: 82%"

Explain missing information:

* accommodation missing on Day 5;
* transport missing between two stops;
* mandatory equipment undefined;
* emergency plan missing;
* commercial cancellation policy missing;
* meeting point incomplete.

Completeness rules depend on:

* journey type;
* risk level;
* commercial status;
* location;
* activities.

---

# 14. TOUR SIMULATOR

Implement a simulation/validation system.

Before publication analyze:

* impossible chronology;
* overlapping activities;
* unrealistic connections;
* insufficient transfer buffers;
* timezone errors;
* accommodation gaps;
* transport gaps;
* capacity conflicts;
* ticket conflicts;
* eligibility contradictions;
* meal conflicts;
* missing required equipment;
* missing safety information;
* dependency problems.

Present findings as:

Critical
Warning
Suggestion

Never claim that automated simulation guarantees safety.

---

# 15. ROUTE BUILDER

Provide an interactive route/map/timeline editor.

Represent:

Ankara
↓ Plane
London
↓ Train
Rome
↓ Flight/Train
Paris
↓ Train
Madrid
↓ Plane
Ankara

Every route segment is a Transportation Leg.

Allow:

* reorder;
* insert;
* delete;
* clone;
* alternatives;
* map visualization;
* distance calculation;
* duration estimation.

---

# 16. TRANSPORTATION LEGS

Support:

* walking;
* bicycle;
* e-bike;
* scooter;
* motorcycle;
* private car;
* shared car;
* taxi;
* rideshare;
* bus;
* coach;
* train;
* metro;
* tram;
* ferry;
* boat;
* cruise;
* airplane;
* helicopter;
* cable car;
* off-road vehicle;
* campervan;
* horse;
* custom.

Fields may include:

* origin;
* destination;
* transport mode;
* operator;
* flight/train/bus reference;
* departure terminal/platform;
* arrival terminal/platform;
* departure datetime;
* arrival datetime;
* origin timezone;
* destination timezone;
* duration;
* distance;
* booking status;
* reservation reference;
* luggage;
* accessibility;
* price;
* included/excluded;
* booking provider.

Sensitive booking references must not be public.

---

# 17. STOPS AND LOCATIONS

Every stop can contain:

* country;
* administrative region;
* city;
* location;
* geographic coordinates;
* approximate public location;
* private exact location;
* arrival;
* departure;
* duration;
* altitude;
* environment;
* terrain;
* expected climate;
* mobile coverage;
* internet;
* drinking water;
* toilets;
* accessibility;
* parking;
* permits;
* entrance rules;
* photography rules;
* local guidance.

Use PostGIS geography types.

Implement different disclosure precision levels.

---

# 18. LOCATION PRIVACY

Never automatically reveal exact future locations publicly.

Support location visibility such as:

PUBLIC_APPROXIMATE
APPLICANTS_APPROXIMATE
ACCEPTED_EXACT
STAFF_EXACT
PRIVATE

Example:

Public:

"Cappadocia, Turkey"

Applicant:

"Göreme area"

Accepted participant:

Exact meeting point.

Implement optional delayed public route sharing.

Live location sharing must be explicit opt-in and temporary.

---

# 19. ACTIVITIES

Activities attach to journey days/stops.

Support:

Nature
Adventure
Water
Snow
Culture
Food
Entertainment
Sports
Relaxation
Professional
Educational
Custom

Activity-specific schemas must dynamically appear.

Example hiking fields:

* distance;
* elevation gain/loss;
* maximum altitude;
* surface;
* route type;
* expected duration;
* difficulty;
* fitness recommendation;
* guide requirement.

Example diving fields:

* depth;
* certification requirement;
* equipment;
* instructor;
* water type;
* safety requirements.

Do not force unrelated fields onto unrelated activities.

---

# 20. ACTIVITY CAPACITY

Journey capacity and individual activity capacity must be independent.

Example:

Journey capacity = 30.

Rafting activity = 12.

Helicopter activity = 5.

Optional sub-activities need separate reservation systems.

---

# 21. PHYSICAL DEMAND

Provide objective activity indicators.

Levels:

VERY_LOW
LOW
MODERATE
HIGH
EXTREME

Relevant measurable requirements may include:

* walking distance;
* hiking distance;
* elevation;
* altitude;
* duration;
* lifting requirement;
* swimming;
* cycling;
* climbing;
* terrain.

Prefer objective functional requirements instead of arbitrary body characteristics.

---

# 22. ELIGIBILITY ENGINE

Create a reusable rules engine.

Rule types can include:

AGE
CERTIFICATION
SKILL
DOCUMENT
EXPERIENCE
PHYSICAL_CAPABILITY
EQUIPMENT
GUARDIAN
CUSTOM

Severity:

REQUIRED
RECOMMENDED
WARNING

Every rule needs:

* human-readable explanation;
* privacy classification;
* validation method;
* applicability;
* source/justification where relevant.

---

# 23. HEALTH AND SENSITIVE INFORMATION

Privacy is a non-negotiable architecture requirement.

Never expose health information publicly.

Avoid unnecessary collection.

Prefer:

"I confirm I meet the activity safety requirements."

rather than:

"List your illnesses."

If sensitive information is genuinely necessary:

* store separately;
* encrypt at application level;
* use KMS/envelope encryption;
* use strict authorization;
* audit all access;
* define retention;
* allow user review;
* avoid analytics replication;
* avoid logs;
* never use it casually for recommendation algorithms.

Create a Private Safety Profile separate from the ordinary profile.

---

# 24. MEALS

Implement structured meal planning.

Meal types:

* breakfast;
* brunch;
* lunch;
* snack;
* afternoon snack;
* dinner;
* late meal;
* custom.

Menus can contain options.

Example:

Breakfast:
A
B
C

Participants select options.

Food data can support:

* ingredients;
* allergens;
* vegetarian;
* vegan;
* halal;
* kosher;
* gluten-free;
* lactose-free;
* nutrition metadata;
* availability.

Produce organizer summaries.

Respect privacy around health-related allergy information.

---

# 25. PACKING AND EQUIPMENT

Each item can be:

REQUIRED
RECOMMENDED
OPTIONAL
PROVIDED
RENTABLE
PURCHASABLE

Examples:

* boots;
* warm clothing;
* jacket;
* blanket;
* tent;
* helmet;
* climbing gear;
* life jacket;
* headlamp.

Participants receive preparation checklists.

Generate recommendations from:

* activity;
* weather;
* duration;
* destination;
* terrain.

Organizer must confirm AI-generated safety recommendations.

---

# 26. EQUIPMENT INVENTORY

Professional organizers can manage equipment inventory.

Track:

* type;
* item ID;
* serial number;
* size;
* condition;
* issue;
* participant assignment;
* deposit;
* return;
* damage.

---

# 27. ACCOMMODATION

Support:

* hotel;
* hostel;
* resort;
* apartment;
* house;
* villa;
* cabin;
* guesthouse;
* homestay;
* campsite;
* tent;
* campervan;
* mountain hut;
* boat;
* custom.

Store:

* provider;
* location;
* check-in;
* check-out;
* room type;
* occupancy;
* beds;
* bathroom;
* accessibility;
* meals;
* cancellation;
* price;
* booking status.

---

# 28. ROOM ASSIGNMENT

Implement group room allocation.

Support:

* room;
* bed;
* tent;
* cabin;
* roommate preference;
* household grouping;
* couple/family grouping.

Never expose private room allocation publicly.

---

# 29. SERVICE MARKETPLACE

Design provider-independent modules for:

Accommodation
Transportation
Mobility
Restaurants
Activities
Tickets
Guides
Translation
Photography
Equipment
Insurance
Connectivity
Luggage
Wellness
Coworking
Shopping

Every service should attach naturally to the Journey Graph.

Do NOT create disconnected marketplace silos.

Example:

Rome Day 6
→ Add accommodation
→ Search
→ Book
→ automatically attach booking to Day 6.

---

# 30. BOOKING FULFILLMENT MODES

Support:

INTERNAL
INTEGRATED_PROVIDER
EXTERNAL_REFERENCE

This lets the platform operate even before all providers are integrated.

---

# 31. PROVIDER ADAPTER ARCHITECTURE

Define contracts such as:

AccommodationProvider
TransportProvider
MobilityProvider
ActivityProvider
TicketProvider
RestaurantProvider
InsuranceProvider
PaymentProvider
IdentityVerificationProvider
GeocodingProvider
RouteProvider
WeatherProvider
TranslationProvider
NotificationProvider

Domain services must never depend directly on one third-party vendor.

---

# 32. PARTICIPATION AND JOIN REQUESTS

Journey participation workflow:

Discover
→ View
→ Apply
→ Eligibility check
→ Application questions
→ Organizer review
→ Accept / Reject / Waitlist
→ Deposit/payment if required
→ Confirmed
→ Preparation
→ Check-in
→ Participate
→ Complete
→ Review

Store state history.

---

# 33. COMMITMENT STATES

Differentiate:

SAVED
INTERESTED
APPLIED
PRE_APPROVED
WAITLISTED
PAYMENT_REQUIRED
DEPOSIT_PAID
CONFIRMED
CHECKED_IN
COMPLETED
CANCELLED
NO_SHOW

Do not count "Interested" users as confirmed participants.

---

# 34. CUSTOM APPLICATION FORMS

Organizers can add structured questions.

Supported field types:

* short text;
* long text;
* number;
* date;
* select;
* multi-select;
* boolean;
* consent;
* structured requirement.

Prevent abusive requests for sensitive information.

Apply privacy classifications.

Support conditional questions.

---

# 35. TRAVEL COMPANION MATCHING

Match using non-sensitive relevant preferences such as:

* dates;
* destination;
* language;
* budget;
* activities;
* travel pace;
* accommodation preference;
* transport preference;
* interests;
* adventure intensity;
* sleep schedule;
* social preference;
* group size;
* food preferences where appropriate.

Do not build discriminatory or sensitive automated profiling.

---

# 36. EXPLAINABLE MATCHING

Do not show an unexplained score alone.

Example:

87% compatibility

Reasons:

* similar hiking interests;
* matching dates;
* compatible budget;
* same preferred pace;
* shared language;
* different nightlife preference.

Allow users to control recommendation preferences.

---

# 37. USER ACCOUNTS

Support:

* email;
* phone verification;
* password;
* passkeys/WebAuthn;
* MFA;
* OAuth/social login;
* password recovery;
* active session management;
* device management;
* login history;
* suspicious-login notifications.

Use secure HttpOnly cookies for browser sessions where appropriate.

Implement CSRF protection.

Rotate sensitive sessions after authentication/security changes.

---

# 38. USER PROFILE

Separate:

Public Profile
Travel Preferences
Private Personal Data
Verification Data
Safety Data
Billing Data

Never use one giant user table.

---

# 39. PROFILE VISIBILITY

Provide field-level visibility policies.

Examples:

PUBLIC
MEMBERS
APPLICANTS
ACCEPTED_PARTICIPANTS
TRIP_STAFF
SAFETY_STAFF
PLATFORM
PRIVATE

The backend must enforce these.

Never rely solely on frontend hiding.

---

# 40. IDENTITY VERIFICATION

Support levels such as:

EMAIL_VERIFIED
PHONE_VERIFIED
ID_VERIFIED
SELFIE_VERIFIED
PROFESSIONAL_VERIFIED
BUSINESS_VERIFIED

Integrate through provider abstraction.

The public UI receives verification status, not government document content.

---

# 41. PROFESSIONAL ORGANIZERS

Professional profiles require functionality including:

* business profile;
* registration data;
* tax information;
* licenses;
* insurance;
* team accounts;
* payout account;
* verified representative;
* business policies;
* public business information;
* support contacts.

Implement credential expiration monitoring.

---

# 42. ORGANIZATIONS

Support organization accounts.

Roles:

Owner
Administrator
Tour Manager
Guide
Finance
Support
Staff

Implement tenancy boundaries.

Prepare for eventual white-label capabilities.

---

# 43. JOURNEY STAFF ROLES

A journey may have:

Owner
Co-organizer
Guide
Assistant Guide
Driver
Safety Officer
Medical/Safety Contact
Finance Manager
Accommodation Coordinator
Transport Coordinator
Meal Coordinator
Photographer
Participant

Implement granular permissions.

Example:

Meal coordinator can see meal choices but not identity documents.

Finance manager can see payment data but not health information.

---

# 44. SOCIAL MEETUPS

Support local travel meetups.

Categories:

* coffee;
* dinner;
* sightseeing;
* hiking;
* photography;
* shopping;
* nightlife;
* sport;
* gaming;
* language exchange;
* coworking;
* business networking;
* conference;
* mentoring;
* music;
* custom.

---

# 45. ROMANTIC MEETUPS

Romantic mode must be explicit opt-in.

Never make dating behavior the default social behavior.

Require adult accounts.

Apply stronger:

* verification;
* reporting;
* blocking;
* location privacy;
* consent;
* spam detection;
* harassment controls;
* safety prompts.

Do not recommend minors.

---

# 46. MINOR SAFETY

Primary social accounts should be adult accounts unless product/legal review explicitly supports another model.

Minors traveling with families should generally be represented as protected dependent travelers associated with verified guardians.

Do not expose minors to:

* public romantic discovery;
* unrestricted adult messaging;
* precise public location;
* independent commercial commitments.

Build child-safety controls into domain rules, not merely Terms of Service.

---

# 47. COMMUNITIES AND CLUBS

Support communities such as:

* hiking clubs;
* motorcycle travelers;
* photographers;
* digital nomads;
* university groups;
* family travel communities.

Features:

* public/private membership;
* membership approval;
* community moderators;
* discussions;
* events;
* recurring tours;
* invitations.

---

# 48. MESSAGING

Implement:

Applicant ↔ Organizer chat before acceptance.

Private journey rooms after acceptance.

Channels may include:

General
Announcements
Questions
Accommodation
Transportation
Food
Equipment
Expenses

Support:

* text;
* files;
* safe images;
* reactions;
* replies;
* mentions;
* pinned messages;
* itinerary references;
* system messages;
* polls.

Use secure attachment validation.

---

# 49. MESSAGE SAFETY

Implement:

* rate limiting;
* spam controls;
* malicious-link controls;
* attachment scanning;
* abuse reporting;
* block controls;
* suspicious solicitation signals.

Protect message privacy.

Do not indiscriminately expose conversations to administrators.

Administrative access must be purpose-limited, permission-controlled and audited.

---

# 50. COMMUNICATION PRIORITY

Messages can have priorities:

NORMAL
ANNOUNCEMENT
IMPORTANT
EMERGENCY

Important messages may require acknowledgment.

Example:

"Departure changed to Gate B17 at 06:00."

Show:

17 / 20 acknowledged.

---

# 51. AUTOMATIC TRANSLATION

Support optional translated chat and announcements.

Preserve original text.

Clearly identify machine-translated content.

Never silently modify safety-critical source text.

---

# 52. PRE-TRIP MEETINGS

Allow:

* scheduled video meeting links;
* agenda;
* required/optional attendance;
* reminders;
* attendance status.

Do not build a custom video stack initially unless justified.

Integrate with provider abstraction or WebRTC solution.

---

# 53. GROUP GOVERNANCE

Support decisions through:

Organizer Decision
Advisory Poll
Majority Vote
Unanimous Vote
Ranked Choice

Use cases:

* restaurant;
* accommodation;
* activity;
* route changes.

---

# 54. CHANGE PROPOSALS

Participants may propose itinerary changes.

Proposal contains:

* description;
* affected itinerary elements;
* estimated financial effect;
* timing effect;
* discussion;
* vote;
* organizer decision.

Canonical itinerary changes only after approval.

---

# 55. VERSIONED ITINERARIES

Never silently overwrite important itinerary information.

Maintain versions.

Record:

* author;
* timestamp;
* previous value;
* new value;
* reason;
* affected participants;
* notification status.

Critical changes may require participant acknowledgment.

---

# 56. CHANGE IMPACT ANALYSIS

If:

Flight delayed by two hours

calculate potentially affected:

* transfer;
* hotel check-in;
* dinner;
* activity;
* meeting;
* connecting transport.

Display impact before applying changes.

---

# 57. CONTINGENCY PLANS

Activities can define:

Primary Plan
Alternative Plan
Weather Plan
Emergency Exit
Cancellation Trigger

Example:

Mountain route A

Alternative route B if wind > threshold.

Never make weather thresholds authoritative unless configured from appropriate professional sources.

---

# 58. LIVE TRIP MODE

When a journey becomes ACTIVE, provide a simplified operational UI.

Primary screen should answer:

"What happens next?"

Display:

* next activity;
* departure countdown;
* meeting point;
* navigation;
* weather;
* required equipment;
* announcements;
* emergency button;
* check-in state.

---

# 59. ATTENDANCE

Allow event/journey check-ins using:

* organizer confirmation;
* QR;
* optional geofence;
* future NFC capability.

Do not force continuous tracking.

Example:

Bus departure:

23 / 25 checked in.

---

# 60. PARTICIPANT READINESS

Calculate readiness privately.

Example:

84% ready.

Items:

* payment;
* document confirmation;
* insurance;
* equipment;
* meal choice;
* briefing;
* waiver;
* meeting attendance.

Organizer should see operational readiness without unnecessary sensitive details.

---

# 61. ORGANIZER COMMAND CENTER

Provide:

* applications;
* participant roster;
* waitlist;
* payments;
* readiness;
* unanswered forms;
* equipment;
* meals;
* rooms;
* transport;
* check-in;
* announcements;
* safety;
* incidents;
* itinerary changes.

Make the organizer dashboard highly actionable.

---

# 62. SAFETY CENTER

Every journey should support a Safety Center containing appropriate information such as:

* organizer emergency contact;
* local emergency services;
* embassy/consulate information where relevant;
* trusted contact;
* hospitals/clinics;
* emergency meeting point;
* activity safety information;
* offline information.

Use authoritative data where available.

---

# 63. TRUSTED CONTACT

Users can designate trusted contacts.

Allow user-controlled sharing of:

* journey summary;
* itinerary;
* emergency contact;
* optional check-ins;
* optional location.

Trusted contacts do not automatically become platform participants.

---

# 64. SAFETY CHECK-INS

For high-risk activities:

Activity begins 08:00.

Expected completion 17:00.

At expected return time request:

"Are you safe?"

Configurable escalation may notify:

1. participant;
2. organizer;
3. trusted contact.

Do not automatically contact emergency authorities unless a legally/technically supported workflow explicitly exists.

---

# 65. SOS

Provide an SOS screen.

It can:

* show local emergency number;
* show emergency information;
* notify organizer;
* notify trusted contacts;
* optionally share authorized last-known location.

Clearly distinguish:

"Contact emergency services"

from:

"Notify platform contacts."

---

# 66. RISK MODEL

Activities can have structured risk dimensions:

* weather;
* terrain;
* altitude;
* isolation;
* water;
* wildlife;
* traffic;
* political/security environment;
* medical access;
* communication availability.

Overall levels:

LOW
MODERATE
HIGH
EXTREME

High-risk trips require more publication information.

---

# 67. INCIDENT MANAGEMENT

Implement structured incident cases.

Fields include:

* journey;
* time;
* location;
* severity;
* affected people;
* incident type;
* narrative;
* actions;
* external emergency involvement;
* attachments;
* follow-up;
* restricted access.

Audit all access.

---

# 68. NEAR-MISS REPORTING

Professional organizers may record near misses.

Use them for private operational improvement.

Do not expose participants unnecessarily.

---

# 69. SAFETY BRIEFINGS

High-risk activities can require:

* document;
* video;
* briefing;
* quiz/check;
* acknowledgment.

Record completion.

---

# 70. WEATHER

Integrate weather through provider abstraction.

Support:

* current conditions;
* forecast;
* precipitation;
* temperature;
* wind;
* UV;
* sunrise;
* sunset.

Map weather to itinerary locations.

Do not treat third-party forecasts as guaranteed.

---

# 71. TRAVEL ADVISORIES

Design provider integration for:

* severe weather;
* border disruption;
* natural disasters;
* transportation disruption;
* security advisories;
* strikes.

Attach advisories to impacted itinerary elements.

---

# 72. OFFLINE TRIP PACK

Accepted participants can prepare an offline package containing authorized information such as:

* itinerary;
* locations;
* maps;
* meeting points;
* booking references;
* tickets;
* packing list;
* organizer contact;
* emergency information.

Encrypt sensitive offline data appropriately.

---

# 73. BUDGET

Journey budget categories:

* flights;
* train;
* buses;
* accommodation;
* food;
* tickets;
* vehicles;
* fuel;
* tolls;
* guide;
* insurance;
* equipment;
* shopping;
* miscellaneous.

Support:

Estimated
Committed
Actual

---

# 74. MONEY MODEL

Never use floating-point values for money.

Store:

integer minor amount
+
ISO currency code

Store exchange rates with:

* provider;
* timestamp;
* base currency;
* quote currency.

Never silently recalculate historical transactions with current exchange rates.

---

# 75. EXPENSE SPLITTING

Support:

* equal;
* exact;
* percentage;
* weighted shares;
* households/couples;
* custom allocation.

Track:

payer
participants
amount
currency
category
settlements

Provide clear balances.

---

# 76. COMMERCIAL PRICING

Commercial journeys can contain:

* base price;
* mandatory fees;
* optional extras;
* deposit;
* installment plan;
* discount;
* coupon;
* tax;
* service fee;
* refundable deposit.

Always show transparent totals.

---

# 77. PAYMENTS

Implement:

* payment intent;
* deposit;
* balance payment;
* refunds;
* partial refunds;
* payout;
* disputes;
* webhooks;
* reconciliation.

All webhook processing must be:

* signature verified;
* idempotent;
* transactional;
* replay safe.

Use idempotency keys for payment creation.

---

# 78. MARKETPLACE LEDGER

Do not calculate marketplace money from arbitrary mutable rows.

Implement an auditable ledger for:

* participant charge;
* organizer gross;
* platform fee;
* tax;
* refund;
* adjustment;
* payout;
* dispute.

Ledger records should be immutable through normal application operations.

Corrections use compensating entries.

---

# 79. CANCELLATION

Policies can include:

FREE
PARTIAL
NON_REFUNDABLE
CUSTOM

Events:

Participant cancellation
Organizer cancellation
Weather cancellation
Insufficient participants
Transport cancellation
Force majeure

Store the policy version accepted at booking.

---

# 80. PACKAGE VS STANDALONE

Architect for regional consumer/travel laws.

Commercial offerings must be classifiable as appropriate into concepts such as:

* standalone service;
* tour/experience;
* package;
* other jurisdiction-specific categories.

Do not hard-code European law globally.

Create jurisdiction/policy modules.

Important legal decisions must be reviewable by legal specialists.

---

# 81. TRADER TRACEABILITY

For regions requiring marketplace trader verification, support:

* trader identity;
* contact information;
* business registration;
* payment account;
* supporting documents;
* verification status;
* public disclosures where legally required.

Protect non-public identity documents.

---

# 82. TRAVEL DOCUMENT READINESS

Provide informational requirement checks for:

* passport;
* visa;
* transit visa;
* insurance;
* permits;
* entry requirements.

Use authoritative/provider sources.

Never present stale static visa information as guaranteed legal advice.

---

# 83. PER-PARTICIPANT REQUIREMENTS

Requirements vary by traveler.

Two participants on the same itinerary may require different documentation.

Calculate privately based on relevant travel/document attributes.

Minimize stored identity data.

---

# 84. DOCUMENT VAULT

Private document categories may include:

* ticket;
* insurance;
* visa;
* permit;
* certificate;
* reservation;
* emergency document.

Use:

* encrypted storage;
* private object storage;
* signed short-lived downloads;
* malware scanning;
* access logs;
* retention rules.

Prefer verifying a fact rather than sharing the entire document.

Example:

"Diving certification verified"

instead of exposing a certificate image to every organizer.

---

# 85. ACCESSIBILITY

Target WCAG 2.2 AA or later applicable stable guidance.

Implement:

* semantic HTML;
* keyboard accessibility;
* focus management;
* high contrast;
* minimum target sizes;
* accessible authentication;
* reduced motion;
* screen reader semantics;
* accessible forms;
* accessible errors;
* accessible dialogs;
* accessible map alternatives.

---

# 86. TRAVEL ACCESSIBILITY DATA

Each:

* transportation leg;
* accommodation;
* activity;
* meeting point;
* venue

can independently describe accessibility.

Possible metadata:

* wheelchair accessible;
* step-free;
* lift;
* accessible toilet;
* accessible transportation;
* assistance animal policy;
* hearing support;
* visual support;
* sign-language support;
* quiet area;
* crowd level;
* sensory considerations.

Never automatically infer that a disabled user cannot participate.

Present factual information and user-controlled matching.

---

# 87. INTERNATIONALIZATION

Architect all user-visible text for localization.

Do not hard-code English strings inside components.

Support:

* locale catalogs;
* pluralization;
* RTL;
* LTR;
* locale numbers;
* dates;
* calendars where required;
* currencies;
* units;
* timezone localization.

Use IANA timezone identifiers.

Store instants consistently.

Retain original local timezone context for travel events.

---

# 88. UNIT SYSTEMS

Store canonical values.

Display configurable:

* kilometers/miles;
* Celsius/Fahrenheit;
* meters/feet;
* kilograms/pounds.

Do not duplicate converted values unnecessarily.

---

# 89. SEARCH

Search must support:

* destination;
* origin;
* dates;
* flexible dates;
* map bounds;
* radius;
* duration;
* budget;
* capacity;
* activity;
* difficulty;
* language;
* transport;
* accommodation;
* accessibility;
* risk;
* verified organizer;
* professional/social;
* instant join;
* paid/free.

---

# 90. MAP DISCOVERY

Provide map-based search.

Requirements:

* clustering;
* viewport search;
* distance;
* approximate privacy-aware pins;
* filters;
* mobile interaction;
* accessible alternative list.

Do not expose hidden exact coordinates in API payloads.

---

# 91. "NEAR ME"

With explicit location permission users can discover:

* nearby journeys;
* activities;
* meetups;
* experiences.

Permission denial must not break the application.

Never request precise background location unnecessarily.

---

# 92. SAVED SEARCHES

Allow saved criteria.

Notify users when matching opportunities become available.

Respect notification preferences.

---

# 93. RECOMMENDATIONS

Build a RecommendationProvider architecture.

Initial recommendations can use explainable heuristics.

Later machine learning may be introduced.

Inputs may include:

* explicit interests;
* saved journeys;
* previous participation;
* search preferences.

Avoid sensitive profiling.

---

# 94. INTENT SEARCH

Support natural-language queries such as:

"I have five days in October, start from Ankara, want hiking, budget under €700, and flights under four hours."

Parse into structured filters.

Always let users inspect/edit inferred constraints.

---

# 95. AI TOUR CREATOR

Natural-language tour creation is a first-class feature.

Pipeline:

User description
→ structured extraction
→ confidence scores
→ unresolved questions
→ Journey Graph draft
→ user confirmation
→ validation
→ save.

Never hallucinate a booking or safety fact as confirmed.

Mark generated suggestions clearly.

---

# 96. AI ASSISTANT FOR ORGANIZERS

Can assist with:

* draft itinerary;
* packing;
* activity descriptions;
* consistency checks;
* missing information;
* cost categories;
* suggested alternative route;
* participant FAQ;
* translation.

AI must not independently approve high-risk safety.

---

# 97. AI ASSISTANT FOR PARTICIPANTS

Can answer authorized questions such as:

* what should I pack?
* what is happening tomorrow?
* which activities are difficult?
* which meals did I choose?
* where is the accepted meeting point?

AI retrieval must enforce the same authorization rules as normal APIs.

Never place unauthorized private information into LLM context.

---

# 98. AI PRIVACY

Before sending data to external AI providers:

* classify data;
* redact unnecessary PII;
* exclude protected health data by default;
* exclude identity documents;
* use provider privacy controls;
* log usage metadata without logging sensitive prompts unnecessarily.

Create an AI gateway/service.

No frontend component should directly call external AI providers with private application data.

---

# 99. AI SAFETY

Prevent AI from:

* inventing legal entry requirements;
* certifying dangerous activities;
* disclosing private participant data;
* making discriminatory eligibility decisions;
* silently modifying paid bookings;
* sending messages impersonating users without authorization.

Require human confirmation for material operations.

For HIGH or EXTREME activities, AI-generated equipment, risk, and safety guidance remains DRAFT and cannot be published or represented as sufficient, certified, or guaranteed until explicitly approved by a human holding the journey's configured safety role and required qualification. Persist the approver, qualification basis, content version, timestamp, and decision.

---

# 100. BUSINESS MEETUPS

Support travel-context business meetings such as:

* networking;
* startup;
* investor;
* coworking;
* conference;
* recruitment;
* mentoring;
* professional community.

---

# 101. RESTAURANTS

Itinerary-integrated restaurant services can support:

* discovery;
* reservation;
* group size;
* time;
* dietary information;
* menu;
* estimated cost;
* group voting.

---

# 102. SOUVENIRS AND SHOPPING

Provide optional trip shopping lists.

Possible categories:

* handicraft;
* souvenir;
* market;
* local specialty;
* food;
* art;
* fashion.

Support:

* location;
* estimated price;
* purchased state;
* luggage note.

Do not create financial investment recommendations from shopping data.

---

# 103. ENTERTAINMENT

Support itinerary-connected reservations for:

* cinema;
* theater;
* concert;
* festival;
* museum;
* exhibition;
* amusement park.

---

# 104. SPORTS

Support spectator and participant experiences for sports such as:

* football;
* basketball;
* volleyball;
* hockey;
* baseball;
* cricket;
* rugby;
* tennis;
* golf;
* handball;
* motorsport;
* athletics;
* other.

---

# 105. VEHICLE RENTAL

Support:

* car;
* motorcycle;
* bicycle;
* e-bike;
* scooter;
* campervan;
* custom mobility.

Attach rentals directly to route segments.

---

# 106. LOCAL EXPERT MARKETPLACE

Potential professional/local roles:

* licensed guide;
* volunteer local;
* translator;
* photographer;
* historian;
* food expert;
* outdoor guide.

Clearly differentiate licensed professionals from ordinary users.

---

# 107. CALENDAR

Unified user calendar includes:

* journeys;
* transport;
* hotel;
* activities;
* meetups;
* restaurant;
* tickets;
* required meetings.

Support ICS export.

Prepare adapters for external calendar providers.

---

# 108. NOTIFICATIONS

Notification channels:

* in-app;
* email;
* push;
* optional SMS.

Events include:

* join request;
* acceptance;
* rejection;
* waitlist;
* payment;
* itinerary change;
* departure reminder;
* critical announcement;
* weather warning;
* safety check;
* review reminder.

Create user-level notification preferences.

Critical safety communications need separate policy review.

---

# 109. REVIEWS

Separate review dimensions.

Organizer:

* communication;
* accuracy;
* planning;
* punctuality;
* safety preparation;
* professionalism;
* value.

Participant:

* reliability;
* communication;
* punctuality;
* respect for rules.

Only verified participation generates verified reviews.

---

# 110. DOUBLE-BLIND REVIEWS

Where appropriate:

Organizer and participant submit independently.

Reveal when:

* both submit;
 or
* review period expires.

Implement moderation/reporting.

---

# 111. REPUTATION

Calculate multiple signals.

Do not reduce trust to one opaque star rating.

Possible signals:

* completed trips;
* verified trips;
* organizer experience;
* cancellation behavior;
* no-shows;
* response rate;
* review quality;
* verification.

Never present an algorithmic trust score as a guarantee of personal safety.

---

# 112. BLOCKING

Blocking must prevent appropriate interactions including:

* messaging;
* invitations;
* applications;
* social discovery;
* meetup requests.

Do not reveal unnecessary information about who blocked whom.

---

# 113. REPORTING

Report categories:

* fake profile;
* harassment;
* discrimination;
* scam;
* dangerous organizer;
* unsafe behavior;
* inaccurate listing;
* illegal content/activity;
* spam;
* suspicious payment request;
* impersonation;
* privacy violation.

---

# 114. MODERATION CASE MANAGEMENT

Create case objects.

Include:

* reporter;
* subject;
* category;
* severity;
* evidence;
* assigned moderator;
* timeline;
* actions;
* appeal;
* resolution.

Restrict access.

Audit moderator actions.

---

# 115. MODERATION APPEALS

Users should be able to appeal relevant platform enforcement decisions.

Preserve:

* decision;
* policy;
* reason code;
* evidence;
* appeal;
* reviewer;
* outcome.

---

# 116. ADMIN CONTROL CENTER

Admin application includes modules for:

Users
Organizations
Journeys
Activities
Verification
Professionals
Payments
Payouts
Refunds
Disputes
Safety
Incidents
Reports
Moderation
Support
Providers
Content
Taxonomies
Locations
Policies
Feature Flags
Analytics
Audit
System Health

Do not use one gigantic admin page.

---

# 117. ADMIN SECURITY

Admin access requires stronger protection.

Require:

* MFA/passkey;
* short session policy;
* reauthentication for sensitive actions;
* least privilege;
* IP/device signals where useful;
* audit logs.

Super Admin should be rare.

---

# 118. PRIVACY ENGINE

Implement privacy as a platform subsystem.

Features:

* consent records;
* purpose records;
* privacy settings;
* retention schedules;
* access requests;
* export;
* correction;
* deletion/anonymization;
* processing restriction where applicable;
* communication preferences.

Do not assume one jurisdiction applies everywhere.

---

# 119. DATA RETENTION

Every sensitive data class should have a retention policy.

Examples:

* verification documents;
* safety information;
* deleted chat;
* transaction records;
* incident evidence;
* logs.

Retention must account for legal requirements and data minimization.

---

# 120. DATA DELETION

Implement account deletion workflows.

Differentiate:

* deletable data;
* anonymizable data;
* legally retained financial records;
* security/fraud evidence requiring lawful retention.

Never falsely promise immediate deletion of data that legally must be retained.

---

# 121. DATA EXPORT

Provide machine-readable user exports.

Do not expose data belonging to other users through exports.

---

# 122. SECURITY BASELINE

Target OWASP ASVS 5.0 or later applicable stable version.

Perform structured threat modeling.

At minimum defend against:

* XSS;
* SQL injection;
* CSRF;
* SSRF;
* IDOR/BOLA;
* broken access control;
* mass assignment;
* command injection;
* path traversal;
* insecure deserialization;
* open redirects;
* authentication attacks;
* session fixation;
* brute force;
* credential stuffing;
* file upload attacks;
* webhook forgery;
* API replay;
* race conditions;
* privilege escalation;
* cache poisoning;
* secret leakage;
* log injection.

---

# 123. AUTHORIZATION

Use policies/authorization services.

Every request accessing another user's data must be authorized server-side.

Test horizontal and vertical privilege escalation.

Use scoped permissions.

Do not rely on IDs being difficult to guess.

---

# 124. RATE LIMITING

Use contextual rate limits for:

* login;
* registration;
* password reset;
* verification;
* messaging;
* applications;
* search;
* uploads;
* AI;
* payment actions;
* API tokens.

Use distributed rate limiting through Redis where appropriate.

---

# 125. FILE SECURITY

Validate uploads using:

* file signatures;
* MIME validation;
* extension validation;
* size;
* dimensions where relevant;
* antivirus/malware scanning;
* image reprocessing where appropriate.

Do not execute user files.

Keep sensitive files private.

---

# 126. ENCRYPTION

Use TLS everywhere.

Use encryption at rest through infrastructure.

Additionally use application-level encryption for selected highly sensitive fields.

Use a cloud KMS or appropriate secrets/key-management architecture.

Never store encryption keys alongside encrypted database values in the same uncontrolled configuration.

---

# 127. LOGGING

Never log:

* passwords;
* MFA secrets;
* payment credentials;
* raw identity documents;
* health details;
* private document contents;
* session tokens;
* API secrets.

Use structured logs.

Add correlation/trace IDs.

---

# 128. AUDIT LOG

Create tamper-resistant audit records for high-impact operations.

Examples:

* permissions;
* itinerary changes;
* payment changes;
* refund;
* payout;
* eligibility;
* privacy access;
* document access;
* moderator actions;
* admin changes.

Audit log access itself must be controlled.

---

# 129. SECURITY HEADERS

Implement appropriate:

* CSP;
* HSTS;
* Referrer-Policy;
* Permissions-Policy;
* frame protections;
* secure cookies;
* modern cross-origin controls.

Use nonce/hash-based CSP where appropriate.

Avoid unsafe-inline dependencies.

---

# 130. CONTENT SECURITY

Sanitize or structurally render user-generated content.

Do not directly inject HTML.

Treat Markdown as untrusted input.

Handle URLs carefully.

---

# 131. PAYMENT SECURITY

Design to minimize PCI scope.

Use provider-hosted/tokenized payment interfaces.

Do not store:

* PAN;
* CVV;
* track data;
* sensitive authentication data.

Follow PCI DSS 4.0.1 or current applicable version.

---

# 132. SOFTWARE SUPPLY CHAIN

Implement:

* dependency lockfiles;
* automated vulnerability scanning;
* dependency update automation;
* secret scanning;
* SAST;
* dependency review;
* SBOM;
* license inventory.

Do not automatically accept incompatible package licenses.

---

# 133. LICENSE POLICY

Treat application source as proprietary unless project ownership explicitly selects an open-source license.

Document third-party dependencies and licenses.

Avoid copyleft dependencies that conflict with distribution strategy unless explicitly approved.

---

# 134. DESIGN SYSTEM

Build a documented reusable design system.

Define:

* typography;
* spacing;
* grid;
* elevations;
* radius;
* motion;
* iconography;
* semantic colors;
* states;
* responsive behavior.

Use tokens.

Do not scatter arbitrary colors through components.

---

# 135. VISUAL DESIGN

The platform must look like a premium international travel product.

Requirements:

* modern;
* trustworthy;
* visually rich without clutter;
* professional;
* strong map/timeline presentation;
* excellent photography treatment;
* clear hierarchy;
* suitable for consumer and professional users.

Do not produce a generic admin-template appearance.

---

# 136. COLOR PSYCHOLOGY

Use color deliberately.

Travel/exploration:
energetic but controlled accents.

Trust:
stable neutral/blue tendencies where appropriate.

Safety warnings:
semantic amber/red.

Success:
accessible green semantics.

Never communicate important information through color alone.

Test contrast.

---

# 137. MOBILE-FIRST UX

Many users will interact during actual travel.

Prioritize:

* one-handed interactions;
* large touch targets;
* offline resilience;
* poor-network behavior;
* fast loading;
* location/map ergonomics;
* emergency usability;
* camera/file upload;
* live itinerary.

---

# 138. RESPONSIVE DESKTOP UX

Desktop organizer experience should exploit larger displays.

Tour Builder may use:

left navigation
+
central editor
+
map/preview

Do not simply enlarge mobile cards.

---

# 139. TOUR PUBLIC PAGE

Design a beautiful public journey page containing appropriate:

* cover;
* organizer;
* verification;
* summary;
* map;
* route;
* dates;
* participant capacity;
* price;
* activities;
* itinerary;
* transport;
* accommodation;
* meals;
* equipment;
* eligibility;
* difficulty;
* accessibility;
* inclusions;
* exclusions;
* cancellation;
* safety summary;
* reviews;
* join CTA.

Do not expose private details.

---

# 140. PUBLIC SEO

Public journeys should have:

* semantic metadata;
* canonical URLs;
* Open Graph;
* Twitter/X metadata;
* structured data where applicable;
* sitemap;
* robots controls;
* localized URLs;
* pagination;
* crawlable server-rendered public content.

Private trips must never become indexable.

---

# 141. PERFORMANCE

Define budgets.

Optimize:

* Core Web Vitals;
* image sizes;
* map loading;
* JavaScript;
* queries;
* N+1 queries;
* cache;
* API payloads.

Use image optimization.

Lazy-load non-critical map functionality.

---

# 142. DATABASE PRACTICES

Use:

* ULID/UUID where beneficial;
* created_at/updated_at;
* explicit status enums or constrained values;
* unique constraints;
* foreign keys;
* delete policies;
* indexes.

Use soft deletion only when a real business requirement exists.

Do not apply soft delete universally.

---

# 143. GEOSPATIAL DATABASE

Use PostGIS for:

* point;
* route;
* bounds;
* radius search;
* distance;
* nearby search.

Ensure proper SRID.

Use GIST indexes.

Do not perform large-scale distance calculations in PHP when PostgreSQL can do them correctly.

---

# 144. JSONB

Use JSONB only for appropriately flexible structures, such as provider metadata or extensible activity schemas.

Critical searchable business fields should remain properly modeled.

---

# 145. DATABASE CONCURRENCY

Protect capacity and inventory against race conditions.

Example:

Only one journey slot remains and two join/payment confirmations occur simultaneously.

Use:

* transactions;
* atomic conditional updates;
* unique constraints;
* row locks where appropriate;
* optimistic concurrency where appropriate.

Never rely on "count then insert" without concurrency protection.

---

# 146. IDEMPOTENCY

Idempotency is mandatory for:

* payments;
* booking creation;
* refund;
* provider callbacks;
* webhooks;
* critical background jobs.

---

# 147. API DESIGN

Use versioned APIs.

Example:

/api/v1/

Document using current OpenAPI specification.

Use consistent:

* errors;
* pagination;
* filters;
* sorting;
* field validation;
* status codes;
* correlation IDs.

---

# 148. API ERROR FORMAT

Use a consistent problem format.

Include:

* machine code;
* user-safe message;
* field validation;
* correlation ID.

Never expose stack traces in production.

---

# 149. API SECURITY

Protect APIs using:

* authentication;
* authorization;
* scopes;
* rate limiting;
* replay protection where needed;
* request size limits;
* validation.

Third-party API tokens need:

* scopes;
* expiry;
* rotation;
* revocation.

---

# 150. WEBHOOKS

Provide signed outgoing webhooks.

Support:

* retries;
* exponential backoff;
* event ID;
* timestamp;
* signing;
* delivery history;
* replay.

---

# 151. REALTIME

Realtime is appropriate for:

* chat;
* presence where needed;
* announcements;
* live application status;
* trip updates.

Do not put durable domain state only in WebSockets.

Database remains authoritative.

---

# 152. BACKGROUND JOBS

Queues handle:

* email;
* push;
* search indexing;
* media processing;
* document scanning;
* provider synchronization;
* AI extraction;
* analytics;
* itinerary impact calculations;
* notifications.

Jobs must be:

* retryable;
* idempotent;
* observable.

---

# 153. SCHEDULER

Scheduled tasks include:

* upcoming reminders;
* expired credentials;
* stale drafts;
* retained data deletion;
* abandoned payments;
* external provider synchronization;
* readiness reminders.

---

# 154. CACHING

Cache read-heavy public information carefully.

Never cache private content under public keys.

Avoid authorization leaks through shared caching.

Define invalidation explicitly.

---

# 155. OBSERVABILITY

Implement:

* structured logs;
* metrics;
* traces;
* error monitoring;
* queue dashboards;
* job failure alerts;
* uptime checks.

Monitor:

* HTTP latency;
* DB latency;
* cache;
* queues;
* websocket connections;
* provider failures;
* payment webhooks;
* auth failures.

---

# 156. SLO/SLA PREPARATION

Define service-level indicators.

Examples:

* availability;
* API response latency;
* booking success rate;
* notification delivery;
* queue delay.

---

# 157. HEALTH CHECKS

Provide:

* liveness;
* readiness;
* database;
* Redis;
* storage;
* queue;
* critical providers.

Do not leak internal topology publicly.

---

# 158. BACKUPS

Implement documented backup strategy for:

* PostgreSQL;
* object storage metadata;
* application configuration.

Encrypt backups.

Test restoration.

A backup that has never been restored is not considered verified.

---

# 159. DISASTER RECOVERY

Document:

RPO
RTO
failure scenarios
restore procedures
key recovery
provider outage handling.

---

# 160. PROVIDER FAILURE

Third-party failures must degrade gracefully.

Example:

Weather provider unavailable.

The tour must remain accessible.

Display:

"Weather information temporarily unavailable"

rather than crashing the page.

Use circuit breakers/backoff where appropriate.

---

# 161. ANALYTICS

Track privacy-conscious events.

Product funnel:

view
→ save
→ apply
→ accept
→ pay
→ participate
→ review.

Organizer funnel:

create
→ complete
→ publish
→ applications
→ confirmations
→ attendance.

Do not put sensitive health/identity/location content in general analytics events.

---

# 162. PROFESSIONAL ANALYTICS

Professional organizers can see:

* views;
* saves;
* conversion;
* response time;
* applications;
* confirmed participants;
* cancellation;
* revenue;
* repeat participants;
* reviews.

---

# 163. ADMIN ANALYTICS

Admin analytics should cover:

* growth;
* active journeys;
* locations;
* marketplace volume;
* safety reports;
* moderation;
* fraud;
* payment failures;
* provider reliability.

Avoid dangerous leaderboard incentives around safety.

---

# 164. SUSTAINABILITY

Optionally calculate estimated travel footprint through provider abstraction.

Allow comparisons of:

* air;
* rail;
* bus;
* driving

where reliable data exists.

Clearly label estimates.

---

# 165. ENVIRONMENTAL RULES

Outdoor templates may include:

* protected area rules;
* waste handling;
* fire restrictions;
* leave-no-trace guidance;
* group size limitations.

Use authoritative local guidance where available.

---

# 166. POST-TRIP MEMORIES

After completion provide:

Trip Album
Trip Journal
Journey Map
Statistics
Highlights

Privacy options:

PRIVATE
PARTICIPANTS
FRIENDS
PUBLIC

---

# 167. MEDIA

Participants can upload authorized:

* photos;
* video;
* notes.

Respect:

* ownership;
* removal;
* consent;
* reporting.

Do not automatically publish participant images publicly.

---

# 168. LOST AND FOUND

Journey-scoped lost-and-found.

Item:

* description;
* image;
* location;
* status;
* claimant.

Only journey participants should normally see relevant information.

---

# 169. REPEAT JOURNEYS

Allow organizers to duplicate completed journeys.

Do not copy:

* old participants;
* old payment records;
* stale booking references;
* private participant data.

Copy reusable itinerary configuration.

---

# 170. TOUR TEMPLATES

Create templates such as:

City
Cultural
Religious
Nature
Hiking
Mountain
Camping
Desert
Beach
Diving
Cycling
Motorcycle
Off-road
Ski
Road Trip
Food
Photography
Family
Festival
Sports
Backpacking

Templates are executable schemas.

Each may define:

* relevant fields;
* required validation;
* suggested equipment;
* risk questions;
* safety requirements.

---

# 171. REGIONAL POLICY ENGINE

Create a configurable regional policy architecture.

Potentially determine:

* minimum age;
* commercial disclosures;
* tax;
* cancellation rights;
* license requirements;
* privacy behavior;
* marketplace seller disclosures.

Do not put jurisdiction-specific logic throughout controllers.

---

# 172. FEATURE FLAGS

Use feature flags for:

* new regions;
* payments;
* romantic meetups;
* AI;
* professional marketplace;
* providers;
* experiments.

Security restrictions must not depend solely on client-side flags.

---

# 173. DATE AND TIME

Use UTC for absolute storage where appropriate.

Preserve location time zones.

Use IANA timezone identifiers.

Avoid ambiguous datetime fields.

Examples should render:

Departure:
14:00 Europe/Rome

User's time:
16:00 Asia/Baku

where useful.

---

# 174. PAGINATION

Use efficient cursor pagination for large/high-change feeds where appropriate.

Use conventional pagination where SEO/indexability requires page URLs.

Do not load thousands of records into browsers.

---

# 175. ACCESS CONTROL MODEL

Combine RBAC with contextual policy checks.

Global roles are insufficient.

Authorization may depend on:

* organization;
* journey membership;
* staff assignment;
* data classification;
* state;
* ownership;
* jurisdiction.

---

# 176. PLATFORM APPLICATION ROLES

Support concepts including:

Guest
Registered Traveler
Verified Traveler
Organizer
Professional Organizer
Organization Owner
Organization Admin
Organization Staff
Guide
Journey Staff
Moderator
Trust & Safety Analyst
Verification Agent
Customer Support Agent
Finance/Dispute Agent
Compliance Administrator
Content Administrator
System Administrator
Super Administrator
API Partner

Define permission matrix.

---

# 177. SUPPORT

Build support ticketing/case capability or a clean adapter.

Cases can attach to:

* account;
* journey;
* booking;
* payment;
* report.

Keep support authorization scoped.

---

# 178. PUBLIC CONTENT MANAGEMENT

Provide manageable content for:

* help;
* safety guidance;
* policies;
* destination guides;
* FAQs;
* onboarding.

Use versioning for legal/policy documents.

---

# 179. CONSENT VERSIONING

Whenever users consent to material terms:

Store:

* policy ID;
* version;
* locale;
* timestamp;
* user;
* IP/device metadata only where lawful/necessary.

If materially changed, request renewed acceptance when appropriate.

---

# 180. WAIVERS

For risk waivers:

* exact document version;
* signer;
* locale;
* timestamp;
* activity;
* acceptance evidence.

Do not retroactively alter previously accepted waiver contents.

---

# 181. PREVIEW AS ROLE

Organizer can preview journey as:

Public Visitor
Applicant
Accepted Participant
Journey Staff

This is important for privacy auditing.

---

# 182. PRIVACY PREVIEW

Provide:

"Who can see this?"

for sensitive configuration.

Show examples of what each audience sees.

---

# 183. EMPTY/LOADING/ERROR STATES

Design every significant interface for:

* empty;
* loading;
* partial;
* error;
* offline;
* permission denied.

Do not leave broken blank panels.

---

# 184. NETWORK RESILIENCE

Travelers frequently have poor internet.

Implement:

* retries;
* offline caching;
* optimistic UI only where safe;
* local drafts;
* sync indicators.

Never optimistically mark financial transactions successful before server confirmation.

---

# 185. PWA

Make the web app installable where appropriate.

Provide:

* manifest;
* service worker strategy;
* offline trip data;
* safe updates.

Design API so native iOS/Android clients can be added later.

---

# 186. TESTING REQUIREMENTS

Testing is mandatory.

Backend:

* unit;
* domain;
* integration;
* API;
* authorization;
* database;
* queue;
* webhook.

Frontend:

* unit;
* component;
* integration;
* E2E.

Infrastructure:

* health;
* deployment smoke tests.

---

# 187. SECURITY TESTING

Automate tests for:

* IDOR;
* privilege escalation;
* hidden field exposure;
* authorization;
* CSRF;
* rate limits;
* malicious upload;
* webhook replay;
* signed URL expiry;
* sensitive data caching.

Run SAST and dependency scanning.

---

# 188. ACCESSIBILITY TESTING

Use automated and manual tests.

Test:

* keyboard only;
* screen reader;
* zoom;
* contrast;
* reduced motion;
* focus;
* dialogs;
* maps;
* mobile targets.

Automated tools do not replace manual accessibility testing.

---

# 189. PERFORMANCE TESTING

Create representative scenarios.

Examples:

* browse popular journeys;
* map search;
* 10,000 concurrent viewers;
* booking surge;
* large chat group;
* organizer dashboard;
* payment webhook burst.

Determine bottlenecks before scaling architecture.

---

# 190. RACE CONDITION TESTS

Specifically test:

* last available journey seat;
* last optional activity seat;
* duplicate payment webhook;
* simultaneous refund;
* double equipment assignment;
* duplicate join approval.

---

# 191. TEST DATA

Provide realistic factories and seeders.

Include:

* social trip;
* professional tour;
* multi-country itinerary;
* mountain trip;
* family journey;
* meetup;
* high-risk activity;
* accessible trip;
* waitlisted trip.

Do not use offensive or privacy-sensitive fake content.

---

# 192. REFERENCE DEMO TOUR

Create a demonstration based on:

Start:
Ankara, Turkey

Then:

England
→ Italy/Rome
→ France/Paris
→ Spain
→ Ankara

Include:

* airplane;
* train;
* cultural activities;
* nature activities;
* religious activities;
* museums;
* age 20–40 example restriction;
* breakfast options A/B/C;
* lunch D/E/F;
* snack G/H/I;
* dinner J/K/L;
* warm clothing;
* jacket;
* blanket;
* boots.

Use this scenario to test the Journey Graph and UI.

---

# 193. DOCUMENTATION

Produce:

README.md

Architecture documentation

Local development guide

Production deployment guide

Database documentation

Domain model documentation

Security architecture

Threat model

Privacy model

API documentation

Provider integration guide

Testing guide

Backup/recovery guide

Admin guide

Tour organizer guide

Incident response guide

---

# 194. ARCHITECTURE DECISION RECORDS

Create ADRs for consequential decisions such as:

* modular monolith;
* authentication;
* payment architecture;
* PostGIS;
* provider abstraction;
* sensitive data separation;
* realtime architecture;
* AI gateway.

---

# 195. ERD

Document significant database relationships.

Keep ERD synchronized with actual migrations.

---

# 196. API DOCUMENTATION

Generate OpenAPI documentation from or synchronized with actual API contracts.

Do not manually maintain documentation that immediately becomes inconsistent.

---

# 197. CI/CD

Pipeline stages should include:

* dependency installation;
* formatting;
* lint;
* static analysis;
* type checking;
* unit tests;
* integration tests;
* frontend tests;
* security scan;
* build;
* E2E;
* artifact/container generation.

Protected deployment stages should require successful checks.

---

# 198. PHP QUALITY

Use:

* strict types where appropriate;
* PHPStan/Larastan;
* Pint or equivalent formatting;
* clear typed DTOs;
* typed enums;
* immutable value objects where beneficial.

Avoid arrays containing undocumented structures.

---

# 199. TYPESCRIPT QUALITY

Enable strict TypeScript.

Avoid `any`.

Use generated API types where practical.

Use runtime validation at trust boundaries.

Never assume compile-time TypeScript types validate network data.

---

# 200. DATABASE MIGRATIONS

Every schema change uses migration.

Migrations must be production-conscious.

Consider:

* locks;
* indexes;
* large tables;
* rollback;
* data migration.

---

# 201. SECRETS

Never commit real secrets.

Provide:

.env.example

Use secrets management in deployment.

Rotate credentials.

---

# 202. INFRASTRUCTURE

Development environment should start predictably.

Provide Docker services for required local infrastructure.

Production architecture should support:

* web;
* API;
* workers;
* scheduler;
* PostgreSQL;
* Redis;
* object storage;
* CDN;
* monitoring.

---

# 203. SCALING

Scale vertically and horizontally based on measurements.

Make:

* web stateless;
* API stateless where practical;
* sessions distributed or secure-cookie based;
* queues scalable;
* websocket infrastructure scalable.

Do not prematurely shard PostgreSQL.

---

# 204. DATA PARTITIONING

Only introduce table partitioning when data volume and query patterns justify it.

Potential future candidates:

* audit logs;
* analytics events;
* messaging;
* notifications.

---

# 205. PRIVACY-PRESERVING ANALYTICS

Use IDs/pseudonymous data where possible.

Do not export:

* medical data;
* government IDs;
* exact future location;
* private messages

into generic analytics warehouses.

---

# 206. ADMIN DATA ACCESS

Do not give administrators universal access by default.

Use role-specific views.

Sensitive data access must have:

* reason;
* permission;
* audit.

---

# 207. SECURITY REVIEW GATE

Before considering implementation complete, the Security team must review:

Authentication
Authorization
Payments
Documents
Uploads
Messaging
Admin
Webhooks
AI
Maps/location
Privacy
Logs
Infrastructure

Fix discovered issues.

---

# 208. UI/UX REVIEW GATE

The UX team must review every major workflow.

Especially:

* registration;
* onboarding;
* create tour;
* edit tour;
* map;
* application;
* organizer dashboard;
* participant dashboard;
* trip mode;
* safety;
* payments;
* mobile.

Measure form complexity.

Remove unnecessary steps.

---

# 209. PRIVACY REVIEW GATE

Privacy Engineer must examine every field asking:

Why do we collect this?

Who needs it?

How long do we keep it?

Who can see it?

Can we avoid collecting it?

Can we store verification status instead?

Fix issues.

---

# 210. ACCESSIBILITY REVIEW GATE

Accessibility team performs:

* automated tests;
* keyboard review;
* screen reader review;
* mobile review;
* contrast review.

Fix all high-severity issues.

---

# 211. PERFORMANCE REVIEW GATE

Performance engineer must inspect:

* slow queries;
* N+1;
* large bundles;
* map payload;
* image payload;
* caching;
* queue delay;
* expensive recommendation queries.

Fix major bottlenecks.

---

# 212. DOMAIN REVIEW GATE

Tourism and Travel Operations roles must execute complete example journeys through the system.

Validate that it works operationally, not merely technically.

---

# 213. QA REVIEW CYCLES

Perform at least five structured end-to-end review cycles.

Cycle 1:
Functional correctness.

Cycle 2:
Security and privacy.

Cycle 3:
UI/UX and accessibility.

Cycle 4:
Concurrency, integrations and failure handling.

Cycle 5:
Full regression, production readiness and documentation.

Fix problems between cycles.

Do not simply claim reviews occurred.

Run actual available tests and record results.

---

# 214. REQUIREMENTS TRACEABILITY

Create a requirements matrix.

Each requirement receives:

ID
Description
Module
Implementation
Tests
Status

No requirement is complete until both implementation and verification exist.

---

# 215. NO FAKE COMPLETION

Never state:

"Implemented"

if only:

* migration exists;
* interface exists;
* route exists;
* button exists;
* TODO exists.

A feature is implemented only when its complete user flow works and is tested.

---

# 216. ERROR HANDLING

Handle domain errors deliberately.

Examples:

JourneyFull
EligibilityFailed
PaymentRequired
BookingUnavailable
Unauthorized
DocumentExpired
ProviderUnavailable
InvalidStateTransition

Do not throw generic exceptions for expected business cases.

---

# 217. USER-FACING ERRORS

Errors must be:

* clear;
* actionable;
* safe;
* localized.

Avoid technical messages such as:

"SQLSTATE 23505".

Log technical details internally.

---

# 218. OBSERVABILITY OF BUSINESS FLOWS

Track operational events such as:

Application accepted
Journey filled
Payment failed
Booking provider failed
Notification failed
Credential expired

Create admin/operator visibility.

---

# 219. ANTI-SCRAPING

Protect:

* participant lists;
* precise itinerary data;
* contact information;
* profile enumeration.

Use:

* authorization;
* rate limiting;
* anti-bot measures;
* response minimization.

---

# 220. ANTI-STALKING

Design against behavior such as:

* following one user's future locations;
* repeated unwanted applications;
* mass romantic requests;
* profile enumeration.

Provide detection and safety controls.

---

# 221. ACCOUNT TAKEOVER PROTECTION

Use:

* MFA/passkey;
* rate limiting;
* security notifications;
* session revocation;
* suspicious device detection.

Reauthenticate before:

* payout change;
* password change;
* MFA removal;
* identity information change.

---

# 222. BUSINESS CONTINUITY

Critical user trip information should remain available even if non-critical systems fail.

An AI outage must not stop trips.

A recommendation outage must not stop bookings.

Analytics failure must not break transactional requests.

---

# 223. SEARCH ENGINE INDEX PRIVACY

Never index:

* private journeys;
* private locations;
* participant private data;
* document data;
* sensitive safety information

into public or insufficiently protected search indices.

---

# 224. SOCIAL PRIVACY

Allow users to control:

* discoverability;
* profile visibility;
* activity history;
* trip history;
* follower/friend behavior;
* messages.

---

# 225. POST-TRIP PRIVACY

A completed journey becoming a memory page must not automatically convert formerly private itinerary data into public content.

Require explicit sharing choice.

---

# 226. DELETED CONTENT

Ensure deleted/private content is invalidated from:

* caches;
* search;
* CDN;
* signed URLs

within defined operational timelines.

---

# 227. WHITE-LABEL READINESS

Architecture should allow future tenant branding.

Potential overrides:

* logo;
* colors;
* domain;
* email templates;
* policies;
* feature flags.

Do not implement full multi-domain white labeling unless part of current release, but do not make it impossible.

---

# 228. MOBILE APP READINESS

All important business operations must be available through authenticated APIs so future:

iOS
Android

applications can reuse the backend.

Do not bury core business logic in Next.js-only server actions.

---

# 229. DEVELOPMENT MODE PROVIDERS

For integrations requiring credentials, supply safe development adapters.

Examples:

FakePaymentProvider
FakeWeatherProvider
FakeIdentityProvider

These must simulate:

* success;
* failure;
* timeout;
* webhook;
* retry.

Never make production accidentally use fake payment success.

---

# 230. FEATURE DELIVERY PRIORITY

Architect the entire system but implement in coherent vertical slices.

Recommended order:

Foundation
→ Identity
→ Profiles
→ Journey Graph
→ Tour Builder
→ Search
→ Applications
→ Messaging
→ Safety
→ Payments
→ Marketplace
→ Communities
→ AI
→ Professional/B2B
→ Advanced operations.

Do not sacrifice architecture required by later modules.

---

# 231. FIRST PRODUCTION-QUALITY RELEASE

The first release must already be capable of:

* account registration;
* verification;
* profile;
* tour creation;
* multi-stop itinerary;
* activity configuration;
* restrictions;
* transport;
* meals;
* equipment;
* accommodation;
* applications;
* acceptance;
* waitlist;
* messaging;
* notifications;
* search;
* maps;
* privacy controls;
* reviews;
* reporting;
* moderation;
* admin;
* responsive mobile experience.

It must not depend on future marketplace integrations to function.

---

# 232. ACCEPTANCE SCENARIO A

A user creates:

Ankara → London → Rome → Paris → Madrid → Ankara.

The system must allow every segment to use different transportation.

London contains nature activities.

Age eligibility:
20–40.

Meals contain multiple menus.

Required equipment includes:

warm clothes;
jacket;
blanket;
boots.

Rome contains religious destinations.

Paris contains museums.

Spain contains activities.

The system must render the complete journey as:

map
+
timeline
+
day-by-day itinerary.

Another user must:

find the journey;
inspect requirements;
apply;
pass eligibility;
answer organizer questions;
be accepted;
receive access to appropriate private details;
join journey chat;
complete preparation checklist.

Test this end-to-end.

---

# 233. ACCEPTANCE SCENARIO B

Create a high-risk mountain expedition.

Verify:

* activity risk;
* required equipment;
* safety briefing;
* emergency information;
* participant readiness;
* check-in;
* contingency plan;
* restricted safety data;
* high-risk publication requirements.

---

# 234. ACCEPTANCE SCENARIO C

Create a simple coffee meetup.

The user must NOT be forced through the full expedition form.

Quick Create must remain lightweight.

This scenario validates progressive disclosure.

---

# 235. ACCEPTANCE SCENARIO D

Create a professional paid tour.

Test:

* business verification;
* capacity;
* price;
* deposit;
* payment;
* invoice/receipt;
* refund;
* cancellation;
* organizer payout;
* ledger;
* reconciliation.

---

# 236. ACCEPTANCE SCENARIO E

Two users attempt to purchase the final available place simultaneously.

Exactly one succeeds unless business rules permit waitlist fallback.

No overselling.

---

# 237. ACCEPTANCE SCENARIO F

A user without authorization attempts to access:

* another participant's exact location;
* private health data;
* ID document;
* private message;
* professional payout.

All requests must fail safely.

Test API and direct object-reference attacks.

---

# 238. ACCEPTANCE SCENARIO G

Organizer changes a flight.

System identifies:

* transfer;
* hotel;
* dinner

as potentially impacted.

Affected participants are notified.

Critical change acknowledgment is tracked.

---

# 239. ACCEPTANCE SCENARIO H

External provider is unavailable.

The application remains usable.

The affected integration displays controlled error/retry behavior.

No corrupt booking state occurs.

---

# 240. DEFINITION OF DONE

A feature is done only when:

Business requirements are satisfied.

UI exists.

Backend exists.

Authorization exists.

Validation exists.

Database constraints exist.

Error handling exists.

Loading/empty/error states exist.

Localization is supported.

Accessibility has been checked.

Tests exist.

Security has been reviewed.

Documentation is updated.

Observability exists where operationally necessary.

---

# 241. FINAL DELIVERY

At the end deliver:

1. complete source code;
2. database migrations;
3. seed data;
4. Docker development environment;
5. production deployment configuration/example;
6. API documentation;
7. architecture documentation;
8. ERD;
9. security threat model;
10. privacy/data classification matrix;
11. permission matrix;
12. provider integration guide;
13. CI/CD;
14. automated test suite;
15. test results;
16. performance test results where executable;
17. security review findings and fixes;
18. README;
19. administrator documentation;
20. organizer documentation.

---

# 242. IMPLEMENTATION EXECUTION PROTOCOL

Follow this exact behavior.

First inspect the entire repository if one exists.

Do not overwrite working functionality without understanding it.

Then create:

Requirements Traceability Matrix
Domain Map
Data Classification Matrix
Threat Model
Architecture Decisions
Implementation Plan

Then implement.

Do NOT stop and ask the user to approve those planning documents unless an irreversible business decision genuinely prevents implementation.

Make safe, professional defaults where possible.

Continue until the current highest-dependency vertical slice is runnable and verified, or a boundary listed in the Turn Completion Contract is reached. A runnable foundation is not platform completion. Do not trade verified depth for broad unverified scaffolding.

After each major module:

* run tests;
* inspect failures;
* fix them;
* run again.

After all modules:

perform cross-role review.

---

# 243. CROSS-ROLE REVIEW PROCEDURE

Apply the following as named review lenses. Do not imply that a person, team, or sub-agent performed a review unless that actor actually inspected the work. Every review claim must cite inspected files, findings, and commands or checks executed.

Have Product Owner check completeness.

Have Business Analyst check flows.

Have Tourism Expert check practical travel workflows.

Have Travel Operations Expert simulate live tours.

Have UI/UX team inspect usability.

Have Accessibility Expert inspect accessibility.

Have Privacy Engineer inspect every sensitive field.

Have Security team perform threat review.

Have Backend Architect inspect domain boundaries.

Have Database Architect inspect schema and indexes.

Have Frontend Architect inspect component architecture.

Have QA team execute regression.

Have DevOps/SRE inspect production readiness.

Have Prompt Engineer compare final implementation against this entire specification.

Fix every critical/high issue and all reasonably correctable medium issues.

Repeat review until stable.

---

# 244. DO NOT REDUCE SCOPE SILENTLY

If resource limitations prevent one integration from being genuinely exercised because credentials are unavailable:

Implement:

* provider interface;
* production adapter structure;
* sandbox/dev adapter;
* configuration;
* callback/webhook endpoint;
* security validation;
* tests.

Document what external credential is required.

Do not silently remove the feature.

---

# 245. NO PREMATURE MICROservices

Keep the initial application a carefully modularized monolith.

Only recommend extraction when there is evidence such as:

* independent scaling requirement;
* operational isolation requirement;
* substantially different availability requirement;
* organizational ownership boundary.

Domain events must make future extraction feasible.

---

# 246. QUALITY OVER ARTIFICIAL COMPLEXITY

Do not introduce:

* Kafka;
* Kubernetes;
* service mesh;
* dozens of microservices;
* CQRS everywhere;
* event sourcing everywhere

simply to appear sophisticated.

Use sophisticated architecture where justified.

Favor understandable, secure, maintainable technology.

---

# 247. SECURITY OVER CONVENIENCE

When convenience conflicts with privacy/security, redesign the UX rather than weakening security.

Examples:

Do not expose exact meeting locations publicly because it is convenient.

Do not expose medical information to organizers because it simplifies eligibility.

Do not store raw card data because it simplifies payments.

Do not allow universal admin database browsing because it simplifies support.

---

# 248. UX OVER FORM SIZE

The internal model may contain hundreds of possible properties.

The user must never perceive this as a giant form.

Use:

* progressive disclosure;
* templates;
* contextual fields;
* smart defaults;
* natural language;
* AI extraction;
* duplication;
* imports;
* autosave;
* collapsible advanced sections.

Complexity shown to the user must be proportional to the complexity and risk of their journey.

Coffee meetup:
very simple.

Multi-country holiday:
moderate.

Mountain expedition:
detailed.

Commercial multi-country package:
comprehensive.

---

# 249. FINAL PRODUCT PRINCIPLE

The platform should feel simple even though its internal architecture is powerful.

The final user experience should resemble:

Describe trip
→ Review generated structure
→ Add missing details
→ Invite/find participants
→ Prepare together
→ Travel safely
→ Manage changes
→ Complete journey
→ Share memories

The application's internal sophistication must remain largely invisible to ordinary users.

---

# 250. FINAL INSTRUCTION

Build this platform as if it will:

* operate internationally;
* handle real payments;
* store sensitive personal information;
* coordinate strangers meeting in real life;
* support professional tour businesses;
* support dangerous recreational activities;
* serve millions of users in the future.

But keep the initial architecture operationally manageable.

Do not optimize merely for demonstration.

Do not generate a fake SaaS dashboard.

Do not produce incomplete boilerplate.

Do not substitute documentation for implementation.

Do not claim functionality that has not been implemented and tested.

Produce a coherent, secure, accessible, privacy-conscious, visually excellent, maintainable, fully runnable system.

When tradeoffs are necessary, explicitly document them and select the option that best preserves:

1. user safety;
2. privacy;
3. security;
4. correctness;
5. usability;
6. maintainability;
7. performance;
8. extensibility.

Begin implementation now.
