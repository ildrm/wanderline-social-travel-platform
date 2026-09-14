# Explore visual fidelity ledger

**Reviewed:** 2026-09-14  
**Concept:** `docs/design/explore-desktop-concept.png`  
**Implementation evidence:** `docs/design/explore-desktop-render-v4.png`, `docs/design/explore-mobile-render-v7.png`

The in-app browser surface was unavailable, so the required browser-first check fell back to the installed Chrome browser through Playwright. The concept and both implementation renders were inspected together after the final production-asset update.

| Fidelity point | Concept intent | Implemented result | Disposition |
|---|---|---|---|
| Copy and information hierarchy | Editorial headline, compact search, filters, journey rail, selected-journey summary | Headline and control order match; four typed seed journeys replace the concept's five illustrative rows | Accepted for the first runnable slice; the UI states are driven by typed data rather than decorative filler |
| Desktop composition | Approximately 60/40 list-detail split with persistent map and detail pane | Responsive 3/2 grid, sticky full-height side pane, list selection reflected in detail | Matched |
| Mobile composition | Single-column search and journey cards with a floating map action | 390px render preserves hierarchy, 44px+ controls, full-width imagery, and fixed map control | Matched |
| Typography | High-contrast editorial serif display with restrained sans-serif UI text | Georgia-based display stack and Avenir/system UI stack reproduce hierarchy without an external font request | Intentional operational deviation; avoids build-time font-network dependency |
| Color and shape | White canvas, navy type, coral actions, pale sea/sage map, thin cool-gray rules | Tokenized global palette and radii closely match the concept across desktop and mobile | Matched |
| Journey imagery | Distinct, place-specific editorial travel photographs | Four production ImageGen assets with factual alt text; encoded as WebP (about 185–313 KB each) | Improved over initial repeated-image fixture |
| Map treatment | Geographic basemap with an Ankara–Europe route | Accessible schematic route with labeled approximate locations and no third-party tracking or API key | Intentional foundation-stage deviation; provider-backed geographic map remains a later slice |
| Interaction states | Search, filter, sort, selection, save, share, list/map switching | Query, date, style, chips, sorting, empty recovery, selection, save, Web Share/clipboard, and responsive map overlay are functional | Matched for local UI behavior |
| Responsive image loading | Every card remains visually complete while scrolling | Final 10-second mobile capture confirms all four optimized images decode; earlier capture exposed lazy-loading timing and was superseded | Resolved |

## Remaining product-level gaps

The Explore slice still uses typed local discovery fixtures while public discovery, privacy-filtered search projections, and a provider-backed geographic map are implemented in later milestones. Those are tracked as incomplete product work, not visual defects in this slice.
