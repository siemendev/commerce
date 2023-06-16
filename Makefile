start:
	cd demo/symfony; symfony server:start -d

stop:
	cd demo/symfony; symfony server:stop

update:
	cd packages; for PACKAGE in *; do cd $$PACKAGE; echo "composer update: $$PACKAGE"; composer update; cd ..; done
	cd demo; for DEMO in *; do cd $$DEMO; composer update; cd ..; done

phpstan:
ifndef DIR
	@for PACKAGE in packages/*; do make DIR=$$PACKAGE phpstan; done
else
	@echo "phpstan: $$DIR"
	@phpstan analyse $$DIR/src --level 9 -a $$DIR/vendor/autoload.php -c phpstan.neon || echo "operation failed, fix it and try it with: \"make DIR=$$DIR phpstan-package\""
endif

cs-fixer:
ifndef DIR
	php-cs-fixer fix --path-mode=intersection $$DIR
else
	@php-cs-fixer fix
endif
