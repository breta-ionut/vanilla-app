FROM nginx:latest

RUN apt-get update \
    && apt-get install -y openssl \
    && openssl dhparam -out /etc/nginx/dhparam.pem 4096 \
    && openssl req \
        -x509 \
        -nodes \
        -days 365 \
        -newkey rsa:2048 \
        -subj "/C=RO/ST=CJ/L=CJ/O=NA/CN=vanilla" \
        -keyout /etc/ssl/vanilla.key \
        -out /etc/ssl/vanilla.crt

COPY config/nginx.conf config/ssl.conf /etc/nginx/

RUN mkdir /etc/nginx/sites-available && mkdir /etc/nginx/sites-enabled
COPY config/vanilla /etc/nginx/sites-available/
RUN ln -s /etc/nginx/sites-available/vanilla /etc/nginx/sites-enabled/vanilla
