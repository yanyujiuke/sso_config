#!/bin/bash

if [ $(which nginx) ]; then
    nginx
fi

# run pre-install
#cd /usr/share/nginx/html && /usr/local/bin/php artisan admin:update  # 这个命令会重置菜单中文翻译
cd /usr/share/nginx/html && /usr/local/bin/php artisan migrate
cd /usr/share/nginx/html && /usr/local/bin/php artisan storage:link
cd /usr/share/nginx/html && /usr/local/bin/php artisan l5-swagger:generate &

# start php server
echo "start php server"
nohup php-fpm -R >>/tmp/php-fpm.log &

# start horizon server
echo "start horizon server"
cd /usr/share/nginx/html && nohup /usr/local/bin/php artisan horizon >>/usr/share/nginx/html/storage/logs/horizon.log &

# start queue work server
echo "start queue work server"
cd /usr/share/nginx/html && nohup /usr/local/bin/php artisan queue:work --queue=pay,loan,queue,push,default >>/usr/share/nginx/html/storage/logs/queue.log &

# start cron schedule
echo "start cron schedule"
log=/usr/share/nginx/html/storage/logs/cron.log
result=""
while true; do
    {
        result=$(cd /usr/share/nginx/html && /usr/local/bin/php artisan schedule:run)
        echo $result >>$log
    } &
    sleep 1m
done
