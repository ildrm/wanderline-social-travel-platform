# Requirements traceability

**Status:** Active implementation ledger  
**Source:** `PROMPT-SOL-HIGH.md`  
**Updated:** 2026-09-14

This living matrix maps every numbered specification section and acceptance scenario to an implementation area. The source prompt remains authoritative. Grouping indicates a shared vertical slice, not reduced scope.

## Status and evidence rules

- Use only `NOT_STARTED`, `FOUNDATION_ONLY`, `IMPLEMENTED_UNVERIFIED`, `VERIFIED`, or `EXTERNAL_BLOCKED`.
- `Implementation` and `Tests` contain actual evidence only. A planned path is not evidence.
- A group can become `VERIFIED` only when every listed section is implemented and its relevant automated checks pass; otherwise split the row.
- Provider credentials may yield `EXTERNAL_BLOCKED` only after the production contract, safe development adapter, configuration, failure behavior, and provider-level tests exist.

## Matrix

| Requirement IDs | Description | Module / owner | Implementation | Tests | Status |
|---|---|---|---|---|---|
| §1, §2 | Operating review lenses and full product vision | Product / Platform | Architecture and initial platform slice exist, but the complete cross-role product has not been implemented | — | FOUNDATION_ONLY |
| §3 | Four Journey Engine modes | Journeys | `JourneyMode.php`, journey migration, store API and Quick Create accept `SOCIAL`, `EXPERIENCE`, `PROFESSIONAL`, and `PRIVATE_GROUP`; mode-specific flows are absent | `JourneyControllerTest`; current backend suite 34/34 passed | FOUNDATION_ONLY |
| §4 | API-first modular-monolith architecture and engineering principles | Platform Architecture | `apps/api`, `apps/web`, ADR-0001 and after-commit journey event establish the runnable shape; most bounded contexts/provider ports remain absent | Pint and PHPStan passed; backend 34/34 and frontend 6/6 passed; production web build passed | FOUNDATION_ONLY |
| §5 | Current reference technology stack | Platform Architecture | Locked Laravel 13.31.0/Sanctum 4.3.3, Next.js 16.3.5/React 19.2.8, PostgreSQL 18/PostGIS, Redis 8.2, MinIO/S3 abstraction and Docker configuration; Reverb/Horizon and several prescribed libraries are not installed | Composer/Node checks, Compose config and production web build passed | FOUNDATION_ONLY |
| §6 | Maintainable monorepo structure | Developer Platform | Root npm workspace with `apps/api`, `apps/web`, `infrastructure`, `.github`, and `docs`; machine-readable API contract is `docs/openapi.yaml` | Backend lint/analysis/tests, frontend lint/type/tests/build, Compose config and Kustomize rendering passed | IMPLEMENTED_UNVERIFIED |
| §7 | Explicit bounded contexts | Platform Architecture | Identity and Journeys boundaries exist; `docs/domain-map.md` defines future boundaries, but most are not implemented | Boundary structure inspected; current PHPStan passed | FOUNDATION_ONLY |
| §8 | Journey Graph | Journeys | `Journey`, `JourneyDay`, `Location`, `Stop`, `Activity`, and `TransportationLeg` persistence plus transactional itinerary create/read APIs exist; services, accommodation, meals, equipment, risks, participants, reservations, costs and documents are absent | `JourneyItineraryControllerTest` covers complete graph, rollback, authorization and privacy; current backend suite 34/34 passed | FOUNDATION_ONLY |
| §9 | Extensible journey classifications | Journeys | — | — | NOT_STARTED |
| §10 | Journey lifecycle state machine, history and events | Journeys | `JourneyStatus.php`, `TransitionJourneyStatus.php`, `journey_transitions` migration, `JourneyStatusTransitioned.php`, transition endpoint and owner policy implement all named states, authorized edges, row locking, history and after-commit event dispatch | `JourneyTransitionControllerTest` and `JourneyPolicyTest`; Pint, PHPStan and 34-test backend suite passed | VERIFIED |
| §11, §12 | Creation entry points and progressive Tour Builder | Journeys / Web | Authenticated `QuickCreateForm` creates a private draft through the real API with basic mode/title/capacity/visibility/timezone fields; guided, AI, template/import flows and the full staged builder are absent | `quick-create-form.test.tsx` 2 tests; journey create API tests; frontend 6/6 and current backend 34/34 passed | FOUNDATION_ONLY |
| §13 | Completeness scoring | Journeys | — | — | NOT_STARTED |
| §14 | Tour simulation | Journeys | `ValidateItineraryChronology.php` rejects unordered days, overlapping/out-of-bounds activities, broken leg connectivity and inconsistent timestamps transactionally; categorized Critical/Warning/Suggestion analysis is absent | Invalid chronology and rollback cases in `JourneyItineraryControllerTest` pass | FOUNDATION_ONLY |
| §15 | Route builder | Routes / Web | Ordered day/stop/leg API graph exists; interactive map/timeline editing, reorder, clone and alternatives UI are absent | Complete itinerary create/read test passed | FOUNDATION_ONLY |
| §16 | Transportation legs | Routes | Five normalized modes, provider label, endpoints and timestamps are stored between consecutive stops; the broader mode/booking/luggage/accessibility/price model is absent | Itinerary graph, chronology and rollback tests passed | FOUNDATION_ONLY |
| §17 | Stops and locations | Routes | Named/country/timezone stops, times, PostGIS point storage and city-precision response coordinates exist; the wider environmental/accessibility/permit model is absent | Itinerary graph and restricted-coordinate response tests passed | FOUNDATION_ONLY |
| §18 | Location privacy | Routes / Privacy | Exact PostGIS coordinates are stored separately from rounded public coordinates and never serialized by current owner itinerary resources; audience precision levels, delayed sharing and live opt-in are absent | Recursive hidden-coordinate and cross-owner API assertions passed | FOUNDATION_ONLY |
| §19 | Activities | Activities | Ordered stop activities with title, description and bounded timestamps exist; typed categories and activity-specific schemas are absent | Graph persistence and chronology tests passed | FOUNDATION_ONLY |
| §20, §21, §22, §23 | Independent activity capacity, demand, eligibility and private safety profile | Activities / Eligibility / Safety | — | — | NOT_STARTED |
| §24, §25, §26, §27, §28 | Meals, packing, organizer equipment inventory, accommodation, and private allocation | Journey Operations | — | — | NOT_STARTED |
| §29, §30, §31 | Journey-attached service marketplace, fulfillment modes, and provider ports/adapters | Marketplace / Integrations | ADR-0004 establishes the provider-boundary decision only | — | FOUNDATION_ONLY |
| §32, §33, §34 | Join workflow, commitment states, structured conditional application forms and privacy constraints | Applications / Participants | — | — | NOT_STARTED |
| §35, §36 | Non-sensitive, user-controlled, explainable companion matching | Recommendations | — | — | NOT_STARTED |
| §37 | Secure user accounts | Identity | Sanctum cookie registration/login/current-user/logout, strong password validation, session rotation/invalidation and contextual auth throttles are implemented; contact verification, recovery, passkeys, MFA, OAuth, device/session history and suspicious-login alerts are absent | Identity feature tests cover success, generic failure, duplicate email, rotation, logout reuse, safe fields, unauthenticated access and login throttling; backend suite passed | FOUNDATION_ONLY |
| §38, §39, §40 | Separated profiles, field-level visibility and verification levels | Profiles / Verification | ADR-0005 defines separation, but the current `users` table and API do not implement these capabilities | Current-user response safety test only | NOT_STARTED |
| §41, §42, §43 | Professional organizer credentials, organizations/tenancy, and journey staff permissions | Organizations / Trust | — | — | NOT_STARTED |
| §44, §45, §46, §47 | Social/business modes, adult-only romantic opt-in, dependent-minor safety, and communities | Meetups / Communities / Trust | — | — | NOT_STARTED |
| §48, §49, §50, §51, §52 | Scoped messaging, abuse controls, priorities/acknowledgment, translation, and pre-trip meetings | Messaging / Trust / Integrations | — | — | NOT_STARTED |
| §53, §54, §55, §56, §57 | Governance, proposals, immutable itinerary versions, impact analysis, and contingencies | Journeys / Operations | — | — | NOT_STARTED |
| §58, §59, §60, §61 | Live Trip UI, non-continuous attendance, private readiness, and organizer command center | Live Operations | — | — | NOT_STARTED |
| §62, §63, §64, §65, §66, §67, §68, §69 | Safety center, trusted contacts, check-ins/SOS, structured risk, restricted incidents, near misses, briefings | Safety | — | — | NOT_STARTED |
| §70, §71, §72 | Weather/advisory adapters and encrypted authorization-aware offline trip pack | Integrations / Safety / Offline | — | — | NOT_STARTED |
| §73, §74, §75, §76 | Budget, integer-minor-unit money, expenses, and transparent commercial pricing | Finance / Expenses | — | — | NOT_STARTED |
| §77, §78, §79, §80, §81 | Payment lifecycle, immutable ledger, versioned cancellation, regional classification, trader traceability | Payments / Compliance / Trust | ADR-0007 establishes the payment architecture only | — | FOUNDATION_ONLY |
| §82, §83, §84 | Per-traveler document readiness and private encrypted document vault | Documents / Compliance | — | — | NOT_STARTED |
| §85 | WCAG 2.2 AA accessibility | Web / Accessibility | Current Explore/auth/create interfaces use semantic labels, focus styles, reduced motion and touch-size foundations; no complete automated/manual WCAG review exists | Component interaction tests passed; no axe, keyboard-only or screen-reader evidence | FOUNDATION_ONLY |
| §86 | Factual travel accessibility data | Journeys / Accessibility | Static Explore fixtures expose only a basic accessible filter; per-leg/accommodation/activity/meeting-point data is absent | Explore filter component test only | FOUNDATION_ONLY |
| §87 | Internationalization | Web / Localization | English catalog and locale-aware `Intl` money formatting exist, but user-visible strings remain partly hard-coded and RTL/plural/date/calendar coverage is absent | Typecheck, lint, component tests and build passed | FOUNDATION_ONLY |
| §88 | Canonical unit systems and configurable display | Localization | — | — | NOT_STARTED |
| §89, §90, §91, §92, §93, §94 | Privacy-aware text/map/nearby/saved/intent search and explainable recommendations | Search / Recommendations | — | — | NOT_STARTED |
| §95, §96, §97, §98, §99 | Reviewable AI creation/assistance through a redacting, authorization-aware, human-gated gateway | AI / Safety | ADR-0008 establishes the gateway decision only | — | FOUNDATION_ONLY |
| §100, §101, §102, §103, §104, §105, §106 | Business meetings and Journey Graph-connected restaurant, shopping, entertainment, sports, rental, expert services | Meetups / Marketplace | — | — | NOT_STARTED |
| §107, §108 | Unified calendar/ICS and preference-aware multichannel notifications | Calendar / Notifications | — | — | NOT_STARTED |
| §109, §110, §111 | Participation-verified multidimensional/double-blind reviews and transparent reputation signals | Reviews / Trust | — | — | NOT_STARTED |
| §112, §113, §114, §115 | Blocking, reporting, restricted moderation cases, and appeals | Trust / Moderation | — | — | NOT_STARTED |
| §116, §117 | Modular admin control center with strengthened authentication and least privilege | Admin | — | — | NOT_STARTED |
| §118, §119, §120, §121 | Privacy subsystem, class-based retention, truthful deletion/anonymization, and safe export | Privacy / Compliance | `docs/data-classification.md` defines baseline policy only | — | FOUNDATION_ONLY |
| §122 | Security baseline and structured threat modeling | Security | `docs/threat-model.md`, safe problem responses, cookie sessions, mass-assignment prohibitions, owner policy, throttles, correlation IDs and CI security/SBOM jobs cover only the initial slice | Negative auth/authz/validation tests; backend suite and static analysis passed | FOUNDATION_ONLY |
| §123 | Server-side authorization | Authorization | `JourneyPolicy.php`, scoped owner queries and form-request/Gate checks deny non-owner journey reads and transitions | `JourneyControllerTest`, `JourneyTransitionControllerTest`, `JourneyPolicyTest`; backend suite passed | FOUNDATION_ONLY |
| §124 | Contextual rate limiting | Security | Registration, normalized email+IP login, and authenticated identity limiters are configured; messaging/search/upload/AI/payment limits do not exist | Login throttling test passed | FOUNDATION_ONLY |
| §125, §126 | Secure files and encryption | Security / Documents | Private S3-compatible storage, Flysystem S3 adapter and architecture policy exist; upload validation/scanning and application-level restricted-field encryption are absent | Reversible configured-disk readiness tests and live MinIO readiness passed | FOUNDATION_ONLY |
| §127 | Safe structured logging and correlation | Reliability | `CorrelationId.php`, API problem correlation and stderr container logging exist; explicit sensitive-field log filters and structured JSON formatting are incomplete | Health/unknown-route correlation tests passed | FOUNDATION_ONLY |
| §128, §129, §130, §131 | Audit, security headers, content and payment security | Security | Architecture policies exist; runtime audit store, hardened response-header middleware, UGC pipeline and payments are absent | — | NOT_STARTED |
| §132 | Software supply chain | Developer Platform | Lockfiles, Dependabot, CI Composer/npm audit, Gitleaks, Trivy and SPDX SBOM jobs exist | Workflow inspected; local lint/analysis/tests/build passed, hosted CI not observed | IMPLEMENTED_UNVERIFIED |
| §133 | License policy | Governance | Repository license and dependency-license policy require reconciliation; no generated license inventory was inspected | — | NOT_STARTED |
| §134, §135, §136 | Design system, visual design and semantic color | Design System / Web | Token foundations and a responsive premium Explore concept exist, but colors remain partly scattered and the complete component system is absent | Frontend lint/type/tests/build passed | FOUNDATION_ONLY |
| §137, §138, §139, §140 | Mobile/desktop UX, public journey page and SEO | Web | Responsive Explore/auth/create and statically generated demonstration journey pages, metadata, robots and sitemap exist; pages use static fixtures rather than privacy-authorized Journey API data | Explore/auth/create component tests and Next.js production build passed | FOUNDATION_ONLY |
| §141 | Measured performance budgets | Performance | Optimized images/static generation are present, but no budgets or representative load/Core Web Vitals evidence exists | Production build passed only | NOT_STARTED |
| §142, §143, §144 | Relational practices, PostGIS and constrained JSONB | Data Platform | Current migrations use ULIDs, FKs/checks/indexes and PostGIS geography points with SRID 4326/GiST for public location; radius/bounds/nearby queries are absent and no JSONB is used | Graph migration-backed tests passed; `docs/erd.md` covers every current application-domain table | FOUNDATION_ONLY |
| §145 | Database concurrency controls | Data Platform | Journey transitions use a transaction and `lockForUpdate`; capacity/inventory/payment races are absent | Invalid/valid transition tests passed; no concurrent transaction test | FOUNDATION_ONLY |
| §146 | Idempotency for critical flows | Platform | — | — | NOT_STARTED |
| §147 | Versioned API design and OpenAPI | API | All current API operations are versioned under `/api/v1`; `docs/openapi.yaml` documents them plus Sanctum CSRF initialization | YAML parse and route/operation parity validation passed | VERIFIED |
| §148 | Consistent safe API problem format | API | `ProblemDetailsResponse.php` emits type/title/status/detail/instance/correlation ID and validation errors without stack traces | Health, identity, journey, itinerary and transition tests cover 401/403/404/409/419/422/429/503-safe formats; Pint, PHPStan and 34-test backend suite passed | VERIFIED |
| §149 | API authentication, authorization, scopes, replay/limits | API Security | Current session-authenticated Journey endpoints have validation and owner authorization; partner scopes, token lifecycle, request-size and replay controls are absent | Authentication and owner-boundary tests passed | FOUNDATION_ONLY |
| §150 | Signed outgoing webhooks | Integrations | — | — | NOT_STARTED |
| §151, §152, §153, §154 | Database-authoritative realtime, retryable jobs, scheduler, and authorization-safe cache | Platform / Realtime | ADR-0006 establishes the realtime decision only | — | FOUNDATION_ONLY |
| §155, §156 | Observability and SLO/SLA preparation | Reliability | Correlation context, stderr logging, OpenTelemetry collector, Prometheus/Grafana and alert configuration exist; application instrumentation and defined production SLIs/SLOs are incomplete | Compose config and Kustomize render passed; runtime telemetry was not exercised | FOUNDATION_ONLY |
| §157 | Liveness and readiness | Reliability | `/api/v1/health`, `/api/v1/readiness` and container probes exist; readiness checks database, configured queue Redis, and reversible private-storage access without topology leakage; future critical providers still need checks when introduced | Healthy and component-failure readiness feature tests passed in the 34-test backend suite | FOUNDATION_ONLY |
| §158, §159, §160 | Verified backups, disaster recovery and provider failure | Reliability / Integrations | Deployment architecture mentions persistence, but restore-tested backup/DR and provider degradation flows are absent | — | NOT_STARTED |
| §161, §162, §163 | Privacy-conscious product, organizer, and admin analytics | Analytics | — | — | NOT_STARTED |
| §164, §165 | Clearly labeled sustainability estimates and authoritative environmental guidance | Sustainability / Integrations | — | — | NOT_STARTED |
| §166, §167, §168, §169, §170 | Privacy-controlled memories/media/lost-and-found, safe duplication, executable templates | Memories / Media / Journeys | — | — | NOT_STARTED |
| §171, §172 | Regional policies and server-enforced feature flags | Platform / Compliance | Architecture only | — | NOT_STARTED |
| §173 | Date/time correctness | Journeys / Localization | Journey timezone is required, length-bounded, validated against known timezones, and returned by the API; itinerary instants/local-zone rendering are absent | Invalid timezone and successful create tests passed | FOUNDATION_ONLY |
| §174 | Bounded pagination | API | Owner journey list uses server pagination with `per_page` constrained to 1–100; cursor and SEO pagination strategies are not yet present | Journey list test and OpenAPI schema inspection | FOUNDATION_ONLY |
| §175, §176 | Contextual access model and platform roles | Authorization | Owner-context Journey policy and `docs/permission-matrix.md` exist; organization/journey/data-class/role model is not implemented | Journey policy unit tests and API non-owner tests passed | FOUNDATION_ONLY |
| §177, §178, §179, §180 | Scoped support, versioned public/legal content, consent evidence, immutable waiver versions | Support / Content / Compliance | — | — | NOT_STARTED |
| §181, §182 | Role and privacy preview | Web / Privacy | Policy documentation exists, but no preview UI/API is implemented | — | NOT_STARTED |
| §183 | Empty/loading/error/permission states | Web | Root loading/error routes and current Explore/auth/create empty, pending, error, unauthenticated and success states exist; coverage is not platform-wide | Six frontend component tests passed | FOUNDATION_ONLY |
| §184 | Poor-network retry/offline/sync resilience | Web / Offline | API errors are surfaced, but controlled retries, local drafts, offline cache and sync indicators are absent | — | NOT_STARTED |
| §185 | Installable PWA and native-ready API | Web / API | Manifest and authenticated REST boundary exist; service worker, offline trip data and safe update strategy are absent | Next.js build generated manifest route | FOUNDATION_ONLY |
| §186, §187, §188, §189, §190, §191, §192 | Full test pyramid, security/accessibility/performance/race suites, realistic fixtures and reference tour | Quality Engineering | Backend feature/unit and frontend component foundations plus a partial Ankara–Europe itinerary fixture exist; E2E, accessibility, performance, race, webhook/queue and the full meals/equipment/eligibility reference scenario are absent | Backend 34/34 with 605 assertions; frontend 6/6; Pint, PHPStan, TypeScript, frontend lint/tests/build passed | FOUNDATION_ONLY |
| §193 | Complete living documentation set | Documentation | README, architecture/security/privacy/permissions/implementation/infrastructure docs exist; operator, provider, recovery, admin and organizer guides remain absent | Documentation structure and links inspected | FOUNDATION_ONLY |
| §194 | Consequential architecture decision records | Architecture | ADR-0001 through ADR-0008 cover modular monolith, authentication, PostGIS, provider adapters, sensitive separation, realtime, payments and AI gateway | ADR structure validation passed | VERIFIED |
| §195 | Migration-synchronized ERD | Data Documentation | `docs/erd.md` documents all current application-domain tables, relationships, deletion behavior, constraints, indexes, and the PostGIS/SQLite test distinction against the four source migrations | ERD table/relationship/source assertions and migration inspection passed | VERIFIED |
| §196 | Synchronized OpenAPI documentation | API Documentation | `docs/openapi.yaml` describes every current `/api` route and the browser CSRF route with actual requests, responses, errors and security | YAML parse, OpenAPI root and route/operation parity validation passed | VERIFIED |
| §197 | CI/CD quality pipeline | Developer Platform | `.github/workflows/ci.yml` installs, formats, analyzes, typechecks, tests, audits, builds, scans and generates SBOM; E2E and protected deploy/artifact-image stages are absent | Local component commands passed; hosted pipeline not observed | FOUNDATION_ONLY |
| §198 | PHP quality | Backend | Typed PHP, enums, resources/requests, Pint and Larastan are configured; strict-types adoption and fuller domain DTO/value-object coverage remain | Pint passed; PHPStan passed with 0 errors; 34 tests and 605 assertions passed | IMPLEMENTED_UNVERIFIED |
| §199 | TypeScript quality | Web | Strict TypeScript and no observed `any`; API response types are handwritten and network responses lack runtime schema validation | Typecheck, ESLint, tests and build passed | FOUNDATION_ONLY |
| §200 | Production-conscious migrations | Data Platform | Every current application schema change is a migration with FKs/checks/indexes and rollback; deployed large-table migration strategy has not been exercised | Migration-backed feature suite passed; ERD synchronized | FOUNDATION_ONLY |
| §201 | Secret handling | Developer Platform | Ignored environment bootstrap, examples and runtime secret references exist; production secret rotation workflow is not implemented | Compose config and manifest inspection passed | FOUNDATION_ONLY |
| §202 | Predictable development/production-compatible infrastructure | Developer Platform | Docker Compose provides API/web/worker/scheduler/PostGIS/Redis/MinIO/Mailpit/telemetry; dependency-lock-aware development entrypoints, hardened runtime containers and Kubernetes examples exist | All nine Compose services ran healthy; DB/Redis/storage readiness, migrations, PostGIS, MinIO, browser auth/Journey smoke, development and production image builds, Compose config and Kustomize rendering passed; no production cluster deploy was attempted | IMPLEMENTED_UNVERIFIED |
| §203, §204, §205, §206 | Measurement-led scaling/partitioning, privacy-preserving analytics and purpose-limited admin access | Platform / Privacy / Admin | — | — | NOT_STARTED |
| §207, §208, §209, §210, §211, §212, §213 | Evidence-backed security, UX, privacy, accessibility, performance, domain and five-cycle QA gates | Quality Governance | — | — | NOT_STARTED |
| §214 | Requirements traceability | Quality | This matrix retains all §1–§250 and AC-A–AC-H and now links implemented slices to concrete files/checks | Coverage script reports 250 unique sections and A–H present | VERIFIED |
| §215 | No fake completion | Quality | Statuses distinguish verified complete requirements from partial foundations; most product scope remains explicitly incomplete | Matrix status/evidence review | FOUNDATION_ONLY |
| §216 | Deliberate domain errors | API / Domain | `InvalidJourneyTransition` maps to a stable 409 problem; remaining named domain errors are absent | Invalid-transition test passed | FOUNDATION_ONLY |
| §217 | Clear, actionable, safe, localized errors | API / Web | Safe problem details and UI error/field feedback exist; localization and full domain coverage are absent | API problem and frontend form tests passed | FOUNDATION_ONLY |
| §218 | Observable business flows | Reliability | Correlation IDs and after-commit journey transition event exist; operator metrics/events for broader flows are absent | Correlation and transition tests passed | FOUNDATION_ONLY |
| §219, §220, §221, §222, §223, §224, §225, §226 | Anti-scraping/stalking/ATO, continuity, index/social/post-trip privacy and deletion propagation | Trust / Security / Privacy | — | — | NOT_STARTED |
| §227, §228, §229 | White-label and native-app readiness plus production-rejected deterministic development providers | Platform / Integrations | — | — | NOT_STARTED |
| §230 | Dependency-ordered vertical-slice delivery | Program / All modules | Runnable foundation, Identity session and Journey lifecycle/Quick Create slices follow `docs/implementation-plan.md`; later slices remain | Current backend/frontend verification suites passed | FOUNDATION_ONLY |
| §231 | First production-quality release scope | Program / All modules | Initial account and journey-draft subset exists; applications, messaging, search-backed discovery, safety, moderation and other release requirements are absent | — | NOT_STARTED |
| §232 | Scenario A: complete multi-country social journey from discovery through preparation | Cross-domain release acceptance | Ankara–London–Rome–Paris–Madrid–Ankara days/stops/activities/mixed AIR/RAIL legs persist and read as an ordered graph; eligibility, meals, equipment, discovery/application/acceptance/chat/preparation and map/timeline E2E are absent | `JourneyItineraryControllerTest::test_owner_transactionally_creates_and_reads_complete_draft_itinerary` passed | FOUNDATION_ONLY |
| §233 | Scenario B: high-risk expedition with safety, readiness and restricted data controls | Safety release acceptance | — | — | NOT_STARTED |
| §234 | Scenario C: lightweight coffee meetup and progressive disclosure | Meetups release acceptance | — | — | NOT_STARTED |
| §235 | Scenario D: verified professional paid tour through payout and reconciliation | Commercial release acceptance | — | — | NOT_STARTED |
| §236 | Scenario E: concurrent final-seat purchase without overselling | Concurrency release acceptance | — | — | NOT_STARTED |
| §237 | Scenario F: safe denial of exact location, health, ID, message and payout IDOR attempts | Security release acceptance | — | — | NOT_STARTED |
| §238 | Scenario G: flight-change impact, notification and critical acknowledgment | Operations release acceptance | — | — | NOT_STARTED |
| §239 | Scenario H: provider outage degrades safely without corrupt booking state | Resilience release acceptance | — | — | NOT_STARTED |
| §240, §241 | Definition of done and complete final delivery inventory | Program / Quality | — | — | NOT_STARTED |
| §242, §243, §244 | Execution protocol, evidence-based cross-role review, and complete provider fallback scope | Program / Integrations | Initial planning artifacts exist; implementation/review evidence does not | Documentation structure inspection only | FOUNDATION_ONLY |
| §245, §246, §247, §248, §249, §250 | Manageable modular architecture, proportional complexity, security/UX priorities, and final product principles | Architecture / Product | ADR-0001 and this plan establish constraints only | — | FOUNDATION_ONLY |

## Acceptance scenario aliases

| Acceptance ID | Source | Required verification |
|---|---|---|
| AC-A | §232 | One E2E journey covering mixed transport, activities, eligibility, meals, equipment, private-detail disclosure, chat, and preparation. |
| AC-B | §233 | Domain, authorization, and E2E tests for high-risk publication, briefings, readiness, check-in, contingencies, and safety-data restrictions. |
| AC-C | §234 | Mobile and desktop E2E showing Quick Create excludes expedition-only fields and can publish a valid coffee meetup. |
| AC-D | §235 | Provider-contract, webhook, ledger, refund, payout, reconciliation, authorization, and E2E tests for a paid professional tour. |
| AC-E | §236 | Database concurrency test proving exactly one final-seat confirmation, with explicit waitlist behavior if configured. |
| AC-F | §237 | API and direct-object-reference tests proving deny-by-default access to five named restricted resource classes. |
| AC-G | §238 | Domain impact test plus E2E notification/acknowledgment flow after a flight change. |
| AC-H | §239 | Provider timeout/outage/retry tests proving controlled errors and no false booking success or partial commit. |

## Update procedure

After each vertical slice, split affected rows as needed and record concrete file paths, named tests, exact commands, results, and the narrowest truthful status. Never infer verification from file presence.
