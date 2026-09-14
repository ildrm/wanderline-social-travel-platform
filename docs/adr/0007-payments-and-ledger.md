# ADR-0007: Tokenized provider payments with immutable double-entry ledger

- **Status:** Accepted
- **Date:** 2026-09-14
- **Deciders:** Payments, finance and security architecture

## Context

Professional tours require deposits, balance payments, refunds, disputes, organizer payouts and reconciliation under concurrent retries and provider callbacks. Mutable booking rows cannot provide sufficient financial auditability, and storing cardholder data would expand PCI scope.

## Decision

Define separate `PaymentProvider` and `MarketplacePayoutProvider` ports; a Stripe/Stripe Connect adapter may be the reference implementation. Use provider-hosted or tokenized payment interfaces and never store PAN, CVV, track or sensitive authentication data. Represent money as integer minor units plus ISO currency; retain exchange-rate provider, timestamp and quote for historical conversions.

Model payment/booking state machines separately from an append-only balanced double-entry ledger. Normal operations cannot update/delete ledger entries; corrections create compensating transactions. Payment/refund/booking commands require idempotency keys. Callback ingress verifies signature and freshness, deduplicates in an inbox, transitions state transactionally and emits an outbox event. Reconciliation compares internal state with provider reports and surfaces discrepancies without fabricating success.

## Consequences

- Financial history is explainable and replay-safe, at the cost of more accounting-domain complexity.
- Capacity reservation, payment expiry and waitlist fallback require explicit transaction/state orchestration.
- Strong reauthentication, scoped finance roles, audit and separation of duties protect payout/refund changes.
- Development providers cover all outcomes but are technically blocked in production.

## Alternatives considered

- Derive balances from mutable bookings: rejected for audit and correction integrity.
- Store raw cards: prohibited.
- Treat webhook receipt as unconditional success: rejected; legal transitions, amount/currency and provider object ownership are verified.
