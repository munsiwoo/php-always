FROM ubuntu:16.04
MAINTAINER munsiwoo <mun.xiwoo@gmail.com>

RUN apt-get update
RUN apt-get install -qq -y apache2

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2

RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
RUN a2enmod rewrite

RUN apt-get install -qq -y sqlite3
RUN apt-get install -qq -y php
RUN apt-get install -qq -y php-common
RUN apt-get install -qq -y php-mbstring
RUN apt-get install -qq -y php-sqlite3
RUN apt-get install -qq -y libapache2-mod-php

RUN apt-get autoclean

ADD . /var/www/html
RUN chmod 777 -R /var/www/html

EXPOSE 80
CMD ["/bin/bash"]

