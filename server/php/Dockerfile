FROM yexk/php-fpm:8.1.3

RUN composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/ \
&& echo -e "\033[42;37m Build Completed :).\033[0m\n"

WORKDIR /usr/share/nginx/html
