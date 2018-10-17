FROM php:7.1-apache

# Install recommended extensions for Symfony
RUN apt-get update && apt-get install -y \
        libicu-dev \
        git \
        zip \
        imagemagick \
        libmagickwand-dev \
    && docker-php-ext-install \
        intl \
        opcache \
    && docker-php-ext-enable \
        intl \
        opcache \
    && apt-get install -y  \
    && pecl install imagick \
    && docker-php-ext-install mysqli pdo_mysql \
    && docker-php-ext-enable imagick

RUN apt-get -qq update && apt-get -qq -y install  \
    automake \
    cmake \
    g++ \
    git \
    libicu-dev \
    libmagickwand-dev \
    libpng-dev \
    librabbitmq-dev \
    libreadline-dev \
    pkg-config \
    ssh-client \
    supervisor \
    zlib1g-dev \
  && docker-php-ext-install \
    bcmath \
    gd \
    intl \
    opcache \
    pdo_mysql \
    zip \
  && git clone git://github.com/alanxz/rabbitmq-c.git \
    && cd rabbitmq-c \
    && mkdir build && cd build \
    && cmake -DENABLE_SSL_SUPPORT=OFF .. \
    && cmake --build . --target install  \
    && pecl install amqp imagick igbinary \
  && docker-php-ext-enable amqp imagick igbinary \
  && version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && curl -A "Docker" -L https://blackfire.io/api/v1/releases/client/linux_static/amd64 | tar zxp -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire /usr/bin/blackfire \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz \
  && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_autostart=true" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_mode=req" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=10000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_log=/var/log/xdebug_remote.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_connect_back=Off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Permission fix
RUN usermod -u 1000 www-data