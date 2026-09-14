# Permission matrix

**Status:** Accepted authorization baseline  
**Updated:** 2026-09-14

## Decision model

Authorization is deny-by-default and evaluated server-side. A role grants eligibility to attempt an action; it never grants unconditional row access. The policy decision also evaluates subject/ownership, organization, journey membership and state, staff assignment, data classification, purpose, jurisdiction, block relationships, reauthentication, and resource attributes.

Visibility labels (`PUBLIC`, `MEMBERS`, `APPLICANTS`, `ACCEPTED_PARTICIPANTS`, `TRIP_STAFF`, `SAFETY_STAFF`, `PLATFORM`, `PRIVATE`) are policy inputs, not frontend display hints. APIs and projections must omit unauthorized fields.

## Role catalog

| Scope | Roles |
|---|---|
| Public/platform | Guest; Registered Traveler; Verified Traveler; Organizer; Professional Organizer; API Partner |
| Organization | Organization Owner; Organization Admin; Organization Staff, refined as Tour Manager, Guide, Finance, Support, Staff |
| Journey | Owner; Co-organizer; Guide; Assistant Guide; Driver; Safety Officer; Medical/Safety Contact; Finance Manager; Accommodation Coordinator; Transport Coordinator; Meal Coordinator; Photographer; Participant |
| Operations | Moderator; Trust & Safety Analyst; Verification Agent; Customer Support Agent; Finance/Dispute Agent; Compliance Administrator; Content Administrator; System Administrator; Super Administrator |

`Super Administrator` is a rare break-glass/control-plane role, not a universal data-reader. `System Administrator` operates infrastructure and cannot read user content by default. API Partners receive explicit scopes, tenant/resource restrictions, expiry, rotation and revocation.

## Core matrix

| Resource / action | Allow | Required context and explicit denies |
|---|---|---|
| Public journey/profile read | Guest and higher | Only a server-built C0 projection; respect publication state, field visibility, blocks, search/index policy and approximate location |
| Private profile read/update | Subject | Reauthenticate for identity/security changes; no role may edit another subject's private profile |
| Applicant-visible journey read | Applicant subject; assigned journey staff | Application is active and visibility permits it; exact location, participant list and C3 fields remain denied |
| Accepted journey detail read | Confirmed/accepted Participant; assigned journey staff | Active membership and field policy; exact meeting point only at configured state/time; blocked/removed members denied |
| Temporary live location publish/read | Subject publisher / expressly selected accepted members or staff | Separate time-bound opt-in and revocation; never inferred from journey membership; Guest, applicants, general admins and analytics denied |
| Journey create | Registered Traveler; Organizer; Professional Organizer; authorized Organization Tour Manager | Adult/region rules and organization scope pass; commercial mode requires verified professional authority |
| Journey draft update | Owner; Co-organizer; authorized Tour Manager | State permits editing; field-specific staff actions use narrower rows below; every material change versioned |
| Journey publish/state transition | Owner; Co-organizer with permission; authorized Tour Manager | Lifecycle transition, completeness, regional, safety and commercial gates pass; high/extreme safety content needs qualified approval |
| Journey delete/archive | Owner; authorized Organization Owner/Admin | Retention/booking/legal constraints; no destructive deletion of financial, consent or incident evidence |
| Preview as audience | Owner; Co-organizer; authorized privacy reviewer | Render through the actual audience policy without impersonating or granting access; C3 source fields excluded unless that audience could see them |
| Route/stops/transport edit | Owner; Co-organizer; Transport Coordinator; authorized Tour Manager | Coordinator limited to assigned journey/transport fields; material changes create version/impact analysis |
| Activity/eligibility edit | Owner; Co-organizer; Guide; authorized Tour Manager | Guide scope must be assigned; cannot access raw private safety evidence; discriminatory/sensitive rules prohibited |
| High/extreme AI safety draft approve | Assigned Safety Officer or Medical/Safety Contact with configured, current qualification | Reauthentication; exact content version, qualification basis, timestamp and decision audited; owner alone is insufficient unless separately qualified/assigned |
| Meal plan/choice read | Subject sees own; Meal Coordinator sees operational choices; Owner/Co-organizer sees aggregate/necessary roster | Health/allergy detail stays C3 and is disclosed only when necessary; Finance, Photographer and unrelated staff denied |
| Accommodation/room allocation | Subject sees own; Accommodation Coordinator, Owner, Co-organizer manage assigned journey | Allocation is never public; household/room preferences minimized; unrelated staff and participants denied |
| Transport roster/booking reference | Subject sees own; Transport Coordinator, Owner, Co-organizer manage assigned journey | Public/applicants denied; provider secrets and other participants' unnecessary references omitted |
| Equipment inventory/assignment | Subject sees own assignment; Guide/Assistant Guide or assigned equipment-capable Organization Staff manage | Atomic assignment; deposits routed to Finance; serial/condition data is not public |
| Application submit/read/withdraw | Applicant subject; Owner/Co-organizer/Tour Manager reads necessary answers | Eligibility/application window and block rules; abusive sensitive questions rejected; staff see status assertions rather than evidence |
| Application accept/reject/waitlist | Owner; Co-organizer; authorized Tour Manager | Atomic capacity, valid transition, reason/audit, no payment success inference; applicant cannot self-approve |
| Participant roster read | Accepted Participant sees privacy-limited roster; assigned journey staff sees task-needed fields | Guest/applicant denied; contact, exact location, C3 and dependent details follow field policies |
| Journey role assignment | Owner; authorized Organization Owner/Admin/Tour Manager | Assigner may grant only permissions held/delegable; safety/finance roles require qualification/organization checks; audit required |
| Private safety profile manage | Subject | Assigned qualified Safety Officer/Medical Contact may read only journey-relevant fields with purpose, reauth and audit; organizers, guides, support and general admins denied |
| Safety incident create | Participant and assigned staff for involved journey; Trust & Safety Analyst | Creator need not see all case data after submission; evidence classified/restricted |
| Safety incident read/update | Assigned Safety Officer/Medical Contact; assigned Trust & Safety Analyst | Case assignment, purpose, reauthentication and read audit; general journey owner/organization/admin/support denied unless explicitly assigned |
| SOS/check-in action | Subject; assigned journey safety staff may initiate configured participant check-in | No automatic emergency-authority contact without supported policy; location sharing remains opt-in |
| Trusted contact manage | Subject | Contact does not become a platform participant; organizer/admin cannot add themselves or expand sharing |
| Message/channel read/write | Channel member satisfying current journey/application relationship | Per-message/channel membership; blocks, removal and rate rules; admins/support cannot browse content by default |
| Announcement/emergency message | Owner; Co-organizer; authorized Guide/Safety Officer | Priority permission and audit; translated content preserves source; required acknowledgment is explicit |
| Message moderation evidence read | Assigned Moderator or Trust & Safety Analyst | Report/case scope, reason and audit; only necessary excerpts/attachments, not unrestricted conversation history |
| Community/meetup manage | Community owner/moderator or meetup organizer | Membership, adult/romantic opt-in, guardian and block policies; minors excluded from romantic discovery |
| Block/report | Subject | Always available against eligible target; target is not told unnecessary blocker/report details; staff cannot remove a block to facilitate contact |
| Moderation case decide | Assigned Moderator or Trust & Safety Analyst | Policy/reason/evidence, separation from appeal reviewer where practicable, audit; reporter/subject cannot decide |
| Moderation appeal decide | Different assigned Moderator/Trust & Safety Analyst with appeal permission | Prior decision evidence read-only; outcome and reason audited |
| Identity evidence upload/read | Subject uploads; assigned Verification Agent or provider adapter reads | Private signed access, reauth and read audit; organizer receives status only; general admin/support denied |
| Verification decision | Assigned Verification Agent or verified provider callback | Legal transition, evidence hash/reference, expiry and audit; subject cannot set status |
| Document vault file read | Subject; explicitly authorized verifier/safety role for a named verification purpose | Short-lived signed URL, scan complete, purpose and audit; journey owner receives verified fact unless raw document is strictly required |
| Price/cancellation policy edit | Owner/Co-organizer for social; Professional Organizer or authorized Finance/Tour Manager for commercial | Before purchase or via versioned future-effective change; accepted booking retains policy version |
| Payment initiate/view | Payer sees own; Finance Manager/authorized Organization Finance sees scoped status | Provider-hosted/tokenized flow; no PAN/CVV; staff cannot mark paid or alter provider result |
| Refund request | Payer subject; organizer finance role may propose | Policy version and amount validated; request is not success |
| Refund/payout execute | Finance/Dispute Agent or authorized Organization Finance through provider workflow | Strong reauth, idempotency, separation of duties for thresholded operations, ledger transaction and audit; support/organizer cannot directly mutate state |
| Ledger read | Subject sees own statement; authorized Organization Finance sees organization ledger; Finance/Dispute Agent sees assigned case | Purpose-bound; immutable entries; health/message/identity content absent |
| Ledger correction | Finance/Dispute Agent with correction permission | Compensating balanced entry only; original immutable; reauth and audit |
| Payout account change | Authorized Organization Owner/Finance | MFA/re-authentication, verification, cooling/security notification, dual approval where policy requires; journey staff/support denied |
| Review submit/reveal | Verified completed Participant or Organizer counterpart | One review per eligible relationship; double-blind reveal rule; subject cannot reveal early |
| Memories/media publish | Content owner with depicted-person consent and journey policy | Defaults private/participants; completion never auto-publishes exact historical itinerary or participant images |
| Support case read/update | Subject sees own safe view; assigned Customer Support Agent sees minimum case data | Linked C3, messages, documents, ledger or incidents require specialized role/handoff; all reads audited where sensitive |
| Public content manage/publish | Content Administrator; Compliance Administrator for legal/policy documents | Versioning and locale; legal content needs appropriate approval; no access to user private data |
| Regional policy/consent/waiver version publish | Compliance Administrator | Versioned, jurisdiction-scoped, immutable acceptance history; feature flag cannot weaken mandatory control |
| Provider configuration operate | System Administrator | Secret references only, not secret values; cannot fabricate domain success; security-sensitive changes audited |
| Feature flag operate | System Administrator or authorized product operator; Compliance for regulated flags | Server-side scope; security/authorization controls cannot be disabled by ordinary flag |
| Audit log read | Assigned Compliance Administrator, Trust & Safety Analyst, Finance/Dispute Agent, or Security operator for their domain | Narrow event types, reason, time window and audit-of-audit; user content and C4 values absent |
| Analytics read | Professional Organizer for own aggregate; authorized Admin analyst for aggregate | Minimum cohort thresholds and pseudonymous events; C3, exact location, raw messages/documents excluded |
| Data export | Subject; Compliance Administrator may execute assigned rights case | Ownership-aware redaction, secure delivery, C4 exclusion, audit; no other user's data |
| Data deletion/restriction | Subject requests; Compliance Administrator executes policy workflow | Legal retention and third-party rights evaluated; derived copies tombstoned; truthful completion report |
| Production impersonation | Denied to all roles | Role preview uses policy simulation; support assistance uses scoped tools. Any exceptional break-glass capability requires a separate accepted security ADR and technical control set |

## Staff field boundaries

| Journey role | May access | Explicitly excluded unless another separately assigned role allows it |
|---|---|---|
| Guide / Assistant Guide | Assigned activity plans, attendance, equipment readiness, public/participant itinerary | Health detail, identity evidence, payments/payouts, private messages, room preferences |
| Driver | Assigned transport leg, necessary pickup location/time and checked-in passenger names | Health, identity documents, payments, unrelated itinerary/private profile |
| Safety Officer / Medical Contact | Assigned risk plan, briefing/readiness status, necessary private safety fields, incidents | Identity evidence, payouts, unrelated messages, marketing/analytics |
| Finance Manager | Price, payment/refund/payout status, ledger and invoice fields for assigned journey | Health/safety detail, identity document images, private messages, room/meal details beyond charge context |
| Accommodation Coordinator | Accommodation roster, accessibility needs explicitly shared for accommodation, room assignment | Payment instruments, identity evidence, private safety profile, unrelated messages |
| Transport Coordinator | Transport roster, necessary accessibility needs and booking references | Health detail, identity evidence, financial accounts, unrelated messages |
| Meal Coordinator | Meal selections and minimum necessary allergy handling | Identity documents, payments, full health profile, exact unrelated location |
| Photographer | Schedule, public/participant itinerary, recorded media consent status | Private safety/health, identity, finance, room allocation, unshared contact details |

## Enforcement and verification

- Policies live in backend application/domain authorization services and apply to HTTP, jobs, websocket subscriptions, exports, admin tools and AI retrieval.
- Repository queries are scoped before materialization; serializers are an additional guard, not the primary boundary.
- C3 reads emit an audit record with actor, subject/resource, purpose, decision, correlation ID and time, never protected content.
- Role and membership changes revoke sessions/channel grants/cached permissions promptly.
- Automated tests cover each allow path and adjacent deny paths, cross-tenant IDs, stale roles, state changes, blocks, direct repository access, and acceptance scenario F.
