start:
	cd demo/symfony; symfony server:start -d

stop:
	cd demo/symfony; symfony server:stop

update:
	cd packages; for PACKAGE in *; do cd $$PACKAGE; echo "composer update: $$PACKAGE"; composer update; cd ..; done
	cd demo; for DEMO in *; do cd $$DEMO; composer update; cd ..; done

fixtures:
	rm -f demo/symfony/var/products/*.xml
	rm -f demo/symfony/var/gift-cards/*.xml
	cd demo/symfony; php bin/console commerce:product:add --id product-1 --no-interaction
	cd demo/symfony; php bin/console commerce:product:add --id product-2 --no-interaction
	cd demo/symfony; php bin/console commerce:product:add --id product-3 --no-interaction
	cd demo/symfony; php bin/console commerce:product:add --id product-4 --no-interaction
	cd demo/symfony; php bin/console commerce:giftcards:add --code 1234 --balance 50 --no-interaction
	cd demo/symfony; php bin/console commerce:giftcards:add --code 2345 --balance 2000 --no-interaction
	cd demo/symfony; php bin/console commerce:giftcards:add --code 3456 --balance 5000 --no-interaction

phpstan:
ifndef DIR
	@for PACKAGE in packages/*; do make DIR=$$PACKAGE phpstan; done
	@make DIR=demo/agnostic phpstan
else
	@echo "phpstan: $$DIR"
	@phpstan analyse $$DIR/src --level 9 -a $$DIR/vendor/autoload.php -c phpstan.neon || echo "operation failed, fix it and try it with: \"make DIR=$$DIR phpstan\""
endif

cs-fixer:
ifdef DIR
	@echo "running cs fixer on \"$$DIR\":"
	@php-cs-fixer fix --path-mode=intersection $$DIR
else
	@echo "running cs fixer on all files:"
	@php-cs-fixer fix
endif
