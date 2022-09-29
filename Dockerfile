FROM composer:2.4.1 as build

WORKDIR /app
COPY . /app
RUN ls -la
RUN composer install

FROM php:7.0-cli-alpine3.7

WORKDIR /app
COPY --from=build /app .
