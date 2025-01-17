FROM ubuntu:20.04

ARG DEBIAN_FRONTEND=noninteractive

ENV APP_HOME=/var/www/expensetracker \
    APP_USER=nobody \
    APP_GROUP=nobody

RUN apt-get update

RUN apt-get install -y curl git

RUN apt-get install -y openssl php php-cli unzip php-bcmath php-curl php-json php-mbstring \
    php-mysql php-tokenizer php-xml php-zip php-sqlite3

RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php && \
    HASH=`curl -sS https://composer.github.io/installer.sig` && \
    php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p ${APP_HOME}

COPY . ${APP_HOME}

CMD ["sleep", "infinity"]
