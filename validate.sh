#!/bin/sh
composer install --quiet --no-interaction
vendor/bin/phpcs --standard=vendor/leaphub/phpcs-symfony2-standard/leaphub/phpcs/Symfony2/ --extensions=php app/
vendor/bin/parallel-lint ./app