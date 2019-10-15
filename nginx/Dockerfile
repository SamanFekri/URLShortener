FROM nginx:1.16.0-alpine
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
RUN mkdir -p /var/etc/sites-available
COPY ./nginx/s.hallows.ir.conf /var/etc/sites-available/s.hallows.ir.conf