# 🛠️ Development

dev-php:
	docker run --rm --network portfolio-manager-symfony_default -v $(PWD):/app -w /app --user 1000:1000 -it dev-php sh

migrate-db:
	docker run --rm --network portfolio-manager-symfony_default -v $(PWD):/app -w /app dev-php php bin/console doctrine:migration:migrate

# 🧪 Test

create-db-test:
	docker compose down
	docker run -d --name temp-mariadb --rm -v $(PWD)/data/db:/var/lib/mysql:Z -e MARIADB_ALLOW_EMPTY_ROOT_PASSWORD=true mariadb:10.6 
	docker exec temp-mariadb bash -c "\
		until mysqladmin ping -h 127.0.0.1 --silent; do sleep 1; done && \
		mysql -h 127.0.0.1 -u root -e \"\
			CREATE DATABASE IF NOT EXISTS portfolio_manager_test;\
			GRANT ALL PRIVILEGES ON portfolio_manager_test.* TO 'portfolio_manager'@'%';\
			FLUSH PRIVILEGES;\""
	docker stop temp-mariadb 

test:
	-@make create-db-test
	docker compose up -d
	docker run --rm --network portfolio-manager-symfony_default -v $(PWD):/app -w /app dev-php sh -c "\
		php vendor/bin/phpstan --memory-limit=256M && \
		php bin/console doctrine:migration:migrate --env test && \
		php bin/phpunit"

# 🐳 Docker

build-dev-php:
	docker build -t dev-php docker/php