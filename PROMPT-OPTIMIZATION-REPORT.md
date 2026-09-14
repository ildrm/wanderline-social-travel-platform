# Sol High Prompt Optimization Report

## Deliverable

`PROMPT-SOL-HIGH.md` is the ready-to-use prompt. Run it from the target repository root with the Sol model and reasoning effort set to High.

## What changed

The original 250-section specification is preserved. A higher-priority execution contract was added to:

- distinguish verified features from scaffolding and unverified implementations;
- deliver dependency-ordered vertical slices instead of shallow repository-wide boilerplate;
- preserve existing stacks, working code, and uncommitted user changes;
- persist cross-turn state in `docs/execution-state.md`;
- constrain sub-agent ownership and require coordinator verification;
- define truthful behavior for unavailable credentials and provider adapters;
- fail closed if fake payment, identity, or safety providers reach production;
- require qualified, auditable approval before publishing AI-generated high/extreme-risk safety guidance;
- define evidence-based testing, review, handoff, and stop conditions.

The final meta-request to optimize the prompt was removed, and the executable instruction `Begin implementation now.` remains.

## Static comparison

| Metric | Original | Revised |
|---|---:|---:|
| Estimated tokens | 21,438 | 23,545 |
| Token change | - | +9.83% |
| Structure score | 75 | 75 |

The static analyzer reports a clarity score of zero for both versions because it mechanically flags deliberate specification language such as “where appropriate.” This score is not a useful absolute quality measure for this domain specification; there was no score regression, and the revision remains within the 10% token-growth gate.

## Evaluation

`prompt-eval-cases.json` contains 15 adversarial execution cases covering empty and dirty repositories, multi-turn scope, offline version selection, planning-only failure, scaffold-only claims, payment credentials, last-seat concurrency, IDOR/location privacy, provider timeouts, test failures, sub-agent conflicts, high-risk AI guidance, fake production providers, and incomplete final reports.

A Sol model at High effort performed a semantic contract review after revision: **15/15 cases passed, with no blocking gap**. This validates instruction coverage; it is not a substitute for running the eventual generated application and its tests.

## Recommended use

1. Place `PROMPT-SOL-HIGH.md` in or attach it to the target repository session.
2. Select Sol and High reasoning effort.
3. Start the session at the repository root with tool access enabled.
4. On a fresh continuation session, attach the same prompt and say: `Continue from docs/execution-state.md. Reconcile it with the worktree and actual test state, then execute the next task.`
