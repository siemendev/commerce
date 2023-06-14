start:
	cd demo/symfony; symfony server:start -d

stop:
	cd demo/symfony; symfony server:stop

update:
	cd packages; for PACKAGE in *; do cd $$PACKAGE; echo "composer update: $$PACKAGE"; composer update; cd ..; done
	cd demo; for DEMO in *; do cd $$DEMO; composer update; cd ..; done

phpstan-package:
	docker run --rm -v $$(pwd)/$$DIR:/app ghcr.io/phpstan/phpstan:latest-php8.2 analyse src --level 9 -a vendor/autoload.php
