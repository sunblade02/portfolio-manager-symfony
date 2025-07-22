# 🛠️ Development

dev-php:
	docker run --rm -v $(PWD):/app -w /app --user 1000:1000 -it dev-php sh

php-serve:
	docker run -d --rm -p 8000:8000 -v $(PWD):/app -w /app dev-php php -S 0.0.0.0:8000 -t public

# 🐳 Docker

build-dev-php:
	docker build -t dev-php docker/php