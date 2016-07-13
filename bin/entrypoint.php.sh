#!/bin/bash -x

/bin/composer --working-dir=/var/www/html -noa --no-ansi --prefer-dist install
exec php-fpm
