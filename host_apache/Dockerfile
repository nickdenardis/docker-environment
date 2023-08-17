FROM httpd:2.4.33-alpine
RUN apk update; \
    apk upgrade;

# Copy apache vhost file to proxy php requests to php-fpm container
# Or COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN echo "Include /usr/local/apache2/conf/apache.local.conf" \
    >> /usr/local/apache2/conf/httpd.conf