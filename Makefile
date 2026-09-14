SHELL := /bin/sh

.PHONY: bootstrap up down restart logs ps lint test build compose-config sbom clean

bootstrap:
	@./infrastructure/scripts/bootstrap-env.sh
	@docker compose build

up:
	@docker compose up -d --wait

down:
	@docker compose down --remove-orphans

restart: down up

logs:
	@docker compose logs --follow --tail=200

ps:
	@docker compose ps

lint:
	@docker compose run --rm api composer run lint
	@docker compose run --rm web npm run lint --workspace=apps/web

test:
	@docker compose run --rm api composer run test
	@docker compose run --rm web npm run test --workspace=apps/web

build:
	@docker compose build api web

compose-config:
	@docker compose config --quiet

sbom:
	@docker buildx build --target runtime --sbom=true --output=type=cacheonly -f infrastructure/docker/api/Dockerfile .
	@test -n "$(PUBLIC_WEB_ORIGIN)" || (echo "Set PUBLIC_WEB_ORIGIN to the production HTTPS origin" && exit 1)
	@docker buildx build --target runtime --build-arg NEXT_PUBLIC_APP_URL="$(PUBLIC_WEB_ORIGIN)" --sbom=true --output=type=cacheonly -f infrastructure/docker/web/Dockerfile .

clean:
	@docker compose down --remove-orphans
	@echo "Persistent database and object-storage volumes were retained. Use 'docker compose down --volumes' explicitly to remove local data."
