# ADR-0002: First-party browser sessions with step-up authentication

- **Status:** Accepted
- **Date:** 2026-09-14
- **Deciders:** Identity and security architecture

## Context

The primary client is a first-party browser/PWA, while future mobile and scoped API partners must remain possible. The product handles location, identity, health and financial data and needs immediate session revocation, CSRF protection, device management and reauthentication.

## Decision

Use Laravel Sanctum or the equivalent Laravel 13 first-party facility for stateful browser authentication with `Secure`, `HttpOnly`, appropriately scoped `SameSite` cookies and CSRF tokens. Rotate session identifiers after authentication, privilege and security changes; store distributed revocable sessions through the supported session store. Require verified contact channels according to operation risk.

Support passkeys/WebAuthn and TOTP MFA through explicit identity ports and recovery controls. Sensitive actions—including payout account, password, MFA and identity changes—require recent reauthentication. Future mobile/partner access uses separately issued short-lived, scoped, rotatable and revocable tokens; browser sessions are not repackaged as long-lived JWTs.

## Consequences

- Browser tokens are not exposed to JavaScript and compromise can be revoked promptly.
- Cross-origin, cookie-domain and CSRF configuration become deployment-critical and receive integration tests.
- API partners/mobile require a dedicated token lifecycle rather than reusing browser cookies.
- Login, recovery and verification receive contextual Redis-backed throttles and audit/security notifications.

## Alternatives considered

- Long-lived JWTs in browser storage: rejected due to theft and revocation risk.
- OAuth-only identity: rejected because email/phone/password/passkey flows remain required; OAuth remains an optional provider-backed login method.
- Auth logic in Next.js: rejected because business authorization and session truth belong to the backend.
