start:
	cd demo/symfony; symfony server:start -d

stop:
	cd demo/symfony; symfony server:stop

update:
	cd packages; for PACKAGE in *; do cd $$PACKAGE; echo "composer update: $$PACKAGE"; composer update; cd ..; done
	cd demo; for DEMO in *; do cd $$DEMO; composer update; cd ..; done

phpstan:
	for PACKAGE in packages/*; do make DIR=$$PACKAGE phpstan-package; done
phpstan-package:
	@echo "phpstan: $$DIR"
	@cd $$DIR; phpstan analyse src --level 9 -a vendor/autoload.php || echo "operation failed, fix it and try it with: \"make DIR=$$DIR phpstan-package\""

cs-fixer:
	for PACKAGE in packages/*; do make DIR=$$PACKAGE cs-fixer-package; done
cs-fixer-package:
	@echo "cs-fixer: $$DIR"
	@php-cs-fixer fix $$DIR --config=.php-cs-fixer.php || echo "operation failed, fix it and try it with: \"make DIR=$$DIR cs-fixer-package\""
