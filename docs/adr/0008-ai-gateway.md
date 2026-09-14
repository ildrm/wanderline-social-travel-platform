# ADR-0008: Central authorization- and privacy-aware AI gateway

- **Status:** Accepted
- **Date:** 2026-09-14
- **Deciders:** AI, privacy and safety architecture

## Context

AI features can extract a Journey Graph, assist organizers/participants, translate and parse search intent. They also risk prompt injection, unauthorized retrieval, sensitive-data transfer, hallucinated bookings/legal guidance and unsafe high-risk recommendations.

## Decision

All AI access passes through a backend AI gateway and provider port. Frontend components and domain models never call an AI provider. The calling application service supplies an already authorized, purpose-specific snapshot; the gateway classifies and minimizes it, redacts unnecessary PII, excludes restricted health/identity/document/location data by default, applies model/tool allowlists, and validates structured output at runtime.

AI output is untrusted, labeled draft content with confidence/unresolved questions. It cannot publish, message as a user, change paid bookings, decide discriminatory eligibility, certify safety or assert legal/booking facts. Material operations require explicit human confirmation. For high/extreme activities, generated equipment/risk/safety guidance requires approval by the assigned qualified safety role, recording approver, qualification basis, content version, timestamp and decision.

Store minimal pseudonymous usage/model/policy metadata; do not log sensitive prompts. Configure provider privacy controls and zero retention where available. The platform retains complete non-AI paths, and AI/provider outage cannot block trips, bookings or safety information.

## Consequences

- Central controls reduce leakage and inconsistent policy, while adding an application hop and deliberate context-building work.
- Authorization is checked before retrieval and again before any proposed action; prompt text cannot grant tools or data.
- Provider/model changes are isolated behind contracts and evaluation suites.
- AI quality never substitutes for domain validation, authoritative sources or qualified human review.

## Alternatives considered

- Direct browser-to-provider calls: rejected because secrets, authorization and private context cannot be controlled safely.
- Give models broad database/search access: rejected due to prompt injection and least-privilege failure.
- Autonomous agent execution for material operations: rejected for safety, legal, payment and impersonation risk.
