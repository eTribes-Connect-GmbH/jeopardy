FROM alpine:3.12.0

RUN apk add bash php7 php7-apache2 php7-bcmath php7-bz2 php7-calendar php7-common php7-curl \
 php7-pdo php7-iconv php-ctype php7-gd php7-intl php7-json php7-json php7-mysqli php7-opcache php7-openssl \
 php7-pdo_mysql php7-phar php7-session php7-simplexml php7-snmp php7-soap php7-sodium \
 php7-tokenizer php7-xml php7-xmlreader php7-xmlrpc php7-xmlwriter php7-xsl php7-zip php7-mbstring \
 php7-pecl-redis php7-pecl-amqp php7-pecl-mcrypt apache2 apache2-http2 apache2-icons apache2-proxy \
 apache2-ssl apache2-utils bzip2 postgresql-client curl procps git \
 nodejs npm openssl busybox-initscripts busybox-suid

RUN ln -s /usr/lib/libxml2.so.2 /usr/lib/libxml2.so && ln -s /lib64/ld-linux-x86-64.so.2 /usr/lib/ld-linux-x86-64.so.2

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

COPY ./httpd.conf /etc/apache2/
COPY ./php.ini /etc/php7/

RUN addgroup -g 1000 symfony && adduser symfony 1000 --ingroup symfony --disabled-password --home=/var/www
RUN mkdir -p /var/www/htdocs/public && echo "it works" > /var/www/htdocs/public/index.php && chown -R symfony:symfony /var/www/htdocs

VOLUME ["/var/www/htdocs"]
WORKDIR /var/www/htdocs
EXPOSE 8080

ADD ./run.sh /
RUN chmod +x /run.sh

CMD ["/run.sh"]
