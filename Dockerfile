FROM yexk/php-fpm:8.1.3

ARG ENV_FILE=.env.test

WORKDIR /www

COPY . /www

RUN cp /www/deploy/php/php.ini /usr/local/etc/php/php.ini \
    && cp /www/deploy/php/php-fpm.conf /usr/local/etc/php-fpm.conf \
    && cp /www/deploy/php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf \
    && mv /usr/local/etc/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf.back \
    # nginx config
    && cp /www/deploy/nginx.conf /etc/nginx/nginx.conf

RUN cd /www && composer install --optimize-autoloader --no-dev \
    # replace repo
    # && composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/ \
    && cp ${ENV_FILE} .env \
    && chmod +x /www/run.sh \
    && echo "script complete!"

EXPOSE 80

CMD ["bash", "/www/run.sh"]
