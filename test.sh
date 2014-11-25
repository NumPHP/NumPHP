#!/bin/sh
vendor/bin/phpmd src/ tests/ text codesize,controversial,design,naming,unusedcode
vendor/bin/phpcs --standard=psr2 src/ tests/
vendor/bin/phpunit
