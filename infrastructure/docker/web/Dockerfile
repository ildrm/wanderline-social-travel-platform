FROM node:24-alpine AS base
ENV NEXT_TELEMETRY_DISABLED=1
WORKDIR /workspace

FROM base AS development
ARG TARGETARCH
COPY package.json package-lock.json ./
COPY apps/web/package.json apps/web/package.json
RUN --mount=type=cache,target=/root/.npm npm ci \
    && case "${TARGETARCH}" in amd64) oxide_arch=x64 ;; arm64) oxide_arch=arm64 ;; *) exit 1 ;; esac \
    && oxide_version="$(node -p "JSON.parse(require('fs').readFileSync('apps/web/node_modules/@tailwindcss/oxide/package.json')).version")" \
    && npm install --no-save --package-lock=false --prefix apps/web "@tailwindcss/oxide-linux-${oxide_arch}-musl@${oxide_version}" \
    && cp "apps/web/node_modules/@tailwindcss/oxide-linux-${oxide_arch}-musl/tailwindcss-oxide.linux-${oxide_arch}-musl.node" \
        "apps/web/node_modules/@tailwindcss/oxide/tailwindcss-oxide.linux-${oxide_arch}-musl.node" \
    && sha256sum package-lock.json | awk '{print $1}' > node_modules/.package-lock.sha256
COPY infrastructure/docker/entrypoints/web-development.sh /usr/local/bin/web-development
RUN chmod 0755 /usr/local/bin/web-development
COPY . .
ENTRYPOINT ["/usr/local/bin/web-development"]
CMD ["npm", "run", "dev", "--workspace=apps/web", "--", "--hostname", "0.0.0.0"]

FROM base AS dependencies
ARG TARGETARCH
COPY package.json package-lock.json ./
COPY apps/web/package.json apps/web/package.json
RUN --mount=type=cache,target=/root/.npm npm ci \
    && case "${TARGETARCH}" in amd64) oxide_arch=x64 ;; arm64) oxide_arch=arm64 ;; *) exit 1 ;; esac \
    && oxide_version="$(node -p "JSON.parse(require('fs').readFileSync('apps/web/node_modules/@tailwindcss/oxide/package.json')).version")" \
    && npm install --no-save --package-lock=false --prefix apps/web "@tailwindcss/oxide-linux-${oxide_arch}-musl@${oxide_version}" \
    && cp "apps/web/node_modules/@tailwindcss/oxide-linux-${oxide_arch}-musl/tailwindcss-oxide.linux-${oxide_arch}-musl.node" \
        "apps/web/node_modules/@tailwindcss/oxide/tailwindcss-oxide.linux-${oxide_arch}-musl.node"

FROM base AS builder
ARG NEXT_PUBLIC_APP_URL
COPY --from=dependencies /workspace/node_modules ./node_modules
COPY --from=dependencies /workspace/apps/web/node_modules ./apps/web/node_modules
COPY . .
ENV NODE_ENV=production \
    NEXT_PUBLIC_APP_URL=${NEXT_PUBLIC_APP_URL}
RUN test -n "${NEXT_PUBLIC_APP_URL}" \
    && case "${NEXT_PUBLIC_APP_URL}" in http://*|https://*) ;; *) exit 1 ;; esac \
    && npm run build --workspace=apps/web

FROM node:24-alpine AS runtime
ENV NODE_ENV=production \
    NEXT_TELEMETRY_DISABLED=1 \
    PORT=3000 \
    HOSTNAME=0.0.0.0
RUN addgroup --system --gid 1001 nodejs \
    && adduser --system --uid 1001 nextjs
WORKDIR /app
COPY --from=builder --chown=nextjs:nodejs /workspace/apps/web/public ./apps/web/public
COPY --from=builder --chown=nextjs:nodejs /workspace/apps/web/.next/standalone ./
COPY --from=builder --chown=nextjs:nodejs /workspace/apps/web/.next/static ./apps/web/.next/static
COPY --from=builder /workspace/infrastructure/docker/healthchecks /healthchecks
USER nextjs
EXPOSE 3000
HEALTHCHECK --interval=15s --timeout=5s --start-period=20s --retries=3 CMD ["/healthchecks/web.sh"]
CMD ["node", "apps/web/server.js"]
