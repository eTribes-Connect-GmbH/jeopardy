#!/usr/bin/env sh

# start cron daemon
/usr/sbin/crond -f -l 2 -L /var/log/cron.log &

(echo "*/5 * * * *  cd /var/www/htdocs/bin && ./console app:index-results -q") | crontab -
# start apache
/usr/sbin/httpd -DFOREGROUND
