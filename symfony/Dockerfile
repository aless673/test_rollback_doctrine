FROM php:8.1.7-fpm

ENV APCU_VERSION 5.1.21
ENV REDIS_VERSION 5.3.7

RUN apt-get update && apt-get install -y \
    wget \
    unzip \
    libzip-dev \
    libicu-dev \
    zlib1g-dev \
    libxml2-dev \
  	libc-client-dev \
    libkrb5-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxpm-dev \
    libwebp-dev \
    gosu \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-configure gd --enable-gd --with-webp --with-jpeg --with-xpm --with-freetype \
    && docker-php-ext-install -j$(nproc) opcache mysqli pdo_mysql zip intl xml imap gd soap \
    && pecl install apcu-$APCU_VERSION \
    && pecl install redis-$REDIS_VERSION \
    && docker-php-ext-enable apcu redis \
    && rm /etc/localtime \
    && ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime \
    && date

RUN curl --silent --show-error https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

ADD 00-timezone.ini /usr/local/etc/php-fpm.d
ADD 00-timezone.ini /usr/local/etc/php/conf.d

ADD uploads.php.ini /usr/local/etc/php-fpm.d
ADD uploads.php.ini /usr/local/etc/php/conf.d

# Hack to fix access to pseudo-secure third party services over old TLS servers
RUN sed -i "s/^MinProtocol =.*$/MinProtocol = TLSv1.0/g" /etc/ssl/openssl.cnf

ADD entrypoint.sh /opt/entrypoint.sh
RUN chmod a+x /opt/entrypoint.sh

ENTRYPOINT ["/opt/entrypoint.sh"]

EXPOSE 9000
WORKDIR /var/www/html
CMD ["php-fpm"]

# Chromium and ChromeDriver
ENV PANTHER_NO_SANDBOX 1
# Not mandatory, but recommended
ENV PANTHER_CHROME_ARGUMENTS='--disable-dev-shm-usage'

# Chrome
RUN apt-get install -y chromium
RUN wget https://chromedriver.storage.googleapis.com/$(curl -s https://chromedriver.storage.googleapis.com/LATEST_RELEASE)/chromedriver_linux64.zip; \
    unzip chromedriver_linux64.zip; \
    mv chromedriver /usr/bin/chromedriver; \
    chown root:root /usr/bin/chromedriver; \
    chmod +x /usr/bin/chromedriver; \
    rm chromedriver_linux64.zip

# Firefox and GeckoDriver (optional)
ARG GECKODRIVER_VERSION=0.28.0
RUN apt-get install -y firefox libzip-dev; \
    docker-php-ext-install zip
RUN wget -q https://github.com/mozilla/geckodriver/releases/download/v$GECKODRIVER_VERSION/geckodriver-v$GECKODRIVER_VERSION-linux64.tar.gz; \
    tar -zxf geckodriver-v$GECKODRIVER_VERSION-linux64.tar.gz -C /usr/bin; \
    rm geckodriver-v$GECKODRIVER_VERSION-linux64.tar.gz

RUN rm -r /var/lib/apt/lists/*
