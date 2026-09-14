# ADR-0005: Separate restricted data stores and purpose-bound access

- **Status:** Accepted
- **Date:** 2026-09-14
- **Deciders:** Privacy and security architecture

## Context

The platform may hold exact future locations, health/allergy details, dependent/minor records, identity evidence, incidents, travel documents and payout references. Combining them with public profiles or broad admin models would magnify accidental disclosure and make least privilege ineffective.

## Decision

Separate public profile, private personal, identity/verification, private safety, document and financial data into distinct tables, repositories, services and private object namespaces. Restricted fields use application-level envelope encryption where values must be stored, with data-encryption keys protected by an external KMS/key-management boundary. Passwords remain one-way hashed; prohibited cardholder data is never stored.

Access requires data-class, relationship, assigned role, resource state and declared purpose checks. Restricted staff reads require recent authentication, reason and audit. Search, general analytics, logs, recommendations and AI exclude restricted content by default. Expose minimal verified facts instead of source documents whenever possible.

## Consequences

- More joins and explicit application coordination are accepted for lower blast radius.
- Data lifecycle jobs must delete/tombstone derived copies across object storage, cache, search, CDN, analytics and offline packs.
- Backup/restore procedures reapply tombstones and preserve encryption-key recoverability.
- General administrators and support staff have no implicit access to restricted content.

## Alternatives considered

- One users/profile table with encrypted columns: rejected because repository/admin/query access stays overly broad.
- Database-at-rest encryption only: rejected as insufficient against application-level overreach or broad database access.
- Duplicate restricted data into analytics/search for convenience: rejected.
