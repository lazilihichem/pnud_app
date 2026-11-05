# Development image for the PNUD ESS platform (Laravel + Inertia + Vue).
# One image serves three compose services: app (artisan serve), vite, queue.
# It carries Node as well as PHP because the Wayfinder Vite plugin calls
# `php artisan wayfinder:generate` while Vite runs.
FROM php:8.4-cli-bookworm

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_pgsql pgsql intl zip bcmath pcntl gd redis opcache

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip postgresql-client \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

COPY --from=node:22-bookworm-slim /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22-bookworm-slim /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s ../lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s ../lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

# Run as the host user so files written to the bind mount (vendor, storage,
# public/build, generated Wayfinder routes) stay owned by you, not root.
ARG UID=1000
ARG GID=1000
RUN groupadd -g "${GID}" app && useradd -u "${UID}" -g "${GID}" -m -s /bin/bash app

USER app
WORKDIR /var/www/html
