FROM php:8.4-cli-bookworm

ARG UID=1000
ARG GID=1000

# PHP extensions (pdo_pgsql for Postgres, redis for queues/Horizon, exif for media-library, + what Laravel needs)
COPY --from=mlocati/php-extension-installer:2 /usr/bin/install-php-extensions /usr/local/bin/
RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip postgresql-client \
    && install-php-extensions pdo_pgsql pgsql redis intl zip bcmath pcntl gd opcache exif \
    && rm -rf /var/lib/apt/lists/* \
    && echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Node 22 (for Vite / npm)
COPY --from=node:22-bookworm-slim /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22-bookworm-slim /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s ../lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s ../lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

# Run as a user matching the host so bind-mounted files keep the right owner
RUN groupadd -g ${GID} app && useradd -m -u ${UID} -g ${GID} -s /bin/bash app

WORKDIR /var/www/html
USER app

EXPOSE 8000 5173

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
