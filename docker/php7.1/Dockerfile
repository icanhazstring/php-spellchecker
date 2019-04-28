FROM php:7.1-cli-stretch

RUN echo "memory_limit=-1" > "$PHP_INI_DIR/conf.d/memory-limit.ini" \
 && echo "date.timezone=${PHP_TIMEZONE:-UTC}" > "$PHP_INI_DIR/conf.d/date_timezone.ini"

RUN apt-get update \
    && apt install -y \
     curl \
     git \
     zip \
     unzip \
     openssl \
     libzip-dev \
     ispell \
     iamerican \
     hunspell \
     hunspell-en-us \
     aspell \
     aspell-en \
     libpspell-dev \
    && docker-php-ext-configure pspell \
    && docker-php-ext-install pspell \
    && docker-php-ext-install zip \
    && rm -r /var/lib/apt/lists/*

RUN cp /usr/share/hunspell/en_US.aff  /usr/share/hunspell/en_US.aff.orig \
    && cp /usr/share/hunspell/en_US.dic  /usr/share/hunspell/en_US.dic.orig \
    && iconv --from ISO8859-1 -t ascii//TRANSLIT /usr/share/hunspell/en_US.aff.orig > /usr/share/hunspell/en_US.aff \
    && iconv --from ISO8859-1 -t ascii//TRANSLIT /usr/share/hunspell/en_US.dic.orig > /usr/share/hunspell/en_US.dic \
    && head /usr/share/hunspell/en_US.aff \
    && sed -i '/SET ISO8859-1/c\SET UTF-8' /usr/share/hunspell/en_US.aff

RUN pecl install xdebug-2.6.0 \
	&& docker-php-ext-enable xdebug \
	&& echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /usr/src/myapp
# Workaround to keep container running
CMD ["tail", "-f", "/dev/null"]
