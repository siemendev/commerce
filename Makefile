start:
	cd demo/symfony; symfony server:start -d

stop:
	cd demo/symfony; symfony server:stop

update:
	cd demo; for DEMO in *; do cd $$DEMO; composer update; cd ..; done
	cd packages; for PACKAGE in *; do cd $$PACKAGE; composer update; cd ..; done
