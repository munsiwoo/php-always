FROM php:8.1-apache

RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
RUN a2enmod rewrite

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN sed -i 's/;extension=pdo_mysql/extension=pdo_mysql/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/;extension=openssl/extension=openssl/g' $PHP_INI_DIR/php.ini 
RUN sed -i 's/;extension=mbstring/extension=mbstring/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/;extension=curl/extension=curl/g' $PHP_INI_DIR/php.ini

# Cannot display PHP version in HTTP response
RUN sed -i 's/expose_php = On/expose_php = Off/g' $PHP_INI_DIR/php.ini

# For debug
RUN sed -i 's/display_errors = Off/display_errors = On/g' $PHP_INI_DIR/php.ini

# For file upload
RUN sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 10M/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/post_max_size = 8M/post_max_size = 12M/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/max_input_time = 60/max_input_time = 120/g' $PHP_INI_DIR/php.ini

RUN apt update && apt install -y libzip-dev openssl libssl-dev libcurl4-openssl-dev vim

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-enable mysqli pdo pdo_mysql

ENV TZ=Asia/Seoul
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone