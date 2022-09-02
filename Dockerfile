# you can change php version from here and webserve as apache or ngnix
FROM webdevops/php-apache:7.4
# change work dir
WORKDIR /app
# copy all project files to container
ADD . .
# run composer install
RUN composer install
# make storage if not exists
RUN mkdir -p storage
# give permissions full access for storage , logs , cache
RUN chmod -R 777 storage/logs
RUN chmod -R 777  bootstrap/cache
RUN chmod -R 777 storage/framework/sessions
RUN chmod -R 777 storage/framework/views
# enable rewrite mode
RUN a2enmod rewrite
# clear cache and class autoload
RUN php artisan optimize:clear
RUN composer dump-autoload
