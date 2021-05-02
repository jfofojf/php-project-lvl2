install:
	composer install
update:
	composer update
lint:
	composer exec -v phpcs -- --standard=PSR12 src bin tests
test:
	composer exec --verbose phpunit tests
