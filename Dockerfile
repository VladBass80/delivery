FROM serversideup/php:8.3-fpm-nginx-alpine-v3.3.0 as base

USER root

RUN set -x \
    && install-php-extensions \
      ctype \
      iconv \
      pcre \
      session \
      simplexml \
      tokenizer \
      xdebug-3.3.2 \
;

FROM base AS development

ARG USER_ID=82
ARG GROUP_ID=82

RUN set -x  \
    && docker-php-serversideup-set-id www-data $USER_ID:$GROUP_ID \
    && docker-php-serversideup-set-file-permissions --owner $USER_ID:$GROUP_ID --service nginx \
;

USER www-data

FROM base AS production

COPY --chown=www-data:www-data . /var/www/html

ENTRYPOINT ["top", "-b"]
