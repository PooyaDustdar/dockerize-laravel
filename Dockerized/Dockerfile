FROM ubuntu:20.04
LABEL maintainer="Pooya Dustdar <pdustdar@gmail.com>"
WORKDIR /var/www/html
ENV DEBIAN_FRONTEND noninteractive
ENV TZ=Asia/Tehran
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip \
        git sqlite3 libcap2-bin libpng-dev python2 libpng-dev libzip-dev \
        libicu-dev gettext nmap zip nano htop git nginx \
        libjpeg-dev libfreetype6-dev webp libwebp-dev openjdk-11-jre

RUN mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu focal main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get upgrade -y

RUN apt-get install -y php8.0-cli php8.0-dev  \
        php8.0-curl php8.0-mbstring php8.0-xml php8.0-zip \
        php8.0-bcmath php8.0-intl php8.0-readline php8.0-msgpack \
        php8.0-igbinary php8.0-redis php8.0-mongodb php8.0-mysql \
        php8.0-fpm php8.0-gd \
        && php -r "readfile('http://getcomposer.org/installer');" \
        |  php -- --install-dir=/usr/bin/ --filename=composer

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.0

RUN mkdir /etc/nginx/templates
VOLUME    /etc/nginx/templates/
VOLUME /usr/local/etc/php/conf.d/
COPY www.conf /etc/php/8.0/fpm/pool.d/www.conf
COPY fastcgi_params /etc/nginx/fastcgi_params

EXPOSE 80
EXPOSE 443
EXPOSE 9000

COPY bash.sh /bash.sh
RUN chmod +x /bash.sh
STOPSIGNAL SIGQUIT
CMD /bash.sh