.PHONY: up down logs setup wpcli

up:
	docker compose up -d db wordpress

down:
	docker compose down

logs:
	docker compose logs -f wordpress db

setup:
	./scripts/setup-wordpress.sh

wpcli:
	docker compose run --rm --profile tools wpcli $(cmd)
