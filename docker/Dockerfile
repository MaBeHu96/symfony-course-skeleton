FROM php:8.1.20-fpm

ARG UID=1000

# Usuario appuser + alias
RUN set -eux; \
    adduser -u ${UID} --disabled-password --gecos "" appuser; \
    mkdir -p /home/appuser/.ssh; \
    chown -R appuser:appuser /home/appuser; \
    echo "StrictHostKeyChecking no" >> /home/appuser/.ssh/config; \
    echo "alias sf=/appdata/www/bin/console" >> /home/appuser/.bashrc

# Paquetes base + extensiones PHP
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        git acl openssl openssh-client wget curl ca-certificates zip \
        libpng-dev zlib1g-dev libzip-dev libxml2-dev libicu-dev \
        gpg dirmngr xz-utils; \
    docker-php-ext-install -j"$(nproc)" intl pdo pdo_mysql zip; \
    pecl install xdebug apcu; \
    docker-php-ext-enable --ini-name 05-opcache.ini opcache xdebug apcu; \
    rm -rf /var/lib/apt/lists/*

# Composer 2.2.18 (compatible con proyectos de 2022)
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.2.18 \
 && mv composer.phar /usr/bin/composer \
 && chmod +x /usr/bin/composer

# ---- Node 14 + npm 6 (desde tarball oficial; funciona en Debian bookworm) ----
ARG NODE_VERSION=14.21.3
RUN set -eux; \
    ARCH="$(dpkg --print-architecture)"; \
    case "$ARCH" in \
      amd64) NODE_ARCH="x64";; \
      arm64) NODE_ARCH="arm64";; \
      *) echo "Arquitectura no soportada: $ARCH" && exit 1;; \
    esac; \
    curl -fsSLO "https://nodejs.org/dist/v${NODE_VERSION}/node-v${NODE_VERSION}-linux-${NODE_ARCH}.tar.xz"; \
    tar -xJf "node-v${NODE_VERSION}-linux-${NODE_ARCH}.tar.xz" -C /usr/local --strip-components=1 --no-same-owner; \
    rm "node-v${NODE_VERSION}-linux-${NODE_ARCH}.tar.xz"; \
    node -v; npm -v

# Yarn clásico (v1) vía npm para evitar apt-key
RUN npm install -g yarn@1

# Symfony CLI (instala y mueve a /usr/local/bin) — sin self:update
USER appuser
RUN wget https://get.symfony.com/cli/installer -O - | bash
USER root
RUN mv /home/appuser/.symfony*/bin/symfony /usr/local/bin/symfony

# Carpeta de trabajo + Xdebug ini
RUN mkdir -p /appdata/www
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /appdata/www
