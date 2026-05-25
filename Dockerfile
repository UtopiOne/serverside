FROM php:8.2-cli
COPY . /usr/src/serverside
WORKDIR /usr/src/serverside
EXPOSE 8080
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]
