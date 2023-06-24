-include .env

SUCCESS = "[\\033[32m✓\\033[0m] "
ERROR = "[\\033[31m✗\\033[0m] "
INFO = "[\\033[34mℹ\\033[0m] "
WARN = "[\\033[33m⚠\\033[0m] "
QUESTION = "[\\033[36m?\\033[0m] "

SEPERATOR = "\\033[90m...........................................\\033[0m"
NEW_LINE = "\\n"


help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

#region Defines
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

define check-requirements
	@which php > /dev/null || (echo "$(ERROR) PHP is not installed. Please install PHP first.")
	@which composer > /dev/null || (echo "$(ERROR) Composer is not installed. Please install Composer first.")
	@which docker > /dev/null || (echo "$(ERROR) Docker is not installed. Please install Docker first.")
	@which docker-compose > /dev/null || (echo "$(ERROR) Docker Compose is not installed. Please install Docker Compose first.")
	@which sed > /dev/null || (echo "$(ERROR) sed is not installed. Please install sed first.")
	$(call infoLine, "All requirements are met")
endef

define install-php
	$(call infoLine, "Checking PHP...")
	@which php > /dev/null || (echo "$(ERROR) PHP is not installed. Installing PHP..." && brew install php && $(call successLine, "PHP installed"))
endef

define install-composer
	$(call infoLine, "Checking Composer...")
	@which composer > /dev/null || (echo "$(ERROR) Composer is not installed. Installing Composer..." && brew install composer && $(call successLine, "Composer installed"))
endef

define install-docker
	$(call infoLine, "Checking Docker...")
	@which docker > /dev/null || (echo "$(ERROR) Docker is not installed. Installing Docker..." && brew install docker && $(call successLine, "Docker installed"))
endef

define install-docker-compose
	$(call infoLine, "Checking Docker Compose...")
	@which docker-compose > /dev/null || (echo "$(ERROR) Docker Compose is not installed. Installing Docker Compose..." && brew install docker-compose && $(call successLine, "Docker Compose installed"))
endef

define install-sed
	$(call infoLine, "Checking sed...")
	@which sed > /dev/null || (echo "$(ERROR) sed is not installed. Installing sed..." && brew install sed && $(call successLine, "sed installed"))
endef

define create-env-files
	$(call seperatorLine)
	$(call infoLine, "Checking .env file for Docker...")
	@if [ ! -f .env ]; then \
			read -p "[?]   Enter your desired NGINX port [default: 80]: " NGINX_PORT; \
			read -p "[?]   Enter your desired Redis port [default: 6379]: " REDIS_PORT; \
			read -p "[?]   Enter your desired MySQL port [default: 3306]: " MYSQL_PORT; \
			read -p "[?]   Enter your desired Database name: " MYSQL_DATABASE; \
			read -p "[?]   Enter your desired Database username: " MYSQL_USER; \
			read -p "[?]   Enter your desired Database password: " MYSQL_PASSWORD; \
			NGINX_PORT=$${NGINX_PORT:-80}; \
			REDIS_PORT=$${REDIS_PORT:-6379}; \
			MYSQL_PORT=$${MYSQL_PORT:-3306}; \
			cp .env.example .env; \
			echo "CREATE DATABASE IF NOT EXISTS $${MYSQL_DATABASE};GRANT ALL PRIVILEGES ON $${MYSQL_DATABASE}.* TO '$${MYSQL_USER}'@'localhost';" >> ./docker/mysql/init.sql; \
			sed -i '' "s/NGINX_PORT=/NGINX_PORT=$$NGINX_PORT/g" .env; \
			sed -i '' "s/REDIS_PORT=/REDIS_PORT=$$REDIS_PORT/g" .env; \
			sed -i '' "s/MYSQL_PORT=/MYSQL_PORT=$$MYSQL_PORT/g" .env; \
			sed -i '' "s/MYSQL_DATABASE=/MYSQL_DATABASE=$$MYSQL_DATABASE/g" .env; \
			sed -i '' "s/MYSQL_USER=/MYSQL_USER=$$MYSQL_USER/g" .env; \
			sed -i '' "s/MYSQL_PASSWORD=/MYSQL_PASSWORD=$$MYSQL_PASSWORD/g" .env; \
			$(call successLine, "Created /.env file"); \
		else \
			$(call warnLine, "/.env file already exists. No further action taken"); \
		fi
	$(call seperatorLine)
	$(call infoLine, "Checking .env file for Laravel...")
	@if [ ! -f ./src/.env ]; then \
			cp ./src/.env.example ./src/.env; \
			sed -i '' "s/DB_HOST=127.0.0.1/DB_HOST=mysql/g" ./src/.env; \
			sed -i '' "s/DB_PORT=3306/DB_PORT=${MYSQL_PORT}/g" ./src/.env; \
			sed -i '' "s/DB_DATABASE=laravel/DB_DATABASE=${MYSQL_DATABASE}/g" ./src/.env; \
			sed -i '' "s/DB_USERNAME=root/DB_USERNAME=${MYSQL_USER}/g" ./src/.env; \
			sed -i '' "s/DB_PASSWORD=/DB_PASSWORD=${MYSQL_PASSWORD}/g" ./src/.env; \
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
#endregion


#region Targets
build: ## Build the project
	$(call infoLine, "Checking requirements...")
	$(call check-requirements)
	@make install-requirements
	$(call seperatorLine)
	$(call infoLine, "Building case study...")
	$(call create-env-files)
	$(call install-composer-dependencies)
	$(call build-containers)
	$(call seperatorLine)
	@echo "$(SUCCESS) Done. You may reach the swagger documentation at http://localhost:$(NGINX_PORT)/api/documentation"

install-requirements: ## Install all requirements
	@which brew > /dev/null || (echo "$(ERROR) brew is not installed. Please install brew first." && exit 1001)
	$(call infoLine, "Installing requirements...")
	$(call install-php)
	$(call install-composer)
	$(call install-docker)
	$(call install-docker-compose)
	$(call install-sed)
	$(call seperatorLine)
	$(call infoLine, "All requirements are met")
#endregion
