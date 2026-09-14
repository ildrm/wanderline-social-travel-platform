# ADR-0003: PostgreSQL 18 and PostGIS for geospatial truth

- **Status:** Accepted
- **Date:** 2026-09-14
- **Deciders:** Data and GIS architecture

## Context

Journeys need relational transactions plus points, routes, bounds, radius/nearby search and privacy-aware map discovery. Capacity and financial workflows require strong consistency, and hidden exact coordinates must not leak through search payloads.

## Decision

Use PostgreSQL 18 as the system of record with PostGIS enabled. Store canonical WGS84 geometry/geography using SRID 4326, selecting geography for earth-distance queries and geometry for route/topology operations where appropriate. Add GiST indexes for supported spatial query patterns and relational/partial/compound indexes for lifecycle filters.

Store exact and public-approximate location as separate policy-governed values/projections. Queries select only the permitted precision. Use PostGIS for distance and containment rather than calculating large result sets in PHP. Flexible provider metadata may use constrained JSONB; searchable business facts remain modeled columns/tables.

## Consequences

- One transactional database supports relational and spatial invariants.
- Migrations must verify the extension, SRID, index use and production locking impact.
- Privacy-safe projection generation and deletion propagation are mandatory.
- Scaling begins with query/index tuning, caching and replicas; neither sharding nor table partitioning occurs without measured need.

## Alternatives considered

- Vendor map database as source of truth: rejected because it couples domain data to a provider.
- Elasticsearch/OpenSearch as primary geo store: rejected due to consistency and operational cost; a SearchProvider projection can be added later.
- Latitude/longitude calculations in application code: rejected for correctness and performance.
