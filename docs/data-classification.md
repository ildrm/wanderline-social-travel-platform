# Data classification and lifecycle

**Status:** Accepted conservative baseline  
**Updated:** 2026-09-14

This policy classifies data by harm from unauthorized disclosure or misuse. Regional law and a documented legal hold may require stricter handling or longer retention; they may not silently weaken access controls. Collection is disabled when no legitimate purpose and retention rule exist.

## Classes

| Class | Meaning | Examples | Minimum controls |
|---|---|---|---|
| C0 Public | Intentionally published, privacy-reviewed data | Public journey summary, approximate public place, published organizer business details | Integrity controls, abuse/rate protection, cache purge, publication audit |
| C1 Internal | Low-impact operational data not meant for public release | Feature configuration, non-sensitive provider health, taxonomy drafts | Authenticated staff/service access, normal encryption and logs |
| C2 Confidential | Personal or commercially sensitive data | Email, phone, application answers, private trip details, non-public messages, support cases | Purpose-bound authorization, TLS/at-rest encryption, no public cache, access minimization |
| C3 Restricted | High-harm data | Exact future/live location, government identity evidence, health/allergy details, private safety profile, incidents, payout/bank references, auth factors, precise minor data | Separate storage/repository, application-level envelope encryption where field data is stored, KMS separation, short-lived access, reason code, audit of reads/writes, no general analytics/search/LLM context |
| C4 Secret | Credentials that authenticate a user, service, or cryptographic operation | Password hashes, MFA seeds, session/access/refresh tokens, provider secrets, signing/encryption keys | Dedicated secret/credential stores, never logged/exported, rotation/revocation, keys outside encrypted values, break-glass procedure |

Passwords are one-way hashed rather than encrypted. Raw card numbers, CVV, track data, and sensitive authentication data are prohibited; provider tokens and status are C3.

## Data inventory and default lifecycle

Durations start at the named event and are enforced by scheduled deletion/anonymization jobs. A shorter configured regional period wins unless a lawful retention obligation applies.

| Data set | Class | Purpose and authorized audience | Default retention | Disposal / propagation |
|---|---|---|---|---|
| Public profile and published journey projection | C0 | Discovery; subject-controlled audiences | Until unpublished or account deletion | Remove projection immediately; purge cache/search/CDN within 24 hours |
| Exact meeting points, future itinerary and temporary live location | C3 | Accepted participants or assigned staff as policy permits | Meeting/route detail: 30 days after journey completion; live samples: 24 hours | Cryptographic/row deletion; invalidate offline packs, caches and signed URLs |
| Public approximate coordinates | C0 | Privacy-preserving discovery | While journey is publishable | Delete search projection and CDN/cache copy within 24 hours |
| Account contact and private personal profile | C2 | Account operation, verified support | Account lifetime plus 30-day recovery window | Delete or irreversibly anonymize, subject to fraud/legal restriction |
| Session and device records | C2/C4 | Authentication and takeover response | Active session plus 30 days; security login history 180 days | Revoke immediately; delete identifiers on expiry schedule |
| MFA seed/passkey private material | C4 | Authentication | Until factor removal/replacement | Immediate revocation and secure deletion; audit metadata retained separately |
| Verification status/fact | C2 | Eligibility/trust without revealing evidence | Account lifetime or until status expires, plus 180-day dispute window | Anonymize where no legal retention applies |
| Raw identity evidence | C3 | Provider/manual verification only | 30 days after decision unless a documented legal rule requires more | Delete object and derived previews; retain minimal decision/audit fact |
| Professional registration/license evidence | C3 | Trader and credential verification | Credential life plus 1 year | Delete evidence; retain verification and expiry history as legally required |
| Private safety profile and health/allergy detail | C3 | User safety and explicitly assigned safety staff | Journey-specific disclosure: 30 days after completion; reusable profile until revoked, reviewed every 12 months | Delete encrypted fields and derived copies; retain non-sensitive completion fact only |
| Dependent/minor details | C3 | Guardian-authorized family travel | Journey completion plus 30 days unless guardian keeps reusable profile | Delete/anonymize with guardian account workflow; never public/searchable |
| Application answers | C2; C3 if approved sensitive field | Organizer selection and eligibility | Rejected/withdrawn: 90 days; accepted: 30 days after journey completion | Field-level deletion; preserve only minimal state/audit facts |
| Messages and attachments | C2; C3 when safety evidence is formally preserved | Journey collaboration | 2 years after journey completion; user deletion hides sooner where lawful | Delete content/object and indexes; moderation evidence moves to restricted case store |
| Safety incidents and near-miss evidence | C3 | Response, investigation, lawful safety improvement | 7 years after case closure, subject to regional policy | Restricted deletion/anonymization review; legal holds explicit and audited |
| Reports, moderation and appeals | C2/C3 | Abuse prevention and due process | 3 years after case closure; severe fraud/safety cases 7 years | Minimize/anonymize reporters where possible; purge evidence separately |
| Tickets, visas, insurance, permits, certificates | C3 | Readiness/verification | 30 days after journey completion or document expiry, whichever is earlier, unless user explicitly keeps it | Delete private objects and signed links; retain verification fact until expiry |
| Booking references and reservations | C2/C3 | Fulfillment and support | 2 years after completion, then minimize; financial subset follows ledger period | Token/reference deletion or minimization; provider deletion where supported |
| Ledger, invoice, refund, payout and tax records | C3 | Accounting, disputes, regulatory obligations | 7 years after transaction by default; regional policy controls exact term | Restrict and minimize personal fields; never mutate ledger entries |
| Payment idempotency/inbox/webhook records | C2/C3 | Replay prevention and reconciliation | 2 years after final financial state; legally material evidence follows 7-year period | Delete payload; retain hashes, IDs and state necessary for audit |
| Support cases | C2/C3 | Resolve user issues | 2 years after closure; linked legal/safety evidence follows its case policy | Anonymize free text and delete attachments first |
| Audit records | C2/C3 metadata only | Security, privacy, financial and admin accountability | 7 years for high-impact records; 1 year for routine security access | Append-only/tamper-evident retention store; never include protected content |
| Structured application logs/traces | C1/C2 metadata only | Reliability and security | 30 days hot, 90 days total | Automatic expiry; scrub subject IDs where not operationally required |
| Analytics events | C1/C2 pseudonymous | Product/operational measurement | Raw: 13 months; aggregates: 25 months | Delete/pseudonymize subject key; no C3 payloads |
| AI request/response content | Maximum class after redaction must be C2 | User-requested drafting/extraction | Application copy: 30 days; provider retention configured to zero where available | Delete prompt/output; retain pseudonymous usage, model and policy decision metadata 13 months |
| Consent and waiver evidence | C2/C3 | Prove exact version and acceptance | 7 years after withdrawal/expiry or longer regional limitation period | Preserve immutable evidence; minimize IP/device metadata when not needed |
| Backups | Same as source | Recovery | 35-day rolling encrypted retention | Expire automatically; deleted data is not restored into live use and is re-tombstoned after restore |

## Handling rules

1. Every field has an owning context, purpose, class, audience, retention trigger, and deletion behavior before collection.
2. C3 stores use separate tables/repositories and private object prefixes/buckets. General admin, search, recommendation, analytics, logging, and cache paths cannot read them.
3. Authorization is evaluated server-side for the data class, subject relationship, journey state, assigned role, jurisdiction, and declared purpose. Staff C3 reads require reauthentication, a reason, and an audit record.
4. Exports include only the requesting subject's data and redact third-party content. C4 and third-party safety/identity evidence are excluded.
5. Signed URLs are short lived, single-purpose where supported, and never serve content after authorization or retention revocation.
6. Derived data inherits the highest source classification unless irreversibly aggregated or anonymized. Translation, thumbnails, search documents, offline packs, and AI context are derived copies.
7. Exact location becomes less useful after the operational need ends; publication does not automatically increase after completion.
8. Logs record stable event/correlation IDs and decisions, not protected values. Free-form payload logging is disabled at trust boundaries.
9. Retention deletion emits a tombstone event consumed by search, cache, CDN, analytics, storage, and offline-pack registries.

## Privacy review gate

Schema and API reviews reject any new field that lacks a documented purpose, class, audience, retention rule, and less-invasive alternative analysis. Verification status is preferred over storing or sharing source evidence.
