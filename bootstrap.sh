#!/usr/bin/env bash

yum update

yum install -y git

yum install -y php-composer-installers

yum install -y rh-php56 rh-php56-php rh-php56-php-bcmath rh-php56-php-cli rh-php56-php-common rh-php56-php-gd rh-php56-php-imap rh-php56-php-intl rh-php56-php-opcache rh-php56-php-mbstring rh-php56-php-mysqlnd rh-php56-php-xml rh-php56-php-xmlrpc
sed -i "s/short_open_tag = Off/short_open_tag = On/g" /etc/opt/rh/rh-php56/php.ini
sed -i "s/memory_limit = 128M/memory_limit = 512M/g" /etc/opt/rh/rh-php56/php.ini
sed -i "s/max_execution_time = 30/max_execution_time = 120/g" /etc/opt/rh/rh-php56/php.ini
sed -i "s/;date.timezone =/date.timezone = Europe\/London/g" /etc/opt/rh/rh-php56/php.ini

yum install -y redis
systemctl enable redis
systemctl start redis