# Kubernetes production example

This Kustomize base demonstrates a conservative production shape: independent web/API workloads, queue workers, a singleton scheduler, explicit health gates, resource bounds, disruption budgets, autoscaling, default-deny network policy, and a migration job that is separate from process startup.

It assumes managed PostgreSQL/PostGIS, managed Redis, S3-compatible object storage, SMTP, a Kubernetes ingress controller, and a secret-management system. Before deployment, provision a Secret named `tour-platform-runtime` with these keys:

- `APP_KEY`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `REDIS_HOST`, `REDIS_PORT`, `REDIS_PASSWORD`
- `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_BUCKET`, `AWS_ENDPOINT`
- `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`

Do not create that Secret from a checked-in literal manifest or shell history. Use the organization's external-secrets, sealed-secrets, or cloud workload-identity workflow. Replace image tags with immutable registry digests and replace the public host/TLS secret with values controlled by the deployment environment.

`NEXT_PUBLIC_APP_URL` is compiled into canonical links and the sitemap during the web image build. Build the production web image with the exact public HTTPS origin; the Dockerfile rejects an omitted or non-HTTP(S) value:

```sh
docker build --target runtime \
  --build-arg NEXT_PUBLIC_APP_URL=https://tour-platform.example \
  -f infrastructure/docker/web/Dockerfile \
  -t ghcr.io/tour-platform/web:1.0.0 .
```

The same value remains in the runtime ConfigMap for server-rendered requests. Changing the public origin requires rebuilding and redeploying the web image; changing only the Kubernetes environment does not rewrite statically generated metadata.

Safe rollout order:

```sh
kubectl apply -f namespace.yaml
kubectl apply -k . --server-side --dry-run=server
kubectl apply -k . --server-side
kubectl wait --for=condition=complete job/tour-platform-migrate -n tour-platform --timeout=5m
kubectl rollout status deployment/tour-api -n tour-platform --timeout=5m
kubectl rollout status deployment/tour-web -n tour-platform --timeout=5m
kubectl rollout status deployment/tour-worker -n tour-platform --timeout=5m
```

If the migration fails, stop the rollout and inspect the job logs. Roll back application deployments to the previously verified image digest only when the migration is backward-compatible; otherwise follow the reviewed migration recovery procedure. Database backups and a restore drill are required before any destructive schema migration.
