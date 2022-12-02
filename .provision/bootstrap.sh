#!/usr/bin/env bash

################
# SERVER SETUP #
################
# install php 7.2, nginx, composer
sudo apt-get update
sudo apt-get -y install tree htop -fpm zip unzip nginx php7.2 php7.2-zip
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
# setup composer permissions
sudo chown -R $USER $HOME/.composer
# start nginx
sudo service nginx start
sudo update-rc.d nginx enable
# set up nginx
mkdir /var/www/retortrumble/logs/
touch /var/www/retortrumble/logs/access.log
touch /var/www/retortrumble/logs/error.log
sudo cp /var/www/setup/retortrumble.conf /etc/nginx/sites-available/retortrumble.test
sudo chmod 644 /etc/nginx/sites-available/retortrumble.test
sudo ln -sf /etc/nginx/sites-available/retortrumble.test /etc/nginx/sites-enabled/retortrumble.test
# remove the default site config
sudo rm /etc/nginx/sites-available/default
sudo rm /etc/nginx/sites-enabled/default
# remove the setup dir, cleanliness and security
sudo rm -rf /var/www/setup
# restart nginx
sudo service nginx restart
# some cleanup
sudo apt-get -y autoremove
sudo apt-get -y autoclean
sudo rm -rf /var/www/html

##############
# SITE SETUP #
##############
# Lets make some dirs!
mkdir /var/www/retortrumble/config/
# # copy composer files over
# sudo cp /var/www/setup/composer.json /var/www/retortrumble/composer.json
# sudo cp /var/www/setup/composer.lock /var/www/retortrumble/composer.lock
# # do composer installs
# composer install
# composer require vlucas/phpdotenv
# composer require cboden/ratchet
# composer require slim/slim
# composer require slim/twig-view
# composer require monolog/monolog