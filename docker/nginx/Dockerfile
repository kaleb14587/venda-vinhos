FROM nginx:1.15-alpine

# set main params
ARG BUILD_ARGUMENT_ENV=dev
ENV ENV=$BUILD_ARGUMENT_ENV

RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log && \
    rm -rf /etc/nginx/conf.d/*

# install openssl
RUN apk add --update openssl && \
    rm -rf /var/cache/apk/*

# create folder for certificates
RUN mkdir -p /etc/nginx/certificates

# generate certificates
# TODO: change it and make additional logic for production environment
#RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/nginx/certificates/key.pem -out /etc/nginx/certificates/cert.pem -subj "/C=AT/ST=Vienna/L=Vienna/O=Security/OU=Development/CN=example.com"

# put nginx config
COPY ./docker/nginx/ /etc/nginx/conf.d/
RUN if [ "$BUILD_ARGUMENT_ENV" = "dev" ] || [ "$BUILD_ARGUMENT_ENV" = "test" ]; then rm -rf  /etc/nginx/conf.d/default.prod.conf; \
    else rm -rf /etc/nginx/conf.d/default.conf; \
    fi
