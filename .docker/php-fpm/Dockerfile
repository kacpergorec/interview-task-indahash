FROM php:8.3-fpm as os

ENV COMPOSER_MEMORY_LIMIT='-1'

RUN apt-get update && \
apt-get install -y --no-install-recommends \
    libpq-dev \
    libssl-dev \
    git \
    unzip \
    wget \
    libicu-dev

# Install PHP extensions
RUN docker-php-ext-install intl pdo_pgsql

## Add postgresql extension
#RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

COPY php.ini /usr/local/etc/php/conf.d/php.ini
RUN pecl install xdebug && docker-php-ext-enable xdebug


# Install Composer globally
RUN curl -s http://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc

# Source the bash
RUN . ~/.bashrc

# Symfony-specific tasks
WORKDIR /var/www

# Set up default Symfony command aliases
RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/bin/console "$@"' > /usr/bin/console && \
    chmod +x /usr/bin/console

# Symfony cache and logs permissions
RUN usermod -u 1000 www-data && \
    mkdir -p var/cache var/log && \
    chown -R www-data:www-data var/cache var/log

# Copy entrypoint script
COPY ./docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
RUN ln -s /usr/local/bin/docker-entrypoint.sh /
ENTRYPOINT ["docker-entrypoint.sh"]

# Expose the PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
