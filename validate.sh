#!/bin/sh
composer install --quiet --no-interaction
vendor/bin/phpcs --standard=vendor/magento-ecg/coding-standard/Ecg ./app
vendor/bin/phpcs --standard=zend ./app
vendor/bin/parallel-lint ./app