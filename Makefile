cc: ## Clear cache
	php bin/console  c:c --env=dev
	php bin/console  c:c --env=prod


clear: ## Clearing ALL Query cache entries
	php bin/console doctrine:cache:clear-query  --env=dev        # Clearing ALL DEV Query cache entries
#	php bin/console doctrine:cache:clear-query-region --env=dev  # Clear a second-level cache query region.
	php bin/console doctrine:cache:clear-query  --env=prod       # Clearing ALL PROD Query cache entries
	php bin/console doctrine:cache:clear-result --env=prod       # Clearing ALL PROD Result cache entries
    #php bin/console doctrine:cache:clear-metadata --env=prod    # Clearing ALL PROD Metadata cache entries
    #php bin/console cache:clear --env=prod                      # Clearing the cache for the prod environment with debug false
    #php bin/console cache:pool:clear cache.app
	php bin/console doctrine:cache:clear-result --env=dev   --flush
	#php bin/console doctrine:cache:clear-query --env=dev    --flush
	#php bin/console doctrine:cache:clear-metadata --env=dev --flush



vendor:composer.json ## installé les dépendances
	composer install

help: ## afficher les description des commandes de makeFile
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-10s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

up:  ## construire les conteneurs docker
	docker-compose up

down:  ## éteindre les conteneurs docker
	docker-compose down


php:  ## Acceder au container php
	 docker exec -it BestPractice-php-fpm bash

mariadb:  ##  Acceder au container de mariadb
	docker exec -it BestPractice-mariadb  mysql -uroot -proot

access:  ## Acceder au container php avec les préviléges Root
	sudo docker exec -it BestPractice-php-fpm chmod -R 777 /application



test:  ## Lance les tests unitaire
	vendor/bin/simple-phpunit

reload:  ## reload database(delete,create,charge les données)
	php bin/console doctrine:schema:drop --force \
	&& php bin/console doctrine:schema:update --force \
	&& php bin/console doctrine:fixtures:load -n

php-cs-fixer: ## l'analyseeur du code php-cs-fixer
	php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix src/

phpstanSetup:  ## Lance l'installation de code PhpStan
	composer require --dev phpstan/phpstan

phpstan:  ## Lance l'installation de code PhpStan
	vendor/bin/phpstan analyse --level 6 src
	#vendor/bin/phpstan analyse -c phpstan.neon

phpmd:  ## Lance l'analyseeur du code phpmd
	vendor/phpmd/phpmd/src/bin/phpmd src/ text cleancode
	vendor/phpmd/phpmd/src/bin/phpmd src/ text naming
	vendor/phpmd/phpmd/src/bin/phpmd src/ text design

phpmdHelp:  ## afficher le help de l'analyseeur du code phpmd avec l'option -h
	vendor/phpmd/phpmd/src/bin/phpmd -h

CheckScript:  ## Lance tout les analyseeurs du code
	php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix src/
	vendor/bin/phpstan analyse --level 6 src
	vendor/phpmd/phpmd/src/bin/phpmd src/ text cleancode
#	vendor/phpmd/phpmd/src/bin/phpmd src/ text naming
#	vendor/phpmd/phpmd/src/bin/phpmd src/ text design


AnalysersSetUp: ## Installer tout les analyseeurs du code
	composer require --dev friendsofphp/php-cs-fixer
	composer require --dev phpstan/phpstan
	composer require --dev phpmd/phpmd
	composer require --dev dealerdirect/phpcodesniffer-composer-installer:"*"


sonar-scanner: ##  Lance sonarQub
#	bash sonar-scanner-4.6.0.2311-linux/bin/sonar-scanner -Dsonar.projectKey=BestPractice -Dsonar.sources=src -Dsonar.host.url=http://127.0.0.1:9002 -Dsonar.login=e96e5f764b81836824ec3ab8a4bfd92801fa0649
	bash sonar-scanner-4.6.0.2311-linux/bin/sonar-scanner \
      -Dsonar.projectKey=BestPractice \
      -Dsonar.sources=src \
      -Dsonar.tests=tests  \
      -Dsonar.host.url=http://172.19.0.1:9002 \
      -Dsonar.login=e96e5f764b81836824ec3ab8a4bfd92801fa0649 \
      -Dsonar.php.tests.reportPath=tests-report.xml    \
      -Dsonar.php.coverage.reportPaths=tests/logs/clover-report.xml   -X


coverage:  ## Lance les tests unitaire
	vendor/bin/simple-phpunit  --log-junit "tests/logs/junit.xml" --coverage-clover "tests/logs/clover.xml" --coverage-html "tests/coverage/html"



coverage-log:  ## Lance les tests unitaire
	vendor/bin/simple-phpunit --coverage-text



