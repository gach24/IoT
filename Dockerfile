FROM php:7.2-apache
# MAINTAINER Germán Carreño <german@docencia.sonofe.es>
RUN docker-php-ext-install mysqli

ADD --chown=www-data:www-data src/ /var/www/html/


