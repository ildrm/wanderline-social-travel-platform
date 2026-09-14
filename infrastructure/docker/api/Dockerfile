FROM php:8.5-fpm-alpine AS php-base

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/tmp/composer \
    PHP_OPCACHE_VALIDATE_TIMESTAMPS=0

RUN apk add --no-cache \
        icu-libs libpq libzip nginx supervisor \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS icu-dev libpq-dev libzip-dev linux-headers \
    && docker-php-ext-install -j"$(nproc)" bcmath intl pcntl pdo_pgsql zip \
    && pecl install redis-6.3.0 \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && rm -rf /tmp/* /var/cache/apk/*

COPY --from=composer:2.8 /usr/bin/composer /usr/local/bin/composer
COPY infrastructure/docker/api/php.ini /usr/local/etc/php/conf.d/99-application.ini
COPY infrastructure/docker/healthchecks /healthchecks

WORKDIR /workspace/apps/api

FROM php-base AS development
ENV APP_ENV=local PHP_OPCACHE_VALIDATE_TIMESTAMPS=1
RUN apk add --no-cache git unzip
COPY apps/api/composer.json apps/api/composer.lock ./
RUN --mount=type=cache,target=/tmp/composer/cache \
    composer install --prefer-dist --no-interaction --no-progress --no-scripts \
    && sha256sum composer.lock | awk '{print $1}' > vendor/.composer-lock.sha256
COPY infrastructure/docker/entrypoints/api-development.sh /usr/local/bin/api-development
RUN chmod 0755 /usr/local/bin/api-development
ENTRYPOINT ["/usr/local/bin/api-development"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]

FROM php-base AS composer-dependencies
COPY apps/api/composer.json apps/api/composer.lock ./
RUN --mount=type=cache,target=/tmp/composer/cache \
    composer install --no-dev --prefer-dist --no-interaction --no-progress --no-scripts \
        --no-autoloader

FROM php-base AS runtime
ENV APP_ENV=production APP_DEBUG=false
COPY --chown=www-data:www-data apps/api/ ./
COPY --from=composer-dependencies --chown=www-data:www-data /workspace/apps/api/vendor ./vendor
COPY infrastructure/docker/api/nginx.conf /etc/nginx/http.d/default.conf
COPY infrastructure/docker/api/supervisord.conf /etc/supervisord.conf
RUN composer dump-autoload --no-dev --optimize --classmap-authoritative --no-interaction \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache /run/nginx \
    && chown -R www-data:www-data storage bootstrap/cache /run/nginx /var/lib/nginx /var/log/nginx
USER www-data
EXPOSE 8080
HEALTHCHECK --interval=15s --timeout=5s --start-period=20s --retries=3 CMD ["/healthchecks/api.sh"]
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
