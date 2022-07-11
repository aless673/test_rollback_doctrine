#!/bin/sh
set -e

[ -d "/var/www/html/var/log" ] && chown -R www-data:www-data /var/www/html/var/log
[ -d "/var/www/html/var/cache" ] && chown -R www-data:www-data /var/www/html/var/cache
[ -d "/var/www/html/var/documents" ] && chown -R www-data:www-data /var/www/html/var/documents
[ -d "/var/www/html/public/documents" ] && chown -R www-data:www-data /var/www/html/public/documents
[ -d "/var/www/.composer" ] && chown -R www-data:www-data /var/www/.composer

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"
