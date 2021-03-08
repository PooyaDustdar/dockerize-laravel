envsubst  ../.env < /etc/nginx/templates/default.conf.template > /etc/nginx/sites-enabled/default
service php8.0-fpm start
nginx -g "daemon off;"
