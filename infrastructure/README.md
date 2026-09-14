# Infrastructure

This directory contains the development containers, production container targets, an example Kubernetes deployment, and a small OpenTelemetry/Prometheus/Grafana stack. Application code lives in `apps/api` and `apps/web`; containers never own source files.

## Local development

Prerequisites are Docker Engine with Compose v2, OpenSSL, and Make.

```sh
make bootstrap
make up
docker compose --profile observability up -d
```

The bootstrap command creates a mode-`0600`, git-ignored `.env` and generates a Laravel application key. Local ports bind only to loopback. The checked-in PostgreSQL, MinIO, and Mailpit credentials are local development values, not reusable production secrets.

Composer and npm dependencies live in Docker volumes so host operating systems cannot contaminate Linux native packages. Each development image records its lockfile fingerprint; container startup resynchronizes only a stale dependency volume. Rebuild the affected image after changing a lockfile (`docker compose build api worker scheduler` or `docker compose build web`) and the next `docker compose up` safely refreshes that volume.

Endpoints:

| Service | Local endpoint |
|---|---|
| Web | http://localhost:3000 |
| API | http://localhost:8080 |
| Mailpit | http://127.0.0.1:8025 |
| MinIO console | http://127.0.0.1:9001 |
| Prometheus (profile) | http://127.0.0.1:9090 |
| Grafana (profile) | http://127.0.0.1:3001 |

`make clean` retains persistent volumes. Removing volumes is intentionally a separate, explicit Docker Compose operation because it destroys local database, object-storage, mail, and telemetry data.

### Redis isolation

One development Redis process uses independent logical databases. Laravel must define named connections rather than using a shared default:

| DB | Concern | Failure/flush boundary |
|---:|---|---|
| 1 | cache and sessions | recomputable data |
| 2 | durable queue coordination | background jobs |
| 3 | rate-limit counters | abuse controls |
| 4 | transient presence | online/typing state |
| 5 | realtime coordination | WebSocket fan-out |

Logical databases isolate accidental key collisions and targeted flushes; they do not provide performance or security isolation. Production may use separate Redis clusters for queue durability, abuse controls, and ephemeral presence. Production Redis must use TLS, authentication, private networking, backups where state is durable, and a concern-appropriate eviction policy. The development server uses `noeviction` so silent loss is visible instead of being normalized.

## Images and production

The API `runtime` target runs Nginx and PHP-FPM as an unprivileged user. The web `runtime` target consumes Next.js standalone output and runs as an unprivileged user. Neither image runs database migrations at startup; deployments run the explicit migration job before rollout. Queue workers have a termination grace period so in-flight work can stop cleanly.

Production web builds require `--build-arg NEXT_PUBLIC_APP_URL=https://<public-origin>`. This origin is embedded into canonical links and the sitemap at build time. The Dockerfile fails when it is omitted or is not HTTP(S), preventing a production image from silently publishing localhost SEO metadata.

The Kubernetes example under `deployment/kubernetes` expects an externally managed Secret named `tour-platform-runtime`. It deliberately contains no secret values. Build images with the repository Dockerfiles, scan them, publish immutable digests, and replace the example version tags with those digests before applying. See the deployment README for the required key contract and rollout order.

## Observability

Applications send OTLP over HTTP to `otel-collector:4318` or gRPC to port `4317`. The collector batches telemetry, applies memory protection, emits local debug output, and exposes received metrics for Prometheus. Production should replace the debug exporter with authenticated trace/log/metric backends and set retention by data classification. Do not attach request bodies, credentials, precise private locations, document contents, or payment attributes to telemetry.

Useful checks:

```sh
docker compose config --quiet
docker compose ps
curl --fail http://127.0.0.1:8080/up
curl --fail http://127.0.0.1:9090/-/ready
```

The pinned container versions are the specification's September 2026 bootstrap baseline where explicit, plus compatible concrete versions selected for reproducibility. Dependabot proposes updates; a human must review changelogs, image provenance, vulnerability results, and application compatibility before merging.
