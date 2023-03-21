start:
	docker compose up -d

build:
	docker compose up -d && \
	docker compose exec php composer install && \
	docker compose exec php bin/console doctrine:migrations:migrate --no-interaction && \
	docker compose exec php bin/console doctrine:fixtures:load --no-interaction

build-test:
	docker compose up -d && \
	docker compose exec php bin/console doctrine:migrations:migrate --env=test --no-interaction && \
	docker compose exec php bin/console doctrine:fixtures:load --env=test --no-interaction

test:
	docker compose exec php bin/phpunit

php-cs-fix:
	docker compose exec php vendor/bin/php-cs-fixer fix

php-cs-fix-dry-run:
	docker compose exec php vendor/bin/php-cs-fixer fix --dry-run --diff

deptrac:
	docker compose exec php vendor/bin/deptrac --config-file=tests/Arch/modules.yaml && \
	docker compose exec php vendor/bin/deptrac --config-file=tests/Arch/cart.yaml && \
	docker compose exec php vendor/bin/deptrac --config-file=tests/Arch/product-management.yaml

console:
	docker compose exec php bash
