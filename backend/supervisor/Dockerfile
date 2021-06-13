FROM php:8.0-cli

ENV APP_ROOT=/var/www QUEUE_DRIVER=redis NUM_PROCS=4 OPTIONS="--sleep=3 --tries=3"

COPY ./supervisord.conf /etc/

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && apt-get update \
    && apt-get install -y --no-install-recommends supervisor

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
