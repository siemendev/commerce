start:
	cd demo/symfony; symfony server:start -d

stop:
	cd demo/symfony; symfony server:stop

update:
	cd packages; for PACKAGE in *; do cd $$PACKAGE; echo "composer update: $$PACKAGE"; composer update; cd ..; done
	cd demo; for DEMO in *; do cd $$DEMO; composer update; cd ..; done

phpstan-package:
	cd $$DIR; phpstan analyse src --level 9
