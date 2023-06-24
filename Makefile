-include .env

SUCCESS = "[\\033[32m✓\\033[0m] "
ERROR = "[\\033[31m✗\\033[0m] "
INFO = "[\\033[34mℹ\\033[0m] "
WARN = "[\\033[33m⚠\\033[0m] "
QUESTION = "[\\033[36m?\\033[0m] "

SEPERATOR = "\\033[90m...........................................\\033[0m"
NEW_LINE = "\\n"


help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

define successLine
	echo "$(SUCCESS) $(1)"
endef

define errorLine
	echo "$(ERROR) $(1)"
endef

define infoLine
	@echo "$(INFO) $(1)"
endef

define warnLine
	echo "$(WARN) $(1)"
endef

define seperatorLine
	@echo "$(NEW_LINE)$(SEPERATOR)$(NEW_LINE) "
endef

build:
	$(call infoLine, "Checking requirements...")
	$(call check-docker)
	$(call seperatorLine)
	$(call infoLine, "Building case study...")
	$(call create-env-files)
	$(call install-composer-dependencies)
	$(call build-containers)
	@echo "$(SUCCESS) Done. You may reach the swagger documentation at http://localhost:$(NGINX_PORT)/api/documentation"

define check-docker
	@which docker > /dev/null || (echo "$(ERROR) Docker is not installed. Please install Docker first." && exit 0)
	@which docker-compose > /dev/null || (echo "$(ERROR) Docker Compose is not installed. Please install Docker Compose first." && exit 101)
endef

define create-env-files
	$(call seperatorLine)
	$(call infoLine, "Creating .env file for Docker...")
	@if [ ! -f .env ]; then \
			read -p "[?]   Enter your desired NGINX port: " NGINX_PORT; \
			read -p "[?]   Enter your desired Redis port: " REDIS_PORT; \
			cp .env.example .env; \
			sed -i '' "s/NGINX_PORT=/NGINX_PORT=$$NGINX_PORT/g" .env; \
			sed -i '' "s/REDIS_PORT=/REDIS_PORT=$$REDIS_PORT/g" .env; \
			$(call successLine, "Created /.env file"); \
		else \
			$(call warnLine, "/.env file already exists. No further action taken"); \
		fi
	$(call seperatorLine)
	$(call infoLine, "Creating .env file for Laravel...")
	@if [ ! -f ./src/.env ]; then \
			cp ./src/.env.example ./src/.env; \
			$(call successLine, "Created /src/.env file for Laravel"); \
		else \
			$(call warnLine, "/src/.env file already exists. No further action taken"); \
		fi
endef

define install-composer-dependencies
	$(call seperatorLine)
	$(call infoLine, "Installing Composer dependencies...")
	@cd ./src && composer install --no-interaction --no-progress --no-suggest --prefer-dist -vvv
	@cd ./src && php artisan key:generate
	@cd ..
endef

define build-containers
	$(call seperatorLine)
	$(call infoLine, "Building Docker containers...")
	@docker-compose up -d --build
endef
