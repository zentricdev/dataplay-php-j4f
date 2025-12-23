.PHONY: lint pint phpstan terminator help

PINT = ./vendor/bin/pint
PHPSTAN = ./vendor/bin/phpstan

lint: pint phpstan composer-validate

composer-validate:
	@composer validate --strict

pint:
	@$(PINT)

phpstan:
	@$(PHPSTAN)

terminator:
	@echo
	@php ./src/SkyNet/Command.php
	@echo

help:
	@echo "+-----------------+------------------------------------------+"
	@echo "| Command         | Description                              |"
	@echo "+-----------------+------------------------------------------+"
	@echo "| make terminator | Instantiate T-800 and accomplish mission |"
	@echo "+-----------------+------------------------------------------+"

# Catch-all para que no de error al pasar argumentos
%:
	@:
