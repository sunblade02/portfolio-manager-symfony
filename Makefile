# 🛠️ Development

dev-php:
	docker run --rm -v $(PWD):/app -w /app --user 1000:1000 -it dev-php sh

php-serve:
	docker run -d --rm -p 8000:8000 -v $(PWD):/app -w /app --name php-container dev-php php -S 0.0.0.0:8000 -t public

db-serve:
	docker run -d --rm -p 3306:3306 \
		--env MARIADB_ALLOW_EMPTY_ROOT_PASSWORD=true \
		--env MARIADB_USER=portfolio_manager \
		--env MARIADB_PASSWORD=password \
		--env MARIADB_DATABASE=portfolio_manager \
		-v $(PWD)/data/db:/var/lib/mysql:Z --name mariadb-container mariadb:10.6

serve-all: db-serve php-serve

# 🐳 Docker

build-dev-php:
	docker build -t dev-php docker/php