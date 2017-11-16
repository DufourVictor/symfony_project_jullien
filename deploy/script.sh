#!/bin/bash

# Add repository for php 5.6
sudo add-apt-repository ppa:ondrej/php5-5.6

# Update repository
sudo apt-get -y update

# For php 5.6
sudo apt-get install python-software-properties

sudo apt-get -y update

# Add locale FR
sudo locale-gen fr_FR.UTF-8

# Install Apache
sudo apt-get -y install apache2

# Install MySQL
sudo debconf-set-selections <<< "mysql-server-5.5 mysql-server/root_password password $4"
sudo debconf-set-selections <<< "mysql-server-5.5 mysql-server/root_password_again password $4"
sudo apt-get -y install mysql-server

sudo rm -rf /etc/mysql/my.cnf
sudo mv /var/www/my.cnf /etc/mysql/my.cnf

sudo chown root:root /etc/mysql/my.cnf
sudo chmod 644 /etc/mysql/my.cnf

mysql -u root -p$4 -e "CREATE USER 'root'@'%' IDENTIFIED BY '$4'; GRANT ALL PRIVILEGES ON * . * TO 'root'@'%' IDENTIFIED BY '$4'; FLUSH PRIVILEGES;"

sudo service mysql restart

# Install PHPMyAdmin
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password $4"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password $4"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password $4"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2"
sudo apt-get -y install phpmyadmin

# Edit PHPMyAdmin config
sudo rm /etc/phpmyadmin/config.inc.php
sudo mv /var/www/config.inc.php /etc/phpmyadmin/config.inc.php
sudo chmod 644 /etc/phpmyadmin/config.inc.php

# Install PHP5
sudo apt-get -y install php5 php5-mysql php5-cli php5-intl php5-xdebug php5-curl php5-gd php5-memcached php5-apcu php5-mcrypt

# Enable PHP5 mod
sudo php5enmod mcrypt

# Edit PHP5 Config
sudo sed -i "s/post_max_size = 8M/post_max_size = 600M/" /etc/php5/apache2/php.ini
sudo sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 500M/" /etc/php5/apache2/php.ini

# Delete default Apache web directory and vhost
sudo rm -rf /var/www/html
sudo rm -rf /etc/apache2/sites-enabled/000-default.conf

# Add Apache vhost
sudo mv /var/www/apache.conf /etc/phpmyadmin/apache.conf
sudo mv /var/www/project.conf /etc/apache2/sites-available/
sudo sed -i "s/project_url/$3/g" /etc/apache2/sites-available/project.conf

# Edit Apache config
sudo rm /etc/apache2/apache2.conf
sudo mv /var/www/apache2.conf /etc/apache2/apache2.conf

# Enable Apache mod and vhost
sudo a2enmod rewrite
sudo a2ensite project

# Restart Apache
sudo service apache2 restart
