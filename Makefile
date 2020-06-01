COMPOSER ?= composer
PHP = php


help: Makefile
	@echo
	@echo " Choose a command run in minimal:"
	@echo
	@sed -n 's/^##//p' $< | column -t -s ':' |  sed -e 's/^/ /'
	@echo


lint:
	@echo "\n==> Validating all php files:"
	@find . -type f -name \*.php | while read file; do php -l "$$file" || exit 1; done


## ci: Run CI Checks
ci: lint
	@echo "All quality checks passed"


.PHONY: help
